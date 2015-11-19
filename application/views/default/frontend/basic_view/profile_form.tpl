<link href="{base_url()}static/basic_view/css/style.css" type="text/css" rel="stylesheet"/>
<div class="basic_form">
    <h2>Thông tin tài khoản</h2>
    <a href="{base_url()}frontend/basic_view/logout">Đăng xuất</a>
    <ul>
        <li>
            <h3>Thông tin tài khoản</h3>
            <a href="{base_url()}frontend/basic_view/change_pass_form" style="float: right; margin: 20px 20px 0 0;">(cập nhật)</a>
        </li>
        <li>
            <label>Tên đăng nhập</label>

            <div class="basic_info_right">
                <p>{$username}</p>
            </div>
        </li>
        <li>
            <label>Email</label>

            <div class="basic_info_right">
                <p>{$email}</p>
            </div>
        </li>
        <li>
            <label>Mật khẩu</label>

            <div class="basic_info_right">
                <p>**********</p>
            </div>
        </li>
        <li>
            <h3>Thông tin cá nhân</h3>
            <a href="{base_url()}frontend/basic_view/change_info_form" style="float: right; margin: 20px 20px 0 0;">(cập nhật)</a>
        </li>
        <li>
            <label>Họ tên</label>
            <div class="basic_info_right">
                <p>{$full_name}</p>
            </div>
        </li>

        <li>
            <label>Ngày sinh</label>

            <div class="basic_info_right">
                <p>{$dob}</p>
            </div>
        </li>
        <li>
            <label>Giới tính</label>

            <div class="basic_info_right">
                <p>{$gender}</p>
            </div>
        </li>
        <li>
            <label>Số điện thoại</label>

            <div class="basic_info_right">
                <p>{$phone}</p>
            </div>
        </li>
        <li>
            <label>Tỉnh/Thành phố</label>
            <div class="basic_info_right">
                <p>{$region}</p>
            </div>
        </li>
        <li>
            <label>Quận/Huyện</label>
            <div class="basic_info_right">
                <p>{$district}</p>
            </div>
        </li>
        <li>
            <label>Phường/Xã</label>

            <div class="basic_info_right">
                <p>{$ward}</p>
            </div>
        </li>
        <li>
            <label>Địa chỉ</label>

            <div class="basic_info_right">
                <p>{$address}</p>
            </div>
        </li>
    </ul>
</div>