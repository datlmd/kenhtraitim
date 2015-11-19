<?php
include_once 'SSO_Config.php';	
class XCheckLogin{
	function XCheckLogin(){
		$sid = isset($_GET['sid']) ?  $_GET['sid'] : '';
		
		if(empty($sid))
		{
			header("Location: xdomain_login.php");
		}else{
			if($sid != 'none')
			{
				setcookie('session_info', $sid);	
			}else{
				setcookie('session_info', '');
			}
			header("Location: xdomain_login.php");
		}
	}
}
$xcLogin = new XCheckLogin();
?>
