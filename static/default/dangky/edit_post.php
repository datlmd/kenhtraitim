<?php

$servername = "localhost";

// $username = "root";
// $password = "";
// $dbname = "dangky";

$username = "flicportal_db";
$password = "flic@portal.!@#$";
$dbname = "flicportal_db";


//check null
if(!isset($_POST['full_name']) || !isset($_POST['last_name']) || !isset($_POST['course_id']) || !isset($_POST['id_schedule']) || !isset($_POST['mssv']) || !isset($_POST['id']) || !isset($_POST['email']) ||!isset($_POST['phone'])
  || $_POST['full_name'] == '' || $_POST['last_name'] == '' || $_POST['course_id'] == '' || $_POST['id_schedule'] == '' || $_POST['mssv'] == '' || $_POST['id'] == '' || $_POST['email'] == '' || $_POST['phone'] == '') {
  die('We are sorry, but there appears to be a problem with the form you submitted.');       
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$id = strip_tags($_POST['id']);
$name = strip_tags($_POST['full_name']);
$last_name = strip_tags($_POST['last_name']);
$mssv = strip_tags($_POST['mssv']);

$email = strip_tags($_POST['email']);
$phone = strip_tags($_POST['phone']);
$address = strip_tags($_POST['address']);
$type_id = strip_tags($_POST['type_id']);

$course_id = strip_tags($_POST['course_id']);
$id_schedule = strip_tags($_POST['id_schedule']);
$course = str_replace('-- ','', strip_tags($_POST['course']));
$schedule = strip_tags($_POST['schedule']);


//date_default_timezone_set("Asia/Calcutta");
mysqli_set_charset($conn, "utf8");
$sql = "UPDATE users 
SET full_name = '" . $name  . "', last_name = '" . $last_name . "', mssv = '" . $mssv . "',  email = '" . $email . "', phone = '" . $phone . "', address = '" . $address .  "', user_type = '" . $type_id . "',
 id_course = '" . $course_id . "', course = '" . $course . "', id_schedule = '" . $id_schedule . "', schedule = '" . $schedule . "' 
 WHERE id = '" . $id . "'";
//var_dump($sql);
if ($conn->query($sql) === TRUE) {
    // create email headers
  
  echo "Đã cập nhật thành công.";
} else {
    echo "Cập nhật thất bại, vui lòng thử lại!";
}

$conn->close();

?>