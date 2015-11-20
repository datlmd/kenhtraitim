<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Đăng ký</title>
    <meta name="keywords" content="Đăng ký" />
    <meta name="description" content="Đăng ký" />
    <meta name="robots" content="index, follow" />
    <meta name="revisit-after" content="7 days" />
    <meta name="author" content="datlm" />
    <meta name="copyright" content="datlm" />
    <meta property="og:title" content="Đăng ký" />
    <meta property="og:description" content="Đăng ký" />

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <SCRIPT TYPE="text/javascript">
      
function dang_ky() {

  var txtType_id = $.trim($('#type_id').val());
  var txtName = $.trim($('#full_name').val());
  var txtLastName = $.trim($('#last_name').val());
  var txtAddress = $('#address').val();
  var txtPhone = $('#phone').val();
  var txtEmail = $('#email').val().toLowerCase();
  var txtMssv = $.trim($('#mssv').val());
  var txtCourse_id = $.trim($('#course_id').val());
  var txtiI_schedule = $.trim($('#id_schedule').val());

  

  if (txtName.length < 1) {
    alert('Vui lòng nhập Tên!');
    return false;
  }

  if (txtLastName.length < 1) {
    alert('Vui lòng nhập Họ và tên đệm!');
    return false;
  }

  if (txtEmail.length < 1) {
    alert('Vui lòng nhập Email!');
    return false;
  }

  var regular = /^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/;
  if (!regular.test(txtEmail)) {
    alert('Email không hợp lệ, vui lòng thử lại!');
    return false;
  }

  if (txtPhone.length < 1) {
    alert('Vui lòng nhập Số điện thoại');
    return false;
  }

  if (isNaN(txtPhone))
  {
    alert('Vui lòng nhập số cho Điện thoại');
    return false;
  }

  if (txtType_id == -1) {
    alert('Vui lòng chọn Trường!');
    return false;
  }

  if (txtMssv.length < 1) {
    alert('Vui lòng nhập MSSV');
    return false;
  }

  if (txtAddress == -1) {
    alert('Vui lòng chọn địa điểm học!');
    return false;
  }
  if (txtCourse_id == -1 || txtCourse_id == 0 || txtCourse_id == 6) {
    alert('Vui lòng chọn Lớp!');
    return false;
  }
  if (txtiI_schedule == -1) {
    alert('Vui lòng chọn Lịch học!');
    return false;
  }

  $('#btn-accept').attr('style', 'pointer-events:none');

  var postData = $('#frm-dang-ky').serializeArray();

  $.post('edit_post.php',
   postData,
   function(data){
      alert( data);
  });

  $('#btn-accept').removeProp('style');
  return false;
}

function numbersonly(myfield, e, dec) {
  var key;
  var keychar;

  if (window.event)
    key = window.event.keyCode;
  else if (e)
    key = e.which;
  else
    return true;
  keychar = String.fromCharCode(key);

  // control keys
  if ((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27) )
    return true;

  // numbers
  else if ((("0123456789").indexOf(keychar) > -1))
    return true;

  // decimal point jump
  else if (dec && (keychar == ".")) {
    myfield.form.elements[dec].focus();
    return false;
  } else
    return false;
}

