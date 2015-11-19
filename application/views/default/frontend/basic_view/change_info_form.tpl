<link href="{base_url()}static/basic_view/css/style.css" type="text/css" rel="stylesheet"/>
<div class="basic_form">
    <form action="" method="post" onsubmit="return validateForm();">
        <ul>
            <li>
                <h2>Thông tin cá nhân</h2>
                <a href="{base_url()}frontend/basic_view/profile_form">Quay lại</a>
            </li>
            <li>
                <label>Họ tên</label>

                <div class="basic_right_li">
                    <input type="text" id="basic_name" name="name" value="{$user_info.full_name}">

                    <div class="basic_register_error" id="basic_name_error">
                        {form_error('name')}
                    </div>
                </div>
            </li>
            <li>
                <label>Ngày sinh</label>

                <div class="basic_right_li">
                    <select style="font-size: 13px; float: left; height: 21px;width:70px; margin: 5px 0 0 0;" id="basic_day"
                            name="dName1" tabindex="0">
                        <option value="-1">[Ngày]</option>
                        <option value="1">&nbsp;1</option>
                        <option value="2">&nbsp;2</option>
                        <option value="3">&nbsp;3</option>
                        <option value="4">&nbsp;4</option>
                        <option value="5">&nbsp;5</option>
                        <option value="6">&nbsp;6</option>
                        <option value="7">&nbsp;7</option>
                        <option value="8">&nbsp;8</option>
                        <option value="9">&nbsp;9</option>
                        <option value="10">&nbsp;10</option>
                        <option value="11">&nbsp;11</option>
                        <option value="12">&nbsp;12</option>
                        <option value="13">&nbsp;13</option>
                        <option value="14">&nbsp;14</option>
                        <option value="15">&nbsp;15</option>
                        <option value="16">&nbsp;16</option>
                        <option value="17">&nbsp;17</option>
                        <option value="18">&nbsp;18</option>
                        <option value="19">&nbsp;19</option>
                        <option value="20">&nbsp;20</option>
                        <option value="21">&nbsp;21</option>
                        <option value="22">&nbsp;22</option>
                        <option value="23">&nbsp;23</option>
                        <option value="24">&nbsp;24</option>
                        <option value="25">&nbsp;25</option>
                        <option value="26">&nbsp;26</option>
                        <option value="27">&nbsp;27</option>
                        <option value="28">&nbsp;28</option>
                        <option value="29">&nbsp;29</option>
                        <option value="30">&nbsp;30</option>
                        <option value="31">&nbsp;31</option>
                    </select>
                    <select style="font-size: 13px; float: left; height: 21px;width:110px; margin: 5px 0 0 5px;" id="basic_month"
                            name="mName1" tabindex="0">
                        <option value="-1">[Tháng]</option>
                        <option value="1">&nbsp;Tháng một</option>
                        <option value="2">&nbsp;Tháng hai</option>
                        <option value="3">&nbsp;Tháng ba</option>
                        <option value="4">&nbsp;Tháng tư</option>
                        <option value="5">&nbsp;Tháng năm</option>
                        <option value="6">&nbsp;Tháng sáu</option>
                        <option value="7">&nbsp;Tháng bảy</option>
                        <option value="8">&nbsp;Tháng tám</option>
                        <option value="9">&nbsp;Tháng chín</option>
                        <option value="10">&nbsp;Tháng mười</option>
                        <option value="11">&nbsp;Tháng mười một</option>
                        <option value="12">&nbsp;Tháng mười hai</option>
                    </select>
                    <select style="font-size: 13px; float: left; height: 21px;width:70px; margin: 5px 0 0 5px;" id="basic_year"
                            name="yName1" tabindex="0">
                        <option value="-1">[Năm]</option>
                        <option value="2013">&nbsp;2013</option>
                        <option value="2012">&nbsp;2012</option>
                        <option value="2011">&nbsp;2011</option>
                        <option value="2010">&nbsp;2010</option>
                        <option value="2009">&nbsp;2009</option>
                        <option value="2008">&nbsp;2008</option>
                        <option value="2007">&nbsp;2007</option>
                        <option value="2006">&nbsp;2006</option>
                        <option value="2005">&nbsp;2005</option>
                        <option value="2004">&nbsp;2004</option>
                        <option value="2003">&nbsp;2003</option>
                        <option value="2002">&nbsp;2002</option>
                        <option value="2001">&nbsp;2001</option>
                        <option value="2000">&nbsp;2000</option>
                        <option value="1999">&nbsp;1999</option>
                        <option value="1998">&nbsp;1998</option>
                        <option value="1997">&nbsp;1997</option>
                        <option value="1996">&nbsp;1996</option>
                        <option value="1995">&nbsp;1995</option>
                        <option value="1994">&nbsp;1994</option>
                        <option value="1993">&nbsp;1993</option>
                        <option value="1992">&nbsp;1992</option>
                        <option value="1991">&nbsp;1991</option>
                        <option value="1990">&nbsp;1990</option>
                        <option value="1989">&nbsp;1989</option>
                        <option value="1988">&nbsp;1988</option>
                        <option value="1987">&nbsp;1987</option>
                        <option value="1986">&nbsp;1986</option>
                        <option value="1985">&nbsp;1985</option>
                        <option value="1984">&nbsp;1984</option>
                        <option value="1983">&nbsp;1983</option>
                        <option value="1982">&nbsp;1982</option>
                        <option value="1981">&nbsp;1981</option>
                        <option value="1980">&nbsp;1980</option>
                        <option value="1979">&nbsp;1979</option>
                        <option value="1978">&nbsp;1978</option>
                        <option value="1977">&nbsp;1977</option>
                        <option value="1976">&nbsp;1976</option>
                        <option value="1975">&nbsp;1975</option>
                        <option value="1974">&nbsp;1974</option>
                        <option value="1973">&nbsp;1973</option>
                        <option value="1972">&nbsp;1972</option>
                        <option value="1971">&nbsp;1971</option>
                        <option value="1970">&nbsp;1970</option>
                        <option value="1969">&nbsp;1969</option>
                        <option value="1968">&nbsp;1968</option>
                        <option value="1967">&nbsp;1967</option>
                        <option value="1966">&nbsp;1966</option>
                        <option value="1965">&nbsp;1965</option>
                        <option value="1964">&nbsp;1964</option>
                        <option value="1963">&nbsp;1963</option>
                        <option value="1962">&nbsp;1962</option>
                        <option value="1961">&nbsp;1961</option>
                        <option value="1960">&nbsp;1960</option>
                        <option value="1959">&nbsp;1959</option>
                        <option value="1958">&nbsp;1958</option>
                        <option value="1957">&nbsp;1957</option>
                        <option value="1956">&nbsp;1956</option>
                        <option value="1955">&nbsp;1955</option>
                        <option value="1954">&nbsp;1954</option>
                        <option value="1953">&nbsp;1953</option>
                        <option value="1952">&nbsp;1952</option>
                        <option value="1951">&nbsp;1951</option>
                        <option value="1950">&nbsp;1950</option>
                        <option value="1949">&nbsp;1949</option>
                        <option value="1948">&nbsp;1948</option>
                        <option value="1947">&nbsp;1947</option>
                        <option value="1946">&nbsp;1946</option>
                        <option value="1945">&nbsp;1945</option>
                        <option value="1944">&nbsp;1944</option>
                        <option value="1943">&nbsp;1943</option>
                        <option value="1942">&nbsp;1942</option>
                        <option value="1941">&nbsp;1941</option>
                        <option value="1940">&nbsp;1940</option>
                        <option value="1939">&nbsp;1939</option>
                        <option value="1938">&nbsp;1938</option>
                        <option value="1937">&nbsp;1937</option>
                        <option value="1936">&nbsp;1936</option>
                        <option value="1935">&nbsp;1935</option>
                        <option value="1934">&nbsp;1934</option>
                        <option value="1933">&nbsp;1933</option>
                        <option value="1932">&nbsp;1932</option>
                        <option value="1931">&nbsp;1931</option>
                        <option value="1930">&nbsp;1930</option>
                        <option value="1929">&nbsp;1929</option>
                        <option value="1928">&nbsp;1928</option>
                        <option value="1927">&nbsp;1927</option>
                        <option value="1926">&nbsp;1926</option>
                        <option value="1925">&nbsp;1925</option>
                        <option value="1924">&nbsp;1924</option>
                        <option value="1923">&nbsp;1923</option>
                        <option value="1922">&nbsp;1922</option>
                        <option value="1921">&nbsp;1921</option>
                        <option value="1920">&nbsp;1920</option>
                        <option value="1919">&nbsp;1919</option>
                        <option value="1918">&nbsp;1918</option>
                        <option value="1917">&nbsp;1917</option>
                        <option value="1916">&nbsp;1916</option>
                        <option value="1915">&nbsp;1915</option>
                        <option value="1914">&nbsp;1914</option>
                        <option value="1913">&nbsp;1913</option>
                        <option value="1912">&nbsp;1912</option>
                        <option value="1911">&nbsp;1911</option>
                        <option value="1910">&nbsp;1910</option>
                        <option value="1909">&nbsp;1909</option>
                        <option value="1908">&nbsp;1908</option>
                        <option value="1907">&nbsp;1907</option>
                        <option value="1906">&nbsp;1906</option>
                        <option value="1905">&nbsp;1905</option>
                        <option value="1904">&nbsp;1904</option>
                        <option value="1903">&nbsp;1903</option>
                        <option value="1902">&nbsp;1902</option>
                        <option value="1901">&nbsp;1901</option>
                        <option value="1900">&nbsp;1900</option>
                    </select>

                    <div class="basic_register_error" id="basic_birthday_error">
                        {$user_info.birthday}
                    </div>
                </div>
            </li>
            <li>
                <label>Giới tính</label>

                <div class="basic_right_li">
                    <input type="radio" name="sex" value="1" style="float: left; width: 15px;" checked><span
                        style="float: left; width: 40px; padding-top: 3px;">Nam</span>
                    <input type="radio" name="sex" value="0" style="float: left;width: 15px;"><span
                        style="float: left; width: 60px; padding-top: 3px;">Nữ</span>
                </div>
            </li>
            <li>
                <label>Số điện thoại</label>

                <div class="basic_right_li">
                    <input type="text" id="basic_phone" name="phone" value="{$user_info.phone}">

                    <div class="basic_register_error" id="basic_phone_error">
                        {form_error('phone')}
                    </div>
                </div>
            </li>
            <li>
                <label>Tỉnh/Thành phố</label>
                <select id="basic_region" name="region">
                    <option value="-1">Tỉnh/Thành phố</option>
                    {foreach from=$region_array item=region}
                        {if $user_info.region_id=={$region.id}}
                            <option value="{$region.id}" selected>{$region.name}</option>
                        {else}
                            <option value="{$region.id}">{$region.name}</option>
                        {/if}
                    {/foreach}
                </select>
            </li>
            <li>
                <label>Quận/Huyện</label>
                <select id="basic_district" name="district">
                    <option value="-1">Quận/Huyện</option>
                    {foreach from=$district_array item=district}
                        {if $user_info.district_id=={$district.id}}
                            <option value="{$district.id}" selected>{$district.name}</option>
                        {else}
                            <option value="{$district.id}">{$district.name}</option>
                        {/if}
                    {/foreach}
                </select>
            </li>
            <li>
                <label>Phường/Xã</label>

                <div class="basic_right_li">
                    <select id="basic_ward" name="ward">
                        <option value="-1">Phường/Xã</option>
                        {foreach from=$ward_array item=ward}
                            {if $user_info.ward_id=={$ward.id}}
                                <option value="{$ward.id}" selected>{$ward.name}</option>
                            {else}
                                <option value="{$ward.id}">{$ward.name}</option>
                            {/if}
                        {/foreach}
                    </select>

                    <div class="basic_register_error" id="basic_region_error">
                        {form_error('region')}
                    </div>
                </div>
            </li>
            <li>
                <label>Địa chỉ</label>

                <div class="basic_right_li">
                    <input type="text" id="basic_address" name="address" value="{$user_info.address}">

                    <div class="basic_register_error" id="basic_address_error"></div>
                </div>
            </li>
        </ul>
        <input type="submit" value="Cập nhật">
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function () {

    $('#basic_day').val({$user_info.dName1});
    $('#basic_month').val({$user_info.mName1});
    $('#basic_year').val({$user_info.yName1});
    $('input:radio[name=sex]').filter('[value={$user_info.gender_id}]').attr('checked', true);

    //get event region is chosen
    $('#basic_region').change(function () {
    get_district(this.value);
    if ($('#basic_district option:selected').val() != null) {
    get_ward($('#basic_district option:selected').val());
}});

//get event district is chosen
$('#basic_district').change(function () {
get_ward(this.value);
});

//Check name
$('#basic_name').blur(function () {
check_name();
});
$('#basic_name').keyup(function () {
$('#basic_name_error').empty();
check_special_key_in_name();
});

//Check phone
$('#basic_phone').blur(function () {
check_phone();
});
$('#basic_phone').keyup(function () {
$('#basic_phone_error').empty();
});

//Check phone
$('#basic_region').blur(function () {
check_region();
});
$('#basic_district').blur(function () {
check_region();
});
$('#basic_ward').blur(function () {
check_region();
});
$('#basic_region').focus(function () {
$('#basic_region_error').empty();
});

//Check Birthday
$("#basic_day").focus(function () {
$('#basic_birthday_error').empty();
});
$("#basic_month").focus(function () {
$('#basic_birthday_error').empty();
});
$("#basic_year").focus(function () {
$('#basic_birthday_error').empty();
});
$("#basic_day").blur(function () {
checkDateValid('dd');
});
$("#basic_month").blur(function () {
checkDateValid('mm');
});
$("#basic_year").blur(function () {
checkDateValid('yyyy');
});
})

