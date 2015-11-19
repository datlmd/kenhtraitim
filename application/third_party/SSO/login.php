<?php
include 'CSSO.php';
include_once 'SSO_Config.php';
class Login{
	var $cookies = "";
	var $return_login_fail_url = "";
	var $return_login_success_url = "";
	var $return_logout_url = "";
	var $product_id = "";
	var $error_message = "";
	function Login(){
		$this->cookies = CSSO::getCookies();//Lấy cookies tại client	
		$this->return_login_fail_url = "http://product.zing.vn/SSO/login.php";//Trở về trang này khi login không thành công
		$this->return_login_success_url = "http://product.zing.vn/SSO/login.php";	//Trở về trang này khi login thành công
		$this->return_logout_url = "http://product.zing.vn/SSO/login.php";//Trở về trang này sau khi logout	
		$this->product_id = 19;//Mã sản phẩm hiện tại, passport đã cung cấp trước đây
		
		//check return code
		$mess = isset($_GET['mess']) ?  $_GET['mess'] : '';
		$err = isset($_GET['err']) ?  $_GET['err'] : '';
		if($mess == 'succ')
		{
			$this->error_message = "";
		}else{
			switch($err)
			{
				case '2001':
					$this->error_message = "Tên đăng nhập hoặc mật khẩu không đúng";
					break;
				case '1001':
					$this->error_message = "Lỗi tạo VNG session";
					break;
				case '1003':
					$this->error_message = "Lỗi service PP";
					break;
				default:
					$this->error_message = "Tái khoản hoặc mật khẩu không đúng";
				break;
			}
		}
	}
	/**
	Check Login
	Giá trị trả về của vngSession:
		[session] => FwSession_Session Object
        (
            [createTime] => 0
            [lastAccess] => 0
            [uin] => 0 //PP id
            [zin] => 0//not use at this time
            [accountName] => //zing nick
            [hostname] => //host of client
            [useragent] => //IP
        )
	**/
	function checkLogin(){
		$vngSession = CSSO::checkVNGSession($this->cookies);//Kiểm tra login tai VNG server chưa
		if(!$vngSession){
			return $this->showLoginForm();
		}
		//Nếu trạng thái là logged in, khởi tạo session local để lưu các thông tin trả về
		$localSession = array(
			'accLogin' => $vngSession->accountName,
			'passportID' => $vngSession->uin			
		);		
		$_SESSION['localSession'] = $localSession;
		//Hiển thị link thoát
		echo '<a href="'.URL_LOGOUT.$this->return_logout_url.'">Thoát</a>';
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
				<form action="'.URL_VNG_SSO.'?method=login" method="post">
				  <div>
				  	<span style="color:red">'.$this->error_message.'</span>
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
	/**
		
	**/
	function logout(){
		return CSSO::logout($this->return_url_logout);
	}
}
$Login = new Login();
$Login->checkLogin();
?>
