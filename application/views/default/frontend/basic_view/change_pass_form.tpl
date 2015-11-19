<link href="{base_url()}static/basic_view/css/style.css" type="text/css" rel="stylesheet"/>
<div class="basic_form">
    <form action="" method="post" onsubmit="">
        <ul>
            <li>
                <h2>Thông tin tài khoản</h2>
                <a href="{base_url()}frontend/basic_view/profile_form">Quay lại</a>
            </li>
            <li>
                <label>Mật khẩu cũ</label>

                <div class="basic_right_li">
                    <input type="password" id="basic_password" name="old_password">

                    <div class="basic_register_error" id="basic_password_error">
                        {form_error('old_password')}
                    </div>
                </div>
            </li>
            <li>
                <label>Mật khẩu mới</label>

                <div class="basic_right_li">
                    <input type="password" id="basic_new_password" name="new_password">

                    <div class="basic_register_error" id="basic_new_password_error">
                        {form_error('new_password')}
                    </div>
                </div>
            </li>
            <li>
                <label>Nhập lại mật khẩu</label>

                <div class="basic_right_li">
                    <input type="password" id="basic_re_password" name="re_password" value="">

                    <div class="basic_register_error" id="basic_re_password_error">
                        {form_error('re_password')}
                    </div>
                </div>
            </li>
        </ul>
        <input type="submit" value="Cập nhật">
    </form>
</div>
<script>
    $(document).ready(function () {
        //Check username
        $('#basic_username').blur(function () {
            if (check_username() == true) {
                check_username_Vietnamese();
            }
        });
        $('#basic_username').keyup(function () {
            check_username_Vietnamese();
        });

        //Check password
        $('#basic_password').blur(function () {
            if (check_password() == true) {
                check_password_Vietnamese();
            }
        });

        //Check password Vietnamese
        $('#basic_password').keyup(function () {
            check_password_Vietnamese();
        });

        //check new password
        $('#basic_new_password').blur(function () {
            if (check_new_password() == true) {
                check_new_password_Vietnamese();
            }
        });

        //Check new password Vietnamese
        $('#basic_new_password').keyup(function () {
            check_new_password_Vietnamese();
        });

        //Check re_password
        $('#basic_re_password').blur(function () {
            check_re_password();
        });
        $('#basic_re_password').keyup(function () {
            $('#basic_re_password_error').empty();
        });
    });

    //function check username
    function check_username() {
        $('#basic_username_error').empty();
        if ($('#basic_username').val() == '') {
            $('#basic_username_error').append('<p>* Bạn phải nhập thông tin này</p>');
            return false;
        } else {
            if ($('#basic_username').val().length < 5 || $('#basic_username').val().length > 24) {
                $('#basic_username_error').append('<p>* Chiều dài phải từ 6-24 ký tự</p>');
                return false;
            }
        }
        return true;
    }

    //Check password
    function check_password() {
        $('#basic_password_error').empty();
        if ($('#basic_password').val() == '') {
            $('#basic_password_error').append('<p>* Bạn phải nhập thông tin này</p>');
            return false;
        } else {
            if ($('#basic_password').val().length < 6 || $('#basic_password').val().length > 32) {
                $('#basic_password_error').append('<p>* Chiều dài phải từ 6-32 ký tự</p>');
                return false;
            }
        }
        return true;
    }

    //Check password
    function check_new_password() {
        $('#basic_new_password_error').empty();
        if ($('#basic_new_password').val() == '') {
            $('#basic_new_password_error').append('<p>* Bạn phải nhập thông tin này</p>');
            return false;
        } else {
            if ($('#basic_new_password').val().length < 6 || $('#basic_new_password').val().length > 32) {
                $('#basic_new_password_error').append('<p>* Chiều dài phải từ 6-32 ký tự</p>');
                return false;
            }
        }
        return true;
    }

    //Check Vietnamese in password
    function check_password_Vietnamese() {
        var str = $('#basic_password').val();
        if (str != '') {
            $('#basic_password_error').empty();

            for (i = 0; i < str.length; i++) {
                if (str.charCodeAt(i) < 32 || str.charCodeAt(i) > 126) {
                    $('#basic_password_error').append('<p>* Không nhập tiếng việt có dấu.</p>');
                    return false;
                }
            }
            return true;
        } else {
            return false;
        }
    }

    //Check Vietnamese in password
    function check_new_password_Vietnamese() {
        var str = $('#basic_new_password').val();
        if (str != '') {
            $('#basic_new_password_error').empty();

            for (i = 0; i < str.length; i++) {
                if (str.charCodeAt(i) < 32 || str.charCodeAt(i) > 126) {
                    $('#basic_new_password_error').append('<p>* Không nhập tiếng việt có dấu.</p>');
                    return false;
                }
            }
            return true;
        } else {
            return false;
        }
    }

    //Check Vietnamese in username
    function check_username_Vietnamese() {
        var str = $('#basic_username').val();
        if (str != '') {
            $('#basic_username_error').empty();
            for (i = 0; i < str.length; i++) {
                if (str.charCodeAt(i) < 32 || str.charCodeAt(i) > 126) {
                    $('#basic_username_error').append('<p>* Không nhập tiếng việt có dấu.</p>');
                    return false;
                }
            }
            return true;
        } else {
            return false;
        }
    }

    //Check re_password
    function check_re_password() {
        $('#basic_re_password_error').empty();
        if ($('#basic_re_password').val() != $('#basic_new_password').val()) {
            $('#basic_re_password_error').append('<p>* Xác nhận mật khẩu phải giống mật khẩu mới.</p>');
            return false;
        }
        return true;
    }
</script>