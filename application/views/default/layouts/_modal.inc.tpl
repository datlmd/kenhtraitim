<!-- Modal -->
<div id="fb-root"></div>
<div id="popup_wrapper">
    {if !$this->session->userdata('user_id')}
        <div id="popup-login" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm" style="width:400px">
                <div class="modal-content">
                    <button aria-hidden="true" data-dismiss="modal" class="close" title="Đóng lại"></button>
                    <div class="modal-header">
                        <h2>Đăng nhập</h2>
                    </div>
                    <div class="modal-body">
                        <ul class="list-login clearfix">
                            <li><a href="javascript:void(0);" class="login-zing" title="Đăng nhập bằng Zing ID">Zing ID</a></li>
                            <li><a href="javascript:void(0);" class="login-facebook" title="Đăng nhập bằng Facebook">Facebook</a></li>
                            <li><a href="javascript:void(0);" class="login-google" title="Đăng nhập bằng Google">Google</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div id="url-popup" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button aria-hidden="true" data-dismiss="modal" class="close" title="Đóng lại"></button>
                    <div class="modal-body" style="margin:10px;">
                        <iframe width="100%" height="100%" frameborder="0" scrolling="no" allowtransparency="true" src="{get_zingme_sso_url()}">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    {/if}
    <div id="popup-alert" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" style="width:400px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Thông báo</h2>
                </div>
                <div class="modal-body">
                    <div class="alert">
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-wrapper">
                        <a href="#" class="btn-done" data-dismiss="modal">OK</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="popup-confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" style="width:400px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Thông báo</h2>
                </div>
                <div class="modal-body">
                    <div class="alert">
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-wrapper">
                        <a href="#" class="btn-done" data-dismiss="modal">OK</a>
                        <a href="#" class="btn-cancel close" data-dismiss="modal">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->
