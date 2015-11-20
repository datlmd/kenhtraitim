<?php
    $servername = "localhost";  // server name
    
    // $username = "root";         // username
    // $password = "";   // password
    // $dbname = 'dangky';    // database

    $username = "flicportal_db";
$password = "flic@portal.!@#$";
$dbname = "flicportal_db";

    $tables = array('users'); // array of tables need to export
 
    $file_name = 'export_school.csv';   // file name
    $file_path = 'downloads/'.$file_name; // file path
 
    // Create connection
    $conn = new mysqli($servername, $username, $password);
 
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
 
     

    mysqli_set_charset($conn, "utf8");
    mb_internal_encoding('UTF-8');
    // select database
    mysqli_select_db($conn, $dbname);
 
    $file = fopen($file_path, "w"); // open a file in write mode
    chmod($file_path, 0777);    // set the file permission
 
    // loop for tables
    foreach($tables as $table) {
        $table_column = array();
        $query_table_columns = "SHOW COLUMNS FROM $table";
 
        // fetch table field names
        if ($result_column = mysqli_query($conn, $query_table_columns)) {
            while ($column = $result_column->fetch_row()) {
                $table_column[] = ($column[0]);
            }
        }
 
        // Format array as CSV and write to file pointer
        fputcsv($file, $table_column, ",", '"');
 
        $sql_get ="";
        if ($_GET['date_from'])
        {
            $sql_get .= " AND DATE(created) >= '" . $_GET['date_from'] . "'" ;
        }
        if ($_GET['date_to'])
        {
            $sql_get .= " AND DATE(created) <= '" . $_GET['date_to'] . "'" ;
        }

        $query_table_columns_data = "SELECT * FROM $table WHERE 1=1 " . $sql_get;
 
        if ($result_column_data = mysqli_query($conn, $query_table_columns_data)) {
 
            // fetch table fields data
            while ($column_data = $result_column_data->fetch_row()) {
                $table_column_data = array();
                foreach($column_data as $data) {
                    $table_column_data[] = mb_strtoupper($data, 'UTF-8');
                }
 
                // Format array as CSV and write to file pointer
                fputcsv($file, $table_column_data, ",", '"');
            }
        }
    }
 
    // close file pointer
    fclose($file);
 
 // ask either save or open
 //    header("Content-Type: application/xls"); 
 // header("Content-Disposition: attachment; filename=importdetails-".$ts.".xls");  
 // header("Pragma: no-cache"); 
 // header("Expires: 0");
 // header("Content-Transfer-Encoding: binary ");

    header('Content-Description: File Transfer');
    header("Pragma: public");
    header("Expires: 0");
    header("Content-Type: application/octet-stream");
    header('Content-Type: text/html;charset=UTF-8'); 
    header("Content-Disposition: attachment; filename={$file_name};" );
    header("Content-Transfer-Encoding: binary");

 
    // open a saved file to read data
    $fhandle = fopen(iconv("UTF-8", "ISO-8859-1//TRANSLIT",$file_path), 'r');
    fpassthru($fhandle);
    fclose($fhandle);
    $conn->close();
    die;
?>