function validateForm() {
var flag_submit = 0;
check_name();
if (checkDateValid('') == true) {
flag_submit++;
}
if (check_phone() == true) {
flag_submit++;
}
if (check_region() == true) {
flag_submit++;
}
if (flag_submit < 3) {
//        alert(flag_submit);
return false;
} else {
return true;
}
}

//Check region
function check_region() {
$('#basic_region_error').empty();
if ($('#basic_region').val() == '-1') {
$('#basic_region_error').append('<p>* Bạn cần chọn Tỉnh/Thành phố</p>');
return false;
}
return true;
}

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

//Check re_password
function check_re_password() {
$('#basic_re_password_error').empty();
if ($('#basic_re_password').val() != $('#basic_password').val()) {
$('#basic_re_password_error').append('<p>* Xác nhận mật khẩu phải giống mật khẩu.</p>');
return false;
}
return true;
}

//Check email
function check_email() {
    {literal}
    $('#basic_email_error').empty();
    var reg = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/;
    if (!reg.test($('#basic_email').val())) {
        $('#basic_email_error').append('<p>* Email không đúng.</p>');
        return false;
    }
    return true;
    {/literal}
}

//Check special key in name
function check_special_key_in_name() {
    {literal}
    var str = $('#basic_name').val();
    if (/^[A-Za-z ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ]*$/.test(str) == false) {
        $('#basic_name_error').append('<p>* Họ tên không đúng</p>');
        return false;
    }
    {/literal}
}

