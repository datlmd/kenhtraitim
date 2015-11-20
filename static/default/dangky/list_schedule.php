<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Danh sách học viên</title>
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
<link href="css/bootstrap-datetimepicker.css" rel="stylesheet">
<script src="js/moment-with-locales.js"></script>
<script src="js/bootstrap-datetimepicker.js"></script>
<SCRIPT TYPE="text/javascript">
function dang_ky() {

  var txtname = $.trim($('#name').val());
  var txtcourse_id = $.trim($('#course_id').val());

  if (txtname.length < 1) {
    alert('Vui lòng nhập Lịch học!');
    return false;
  }

  if (txtcourse_id == -1) {
    alert('Vui lòng nhập Khoá học!');
    return false;
  }

  $('#btn-accept').attr('style', 'pointer-events:none');

  var postData = $('#frm-dang-ky').serializeArray();

  $.post('edit_schedule.php',
   postData,
   function(data){
      alert( data);
  });

  $('#btn-accept').removeProp('style');
  return false;
}
</SCRIPT>
  </head>
  <body>
  	<?php

	$servername = "localhost";

$username = "root";
$password = "";
$dbname = "dangky";

// $username = "flicportal_db";
// $password = "flic@portal.!@#$";
// $dbname = "flicportal_db";


	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

  mysqli_set_charset($conn, "utf8");

  if (isset($_GET['id']) && $_GET['id'] > 0)
  {
      $sql_edit = "SELECT * FROM user_schedules WHERE id=" . $_GET['id'];
      $result = $conn->query($sql_edit);

      while($row_edit = $result->fetch_array())
      {

          $row_edits[] = $row_edit;

      }
  }

	?>
    <div class="container">
      
          <div class="row placeholders">
            
            <div class="col-xs-6 col-sm-3 placeholder">
              <span class="text-muted">
               
                </span>

            </div>
          </div>

          <h3 class="sub-header">Danh sách lịch học </h3>
          <div class="table-responsive">
            <form role="form" id="frm-dang-ky" method="post">
                <div class="form-group">
                  <table class="table table-striped" style="">
                    <tbody>
                      <tr style="background-color:#fff; border-top: 0px solid #fff;">
                        
                        <td style="border-top: 0px solid #fff;">
                          <?php
                            if(isset($_GET['id'])  && $_GET['id'] > 0)
                              echo '<input id="id" name="id" class="form-control" type="hidden" value="' . $row_edits[0]['id'] . '"/>';
                            else
                              echo '<input id="id" name="id" class="form-control" type="hidden" value="0"/>';
                            if (isset($_GET['id'])  && $_GET['id'] > 0)
                              echo '<input id="name" name="name" class="form-control" type="text" placeholder="Lịch học" value="' . $row_edits[0]['name'] . '" />';
                            else
                              echo '<input id="name" name="name" class="form-control" type="text" placeholder="Lịch học" value="" />';
                          ?>
                        </td>
                        <td style="border-top: 0px solid #fff;">
                          <select id="course_id" name="course_id" class="form-control">
                            <option value="-1">-----Chọn khoá học-----</option>
                          <?php
                          $sql = "SELECT * FROM user_courses WHERE parent_id != 0 Order By id desc";
                          //var$result = $conn->query($sql);
                          $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                              while($row = $result->fetch_array())
                              {
                                $rows[] = $row;
                              }
                              foreach($rows as $item) { 
                                if($_GET['id'] && $_GET['id'] > 0)
                                  if($row_edits[0]['course_id'] == $item['id'])
                                    echo '<option value="' . $item['id'] . '" selected>' . $item['name'] . '</option>';
                                  else
                                    echo '<option value="' . $item['id'] . '">' . $item['name'] . '</option>';
                                else
                                  echo '<option value="' . $item['id'] . '">' . $item['name'] . '</option>';
                              }
                            };
                          ?>
                          </select>
                        </td>
                        <td style="border-top: 0px solid #fff;">
                          <?php
                            if(isset($_GET['id'])  && $_GET['id'] > 0){
                              echo '<button id="btn-accept" type="button" onclick="javascript:dang_ky();" class="btn btn-success">Cập nhật</button> ';
                              echo '<a href="list_schedule.php" class="btn btn-success">Tạo mới</a>';
                            }
                            else
                              echo '<button id="btn-accept" type="button" onclick="javascript:dang_ky();" class="btn btn-success">Thêm mới</button>';
                          ?>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                    
                    
                </div>
                
            </form>
            <div style="height:400px; overflow: scroll-y;">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th></th>
                  <th>ID</th>
                  <th>Ngày ĐK</th>
                  <th>Lịch học</th>
                  <th>Trạng thái</th>
                  <th>Khoá học</th>
                  
                </tr>
              </thead>
              <tbody>
              	<?php
              		

             


              		$sql = "SELECT user_schedules.*, user_courses.name AS course FROM user_schedules, user_courses WHERE user_courses.id = user_schedules.course_id Order By id desc";
                  //var_dump($sql);
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
              $rows = null;

						while($row = $result->fetch_array())
						{
							$rows[] = $row;
						}
					  foreach($rows as $item) { 
					  	echo '<tr>';
              echo '<td><a href="list_schedule.php?id=' . $item['id'] . '">Edit</a></td>';
					  	echo '<td>' . $item['id'] . '</td>';
					  	if($item['created'] != null || $item['created'] != '')
					  		echo '<td>' . $item['created'] . '</td>';
					  	else
					  		echo '<td>2015-11-02 00:00:00</td>';
					  	echo '<td>' . $item['name'] . '</td>';
					  	echo '<td>' . $item['status'] . '</td>';
					  	echo '<td>' . $item['course'] . '</td>';
              
					  	echo '</tr>';
					  }
					}
$conn->close();
              	?>
                
              </tbody>
            </table>
          </div>
        </div>
    </div>
    
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

  </body>
</html>
 
