<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common;

require_once (realpath(dirname(__FILE__) . "/../../vendor/autoload.php"));
require_once (realpath(dirname(__FILE__) . "/../exception/ZaloSdkException.php"));
require_once (realpath(dirname(__FILE__) . "/CommonInfo.php"));
require_once (realpath(dirname(__FILE__) . "/SecurityHelper.php"));
require_once (realpath(dirname(__FILE__) . "/../entity/ZaloPageResult.php"));
require_once (realpath(dirname(__FILE__) . "/../entity/ZaloMsgSttResult.php"));
require_once (realpath(dirname(__FILE__) . "/../entity/ZaloProfile.php"));
require_once (realpath(dirname(__FILE__) . "/../enum/ZaloMessageDataType.php"));
require_once (realpath(dirname(__FILE__) . "/../enum/ZPUserGender.php"));
require_once (realpath(dirname(__FILE__) . "/../enum/ZPTypeFeed.php"));

use exception\ZaloSdkException;
use Guzzle\Http\Client;
use enum\MESSAGESTATUS;
use enum\ZPUserGender;
use enum\ZPTypeFeed;

class ZaloSdkHelper {

    public static function buildRequestA($pageId, $toUid, $message, $act, $servlet, $timeStamp) {

        ValidateFunc::checkNotNull($pageId, "Page id can't be null");
        ValidateFunc::checkNotNull($toUid, "To user id can't be null");
        ValidateFunc::checkEmptyString($message, "Message can't be empty");

        $client = new Client(CommonInfo::$DOMAIN . $servlet);

        $params = array(
            CommonInfo::$URL_ACT => $act,
            CommonInfo::$URL_PAGEID => $pageId,
            CommonInfo::$URL_TOUID => $toUid,
            CommonInfo::$URL_MESSAGE => $message,
            CommonInfo::$URL_TIMESTAMP => $timeStamp,
        );

        $client->setDefaultOption('query', $params);

        return $client;
    }

    public static function buildRequestByPhoneA($pageId, $phoneNum, $message, $act, $servlet, $timeStamp) {


        ValidateFunc::checkNotNull($pageId, "Page id  be null");
        ValidateFunc::checkNotNull($phoneNum, "To phone number can't be null");
        ValidateFunc::checkEmptyString($message, "Message can't be empty");

        $client = new Client(CommonInfo::$DOMAIN . $servlet);

        $params = array(
            CommonInfo::$URL_ACT => $act,
            CommonInfo::$URL_PAGEID => $pageId,
            CommonInfo::$URL_PHONENUM => $phoneNum,
            CommonInfo::$URL_MESSAGE => $message,
            CommonInfo::$URL_TIMESTAMP => $timeStamp,
        );

        $client->setDefaultOption('query', $params);

        return $client;
    }

    public static function buildRequestB($pageId, $toUid, $act, $servlet, $timeStamp) {

        ValidateFunc::checkNotNull($pageId, "Page id can't be null");
        ValidateFunc::checkNotNull($toUid, "To user id can't be null");

        $client = new Client(CommonInfo::$DOMAIN . $servlet);

        $params = array(
            CommonInfo::$URL_ACT => $act,
            CommonInfo::$URL_PAGEID => $pageId,
            CommonInfo::$URL_TOUID => $toUid,
            CommonInfo::$URL_TIMESTAMP => $timeStamp,
        );

        $client->setDefaultOption('query', $params);

        return $client;
    }

    public static function buildRequestByPhoneB($pageId, $phoneNum, $act, $servlet, $timeStamp) {

        ValidateFunc::checkNotNull($pageId, "Page id can't be null");
        ValidateFunc::checkNotNull($phoneNum, "To phone number can't be null");

        $client = new Client(CommonInfo::$DOMAIN . $servlet);

        $params = array(
            CommonInfo::$URL_ACT => $act,
            CommonInfo::$URL_PAGEID => $pageId,
            CommonInfo::$URL_PHONENUM => $phoneNum,
            CommonInfo::$URL_TIMESTAMP => $timeStamp,
        );

        $client->setDefaultOption('query', $params);

        return $client;
    }

    public static function buildRequestC($pageId, $message, $act, $servlet, $timeStamp) {

        ValidateFunc::checkNotNull($pageId, "Page id can't be null");
        ValidateFunc::checkEmptyString($message, "Message can't be empty");

        $client = new Client(CommonInfo::$DOMAIN . $servlet);

        $params = array(
            CommonInfo::$URL_ACT => $act,
            CommonInfo::$URL_PAGEID => $pageId,
            CommonInfo::$URL_MESSAGE => $message,
            CommonInfo::$URL_TIMESTAMP => $timeStamp,
        );

        $client->setDefaultOption('query', $params);

        return $client;
    }