//Check spell name
function check_name() {
$('#basic_name_error').empty();
if ($('#basic_name').val() == '') {
$('#basic_name_error').append('<p>* Bạn phải nhập thông tin này</p>');
return false;
} else {
var flag = CheckSpell($('#basic_name').val());
if (flag == false) {
$('#basic_name_error').append('<p>* Tên bạn không đúng</p>');
return false;
}
}
return true;
}

//Check phone
function check_phone() {
    {literal}
    $('#basic_phone_error').empty();
    if ($('#basic_phone').val() == '') {
        $('#basic_phone_error').append('<p>* Bạn phải nhập thông tin này</p>');
        return false;
    } else {
        var regex_pattern_mobile = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
        var regex_pattern_mobile2 = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{5})$/;
        if (!$('#basic_phone').val().match(regex_pattern_mobile)) {
            if (!$('#basic_phone').val().match(regex_pattern_mobile2)) {
                $('#basic_phone_error').append('<p>* Số điện thoại không hợp lệ</p>');
                return false;
            }
        }
    }
    return true;
    {/literal}
}

//Check address
//function check_address() {
//    $('#basic_address_error').empty();
//    if ($('#basic_address').val() == '') {
//        $('#basic_address_error').append('<p>* Bạn phải nhập thông tin này</p>');
//    }
//}

