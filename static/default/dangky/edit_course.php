<?php

$servername = "localhost";

$username = "root";
$password = "";
$dbname = "dangky";

// $username = "flicportal_db";
// $password = "flic@portal.!@#$";
// $dbname = "flicportal_db";

if(!isset($_POST['id']) || !isset($_POST['name']) 
  || $_POST['id'] == '' || $_POST['name'] == '') {
  die('We are sorry, but there appears to be a problem with the form you submitted.');       
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
mysqli_set_charset($conn, "utf8");
if(isset($_POST['id']) && $_POST['id'] == 0){
//check null
  if(isset($_POST['name']) && $_POST['name'] != '') {
    $name = strip_tags($_POST['name']);
    if($_POST['parent_id'] > 0)
      $parent_id = strip_tags($_POST['parent_id']);   
    else
      $parent_id = 0;

    $sql = "INSERT INTO user_courses (created, name, parent_id, status)
    VALUES ('" . date('Y-m-d H:i:s') . "','" . $name . "','" . $parent_id . "','" . 1 . "')";

    if ($conn->query($sql) === TRUE) {
        // create email headers
      echo "Đã đăng ký thành công.";die;
    } else {
        echo "Đăng ký thất bại, vui lòng thử lại!";die;
    }
  }
}
else{
	$name = strip_tags($_POST['name']);
    if($_POST['parent_id'] > 0)
      $parent_id = strip_tags($_POST['parent_id']);   
    else
      $parent_id = 0;
  	$id = strip_tags($_POST['id']);
	$sql = "UPDATE user_courses 
		SET name = '" . $name  . "', parent_id = '" . $parent_id . "' 
 		WHERE id = '" . $id . "'";
 	if ($conn->query($sql) === TRUE) {
    // create email headers
  
 		 echo "Đã cập nhật thành công.";
	} else {
	    echo "Cập nhật thất bại, vui lòng thử lại!";
	}
}

$conn->close();

?>