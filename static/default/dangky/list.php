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
  </head>
  <body>
  	<?php

	$servername = "localhost";

// $username = "root";
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

	?>
    <div class="container">
      
          <div class="row placeholders">
            
            <div class="col-xs-6 col-sm-3 placeholder">
              <span class="text-muted">
                <?php
                $sql_get ="?";
                if ($_GET['date_from'])
                {
                    $sql_get .= "&date_from=" . $_GET['date_from'] ;
                }
                if ($_GET['date_to'])
                {
                    $sql_get .= "?date_to=" . $_GET['date_to'] ;
                }
                echo '<a href="export.php' . $sql_get . '">Xuất danh sách</a>';
                ?>
                </span>

            </div>
          </div>

          <h3 class="sub-header">Danh sách đăng ký lịch học </h3>
          <div class="table-responsive">
            <form role="form" action="list.php" method="get">
                <div class="form-group">
                  <table class="table table-striped" style="">
                    <tbody>
                      <tr style="background-color:#fff;">
                        <td style="max-width: 170px; border-top: 0px solid #fff;" >
                          <div class="form-group">
                              <div class='input-group date datetimepicker' id='datetimepicker1'>
                                  <input type='text' id="date_from" name="date_from" class="form-control" placeholder="Từ ngày" />
                                  <span class="input-group-addon">
                                      <span class="glyphicon glyphicon-calendar"></span>
                                  </span>
                              </div>
                          </div>
                          <script type="text/javascript">
                              $(function () {
                                  $('.datetimepicker').datetimepicker({
                                    format: 'YYYY-MM-DD'
                                  });
                              });
                          </script>
                        </td>
                        <td style="max-width: 170px; border-top: 0px solid #fff;">
                          <div class="form-group">
                              <div class='input-group date datetimepicker' id='datetimepicker1'>
                                  <input type='text' id="date_to" name="date_to" class="form-control" placeholder="Đến ngày" />
                                  <span class="input-group-addon">
                                      <span class="glyphicon glyphicon-calendar"></span>
                                  </span>
                              </div>
                          </div>
                          <script type="text/javascript">
                              $(function () {
                                  $('.datetimepicker').datetimepicker({
                                    format: 'YYYY-MM-DD'
                                  });
                              });
                          </script>
                        </td>
                        <td style="border-top: 0px solid #fff;"></td>
                        <td style="border-top: 0px solid #fff;"></td>
                      </tr>
                      <tr style="background-color:#fff; border-top: 0px solid #fff;">
                        
                        <td style="border-top: 0px solid #fff;"><input id="mssv" name="mssv" class="form-control" type="search" placeholder="Mã số" /></td>
                        <td style="border-top: 0px solid #fff;"><input id="name" name="name" class="form-control" type="search" placeholder="Tên" /></td>
                        <td style="border-top: 0px solid #fff;"><input id="phone" name="phone" class="form-control" type="search" placeholder="Điện thoại" /></td>
                        <td style="border-top: 0px solid #fff;"><button id="btn-accept" type="submit" class="btn btn-success">Tìm kiếm</button></td>
                      </tr>
                    </tbody>
                  </table>
                    
                    
                </div>
                
            </form>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th></th>
                  <th>ID</th>
                  <th>Ngày ĐK</th>
                  <th>Tên</th>
                  <th>Họ</th>
                  <th>Email</th>
                  <th>Điện thoại</th>
                  <th>SVNH </th>
                  <th>MSSV/CMND</th>
                  <th>Địa điểm học</th>
                  <th>Lớp</th>
                  <th>Lịch học</th>
                  
                </tr>
              </thead>
              <tbody>
              	<?php
              		mysqli_set_charset($conn, "utf8");

              		$baitren_mottrang = 20; // Tổng số tin hiện trên 1 trang

					// Nếu chưa chọn trang để xem. thì ta mặc định người dùng xem đang số 0 .  
					if (!$_GET['page'])
					{
					    $page = 0 ;
					}
					else{
						$page = $_GET['page'] ;
					}
          $sql_where = "";
          if ($_GET['mssv'])
          {
              $sql_where .= " AND mssv like '%" . $_GET['mssv'] . "%'" ;
          }
          if ($_GET['name'])
          {
              $sql_where .= " AND full_name like '%" . $_GET['name'] . "%'" ;
          }
          if ($_GET['phone'])
          {
              $sql_where .= " AND phone like '%" . $_GET['phone'] . "%'" ;
          }
          if ($_GET['date_from'])
          {
              $sql_where .= " AND DATE(created) >= '" . $_GET['date_from'] . "'" ;
          }
          if ($_GET['date_to'])
          {
              $sql_where .= " AND DATE(created) <= '" . $_GET['date_to'] . "'" ;
          }
					// Đầu tiên bạn phải lấy số dữ liệu để xem, trong data bạn có bao nhiêu bài post
					$sql = "SELECT * FROM users WHERE 1=1 " . $sql_where . " Order By id desc";
					$total = $conn->query($sql);
					$sodu_lieu = $total->num_rows;
					/* Ví dụ ta có 
					20 bài viết trong data. 
					mỗi trang hiển thị 10 bài
					=> Chúng ta có 20/10 = 2 trang 
					*/
					$sotrang = $sodu_lieu/$baitren_mottrang;


              		$sql = "SELECT * FROM users WHERE 1=1 " . $sql_where . " Order By id desc LIMIT " . $page*$baitren_mottrang . ',' . $baitren_mottrang . "";
                  //var_dump($sql);
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
						while($row = $result->fetch_array())
						{
							$rows[] = $row;
						}
					  foreach($rows as $item) { 
					  	echo '<tr>';
              echo '<td><a href="update.php?id=' . $item['id'] . '">Edit</a></td>';
					  	echo '<td>' . $item['id'] . '</td>';
					  	if($item['created'] != null || $item['created'] != '')
					  		echo '<td>' . $item['created'] . '</td>';
					  	else
					  		echo '<td>2015-11-02 00:00:00</td>';
					  	echo '<td>' . $item['full_name'] . '</td>';
					  	echo '<td>' . $item['last_name'] . '</td>';
					  	echo '<td>' . $item['email'] . '</td>';
					  	echo '<td>' . $item['phone'] . '</td>';
					  	echo '<td>' . $item['user_type'] . '</td>';
					  	echo '<td>' . $item['mssv'] . '</td>';
					  	echo '<td style="min-width:200px">' . $item['address'] . '</td>';
					  	echo '<td>' . $item['course'] . '</td>';
					  	echo '<td>' . $item['schedule'] . '</td>';
              
					  	echo '</tr>';
					  }
					}

              	?>
                
              </tbody>
            </table>
            <?php

	            if($sotrang > 1){
	            	echo '<ul class="pagination pagination-sm">';
	            	for ( $page = 0; $page < $sotrang; $page ++ )
					{
					echo "<li><a href='list.php?page={$page}'>{$page}</a></li>";
					}
					echo '</ul>';
	            }
            ?>
          </div>
    </div>
    
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

  </body>
</html>
 