<script type="text/javascript">
    var facebook_app_id = '{config_item('fb_appid')}';
    var google_client_id = '{config_item('gg_clientid')}';
    var google_api_key = '{config_item('gg_clientsecret')}';
    var base_url_zing = '{base_url_zing()}';
    var static_frontend_zing = '{base_url_zing()}';

    {if !$this->session->userdata('user_id')}

    var init = false; // init facebook + Google
    var is_logged = false; // is logged in?

    window.closeModal = function () {
        $('#url-popup').modal('hide');
    };

    function resize_popup() {
        $('#url-popup .modal-dialog').css({
            width: '410px', //choose your width
            height: '496px',
            'padding': '0'
        });
        $('#url-popup .modal-content').css({
            height: '100%',
            'border-radius': '0',
            'padding': '0'
        });
        $('#url-popup .modal-body').css({
            width: 'auto',
            height: '476px',
            'padding': '0',
            overflow: 'hidden'
        });
    }
    function show_loading() {
        $('#login_panel').append('<div class="login_loading login-loading"></div><div class="login_loading login-loading-otr"><img src="{static_base()}images/loading.gif" alt="" /></div>');
    }

    function hide_loading() {
        $('.login_loading').hide();
    }

    function onLoadCallback() {
        gapi.client.setApiKey(google_api_key); //set your API KEY
        gapi.client.load('plus', 'v1', function () {
        });//Load Google + API
    }

    function loginCallback(result) {
        if (result['status']['signed_in']) {
            if (result['status']['method'] === 'PROMPT') {
                login_ajax("google", result["access_token"]);
                console.log("Login Success");
                is_logged = true;
            }
        } else {
            console.log("Login Failed");
            //user hit cancel button
            show_alert('danger', 'Xin vui lòng cho phép Google truy cập vào Fashionista để đăng nhập!', function () {
                if (!is_logged) {
                    $('#popup-login').modal('show');
                }
                hide_loading();
            });
        }
    }

    function menu_profile(json) {
        var logout_function = '';

        if (json.user_type_id === 2) {
            logout_function = 'onclick="fb_logout();"';
        } else if (json.user_type_id === 3) {
            logout_function = 'onclick="gg_logout();"';
        }
        $('#login_panel').addClass("parent").html('<a class="info-mini clearfix">' +
                '<div class="avatar"><img src="' + json.avatar + '" alt="" width="50" height="50"/><span class="ic-social ic-0' + json.user_type_id + '"></span></div>' +
                '<div class="info-inside">' +
                '<p class="lstitle">Tài khoản</p>' +
                '<p class="desc">' + json.fullname + '</p>' +
                '</div>' +
                '</a>' +
                '<ul class="subnav">' +
                '<li><a href="' + base_url_zing + 'thoat" ' + logout_function + ' style="color: #0033ff; text-decoration: underline;">Thoát</a></li></ul>');
    }

    function login_ajax(from, access_token) {
        $.ajax({
            url: base_url_zing + "open_login/ajax_login",
            data: {
                from: from,
                access_token: access_token
            },
            type: "POST",
            async: true,
            success: function (data) {
                try {
                    var json = jQuery.parseJSON(data);
                    menu_profile(json);
                    $('.login_loading').hide();
                    show_alert('success', 'Đăng nhập thành công!', function () {
                        console.log(typeof login_completed);
                        if (typeof login_completed !== 'undefined' && $.isFunction(login_completed)) {
                            login_completed();
                        }
                    });

                } catch (e) {
                    show_alert('danger', 'Đăng nhập thất bại. Vui lòng thử lại!', function () {
                        $('#popup-login').modal('show');
                    });
                    $('.login_loading').hide();
                }

            },
            fail: function () {
                show_alert('danger', 'Đăng nhập không thành công. Vui lòng thử lại!', function () {
                    $('#popup-login').modal('show');
                });
                hide_loading();
            }
        });
    }

    $(function () {
        $('#popup-login').on('shown.bs.modal', function (e) {
            if (!init) {
                // google SDK
                (function () {
                    var po = document.createElement('script');
                    po.type = 'text/javascript';
                    po.async = true;
                    po.src = 'https://apis.google.com/js/client.js?onload=onLoadCallback;'
                    var s = document.getElementsByTagName('script')[0];
                    s.parentNode.insertBefore(po, s);
                })();

                init = true;
            }
        });
        $('.login-facebook').on('click', function () {
            show_loading();
            $('#popup-login').modal('hide');
            var facebook_scope = 'publish_stream,email';
            FB.login(function (response) {

                if (response.authResponse) {
                    is_logged = true;
                    access_token = response.authResponse.accessToken; //get access token
                    user_id = response.authResponse.userID; //get FB UID                        
                    FB.api('/me', function (response) {
                        // call ajax to store this data into your database   
                        login_ajax("facebook", access_token);
                    });

                } else {
                    //user hit cancel button
                    show_alert('danger', 'Xin vui lòng cho phép Facebook truy cập vào Fashionista để đăng nhập!', function () {
                        if (!is_logged) {
                            $('#popup-login').modal('show');
                        }
                        hide_loading();
                    });
                }
            }, {
                scope: facebook_scope
            });
        });

        $('.login-google').on('click', function () {
            show_loading();
            $('#popup-login').modal('hide');

            var myParams = {
                'clientid': google_client_id, //You need to set client id
                'cookiepolicy': 'single_host_origin',
                'callback': 'loginCallback', //callback function
                //'approvalprompt': 'force',
                'scope': 'https://www.googleapis.com/auth/plus.login'
            };
            gapi.auth.signIn(myParams);
        });

        $('.login-zing').on('click', function () {
            $('#popup-login').modal('hide');
            $("#zing-popup .modal-body").html('<iframe width="100%" height="100%" frameborder="0" scrolling="no" allowtransparency="true" src="{get_zingme_sso_url()}"></iframe>');
            resize_popup();
            $('#url-popup').modal('show');
        });
    });

    $(document).ready(function () {
        $('#popup-login').modal('show');
    });
    {/if}
</script>

<script type="text/javascript" src="{static_base_cache()}/frontend/js/utilities.js"></script>
<script type="text/javascript" src="{static_base_cache()}js/bootstrap.min.js"></script>
<link href="{static_base_cache()}css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="{static_base_cache()}css/modal.css" rel="stylesheet" type="text/css">
<link href="{static_base_cache()}css/reset.css" rel="stylesheet" type="text/css">
<script src="{static_frontend_cache()}js/waypoints.min.js"></script>
<script src="{static_frontend_cache()}js/jquery.easing.1.3.js"></script>