<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


//set up thirth party
ini_set('include_path', FPENGUIN . 'application/third_party/Zalo-sdk/src' . PATH_SEPARATOR . ini_get('include_path'));

use exception\ZaloSdkException;
use service\ZaloServiceFactory;
use service\ZaloServiceConfigure;

require_once 'service/ZaloServiceFactory.php';
require_once 'service/ZaloMessageService.php';
require_once 'service/ZaloQueryService.php';
require_once 'service/ZaloUploadService.php';
require_once 'service/ZaloSocialService.php';
require_once 'service/ZaloServiceConfigure.php';
require_once 'exception/ZaloSdkException.php';

class Zalo {

    private $pageId = '1003569193993061741'; //page 's id
    private $secretKey = "B1VG8UEi7OZY8JDYsLmj"; //page's secret_key
    private $factory;
    private $messageService;

    function __construct() {
        $configure = new ZaloServiceConfigure($this->pageId, $this->secretKey);
        $this->factory = $configure->getZaloServiceFactory();
        $this->messageService = $this->factory->getZaloMessageService();
    }

    /**
     * Function get secretkey
     * @return string secret key
     */
    public function getSecretKey() {
        return $this->secretKey;
    }

    /**
     * Function to get user profile from Zalo
     * @param type $toUid id of user
     * @return array user_data('userId','displayName','avatar','gender')
     */
    public function getProfile($toUid) {
        $user_profile = $this->factory->getZaloQueryService()->getProfile($toUid);
        if ($user_profile != null) {
            $user_data = array(
                'userId' => $user_profile->getUserId(),
                'displayName' => $user_profile->getDisplayName(),
                'avatar' => $user_profile->getAvatar(),
                'gender' => $user_profile->getUserGender()
            );
            return $user_data;
        } else {
            return FALSE;
        }
    }

    /**
     * Function to upload image to Zalo
     * @param type $pathPhoto file path in local of image
     * @return string Id of image after upload to zalo
     */
    public function uploadImage($pathPhoto) {
        $photoId = $this->factory->getZaloUploadService()->uploadImage($pathPhoto);
        return $photoId;
    }

    /**
     * Function to send text message to user
     * @param type $toUid id of user
     * @param type $message text message send to user
     * @param type $sms
     * @param type $isNotify notify to user (default is FALSE)
     * @return boolean True is send message success
     */
    public function sendTextMessage($toUid, $message, $sms, $isNotify) {
        $result = $this->messageService->sendTextMessage($toUid, $message, $sms, $isNotify);
        //Check success service
        if ($result->getError() >= 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Function to send Image message to user
     * @param type $toUid id of user
     * @param type $message text message send to user
     * @param type $photoId id of photo get from uploadImage($pathPhoto)
     * @param type $sms
     * @param type $isNotify notify to user (default is FALSE)
     * @return boolean True is send message success
     */
    public function sendImageMessage($toUid, $message, $photoId, $smsMsg, $isNotify) {
        $result = $this->messageService->sendImageMessage($toUid, $message, $photoId, $smsMsg, $isNotify);
        //Check success service
        if ($result->getError() >= 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
