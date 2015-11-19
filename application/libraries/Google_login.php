<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author khanhpt <khanhpt@vng.com.vn> 0972014011
 * @copyright Pham Tuan Khanh
 * 
 * Login with google account library
 * 
 * @package PenguinFW
 * @subpackage Google
 * @version 1.0.0
 */

//set up thirth party
ini_set('include_path', FPENGUIN . 'application/third_party/google-sdk' . PATH_SEPARATOR . ini_get('include_path'));
require_once 'Google_Client.php';
require_once 'contrib/Google_Oauth2Service.php';
class Google_login{
	private $gClient=null;
	private $gOauth2=null;
	private $gAccessToken=null;
	private $gUser=null;
	public function __construct() {    
		if (!session_id()) {
		  session_start();
		}
		$this->gClient = new Google_Client();
		$this->gOauth2 = new Google_Oauth2Service($this->gClient);
    }
	/* get google authentication url
	   return authentication URL */
	public function getGoogleLoginURL(){
		return $this->gClient->createAuthUrl();
	}
	/* set google access token */
	public function setGoogleAccessToken($token){
		$this->gAccessToken = $token;
	}
	/* get google access token */
	public function getGoogleAccessToken(){
		return $this->gClient->getAccessToken();
	}
	public function logoutGoogle(){
		$this->gClient->revokeToken();
	}
	/* authenticate user */
	public function authGoogleAccount(){
		$this->gClient->authenticate();
		$this->gAccessToken = $this->gClient->getAccessToken();
		$this->setGoogleAccessToken($this->gAccessToken);
		// $redirect = filter_var('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REDIRECT_URL'], FILTER_SANITIZE_URL);
		// return $redirect;
	}
	/* get google user data */
	function getGoogleUserProfile(){
		$this->gUser = $this->gOauth2->userinfo->get();
		return $this->gUser;
	}
}
?>
