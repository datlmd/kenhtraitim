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
ini_set('include_path', FPENGUIN . 'application/third_party/SSO/' . PATH_SEPARATOR . ini_get('include_path'));
require_once "CSSO.php";

class Vng_sso
{
	var $cookies = "";
	var $return_login_fail_url = "";
	var $return_login_success_url = "";
	var $return_logout_url = "";
	var $product_id = "";
	var $error_message = "";
	
	function __construct() {
		$this->cookies = CSSO::getCookies();
	}
	
	/**
	 * 
	 * Enter description here ...
	 * 
	 * @return boolean
	 */
	public function check_sso() {
		$vngSession = CSSO::checkVNGSession($this->cookies);//Kiem tra login tai VNG server chua
		
		if(!$vngSession || empty($vngSession->accountName)){
			return FALSE;
		}
		// neu trang thai la logged in, khoi tao session local de luu cac thong tin tra ve
		$localSession = array(
					'accLogin' => $vngSession->accountName,
					'passportID' => $vngSession->uin			
		);
		
		$_SESSION['user_pp'] = $localSession;
		// Hien thi link thoat
		return TRUE;
	}
}