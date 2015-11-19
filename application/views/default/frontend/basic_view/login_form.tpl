<link href="{base_url()}static/basic_view/css/style.css" type="text/css" rel="stylesheet"/>
<div class="basic_form">
    <form action="" method="post" onsubmit="return validateForm();">
        <ul>
            <li>
                <label>Tên đăng nhập</label>

                <div class="basic_right_li">
                    <input type="text" id="basic_username" name="username" value="{$post.username}">

                    <div class="basic_register_error" id="basic_username_error">
                        {form_error('username')}
                    </div>
                </div>
            </li>
            <li>
                <label>Mật khẩu</label>

                <div class="basic_right_li">
                    <input type="password" id="basic_password" name="password">

                    <div class="basic_register_error" id="basic_password_error">
                        {form_error('password')}
                        {$check_login}
                    </div>
                </div>
            </li>
            <li>
                <div class="basic_remember_li">
                    <input type="checkbox" id="basic_remember" name="remember">
                    <p>Ghi nhớ đăng nhập</p>
                </div>
            </li>
            <li>
                <label>Mã bảo vệ</label>

                <div class="captcha" class="basic_right_li">
                    <input type="text" style=" margin: 0 0 5px 0; text-align: center; width: 250px;" id="captcha"
                           name="captcha">

                    <div class="basic_register_error" id="basic_region_error">
                        {form_error('captcha')}
                    </div>
                    {print_captcha()}
                </div>

            </li>
        </ul>
        <input type="submit" value="Đăng nhập">
    </form>
</div>
<script type="text/javascript">
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

</script>