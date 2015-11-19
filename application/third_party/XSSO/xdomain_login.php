<?php
include 'CXSSO.php';
include_once 'SSO_Config.php';	
class XLogin{
	var $return_check_url = "";
	var $return_login_fail_url = "";
	var $return_login_success_url = "";
	var $return_logout_url = "";
	var $product_id = "";
	var $error_message='';
	var $env = 'xsso';
	function XLogin(){
		$this->return_check_url = "http://sso.com.vn/xsso/xdomain_checklogin.php";//Trở về trang này sau khi logout	
		$this->return_login_fail_url = "http://sso.com.vn/".$this->env."/xdomain_login.php";//Trở về trang này khi login không thành công
		$this->return_login_success_url = "http://sso.com.vn/".$this->env."/xdomain_login.php";	//Trở về trang này khi login thành công
		$this->return_logout_url = "http://sso.com.vn/".$this->env."/xdomain_login.php";//Trở về trang này sau khi logout	
		$this->product_id = 1;//Mã sản phẩm hiện tại, passport đã cung cấp trước đây
		echo '<a href="http://sso.com.vn/'.$this->env.'/xdomain_login.php"> Vào trang login</a><br/>';
		echo $this->showLoginButton();
		$this->checkLocalLogin();
	}
	function checkLocalLogin(){
		$localSS = $_COOKIE['session_info'];
		if($localSS != NULL && !empty($localSS))
		{
			$this->getLoginInfo($localSS);
		}else{
			$sid = isset($_GET['sid']) ?  $_GET['sid'] : '';
			$mess = isset($_GET['mess']) ?  $_GET['mess'] : '';
			$err = isset($_GET['err']) ?  $_GET['err'] : '';
			if(!empty($sid) && $sid != 'none')
			{	
				$this->getLoginInfo($sid);
			}else{
				if($mess != 'succ' && !empty($err))
				{
					$this->error_message = 'Tên đăng nhập hay mật khẩu không đúng';
				}else{
					$this->error_message = '';
				}
				setcookie('session_info', '');
				return $this->showLoginForm();
			}
		}
	}
	function getLoginInfo($sid)
	{
		$vngSession = CXSSO::checkVNGSession($sid);
			//echo '<pre>';
			//print_r($vngSession);
			//exit;
		if(!$vngSession){
			setcookie('session_info', '');	
			return $this->showLoginForm();
		}else{
			setcookie('session_info',$sid);	
			echo 'Thông tin session trả về<br/><pre>';
			print_r($vngSession);
			echo '</pre>';
			echo '<a href="xdomain_logout.php">Thoát</a>';
			exit;
		}
	}
	function print_var($value, $exit = true)
	{
		echo '<pre>';
		print_r($value);
		if($exit)exit;
	}	
	/**
	Login form:
		Method: POST
		Action: http://sso2.zing.vn/index.php?method=login
		u : UserName(4-24 char)
		p : Password(6-32char)
		longtime : check/uncheck (cho phép ghi nhớ đăng nhập/ hoặc không)
		u1: return url khi login thành công.
		fp : return url khi login không thành công.
		pid : ProductID của sản phâm (passport cung cấp khi có product mới).
	**/	
	function showLoginForm(){
		$html = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<form action="'.URL_VNG_SSO.'?method=xdomain_login" method="post">
				  <div>
				  	<span style="color:red">'.$this->error_message.'</span><br/>
					<label style="width:100px;float:left">Tên đăng nhập</label>
					<input type="text" id="u" name="u" value="" maxlength="24" /><br/>
					<label style="width:100px;float:left">Mật khẩu</label>
					<input type="password" id="p" name="p" value="" maxlength="32" /><br/>
					<label style="width:100px;float:left">Mật khẩu</label>
					<input type="checkbox" name="longtime" id="longtime" /> Ghi nhớ đăng nhập <br/>
					<input type="hidden" name="u1" value="'.$this->return_login_success_url.'" />
					<input type="hidden" name="fp" value="'.$this->return_login_fail_url.'" />
					<input type="hidden" name="pid" value="'.$this->product_id.'" />
					<label style="width:100px;float:left">&nbsp;</label>
					<input type="submit" value="Đăng nhập" title="Đăng nhập" />
				  </div>
				</form>';
		echo $html;
		exit;
	}
	
	function showLoginButton()
	{
		$html = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<form action="'.URL_VNG_SSO.'?method=xcheck_login" method="post">
				  <div>
					<input type="hidden" name="u" value="'.$this->return_check_url.'" />
					<input type="hidden" name="aid" value="'.$this->product_id.'" />
					<input type="submit" value="Đăng nhập" title="Đăng nhập" />
				  </div>
				</form>';
		return $html;
	}
	/**
		
	**/
	function logout(){
		setcookie('session_info', '');
		return CXSSO::logout($this->return_url_logout);
	}
}
$XLogin = new XLogin();
?>