    public static function buildRequestD($pageId, $act, $servlet, $timeStamp) {

        ValidateFunc::checkNotNull($pageId, "Page id can't be null");

        $client = new Client(CommonInfo::$DOMAIN . $servlet);

        $params = array(
            CommonInfo::$URL_ACT => $act,
            CommonInfo::$URL_PAGEID => $pageId,
            CommonInfo::$URL_TIMESTAMP => $timeStamp,
        );

        $client->setDefaultOption('query', $params);

        return $client;
    }

    public static function buildLinksParam($linksInfo) {
        $arr = array();
        for ($i = 0; $i < count($linksInfo); $i++) {
            ValidateFunc::checkEmptyString($linksInfo[$i]["link"], "Link can't be empty!");
            ValidateFunc::checkEmptyString($linksInfo[$i]["linkdes"], "Link description can't be empty!");
            ValidateFunc::checkEmptyString($linksInfo[$i]["linktitle"], "Link title can't be empty!");
            ValidateFunc::checkEmptyString($linksInfo[$i]["linkthumb"], "Link thumbnail can't be empty!");

            $arr[] = $linksInfo[$i];
        }
        return json_encode($arr);
    }

    public static function addParamsHttpGet($client, $key, $value) {
        $params = $client->getDefaultOption('query');
        if (empty($params[$key])) {
            $params[$key] = $value;
        }
        $client->setDefaultOption('query', $params);
        return $client;
    }

    public static function sendMessage($client) {
        $request = $client->get();
        $response = $request->send()->json();

        $error = $response["error"];

        if ($error < 0) {
            $zaloSdkExcep = new ZaloSdkException();
            $zaloSdkExcep->setZaloSdkExceptionErrorCode($error);
            if (!empty($response["message"])) {
                $zaloSdkExcep->setZaloSdkExceptionMessage($response["message"]);
            }
            throw $zaloSdkExcep;
        } else {
            $zaloPageResult = new ZaloPageResult();
            $zaloPageResult->setError($error);
            if (!empty($response["id"])) {
                $zaloPageResult->setId($response["id"]);
            }
            return $zaloPageResult;
        }
    }

    public static function sendQuery($client) {
        $request = $client->get();
        $response = $request->send()->json();

        $error = $response["error"];

        if ($error < 0) {
            $zaloSdkExcep = new ZaloSdkException();
            $zaloSdkExcep->setZaloSdkExceptionErrorCode($error);
            if (!empty($response["message"])) {
                $zaloSdkExcep->setZaloSdkExceptionMessage($response["message"]);
            }
            throw $zaloSdkExcep;
        } else {
            if (!empty($response["result"])) {
                return $response["result"];
            } else {
                $zaloSdkExcep = new ZaloSdkException();
                $zaloSdkExcep->setZaloSdkExceptionErrorCode(-1);
                throw zaloSdkExcep;
            }
        }
    }

    public static function sendQueryStatusMsgPage($client) {
        $request = $client->get();
        $response = $request->send()->json();
        $zaloMsgSttResult = new ZaloMsgSttResult();
        $error = $response["error"];
        echo $error;
        if ($error == -1) {
            $notExist = new MESSAGESTATUS(MESSAGESTATUS::NOT_EXIST);
            $zaloMsgSttResult->setError($notExist->getValue());
            $zaloMsgSttResult->setStatus("NOT_EXIST");
        } else if ($error < 0) {
            $zaloSdkExcep = new ZaloSdkException();
            $zaloSdkExcep->setZaloSdkExceptionErrorCode($error);
            if (!empty($response["message"])) {
                $zaloSdkExcep->setZaloSdkExceptionMessage($response["message"]);
            }
            throw $zaloSdkExcep;
        } else {
            $zaloMsgSttResult->setError(ZaloSdkHelper::getMsgStatusFrResponse($error));
            $zaloMsgSttResult->setStatus(ZaloSdkHelper::getStringStatusFrResponse($error));
        }
        return $zaloMsgSttResult;
    }
    
    public static function sendQueryProfile($client) {
        $request = $client->get();
        $response = $request->send()->json();
        $zaloProfile = new ZaloProfile();
        $error = $response["error"];
//        echo $error;
        if ($error == -1) {
            $notExist = new MESSAGESTATUS(MESSAGESTATUS::NOT_EXIST);
            $zaloMsgSttResult->setError($notExist->getValue());
            $zaloMsgSttResult->setStatus("NOT_EXIST");
        } else if ($error < 0) {
            $zaloSdkExcep = new ZaloSdkException();
            $zaloSdkExcep->setZaloSdkExceptionErrorCode($error);
            if (!empty($response["message"])) {
                $zaloSdkExcep->setZaloSdkExceptionMessage($response["message"]);
            }
            throw $zaloSdkExcep;
        } else {
            if (!empty($response["result"])) {
                $zaloProfile->setAvatar($response["result"]["avatar"]);
                $zaloProfile->setDisplayName($response["result"]["displayName"]);
                $zaloProfile->setUserGender(ZaloSdkHelper::getUserGender($response["result"]["userGender"]));
                $zaloProfile->setUserId($response["result"]["userId"]);
                return $zaloProfile;
            } else {
                $zaloSdkExcep = new ZaloSdkException();
                $zaloSdkExcep->setZaloSdkExceptionErrorCode(-1);
                throw zaloSdkExcep;
            }
        }
        return $zaloProfile;
    }
    