$(document).ready(function() {
    
    $('#course_id').change(function() {
      $('input[name=course]').val($(this).find('option:selected').text());
      var course_id = $('#course_id').val();
      if(course_id == 1 || course_id == 2 || course_id == 3){
        $('#id_schedule').html('');
        $('#id_schedule').html('<option value="-1">Chọn lịch học</option>');
        $('#id_schedule').append('<option value="1">Sáng thứ 2 - Sáng thứ 4</option>');
        $('#id_schedule').append('<option value="2">Sáng thứ 2 - Chiều thứ 4</option>');
        $('#id_schedule').append('<option value="3">Chiều thứ 2 - Sáng thứ 4</option>');
        $('#id_schedule').append('<option value="4">Chiều thứ 2 - Chiều thứ 4</option>');
        $('#id_schedule').append('<option value="5">Sáng thứ 3 - Sáng thứ 5</option>');
        $('#id_schedule').append('<option value="6">Sáng thứ 3 - Chiều thứ 5</option>');
        $('#id_schedule').append('<option value="7">Chiều thứ 3 - Sáng thứ 5</option>');
        $('#id_schedule').append('<option value="8">Chiều thứ 3 - Chiều thứ 5</option>');
        $('#id_schedule').append('<option value="9">Tối 2 - 4</option>');
        $('#id_schedule').append('<option value="33">Tối 2 - 6</option>');
        $('#id_schedule').append('<option value="10">Tối 3 - 5</option>');
        $('#id_schedule').append('<option value="34">Tối 3 - 7</option>');
      }
      if(course_id == 4){
        $('#id_schedule').html('');
        $('#id_schedule').html('<option value="-1">Chọn lịch học</option>');
        $('#id_schedule').append('<option value="11">Tối 2 - 6</option>');
        $('#id_schedule').append('<option value="12">Tối 4 - 6</option>');
        $('#id_schedule').append('<option value="13">Tối 3 - 5</option>');
        $('#id_schedule').append('<option value="14">Tối 5 - 7</option>');
      }
      if(course_id == 5){
        $('#id_schedule').html('');
        $('#id_schedule').html('<option value="-1">Chọn lịch học</option>');
        $('#id_schedule').append('<option value="15">Sáng 2 - 4</option>');
        $('#id_schedule').append('<option value="16">Sáng 4 - 6</option>');
        $('#id_schedule').append('<option value="17">Sáng 3 - 5</option>');
        $('#id_schedule').append('<option value="18">Sáng 5 - 7</option>');
        $('#id_schedule').append('<option value="19">Chiều 2 - 4</option>');
        $('#id_schedule').append('<option value="20">Chiều 4 - 6</option>');
        $('#id_schedule').append('<option value="21">Chiều 3 - 5</option>');
        $('#id_schedule').append('<option value="22">Chiều 5 - 7</option>');
      }
      if(course_id == 7 || course_id == 8 ){
        $('#id_schedule').html('');
        $('#id_schedule').html('<option value="-1">Chọn lịch học</option>');
        $('#id_schedule').append('<option value="23">Sáng 2</option>');
        $('#id_schedule').append('<option value="24">Sáng 3</option>');
        $('#id_schedule').append('<option value="25">Sáng 4</option>');
        $('#id_schedule').append('<option value="26">Sáng 5</option>');
        $('#id_schedule').append('<option value="27">Sáng 6</option>');
        $('#id_schedule').append('<option value="28">Chiều 2</option>');
        $('#id_schedule').append('<option value="29">Chiều 3</option>');
        $('#id_schedule').append('<option value="30">Chiều 4</option>');
        $('#id_schedule').append('<option value="31">Chiều 5</option>');
        $('#id_schedule').append('<option value="32">Chiều 6</option>');
      }
      return false; 
    });
    $('#id_schedule').change(function() {
      $('input[name=schedule]').val($(this).find('option:selected').text());
      return false; 
    });
    });
    </SCRIPT>
  </head>
  <body>
    <?php

  $servername = "localhost";
//   $username = "root";
// $password = "";
// $dbname = "dangky";

