<?php

$servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "dangky";

$username = "flicportal_db";
$password = "flic@portal.!@#$";
$dbname = "flicportal_db";


//check null
if(!isset($_POST['full_name']) || !isset($_POST['last_name']) || !isset($_POST['mssv']) || !isset($_POST['course_id']) || !isset($_POST['id_schedule']) || !isset($_POST['email']) ||!isset($_POST['phone'])
  || $_POST['full_name'] == '' || $_POST['last_name'] == '' || $_POST['mssv'] == '' || $_POST['course_id'] == '' || $_POST['id_schedule'] == '' || $_POST['email'] == '' || $_POST['phone'] == '') {
  die('We are sorry, but there appears to be a problem with the form you submitted.');       
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT id, mssv FROM users WHERE mssv = '" . $_POST['mssv'] . "' AND id_course = '$_POST[course_id]'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  die("Bạn đã đăng ký lớp học này rồi!");
}


$name = strip_tags($_POST['full_name']);
$last_name = strip_tags($_POST['last_name']);
$mssv = strip_tags($_POST['mssv']);
$course_id = strip_tags($_POST['course_id']);
$id_schedule = strip_tags($_POST['id_schedule']);
$email = strip_tags($_POST['email']);
$phone = strip_tags($_POST['phone']);
$address = strip_tags($_POST['address']);
$type_id = strip_tags($_POST['type_id']);

$course = str_replace('-- ','', strip_tags($_POST['course']));
$schedule = strip_tags($_POST['schedule']);

if($address == 0){
  $address = '39 Hàm Nghi Quận 1 TP.HCM';
}
else{
  $address = '56 Hoàng Diệu 2 Quận Thủ Đức TP.HCM';
}
//date_default_timezone_set("Asia/Calcutta");
mysqli_set_charset($conn, "utf8");
$sql = "INSERT INTO users (created, full_name, last_name, mssv,  id_course, course, id_schedule, schedule,  email, phone, address, user_type)
VALUES ('" . date('Y-m-d H:i:s') . "','" . $name . "','" . $last_name . "','" . $mssv . "'," . $course_id . ",'" . $course . "'," . $id_schedule . ",'" . $schedule . "','" . $email . "','" . $phone . "','" . $address . "'," . $type_id . ")";

if ($conn->query($sql) === TRUE) {
    // create email headers
  
  echo "Đã đăng ký thành công.";
} else {
    echo "Đăng ký thất bại, vui lòng thử lại!";
}

$conn->close();

?>