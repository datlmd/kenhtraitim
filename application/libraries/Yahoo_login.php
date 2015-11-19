<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author khanhpt <khanhpt@vng.com.vn> 0972014011
 * @copyright Pham Tuan Khanh
 * 
 * Login with yahoo account library
 * 
 * @package PenguinFW
 * @subpackage Yahoo
 * @version 1.0.0
 */

//set up thirth party
ini_set('include_path', FPENGUIN . 'application/third_party/yahoo-sdk' . PATH_SEPARATOR . ini_get('include_path'));

require_once "lib/Yahoo.inc";
require_once "lib/config.php";
class Yahoo_login{
	public function __construct() {    
		if (!session_id()) {
		  session_start();
		}
    }
    /*get authentication url
    return authentication url
	@param $callback => url callback
    */
    public function getAuthenticateURL($callback){
		$sessionStore = new NativeSessionStore();
		$auth_url = YahooSession::createAuthorizationUrl(OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET, $callback, $sessionStore);
		return $auth_url;
    }
    /*get yahoo session
   		return yahoo session (true/false)
    */
    public function getYahooSession(){
    	$hasSession = YahooSession::hasSession(OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET, OAUTH_APP_ID);
		return $hasSession;
    }
	/* clear yahoo session */
    public function clearYahooSession(){
		YahooSession::clearSession();
	}
	public function getYahooProfile(){
		$session = YahooSession::requireSession(OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET, OAUTH_APP_ID);
		$profile = null;
		if($session) {
			// Get the currently sessioned user.
			$user = $session->getSessionedUser();
			// Load the profile for the current user.
			$profile = $user->getProfile();
			return $profile;
		}
		return $profile;
	}
}
?>