$username = "flicportal_db";
$password = "flic@portal.!@#$";
$dbname = "flicportal_db";

  
  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  mysqli_set_charset($conn, "utf8");


  if (!$_GET['id'])
  {
      die("Không tồn tại!");
  }
  $sql = "SELECT * FROM users WHERE id = '" . $_GET['id'] . "'";
  $result = $conn->query($sql);

  while($row = $result->fetch_array())
  {
      $rows[] = $row;
  }

  ?>
    <div class="container">
      <form id="frm-dang-ky" class="form-horizontal" role="form" method="post">
        <h3 style="text-align: center; padding:15px 0;">Cập nhật thông tin</h1>
        
        <div class="form-group">
          <label for="full_name" class="col-sm-2 control-label">Tên</label>
          <div class="col-sm-10">
            <?php
            echo '<input type="text" class="form-control" id="full_name" name="full_name" placeholder="Nhập tên" value="' . $rows[0]['full_name'] . '">';

            echo '<input type="hidden" class="form-control" id="full_name" name="id" value="' . $rows[0]['id'] . '">';
            ?>
          </div>
        </div>
        <div class="form-group">
          <label for="last_name" class="col-sm-2 control-label">Họ và tên đệm</label>
          <div class="col-sm-10">
            <?php

            echo '<input type="text" class="form-control" id="last_name" name="last_name" placeholder="Nhập họ và tên đệm" value="' . $rows[0]['last_name'] . '">';

            ?>
          </div>
        </div>
        <div class="form-group">
          <label for="email" class="col-sm-2 control-label">Email</label>
          <div class="col-sm-10">
              <?php
              echo '<input type="email" class="form-control" id="email" name="email" placeholder="Email" value="' . $rows[0]['email'] . '">';
              ?>
          </div>
        </div>
        <div class="form-group">
          <label for="phone" class="col-sm-2 control-label">Điện thoại</label>
          <div class="col-sm-10">
            <?php
            echo '<input type="text" class="form-control" id="phone" name="phone" onkeypress="return numbersonly(this, event)" maxlength="13" placeholder="Nhập số điện thoại" value="' . $rows[0]['phone'] . '">';
            ?>
          </div>
        </div>
        
        <div class="form-group">
          <label for="type_id" class="col-sm-2 control-label">Sinh viên trường</label>
          <div class="col-sm-10">
            <select id="type_id" name="type_id" class="form-control">
                <option value="-1">---Chọn trường---</option>
                <?php
                  if($rows[0]['user_type'] == 0){
                    echo '<option value="0" selected>Sinh viên trường khác</option>';
                    echo '<option value="1">Sinh viên trường ĐH Ngân Hàng</option>';
                  }
                  else{
                    echo '<option value="0">Sinh viên trường khác</option>';
                    echo '<option value="1" selected>Sinh viên trường ĐH Ngân Hàng</option>';
                  }
                ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="mssv" class="col-sm-2 control-label">MSSV (hoặc CMND)</label>
          <div class="col-sm-10">
            <?php
              echo '<input type="text" class="form-control" id="mssv" name="mssv" placeholder="Nhập MSSV hoặc CMND nếu học trường khác" value="' . $rows[0]['mssv'] . '">';
              ?>
          </div>
        </div>
        <div class="form-group">
          <label for="address" class="col-sm-2 control-label">Địa điểm học</label>
          <div class="col-sm-10">
            
                <?php
                  echo '<input type="text" class="form-control" id="address" name="address" placeholder="Email" value="' . $rows[0]['address'] . '">';
                  
                ?>
          </div>
        </div>
        <div class="form-group">
          <SCRIPT TYPE="text/javascript">
        $(document).ready(function() {
  
              <?php
                echo '$("#course_id").val("' . $rows[0]['id_course'] . '");';

                $course = $rows[0]['id_course'];
                if($course == 1 || $course == 2 || $course == 3){
                  echo "$('#id_schedule').html('');";
                  echo "$('#id_schedule').html('<option value=-1>Chọn lịch học</option>');";
                  echo "$('#id_schedule').append('<option value=1>Sáng thứ 2 - Sáng thứ 4</option>');";
                  echo "$('#id_schedule').append('<option value=2>Sáng thứ 2 - Chiều thứ 4</option>');";
                  echo "$('#id_schedule').append('<option value=3>Chiều thứ 2 - Sáng thứ 4</option>');";
                  echo "$('#id_schedule').append('<option value=4>Chiều thứ 2 - Chiều thứ 4</option>');";
                  echo "$('#id_schedule').append('<option value=5>Sáng thứ 3 - Sáng thứ 5</option>');";
                  echo "$('#id_schedule').append('<option value=6>Sáng thứ 3 - Chiều thứ 5</option>');";
                  echo "$('#id_schedule').append('<option value=7>Chiều thứ 3 - Sáng thứ 5</option>');";
                  echo "$('#id_schedule').append('<option value=8>Chiều thứ 3 - Chiều thứ 5</option>');";
                  echo "$('#id_schedule').append('<option value=9>Tối 2 - 4</option>');";
                  echo "$('#id_schedule').append('<option value=33>Tối 2 - 6</option>');";
                  echo "$('#id_schedule').append('<option value=10>Tối 3 - 5</option>');";
                  echo "$('#id_schedule').append('<option value=34>Tối 3 - 7</option>');";
                }
                if($course == 4){
                  echo "$('#id_schedule').html('');";
                  echo "$('#id_schedule').html('<option value=-1>Chọn lịch học</option>');";
                  echo "$('#id_schedule').append('<option value=11>Tối 2 - 6</option>');";
                  echo "$('#id_schedule').append('<option value=12>Tối 4 - 6</option>');";
                  echo "$('#id_schedule').append('<option value=13>Tối 3 - 5</option>');";
                  echo "$('#id_schedule').append('<option value=14>Tối 5 - 7</option>');";
                }
                if($course == 5){
                  echo "$('#id_schedule').html('');";
                  echo "$('#id_schedule').html('<option value=-1>Chọn lịch học</option>');";
                  echo "$('#id_schedule').append('<option value=15>Sáng 2 - 4</option>');";
                  echo "$('#id_schedule').append('<option value=16>Sáng 4 - 6</option>');";
                  echo "$('#id_schedule').append('<option value=17>Sáng 3 - 5</option>');";
                  echo "$('#id_schedule').append('<option value=18>Sáng 5 - 7</option>');";
                  echo "$('#id_schedule').append('<option value=19>Chiều 2 - 4</option>');";
                  echo "$('#id_schedule').append('<option value=20>Chiều 4 - 6</option>');";
                  echo "$('#id_schedule').append('<option value=21>Chiều 3 - 5</option>');";
                  echo "$('#id_schedule').append('<option value=22>Chiều 5 - 7</option>');";
                }
                if($course == 7 || $course == 8 ){
                  echo "$('#id_schedule').html('');";
                  echo "$('#id_schedule').html('<option value=-1>Chọn lịch học</option>');";
                  echo "$('#id_schedule').append('<option value=23>Sáng 2</option>');";
                  echo "$('#id_schedule').append('<option value=24>Sáng 3</option>');";
                  echo "$('#id_schedule').append('<option value=25>Sáng 4</option>');";
                  echo "$('#id_schedule').append('<option value=26>Sáng 5</option>');";
                  echo "$('#id_schedule').append('<option value=27>Sáng 6</option>');";
                  echo "$('#id_schedule').append('<option value=28>Chiều 2</option>');";
                  echo "$('#id_schedule').append('<option value=29>Chiều 3</option>');";
                  echo "$('#id_schedule').append('<option value=30>Chiều 4</option>');";
                  echo "$('#id_schedule').append('<option value=31>Chiều 5</option>');";
                  echo "$('#id_schedule').append('<option value=32>Chiều 6</option>');";
                }
                echo '$("#id_schedule").val("' . $rows[0]['id_schedule'] . '");';
              ?>
            });
          </SCRIPT>
          <label for="type_id" class="col-sm-2 control-label">Lớp</label>
          <div class="col-sm-10">
            <select id="course_id" name="course_id" class="form-control">
                <option value="-1">---Chọn khoá học---</option>  
                <option value="0">Anh văn</option>
                <option value="1">-- Đại cương A1 (elemantary)</option>
                <option value="2">-- Đại cương A2-1 (Pre-intermedia)</option>
                <option value="3">-- B1-1 (tiền b1-1)</option>
                <option value="4">-- IELTS 3.0 (Hàm Nghi)</option>
                <option value="5">-- IELTS 3.0 (Hoàng Diệu 2)</option>
                <option value="6">Tin học</option>
                <option value="7">-- Tin học trình độ A</option>
                <option value="8">-- Tin học trình độ B</option>
            </select>
            <?php
              echo '<input type="hidden" class="form-control" id="course" name="course" value="' . $rows[0]['course'] . '">';
            ?>
          </div>
        </div>
        <div class="form-group">
          <label for="type_id" class="col-sm-2 control-label">Lịch học</label>
          <div class="col-sm-10">
            <select id="id_schedule" name="id_schedule" class="form-control">
                <option value="-1">---Chọn lịch học---</option>  
            </select>
            <?php
            echo '<input type="hidden" class="form-control" id="schedule" name="schedule" value="' . $rows[0]['schedule'] . '">'
            ?>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button id="btn-accept" type="button" onclick="javascript:dang_ky();" class="btn btn-success">Hoàn tất</button>
          </div>
        </div>
      </form>
    </div>
    
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

  </body>
</html>
 