    public static function sendQueryFeed($client) {
        $request = $client->get();
        $response = $request->send()->json();
        $zaloFeed = new ZaloFeed();
        $error = $response["error"];
        echo $error;
        if ($error == -1) {
            $notExist = new MESSAGESTATUS(MESSAGESTATUS::NOT_EXIST);
            $zaloMsgSttResult->setError($notExist->getValue());
            $zaloMsgSttResult->setStatus("NOT_EXIST");
        } else if ($error < 0) {
            $zaloSdkExcep = new ZaloSdkException();
            $zaloSdkExcep->setZaloSdkExceptionErrorCode($error);
            if (!empty($response["message"])) {
                $zaloSdkExcep->setZaloSdkExceptionMessage($response["message"]);
            }
            throw $zaloSdkExcep;
        } else {
            if (!empty($response["result"])) {
                
                $type = $response["result"]["type"];
                $zaloFeed->setCreateTime($response["result"]["time"]);
                $zaloFeed->setMessage($response["result"]["message"]);

                if ($type == 1) {
                    $zaloFeed->setType(ZPTypeFeed::ZTF_Text);
                } else if ($type == 2) {
                    $zaloFeed->setType(ZPTypeFeed::ZTF_Voice);
                    $zaloFeed->setVoiceURL($response["result"]["urlVoice"]);
                } else if ($type == 3) {
                    $zaloFeed->setType(ZPTypeFeed::ZTF_Link);
                    $linkInfo = array (
                        "link" => $response["result"]["href"],
                        "linkdes" => $response["result"]["description"],
                        "linktitle" => $response["result"]["title"],
                        "linkthumb" => $response["result"]["thumb"]
                    );

                    $zaloFeed->setLinkInfo($linkInfo);
                } else if ($type == 4) {
                    $zaloFeed->setType(ZPTypeFeed::ZTF_Photo);
                    $arr = $response["result"]["thumb"];
                    if ($arr != null) {
                        $lstImage = array();
                        for ($i = 0; $i < count($arr); $i++) {
                            array_push($lstImage, $arr[$i]);
                        }
                        $zaloFeed->setImageURL($lstImage);
                    }
                } else if ($type == 5) {
                    $zaloFeed->setType(ZPTypeFeed::ZTF_Sticker);
                    $arr = $response["result"]["thumb"];
                    if ($arr != null) {
                        $lstSticker = array();
                        for ($i = 0; $i < count($arr); $i++) {
                            array_push($lstSticker, $arr[$i]);
                        }
                        $zaloFeed->setStickerURL($lstSticker);
                    }
                }
            
                return $zaloFeed;
            } else {
                $zaloSdkExcep = new ZaloSdkException();
                $zaloSdkExcep->setZaloSdkExceptionErrorCode(-1);
                throw zaloSdkExcep;
            }
        }
        return $zaloFeed;
    }
    
    private static function getUserGender($gender) {
        switch ($gender) {
            case 0:
                return ZPUserGender::UGEN_Undef;

            case 1:
                return ZPUserGender::UGEN_Male;

            case 2:
                return ZPUserGender::UGEN_Female;

            case 3:
                return ZPUserGender::UGEN_Other;

            default:
                return ZPUserGender::UGEN_Other;
        }
    }

    public static function buildMacForAuthentication($lstParams) {
        $res = "";

        for ($i = 0; $i < count($lstParams); $i++) {
            $res .= $lstParams[$i];
        }

        return SecurityHelper::encodeSHA256($res);
    }

    private static function getMsgStatusFrResponse($res) {
        switch ($res) {
            case 0:
                return MESSAGESTATUS::DELIVERED;
            case 1:
                return MESSAGESTATUS::SENT_ZALO;
            case 2:
                return MESSAGESTATUS::SENT_SMS;
            case 3:
                return MESSAGESTATUS::NOT_DELIVERED;
            case 4:
                return MESSAGESTATUS::SENT_SMS_FAIL;
            case 5:
                return MESSAGESTATUS::SEEN;
        }
        return MESSAGESTATUS::UNDEF;
    }
    
    private static function getStringStatusFrResponse($res) {
        switch ($res) {
            case 0:
                return "DELIVERED";
            case 1:
                return "SENT_ZALO";
            case 2:
                return "SENT_SMS";
            case 3:
                return "NOT_DELIVERED";
            case 4:
                return "SENT_SMS_FAIL";
            case 5:
                return "SEEN";
        }
        return "UNDEF";
    }

}

?>