function checkDateValid(opt) {
var flag = 1;
var dd = trimString($("#basic_day").val());
var mm = $("#basic_month").val();
var yyyy = trimString($("#basic_year").val());
if (dd == -1 && mm == -1 && yyyy == -1) {
$('#basic_birthday_error').empty();
$('#basic_birthday_error').append('<p>* Ngày sinh không hợp lệ</p>');
return false;
}
if (opt == '') {
if (dd != -1 && mm != -1 && yyyy != -1) {
if (!checkDate(dd, mm, yyyy)) {
flag = 0;
}
}
}

//neu blur ddd
if (opt == 'dd') {
if (mm != -1 && yyyy != -1) {
if (!checkDate(dd, mm, yyyy)) {
flag = 0;
}
}
}
//neu blur mm
if (opt == 'mm') {
if (yyyy != -1) {
if (!checkDate(dd, mm, yyyy)) {
flag = 0;
}
}
}
//neu blur yyyy
if (opt == 'yyyy') {
if (dd != -1 || mm != -1) {
if (!checkDate(dd, mm, yyyy)) {
flag = 0;
}
}
}
if (flag == 0) {
$('#basic_birthday_error').append('<p>* Ngày sinh không hợp lệ</p>');
return false;
}
return true;
}

//Check date
function checkDate(dd, mm, yyyy) {
var mydate = new Date();
var year = mydate.getFullYear();
var month = mydate.getMonth() + 1;
var daym = mydate.getDate();
//    alert(dd + ' --- ' + daym);
//    alert(mm + ' --- ' + month);
//    alert(yyyy + ' --- ' + year);
//Kiem tra thoi gian hien tai
//    if (!checkStringIsNum(dd) || !checkStringIsNum(mm) || !checkStringIsNum(yyyy))
//        return false;
if (dd < 1 || dd > 31 || yyyy < 1900)
return false;
if (yyyy > year)
return false;
if (yyyy == year) {
if (mm > month)
return false;
if (mm == month)
if (dd > daym || dd == daym)
return false;
}
//Kiem tra hop le
if (!isNaN(yyyy) && (yyyy != "") && (yyyy < 10000)) {
if ((mm == 4 || mm == 6 || mm == 9 || mm == 11) && dd == 31)
return false;
if (mm == 2) { // check for february 29th
var isleap = (yyyy % 4 == 0 && (yyyy % 100 != 0 || yyyy % 400 == 0));
if (dd > 29 || (dd == 29 && !isleap))
return false;
}
}
return true;
}

