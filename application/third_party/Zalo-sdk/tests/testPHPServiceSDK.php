<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace tests;

if (!ini_get('display_errors')) {
    ini_set('display_errors', '1');
}

use exception\ZaloSdkException;
use service\ZaloServiceFactory;
use service\ZaloServiceConfigure;

require_once '../src/service/ZaloServiceFactory.php';
require_once '../src/service/ZaloMessageService.php';
require_once '../src/service/ZaloQueryService.php';
require_once '../src/service/ZaloUploadService.php';
require_once '../src/service/ZaloSocialService.php';
require_once '../src/service/ZaloServiceConfigure.php';
require_once '../src/exception/ZaloSdkException.php';


try {
    $pageId = 0; //fill your page 's id here
    $secretKey = ""; //fill your page 's secret key here
    $toUid = 0; //fill user 'id, you want to send message
    $message = "";
    $smsMsg = "";
    $pathPhoto = ""; //path image file on your server.
    $pathVoice = ""; //path voice file on your server.
    $images = array();
    $templateId = "";
    $isNotify = true;
    
    $data = array ();
    
    $configure = new ZaloServiceConfigure($pageId, $secretKey);
    $factory = $configure->getZaloServiceFactory();

//    $photoId = "";
//    $voiceId = "";
    $photoId = $factory->getZaloUploadService()->uploadImage($pathPhoto);
    $voiceId = $factory->getZaloUploadService()->uploadVoice($pathVoice);
    
    echo("</br>Upload photo   >>>>>>" . $photoId);
    echo("</br>Upload voice   >>>>>>". $voiceId);
//    
    array_push($images, $photoId);
    array_push($images, $photoId);
    array_push($images, $photoId);
    array_push($images, $photoId);
//
    $lnksInfo = array();
    
    $linkInfo = array (
        "link" => "http://news.zing.vn/Nhung-not-ruoi-dac-biet-tren-guong-mat-hot-girl-Viet-post396736.html#home_multimedia",
        "linkdes" => "Tâm Tít lộ nốt ruồi trên môi, mũi và gần đuôi mắt khi để mặt mộc. Đặc điểm ngoại hình này nói lên Tâm là cô gái khá dễ gần, thân thiện, sành ăn và có một cuộc sống tốt",
        "linktitle" => "Những nốt ruồi đặc biệt trên gương mặt hot girl Việt",
        "linkthumb" => "http://img.v3.news.zdn.vn/w660/Uploaded/qjyyf/2014_03_05/1896819_291395227675374_502804893_n.jpg"
    );
    
    array_push($lnksInfo, $linkInfo);
    
    $linkInfo = array (
        "link" => "http://news.zing.vn/Em-chong-Ha-Tang-ngay-cang-truong-thanh-va-xinh-dep-post370107.html#home_multimedia",
        "linkdes" => "Xuất hiện tại buổi chạy tập luyện cùng vợ chồng anh trai Louis tại TP.HCM, Thảo Tiên nhanh chóng được nhiều người nhận ra.",
        "linktitle" => "Em chồng Hà Tăng ngày càng trưởng thành và xinh đẹp",
        "linkthumb" => "http://img.v3.news.zdn.vn/w660/Uploaded/SotnTJ/2014_01_10/roma2_zing.jpg"
    );
    
    array_push($lnksInfo, $linkInfo);
    
    $linkInfo = array (
        "link" => "http://news.zing.vn/4-gai-hu-duoc-san-don-nhat-showbiz-Viet-post369704.html#detail_sidebar.mostview",
        "linkdes" => "Dù dính nhiều rắc rối nhưng các người đẹp này vẫn rất được dư luận quan tâm và truyền thông thường xuyên nhắc đến.",
        "linktitle" => "4 gái hư được 'săn đón' nhất showbiz Việt",
        "linkthumb" => "http://img.v3.news.zdn.vn/w660/Uploaded/rdsis/2013_11_18/trinh2.jpg"
    );
    
    array_push($lnksInfo, $linkInfo);
    
    $linkInfo = array (
        "link" => "http://news.zing.vn/Thi-hat-nhay-online-cung-Be-Unik-16-post369890.html#detail_sidebar.pr",
        "linkdes" => "Được tổ chức trực tuyến với hình thức dự thi đơn giản và giải thưởng hấp dẫn, cuộc thi thu hút hàng ngàn bạn trẻ khoe tài năng âm nhạc lẫn vũ đạo cá tính.",
        "linktitle" => "Thi hát nhảy online cùng Be U-nik 16",
        "linkthumb" => "http://img.v3.news.zdn.vn/w660/Uploaded/JAC2_N3/2013_11_18/Be_Unik_16__Thi_hat_nhay_online_rinh_giai_thuong_lon_3.jpg"
    );
    
    array_push($lnksInfo, $linkInfo);
    
    $linkInfo = array (
        "link" => "http://news.zing.vn/PG--nghe-khong-chi-khoe-dui-post368884.html#detail_sidebar.topic",
        "linkdes" => "Hà Trang (sinh năm 1991) cho biết làm PG thường xuyên phải mặc váy ngắn, chẳng may bước mạnh bị rách váy, phải đền mất cả ngày lương; lần thì hoảng hồn vì bị khách chạm vào đùi.",
        "linktitle" => "PG - nghề không chỉ… khoe đùi",
        "linkthumb" => "http://img.v3.news.zdn.vn/w660/Uploaded/rugtzn/2013_11_14/pg2_1.jpg"
    );
    
    array_push($lnksInfo, $linkInfo);
    
    $messageService = $factory->getZaloMessageService();

    $err1 = $messageService->sendTextMessage($toUid, $message, $smsMsg, $isNotify);
    if ($err1->getError() >= 0) {
        echo("</br>Pass send text message   >>>>>> " . $err1->getId() . " <<<<<<<");
    }
    
    $err33 = $messageService->sendTemplateTextMessage($toUid, $templateId, $data, $smsMsg, $isNotify);
    if ($err33->getError() >= 0) {
        echo("</br>Pass send template text message   >>>>>> " . $err33->getId() . " <<<<<<<");
    }

    $err2 = $messageService->sendImageMessage($toUid, $message, $photoId, $smsMsg, $isNotify);
    if ($err2->getError() >= 0) {
        echo("</br>Pass send image message   >>>>>> " . $err2->getId() . " <<<<<<<");
    }

    $err3 = $messageService->sendVoiceMessage($toUid, $voiceId, $smsMsg, $isNotify);
    if ($err3->getError() >= 0) {
        echo("</br>Pass send voice message   >>>>>> " . $err3->getId() . " <<<<<<<");
    }

    $err4 = $messageService->sendStickerMessage($toUid, 411, $smsMsg, $isNotify);
    if ($err4->getError() >= 0) {
        echo("</br>Pass send sticker message   >>>>>> " . $err4->getId() . " <<<<<<<");
    }

    $err5 = $messageService->sendContactMessage($toUid, "3106381280861738221", $smsMsg, $isNotify);
    if ($err5->getError() >= 0) {
        echo("</br>Pass send contact message   >>>>>> " . $err5->getId() . " <<<<<<<");
    }

    $err6 = $messageService->sendLinkMessage($toUid, "genk.vn", "genk", "Trang cong nghe", "http://genknews.vcmedia.vn/zoom/230_180/2013/ten-lua-tq-ddd008bbe2683486894f80e71565daf12-1380086078202.jpg", $smsMsg, $isNotify);
    if ($err6->getError() >= 0) {
        echo("</br>Pass send link message   >>>>>> " . $err6->getId() . " <<<<<<<");
    }
    
    $err28 = $messageService->sendMultiLinksMessage($toUid, $lnksInfo, $smsMsg, $isNotify);
    if ($err28->getError() >= 0) {
        echo("</br>Pass send multi-links message   >>>>>> " . $err28->getId() . " <<<<<<<");
    }

    $err7 = $messageService->broadcastTextMessage($message);
    if ($err7->getError() >= 0) {
        echo("</br>Pass broadcast text message   >>>>>> " . $err7->getId() . " <<<<<<<");
    }

    $err8 = $messageService->broadcastImageMessage($photoId);
    if ($err8->getError() >= 0) {
        echo("</br>Pass broadcast photo message   >>>>>> " . $err8->getId() . " <<<<<<<");
    }

    $err9 = $messageService->broadcastVoiceMessage($voiceId);
    if ($err9->getError() >= 0) {
        echo("</br>Pass broadcast voice message   >>>>>> " . $err9->getId() . " <<<<<<<");
    }

    $err10 = $messageService->broadcastContactMessage("3106381280861738221");
    if ($err10->getError() >= 0) {
        echo("</br>Pass broadcast contact message   >>>>>> " . $err10->getId() . " <<<<<<<");
    }

    $err11 = $messageService->broadcastStickerMessage(411);
    if ($err11->getError() >= 0) {
        echo("</br>Pass broadcast sticker message   >>>>>> " . $err11->getId() . " <<<<<<<");
    }

    $err12 = $messageService->broadcastLinkMessage("genk.vn", "genk", "Trang cong nghe", "http://genknews.vcmedia.vn/zoom/230_180/2013/ten-lua-tq-ddd008bbe2683486894f80e71565daf12-1380086078202.jpg");
    if ($err12->getError() >= 0) {
        echo("</br>Pass broadcast link message   >>>>>> " . $err12->getId() . " <<<<<<<");
    }
    
    $err29 = $messageService->broadcastMultiLinksMessage($lnksInfo);
    if ($err29->getError() >= 0) {
        echo("</br>Pass broadcast multi-links message   >>>>>> " . $err29->getId() . " <<<<<<<");
    }

    $socialService = $factory->getZaloSocialService();
    $err13 = $socialService->pushTextFeed($message);
    if ($err13->getError() >= 0) {
        echo("</br>Pass push feed text message   >>>>>> " . $err13->getId() . " <<<<<<<");
    }

    $err14 = $socialService->pushMultiImagesFeed($message, $images);
    if ($err14->getError() >= 0) {
        echo("</br>Pass push feed multi-images message   >>>>>> " . $err14->getId() . " <<<<<<<");
    }

    $err15 = $socialService->pushVoiceFeed($message, $voiceId);
    if ($err15->getError() >= 0) {
        echo("</br>Pass push feed voice message   >>>>>> " . $err15->getId() . " <<<<<<<");
    }

    $err16 = $socialService->pushLinkFeed($message, "genk.vn", "genk", "Trang cong nghe", "http://genknews.vcmedia.vn/zoom/230_180/2013/ten-lua-tq-ddd008bbe2683486894f80e71565daf12-1380086078202.jpg");
    if ($err16->getError() >= 0) {
        echo("</br>Pass push feed link message   >>>>>> " . $err16->getId() . " <<<<<<<");
    }

    $err17 = $socialService->pushStickerFeed($message, 905);
    if ($err17->getError() >= 0) {
        echo("</br>Pass push feed sticker message   >>>>>> " . $err17->getId() . " <<<<<<<");
    }
    
    $queryService = $factory->getZaloQueryService();

    $phone = 0; //fone number, you want to check.
    $contactPhone = 0; //contact fone number you want to check.
    
    $msgId = "";
    
    $err32 = $queryService->getMessageStatus($msgId);
    if ($err32->getError() >= 0) {
        echo("</br>Pass get status message by message id >>>>>> " . $err32->getStatus());
    }
    
    $err34 = $queryService->getProfile($toUid);
    if ($err34 != null) {
        echo("</br>Pass get profile   >>>>>> " . $err34->getUserId() . "|" . $err34->getDisplayName() . "|" . $err34->getAvatar() . "|" . $err34->getUserGender());
    }

    $err20 = $messageService->sendTextMessageByPhoneNum($phone, $message, $smsMsg, $isNotify);
    if ($err20->getError() >= 0) {
        echo("</br>Pass send text message page by phone number >>>>>> " . $err20->getId() . " <<<<<<<");
    }
    
    $err34 = $messageService->sendTemplateTextMessageByPhoneNum($phone, $templateId, $data, $smsMsg, $isNotify);
    if ($err34->getError() >= 0) {
        echo("</br>Pass send template text message by phone number  >>>>>> " . $err34->getId() . " <<<<<<<");
    }

    $err21 = $messageService->sendImageMessageByPhoneNum($phone, $message, $photoId, $smsMsg, $isNotify);
    if ($err21->getError() >= 0) {
        echo("</br>Pass send image message page by phone number >>>>>> " . $err21->getId() . " <<<<<<<");
    }

    $err22 = $messageService->sendVoiceMessageByPhoneNum($phone, $voiceId, $smsMsg, $isNotify);
    if ($err22->getError() >= 0) {
        echo("</br>Pass send voice message page by phone number >>>>>> " . $err22->getId() . " <<<<<<<");
    }

    $err23 = $messageService->sendStickerMessageByPhoneNum($phone, 415, $smsMsg, $isNotify);
    if ($err23->getError() >= 0) {
        echo("</br>Pass send sticker message page by phone number >>>>>> " . $err23->getId() . " <<<<<<<");
    }

    $err24 = $messageService->sendContactMessageByPhoneNum($phone, $contactPhone, $smsMsg, $isNotify);
    if ($err24->getError() >= 0) {
        echo("</br>Pass send contact message page by phone number >>>>>> " . $err24->getId() . " <<<<<<<");
    }

    $err25 = $messageService->sendLinkMessageByPhoneNum($phone, "genk.vn", "genk", "Trang cong nghe", "http://genknews.vcmedia.vn/zoom/230_180/2013/ten-lua-tq-ddd008bbe2683486894f80e71565daf12-1380086078202.jpg", $smsMsg, $isNotify);
    if ($err25->getError() >= 0) {
        echo("</br>Pass send link message page by phone number >>>>>> " . $err25->getId() . " <<<<<<<");
    }
    
    $err30 = $messageService->sendMultiLinksMessageByPhoneNum($phone, $lnksInfo, $smsMsg, $isNotify);
    if ($err30->getError() >= 0) {
        echo("</br>Pass send multi-links message page by phone number >>>>>> " . $err30->getId() . " <<<<<<<");
    }
    
} catch (ZaloSdkException $ex) {
    echo("</br></br>Err = " . $ex->getZaloSdkExceptionErrorCode());
    echo("</br></br>Mes = " . $ex->getZaloSdkExceptionMessage());
} catch (Exception $ex) {
    echo("</br></br>Message = " + $ex->getMessage());
}
?>