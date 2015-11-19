<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author tungcn <cntung2187@gmail.com> 0909898592
 * @copyright Chung Nhut Tung 2011
 * 
 * Check VNG SSO
 * 
 * @package PenguinFW
 * @subpackage SSO
 * @version 1.0.0
 */
ini_set('include_path', FPENGUIN . 'application/third_party/XSSO/' . PATH_SEPARATOR . ini_get('include_path'));
require_once "CXSSO.php";

class Vng_xsso
{
	var $cookies = "";
	var $return_login_fail_url = "";
	var $return_login_success_url = "";
	var $return_logout_url = "";
	var $product_id = "";
	var $error_message = "";
	
	function __construct() {
		//$this->cookies = CXSSO::getCookies();
	}
	
	public function check_xsso(){
		$localSS = $_COOKIE['session_info'];
		$status = FALSE;
		if($localSS != NULL && !empty($localSS)) {
			$status = $this->getLoginInfo($localSS);
		}
		else {
			$sid = isset($_GET['sid']) ?  $_GET['sid'] : '';
			$mess = isset($_GET['mess']) ?  $_GET['mess'] : '';
			$err = isset($_GET['err']) ?  $_GET['err'] : '';
			if( !empty($sid) && $sid != 'none') {
				$status = $this->getLoginInfo($sid);
			}
			else {
				if($mess != 'succ' && !empty($err)) {
					//$this->error_message = 'Ten dang nhap hoac mat khau khong dung';
				}
				else {
					$this->error_message = '';
				}
				setcookie('session_info', '');
			}
		}
		
		return $status;
	}
	
	function getLoginInfo($sid)
	{
		$vngSession = CXSSO::checkVNGSession($sid);
		
		if ( !$vngSession) {
			setcookie('session_info', '');
			return FALSE;
		}
		else {
			setcookie('session_info',$sid);
			$localSession = array(
					'accLogin' => $vngSession->accountName,
					'passportID' => $vngSession->uin			
				);
			
			$_SESSION['user_pp'] = $localSession;
			
			return TRUE;
		}
	}
}