function trimString(text) {
var len = text.length;
var i = 0;
var j = len - 1;
var s = "";

while (text.charAt(i) == " ")
i++;

while (text.charAt(j) == " ")
j--;

if (i > j)
s = "";
else
s = text.substring(i, j + 1);

return s;
}

//Get district by ajax
function get_district(id_region) {
$('#basic_district').empty();
$.ajax({
url: "{base_url()}vn_areas/districts/ajax_get_district/" + id_region,
async: false,
success: function (result) {
var region_array = JSON.parse(result);
if (region_array != '') {
//                    $('#basic_district').append('<option value="0">Quận/Huyện</option>');
$.each(region_array, function () {
$('#basic_district').append('<option value=' + this.id + '>' + this.name + '</option>');
});
} else {
$('#basic_district').append('<option value="0">Quận/Huyện</option>');
$('#basic_ward').append('<option value="0">Phường/Xã</option>');
}
}
});
}

//get ward by ajax
function get_ward(id_district) {
$('#basic_ward').empty();
$.ajax({
url: "{base_url()}vn_areas/wards/ajax_get_ward/" + id_district,
success: function (result) {
var ward_array = JSON.parse(result);
if (ward_array != '') {
//                    $('#basic_ward').append('<option value="0">Phường/Xã</option>');
$.each(ward_array, function () {
$('#basic_ward').append('<option value=' + this.id + '>' + this.name + '</option>');
});
} else {
$('#basic_ward').append('<option value="0">Phường/Xã</option>');
}
}
});
}
</script>