<?php
include_once 'SSO_Config.php';
class XLogout{
	var $return_logout_url = "";
	
	function XLogout(){
		$this->return_logout_url = "http://sso.com.vn/xsso/xdomain_login.php";//Trở về trang này sau khi logout	
		$this->logout();
	}
	function logout()
	{
		setcookie('session_info', '');
		header("Location: ".'http://ssolocal.zing.vn/?method=xdomain_logout&return='.$this->return_logout_url);
		exit;
	}
}
$lout = new XLogout();
?>
