<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author khanhpt <khanhpt@vng.com.vn> 0972014011
 * @copyright Pham Tuan Khanh
 * 
 * Login with facebook account library
 * 
 * @package PenguinFW
 * @subpackage Facebook
 * @version 1.0.0
 */
//set up thirth party
ini_set('include_path', FPENGUIN . 'application/third_party/facebook-sdk' . PATH_SEPARATOR . ini_get('include_path'));

require_once "facebook.php";
require_once "config.php";

class Facebook_login {

    private $fbObject = "";
    private $accessToken = "";
    private $user_profile = "";

    public function __construct() {
        if (!session_id()) {
            session_start();
        }
        $this->fbObject = new Facebook(array(
            'appId' => FB_APPID,
            'secret' => FB_SECRETKEY,
        ));
    }

    /* get facebook login url
      param : scope array (user permission on facebook)
      return facebook login url with scope
     */

    public function getFBLoginUrl($scope = array("email"), $redirect = "") {
        $scope = implode(",", $scope);
        $loginURL = $this->fbObject->getLoginUrl(array('scope' => $scope, 'redirect_uri' => $redirect));
        return $loginURL;
    }

    /* get facebook logout url;
      return facebook logout url
     */

    public function getFBLogoutUrl() {
        return $this->fbObject->getLogoutUrl();
    }

    /* get facebook user access token */

    public function getAccessToken() {
        return $this->fbObject->getAccessToken();
    }

    /* set facebook user access token */

    public function setAccessToken($token) {
        $this->$accessToken = $token;
    }

    /* get facebook user profile
      param fbId facebook userid
      return user profile as array.
     */

    public function getFBUserProfile($fbId) {
        $user = $this->fbObject->getUser();
        if ($user) {
            try {
                // Proceed knowing you have a logged in user who's authenticated.
                $this->user_profile = $this->fbObject->api('/' . $fbId);
                return $this->user_profile;
            } catch (FacebookApiException $e) {
                error_log($e);
                $user = null;
            }
        }
        return $this->user_profile;
    }

    /* get facebook user id
      return facebook userid
     */

    public function getFBUserId() {
        return $this->fbObject->getUser();
    }

    /* clear all facebook user session */

    public function destroyFacebookSession() {
        $this->fbObject->destroySession();
    }

    /* post user stream required publish_stream scope when get login url
      parm facebook access token
      param fbId, facebook user id
      param message, message post to wall
      return true/false
     */

    public function postFacebookMessage($fbAccessToken, $fbId, $message) {
        $this->fbObject->setAccessToken($fbAccessToken);
        $ret_obj = $this->fbObject->api('/' . $fbId . '/feed', 'post', array(
            'message' => $message
        ));
        if ($ret_obj['id'])
            return true;
        else
            return false;
    }

    /* post user stream required user_photos scope when get login url
      param fbId, facebook user id
      pram photoPath, path of photo upload
      param message, message of photo
      return true/false
     */

    public function postFacebookPhotos($fbAccessToken, $fbId, $photoPath, $message) {
        $this->fbObject->setAccessToken($fbAccessToken);
        $this->fbObject->setFileUploadSupport(true);
        $file = "@" . realpath($photoPath);
        $args = array(
            'message' => $message,
            "image" => $file
        );
        $ret_obj = $this->fbObject->api('/' . $fbId . '/photos', 'post', $args);
        if ($ret_obj['id'])
            return true;
        else
            return false;
    }

}

?>
