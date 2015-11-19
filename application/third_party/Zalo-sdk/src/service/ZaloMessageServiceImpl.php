<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace service;

use common\ZaloSdkHelper;
use common\CommonInfo;
use common\ValidateFunc;
use Guzzle\Http\Client;

require_once (realpath(dirname(__FILE__)) . "/../common/CommonInfo.php");
require_once (realpath(dirname(__FILE__)) . "/../common/ZaloSdkHelper.php");
require_once (realpath(dirname(__FILE__)) . "/ZaloMessageService.php");

class ZaloMessageServiceImpl implements ZaloMessageService {

    private $pageId;
    private $secretKey;

    public function __construct($pageId, $secretKey) {
        $this->pageId = $pageId;
        $this->secretKey = $secretKey;
    }

    public function sendTextMessage($toUid, $message, $smsMsg, $isNotify) {
        $timeStamp = microtime(TRUE); //system('date +%s%N');
        //echo '\n' . $this->pageId . $this->secretKey . $toUid . $message . CommonInfo::$ACT_TEXT. CommonInfo::$SER_MESSAGE . $timeStamp;
        $client = ZaloSdkHelper::buildRequestA($this->pageId, $toUid, $message, CommonInfo::$ACT_TEXT, CommonInfo::$SER_MESSAGE, $timeStamp);
        if ($smsMsg == null) {
            $smsMsg = "";
        }

        //build Mac
        $lstParams = array($this->pageId, $toUid, $message, $smsMsg, $isNotify == true ? "true" : "false", $timeStamp, $this->secretKey);
        $mac = ZaloSdkHelper::buildMacForAuthentication($lstParams);

        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_MAC, $mac);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_SMS, $smsMsg);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_ISNOTIFY, $isNotify == true ? "true" : "false");

        return ZaloSdkHelper::sendMessage($client);
    }

    public function sendTemplateTextMessage($toUid, $templateId, $data, $smsMsg, $isNotify) {
        $timeStamp = microtime(TRUE); //system('date +%s%N');
        ValidateFunc::checkNotNull($this->pageId, "Page id can't be null");
        ValidateFunc::checkNotNull($toUid, "To user id can't be null");
        ValidateFunc::checkEmptyString($templateId, "Template ID can't be empty");
        ValidateFunc::checkNotNull($data, "Data can't be null");

        $dataJSONStr = json_encode($data);
        if ($smsMsg == null) {
            $smsMsg = "";
        }

        $client = new Client(CommonInfo::$DOMAIN . CommonInfo::$SER_MESSAGE);

        $params = array(
            CommonInfo::$URL_ACT => CommonInfo::$ACT_TEMPLATE_TEXT,
            CommonInfo::$URL_PAGEID => $this->pageId,
            CommonInfo::$URL_TOUID => $toUid,
            CommonInfo::$URL_TEMPLATE => $templateId,
            CommonInfo::$URL_TEMPLATE_DATA => $dataJSONStr,
            CommonInfo::$URL_SMS => $smsMsg,
            CommonInfo::$URL_ISNOTIFY => $isNotify == true ? "true" : "false",
            CommonInfo::$URL_TIMESTAMP => $timeStamp,
        );

        $client->setDefaultOption('query', $params);

        //build Mac
        $lstParams = array($this->pageId, $toUid, $templateId, $dataJSONStr, $smsMsg, $isNotify == true ? "true" : "false", $timeStamp, $this->secretKey);
        $mac = ZaloSdkHelper::buildMacForAuthentication($lstParams);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_MAC, $mac);

        return ZaloSdkHelper::sendMessage($client);
    }

    public function sendImageMessage($toUid, $message, $image, $smsMsg, $isNotify) {
        $timeStamp = microtime(TRUE); //system('date +%s%N');
        $client = ZaloSdkHelper::buildRequestA($this->pageId, $toUid, $message, CommonInfo::$ACT_IMAGE, CommonInfo::$SER_MESSAGE, $timeStamp);
        if ($smsMsg == null) {
            $smsMsg = "";
        }

        //plus param
        ValidateFunc::checkEmptyString($image, "Image id can't be empty");
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_IMAGE, $image);

        //build Mac
        $lstParams = array($this->pageId, $toUid, $message, $image, $smsMsg, $isNotify == true ? "true" : "false", $timeStamp, $this->secretKey);
        $mac = ZaloSdkHelper::buildMacForAuthentication($lstParams);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_MAC, $mac);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_SMS, $smsMsg);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_ISNOTIFY, $isNotify == true ? "true" : "false");

        return ZaloSdkHelper::sendMessage($client);
    }

    public function sendVoiceMessage($toUid, $voice, $smsMsg, $isNotify) {
        $timeStamp = system('date +%s%N');
        $client = ZaloSdkHelper::buildRequestB($this->pageId, $toUid, CommonInfo::$ACT_VOICE, CommonInfo::$SER_MESSAGE, $timeStamp);
        if ($smsMsg == null) {
            $smsMsg = "";
        }

        //plus param
        ValidateFunc::checkEmptyString($voice, "Voice id can't be empty");
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_VOICE, $voice);

        //build Mac
        $lstParams = array($this->pageId, $toUid, $voice, $smsMsg, $isNotify == true ? "true" : "false", $timeStamp, $this->secretKey);
        $mac = ZaloSdkHelper::buildMacForAuthentication($lstParams);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_MAC, $mac);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_SMS, $smsMsg);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_ISNOTIFY, $isNotify == true ? "true" : "false");

        return ZaloSdkHelper::sendMessage($client);
    }

    public function sendStickerMessage($toUid, $stickerId, $smsMsg, $isNotify) {
        $timeStamp = system('date +%s%N');
        $client = ZaloSdkHelper::buildRequestB($this->pageId, $toUid, CommonInfo::$ACT_STICKER, CommonInfo::$SER_MESSAGE, $timeStamp);
        if ($smsMsg == null) {
            $smsMsg = "";
        }

        //plus param
        ValidateFunc::checkNotNull($stickerId, "Sticker id can't be empty");
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_STICKERID, $stickerId);

        //build Mac
        $lstParams = array($this->pageId, $toUid, $stickerId, $smsMsg, $isNotify == true ? "true" : "false", $timeStamp, $this->secretKey);
        $mac = ZaloSdkHelper::buildMacForAuthentication($lstParams);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_MAC, $mac);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_SMS, $smsMsg);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_ISNOTIFY, $isNotify == true ? "true" : "false");

        return ZaloSdkHelper::sendMessage($client);
    }

    public function sendContactMessage($toUid, $contactUid, $smsMsg, $isNotify) {
        $timeStamp = system('date +%s%N');
        $client = ZaloSdkHelper::buildRequestB($this->pageId, $toUid, CommonInfo::$ACT_CONTACT, CommonInfo::$SER_MESSAGE, $timeStamp);
        if ($smsMsg == null) {
            $smsMsg = "";
        }

        //plus param
        ValidateFunc::checkNotNull($contactUid, "ContactUid id can't be empty");
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_CONTACTUID, $contactUid);

        //build Mac
        $lstParams = array($this->pageId, $toUid, $contactUid, $smsMsg, $isNotify == true ? "true" : "false", $timeStamp, $this->secretKey);
        $mac = ZaloSdkHelper::buildMacForAuthentication($lstParams);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_MAC, $mac);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_SMS, $smsMsg);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_ISNOTIFY, $isNotify == true ? "true" : "false");

        return ZaloSdkHelper::sendMessage($client);
    }

    public function sendLinkMessage($toUid, $link, $linkTitle, $linkDesc, $linkThumb, $smsMsg, $isNotify) {
        $timeStamp = system('date +%s%N');
        $client = ZaloSdkHelper::buildRequestB($this->pageId, $toUid, CommonInfo::$ACT_LINK, CommonInfo::$SER_MESSAGE, $timeStamp);
        if ($smsMsg == null) {
            $smsMsg = "";
        }

        //plus param
        ValidateFunc::checkEmptyString($link, "Link can't be empty");
        ValidateFunc::checkEmptyString($linkDesc, "Link description can't be empty");
        ValidateFunc::checkEmptyString($linkThumb, "Link thumbnail can't be empty");
        ValidateFunc::checkEmptyString($linkTitle, "Link title can't be empty");

        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_LINK, $link);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_LINKTITLE, $linkTitle);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_LINKDES, $linkDesc);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_LINKTHUMB, $linkThumb);

        //build Mac
        $lstParams = array($this->pageId, $toUid, $link, $linkTitle, $linkDesc, $linkThumb, $smsMsg, $isNotify == true ? "true" : "false", $timeStamp, $this->secretKey);
        $mac = ZaloSdkHelper::buildMacForAuthentication($lstParams);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_MAC, $mac);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_SMS, $smsMsg);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_ISNOTIFY, $isNotify == true ? "true" : "false");

        return ZaloSdkHelper::sendMessage($client);
    }

    public function sendMultiLinksMessage($toUid, $linksInfo, $smsMsg, $isNotify) {
        $timeStamp = system('date +%s%N');
        $client = ZaloSdkHelper::buildRequestB($this->pageId, $toUid, CommonInfo::$ACT_LINKS, CommonInfo::$SER_MESSAGE, $timeStamp);
        if ($smsMsg == null) {
            $smsMsg = "";
        }

        //plus param
        ValidateFunc::checkListNotEmpty($linksInfo, "List linkinfos can't be empty");
        $links = ZaloSdkHelper::buildLinksParam($linksInfo);

        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_LINKS, $links);

        //build Mac
        $lstParams = array($this->pageId, $toUid, $links, $smsMsg, $isNotify == true ? "true" : "false", $timeStamp, $this->secretKey);
        $mac = ZaloSdkHelper::buildMacForAuthentication($lstParams);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_MAC, $mac);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_SMS, $smsMsg);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_ISNOTIFY, $isNotify == true ? "true" : "false");

        return ZaloSdkHelper::sendMessage($client);
    }

    public function broadcastTextMessage($message) {
        $timeStamp = system('date +%s%N');
        $client = ZaloSdkHelper::buildRequestC($this->pageId, $message, CommonInfo::$ACT_TEXT, CommonInfo::$SER_BROADCAST, $timeStamp);

        //build Mac
        $lstParams = array($this->pageId, $message, $timeStamp, $this->secretKey);
        $mac = ZaloSdkHelper::buildMacForAuthentication($lstParams);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_MAC, $mac);

        return ZaloSdkHelper::sendMessage($client);
    }

    public function broadcastImageMessage($image) {
        $timeStamp = system('date +%s%N');
        $client = ZaloSdkHelper::buildRequestD($this->pageId, CommonInfo::$ACT_IMAGE, CommonInfo::$SER_BROADCAST, $timeStamp);

        //plus param
        ValidateFunc::checkEmptyString($image, "Image id can't be empty");
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_IMAGE, $image);

        //build Mac
        $lstParams = array($this->pageId, $image, $timeStamp, $this->secretKey);
        $mac = ZaloSdkHelper::buildMacForAuthentication($lstParams);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_MAC, $mac);

        return ZaloSdkHelper::sendMessage($client);
    }

    public function broadcastVoiceMessage($voice) {
        $timeStamp = system('date +%s%N');
        $client = ZaloSdkHelper::buildRequestD($this->pageId, CommonInfo::$ACT_VOICE, CommonInfo::$SER_BROADCAST, $timeStamp);

        //plus param
        ValidateFunc::checkEmptyString($voice, "Voice id can't be empty");
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_VOICE, $voice);

        //build Mac
        $lstParams = array($this->pageId, $voice, $timeStamp, $this->secretKey);
        $mac = ZaloSdkHelper::buildMacForAuthentication($lstParams);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_MAC, $mac);

        return ZaloSdkHelper::sendMessage($client);
    }

    public function broadcastStickerMessage($stickerId) {
        $timeStamp = system('date +%s%N');
        $client = ZaloSdkHelper::buildRequestD($this->pageId, CommonInfo::$ACT_STICKER, CommonInfo::$SER_BROADCAST, $timeStamp);

        //plus param
        ValidateFunc::checkNotNull($stickerId, "Sticker id can't be empty");
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_STICKERID, $stickerId);

        //build Mac
        $lstParams = array($this->pageId, $stickerId, $timeStamp, $this->secretKey);
        $mac = ZaloSdkHelper::buildMacForAuthentication($lstParams);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_MAC, $mac);

        return ZaloSdkHelper::sendMessage($client);
    }

    public function broadcastContactMessage($contactUid) {
        $timeStamp = system('date +%s%N');
        $client = ZaloSdkHelper::buildRequestD($this->pageId, CommonInfo::$ACT_CONTACT, CommonInfo::$SER_BROADCAST, $timeStamp);

        //plus param
        ValidateFunc::checkNotNull($contactUid, "ContactUid id can't be empty");
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_CONTACTUID, $contactUid);

        //build Mac
        $lstParams = array($this->pageId, $contactUid, $timeStamp, $this->secretKey);
        $mac = ZaloSdkHelper::buildMacForAuthentication($lstParams);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_MAC, $mac);

        return ZaloSdkHelper::sendMessage($client);
    }

    public function broadcastLinkMessage($link, $linkTitle, $linkDesc, $linkThumb) {
        $timeStamp = system('date +%s%N');
        $client = ZaloSdkHelper::buildRequestD($this->pageId, CommonInfo::$ACT_LINK, CommonInfo::$SER_BROADCAST, $timeStamp);

        //plus param
        ValidateFunc::checkEmptyString($link, "Link can't be empty");
        ValidateFunc::checkEmptyString($linkDesc, "Link description can't be empty");
        ValidateFunc::checkEmptyString($linkThumb, "Link thumbnail can't be empty");
        ValidateFunc::checkEmptyString($linkTitle, "Link title can't be empty");

        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_LINK, $link);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_LINKDES, $linkDesc);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_LINKTHUMB, $linkThumb);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_LINKTITLE, $linkTitle);

        //build Mac
        $lstParams = array($this->pageId, $link, $linkTitle, $linkDesc, $linkThumb, $timeStamp, $this->secretKey);
        $mac = ZaloSdkHelper::buildMacForAuthentication($lstParams);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_MAC, $mac);

        return ZaloSdkHelper::sendMessage($client);
    }

    public function broadcastMultiLinksMessage($linksInfo) {
        $timeStamp = system('date +%s%N');
        $client = ZaloSdkHelper::buildRequestD($this->pageId, CommonInfo::$ACT_LINKS, CommonInfo::$SER_BROADCAST, $timeStamp);

        //plus param
        ValidateFunc::checkListNotEmpty($linksInfo, "List linkinfos can't be empty");
        $links = ZaloSdkHelper::buildLinksParam($linksInfo);

        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_LINKS, $links);

        //build Mac
        $lstParams = array($this->pageId, $links, $timeStamp, $this->secretKey);
        $mac = ZaloSdkHelper::buildMacForAuthentication($lstParams);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_MAC, $mac);

        return ZaloSdkHelper::sendMessage($client);
    }

    public function sendTextMessageByPhoneNum($phoneNum, $message, $smsMsg, $isNotify) {
        $timeStamp = system('date +%s%N');
        $client = ZaloSdkHelper::buildRequestByPhoneA($this->pageId, $phoneNum, $message, CommonInfo::$ACT_TEXT, CommonInfo::$SER_PHONE, $timeStamp);
        if ($smsMsg == null) {
            $smsMsg = "";
        }

        //build Mac
        $lstParams = array($this->pageId, $phoneNum, $message, $smsMsg, $isNotify == true ? "true" : "false", $timeStamp, $this->secretKey);
        $mac = ZaloSdkHelper::buildMacForAuthentication($lstParams);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_MAC, $mac);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_SMS, $smsMsg);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_ISNOTIFY, $isNotify == true ? "true" : "false");

        return ZaloSdkHelper::sendMessage($client);
    }

    public function sendTemplateTextMessageByPhoneNum($phoneNum, $templateId, $data, $smsMsg, $isNotify) {
        $timeStamp = system('date +%s%N');
        ValidateFunc::checkNotNull($this->pageId, "Page id can't be null");
        ValidateFunc::checkNotNull($phoneNum, "To phone number can't be null");
        ValidateFunc::checkEmptyString($templateId, "Template ID can't be empty");
        ValidateFunc::checkNotNull($data, "Data can't be null");

        $dataJSONStr = json_encode($data);
        if ($smsMsg == null) {
            $smsMsg = "";
        }

        $client = new Client(CommonInfo::$DOMAIN . CommonInfo::$SER_PHONE);

        $params = array(
            CommonInfo::$URL_ACT => CommonInfo::$ACT_TEMPLATE_TEXT,
            CommonInfo::$URL_PAGEID => $this->pageId,
            CommonInfo::$URL_PHONENUM => $phoneNum,
            CommonInfo::$URL_TEMPLATE => $templateId,
            CommonInfo::$URL_TEMPLATE_DATA => $dataJSONStr,
            CommonInfo::$URL_SMS => $smsMsg,
            CommonInfo::$URL_ISNOTIFY => $isNotify == true ? "true" : "false",
            CommonInfo::$URL_TIMESTAMP => $timeStamp,
        );

        $client->setDefaultOption('query', $params);

        //build Mac
        $lstParams = array($this->pageId, $phoneNum, $templateId, $dataJSONStr, $smsMsg, $isNotify == true ? "true" : "false", $timeStamp, $this->secretKey);
        $mac = ZaloSdkHelper::buildMacForAuthentication($lstParams);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_MAC, $mac);

        return ZaloSdkHelper::sendMessage($client);
    }

    public function sendImageMessageByPhoneNum($phoneNum, $message, $image, $smsMsg, $isNotify) {
        $timeStamp = system('date +%s%N');
        $client = ZaloSdkHelper::buildRequestByPhoneA($this->pageId, $phoneNum, $message, CommonInfo::$ACT_IMAGE, CommonInfo::$SER_PHONE, $timeStamp);
        if ($smsMsg == null) {
            $smsMsg = "";
        }

        //plus param
        ValidateFunc::checkEmptyString($image, "Image id can't be empty");
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_IMAGE, $image);

        //build Mac
        $lstParams = array($this->pageId, $phoneNum, $message, $image, $smsMsg, $isNotify == true ? "true" : "false", $timeStamp, $this->secretKey);
        $mac = ZaloSdkHelper::buildMacForAuthentication($lstParams);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_MAC, $mac);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_SMS, $smsMsg);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_ISNOTIFY, $isNotify == true ? "true" : "false");

        return ZaloSdkHelper::sendMessage($client);
    }

    public function sendVoiceMessageByPhoneNum($phoneNum, $voice, $smsMsg, $isNotify) {
        $timeStamp = system('date +%s%N');
        $client = ZaloSdkHelper::buildRequestByPhoneB($this->pageId, $phoneNum, CommonInfo::$ACT_VOICE, CommonInfo::$SER_PHONE, $timeStamp);
        if ($smsMsg == null) {
            $smsMsg = "";
        }

        //plus param
        ValidateFunc::checkEmptyString($voice, "Voice id can't be empty");
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_VOICE, $voice);

        //build Mac
        $lstParams = array($this->pageId, $phoneNum, $voice, $smsMsg, $isNotify == true ? "true" : "false", $timeStamp, $this->secretKey);
        $mac = ZaloSdkHelper::buildMacForAuthentication($lstParams);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_MAC, $mac);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_SMS, $smsMsg);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_ISNOTIFY, $isNotify == true ? "true" : "false");

        return ZaloSdkHelper::sendMessage($client);
    }

    public function sendStickerMessageByPhoneNum($phoneNum, $stickerId, $smsMsg, $isNotify) {
        $timeStamp = system('date +%s%N');
        $client = ZaloSdkHelper::buildRequestByPhoneB($this->pageId, $phoneNum, CommonInfo::$ACT_STICKER, CommonInfo::$SER_PHONE, $timeStamp);
        if ($smsMsg == null) {
            $smsMsg = "";
        }

        //plus param
        ValidateFunc::checkNotNull($stickerId, "Sticker id can't be empty");
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_STICKERID, $stickerId);

        //build Mac
        $lstParams = array($this->pageId, $phoneNum, $stickerId, $smsMsg, $isNotify == true ? "true" : "false", $timeStamp, $this->secretKey);
        $mac = ZaloSdkHelper::buildMacForAuthentication($lstParams);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_MAC, $mac);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_SMS, $smsMsg);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_ISNOTIFY, $isNotify == true ? "true" : "false");

        return ZaloSdkHelper::sendMessage($client);
    }

    public function sendContactMessageByPhoneNum($phoneNum, $contactPhone, $smsMsg, $isNotify) {
        $timeStamp = system('date +%s%N');
        $client = ZaloSdkHelper::buildRequestByPhoneB($this->pageId, $phoneNum, CommonInfo::$ACT_CONTACT, CommonInfo::$SER_PHONE, $timeStamp);
        if ($smsMsg == null) {
            $smsMsg = "";
        }

        //plus param
        ValidateFunc::checkNotNull($contactPhone, "Contact phone can't be empty");
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_CONTACTFONE, ($contactPhone));

        //build Mac
        $lstParams = array($this->pageId, $phoneNum, ($contactPhone), $smsMsg, $isNotify == true ? "true" : "false", $timeStamp, $this->secretKey);
        $mac = ZaloSdkHelper::buildMacForAuthentication($lstParams);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_MAC, $mac);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_SMS, $smsMsg);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_ISNOTIFY, $isNotify == true ? "true" : "false");

        return ZaloSdkHelper::sendMessage($client);
    }

    public function sendLinkMessageByPhoneNum($phoneNum, $link, $linkTitle, $linkDesc, $linkThumb, $smsMsg, $isNotify) {
        $timeStamp = system('date +%s%N');
        $client = ZaloSdkHelper::buildRequestByPhoneB($this->pageId, $phoneNum, CommonInfo::$ACT_LINK, CommonInfo::$SER_PHONE, $timeStamp);
        if ($smsMsg == null) {
            $smsMsg = "";
        }

        //plus param
        ValidateFunc::checkEmptyString($link, "Link can't be empty");
        ValidateFunc::checkEmptyString($linkDesc, "Link description can't be empty");
        ValidateFunc::checkEmptyString($linkThumb, "Link thumbnail can't be empty");
        ValidateFunc::checkEmptyString($linkTitle, "Link title can't be empty");

        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_LINK, $link);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_LINKTITLE, $linkTitle);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_LINKDES, $linkDesc);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_LINKTHUMB, $linkThumb);

        //build Mac
        $lstParams = array($this->pageId, $phoneNum, $link, $linkTitle, $linkDesc, $linkThumb, $smsMsg, $isNotify == true ? "true" : "false", $timeStamp, $this->secretKey);
        $mac = ZaloSdkHelper::buildMacForAuthentication($lstParams);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_MAC, $mac);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_SMS, $smsMsg);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_ISNOTIFY, $isNotify == true ? "true" : "false");

        return ZaloSdkHelper::sendMessage($client);
    }

    public function sendMultiLinksMessageByPhoneNum($phoneNum, $linksInfo, $smsMsg, $isNotify) {
        $timeStamp = system('date +%s%N');
        $client = ZaloSdkHelper::buildRequestByPhoneB($this->pageId, $phoneNum, CommonInfo::$ACT_LINKS, CommonInfo::$SER_PHONE, $timeStamp);
        if ($smsMsg == null) {
            $smsMsg = "";
        }

        //plus param
        ValidateFunc::checkListNotEmpty($linksInfo, "List linkinfos can't be empty");
        $links = ZaloSdkHelper::buildLinksParam($linksInfo);

        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_LINKS, $links);

        //build Mac
        $lstParams = array($this->pageId, $phoneNum, $links, $smsMsg, $isNotify == true ? "true" : "false", $timeStamp, $this->secretKey);
        $mac = ZaloSdkHelper::buildMacForAuthentication($lstParams);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_MAC, $mac);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_SMS, $smsMsg);
        ZaloSdkHelper::addParamsHttpGet($client, CommonInfo::$URL_ISNOTIFY, $isNotify == true ? "true" : "false");

        return ZaloSdkHelper::sendMessage($client);
    }

}

?>