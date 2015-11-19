<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
//set up thirth party
ini_set('include_path', FPENGUIN . 'application/third_party/zingme-sdk' . PATH_SEPARATOR . ini_get('include_path'));
require_once 'BaseZingMe.php';
require_once 'ZME_FeedDialog.php';
require_once 'ZME_Me.php';
require_once 'ZME_Photo.php';
require_once 'ZME_User.php';
require_once 'ZME_UserLevel.php';

/**
 * Author: dungdv3@vng.com.vn
 * Created date: 30/09/2013
 * This help contain many function use to call API of Zing_me
 */
class Zing_me {

    //URL App ZingMe http://me.zing.vn/apps/fp_wada
    private $config = array(
        'appname' => ZM_APPNAME,
        'fanname' => ZM_FANNAME,
        'apikey' => ZM_APIKEY,
        'secretkey' => ZM_SECRETKEY,
        'env' => 'production'
    );
    private $ZME_Me;
    private $ZME_FeedDialog;
    private $ZME_Photo;
    private $ZME_User;
    private $ZME_UserLevel;
    private $access_token;
    private $user_info;

    /**
     * Constructor 
     */
    function __construct() {
        $this->ZME_Me = new ZME_Me($this->config);
        $this->ZME_FeedDialog = new ZME_FeedDialog($this->config);
        //$this->get_access_token();
    }

    /**
     * Return public key of app in Zing Me
     * @return String public key
     */
    public function get_pub_key() {
        return $this->config['apikey'];
    }

    /**
     * Get access token for app
     * @param string $signed_request that get by $_REQUEST
     * @return string access token
     */
    public function get_access_token() {
        $signed_request = $_REQUEST['signed_request'];
        $this->access_token = $this->ZME_Me->getAccessTokenFromSignedRequest($signed_request);
        return $this->access_token;
    }

    /**
     * Get access token for app
     * @param string $auth_code that get by $_GET['code']
     * @return string access token
     */
    public function get_access_token_from_code($auth_code) {
        $return = $this->ZME_Me->getAccessTokenFromCode($auth_code);
        $this->access_token = $return['access_token'];
        return $this->access_token;
    }

    /**
     * check fan of fanpage
     * @return boolean
     */
    public function isFanOf() {
        if ($this->access_token == null) {
            $this->get_access_token();
        }

        return $this->ZME_Me->isFanOf($this->access_token, $this->config['fanname']);
    }

    /**
     * This function get full info of user Zing Me
     * @param String $access_token
     * @return Array infomation of user who logged in
     */
    public function get_info_user_logged_in() {
        if ($this->access_token == null) {
            $this->get_access_token();
        }
        $this->user_info = $this->ZME_Me->getInfo($this->access_token, 'id,username,displayname,tinyurl,profile_url,gender,dob');
        return $this->user_info;
    }

    /**
     * This function get full info of user Zing Me
     * @param String $access_token
     * @return Array infomation of user who logged in
     * gender:-1:invalid|0:male|1:female
     */
    public function get_info_user_sso($auth_code) {
        if ($this->access_token == null) {
            $this->get_access_token_from_code($auth_code);
        }
        $this->user_info = $this->ZME_Me->getInfo($this->access_token, 'id,username,displayname,tinyurl,profile_url,gender,dob');
        return $this->user_info;
    }

    /**
     * This function will get birthday of user from Zingme Graph
     * @return date Y-m-d is birthday of user
     */
    public function get_dob_user_logged_in() {
        if ($this->access_token == null) {
            $this->get_access_token();
        }
        $this->user_info = $this->ZME_Me->getInfo($this->access_token, 'dob');
        return(date('Y-m-d', $this->user_info['dob']));
    }

    /**
     * This function will get gender of user from Zingme Graph
     * @return int 1:male|0:female|-1:unknown
     */
    public function get_gender_user_logged_in() {
        if ($this->access_token == null) {
            $this->get_access_token();
        }
        $this->user_info = $this->ZME_Me->getInfo($this->access_token, 'gen der');
        if ($this->user_info['gender'] == 0) {
            //Nam
            return 1;
        } elseif ($this->user_info['gender'] == 1) {
            //Nữ
            return 0;
        } else {
            //Khác
            return -1;
        }
    }

    /**
     * This function help to get feed Item before get sig key to push feed to user's wall
     * Create new feed item
     * @param type $feed_info = array(
      'userIdFrom' => $userIdFrom,
      'userIdTo' => $userIdTo,
      'actId' => $actId,
      'tplId' => $tplId,
      'objectId' => $objectId,
      'attachName' => $attachName,
      'attachHref' => $attachHref,
      'attachCaption' => $attachCaption,
      'attachDescription' => $attachDescription,
      'mediaType' => $mediaType,
      'mediaImage' => $mediaImage,
      'mediaSource' => $mediaSource,
      'actionLinkText' => $actionLinkText,
      'actionLinkHref'=>$actionLinkHref);
     */
    public function get_feed_item($feed_info) {
        $feedItem = new ZME_FeedItem($feed_info['userIdFrom'], $feed_info['userIdTo'], $feed_info['actId'], $feed_info['tplId'], $feed_info['objectId'], $feed_info['attachName'], $feed_info['attachHref'], $feed_info['attachCaption'], $feed_info['attachDescription'], $feed_info['mediaType'], $feed_info['mediaImage'], $feed_info['mediaSource'], $feed_info['actionLinkText'], $feed_info['actionLinkHref']);
        return $feedItem;
    }

    /**
     * This function return the signature key of feed item when push feed
     * @param Object $feedItem
     * @return String signature key
     */
    public function get_sig_key($feedItem) {
        return $this->ZME_FeedDialog->genFeedSigForDialog($feedItem);
    }

    /**
     * This function will get list friend of user from Zingme Graph
     * @return array id friends of user
     */
    public function get_friends() {
        return $this->ZME_Me->getFriends($this->access_token);
    }

    /**
     * 
     * This function return url to get login
     * @param type $redirect
     * @param type $return_url
     * @return type
     */
    public function zm_get_login_url($redirect, $return_url = "") {
        $state = rand(1, 100000);
        $url_login = $this->ZME_Me->getUrlAuthorized($redirect . '?return_url=' . $return_url, $state);
        $_SESSION["get_zm_url_login"] = $url_login;
        return $url_login;
    }

}
