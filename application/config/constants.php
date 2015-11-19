<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//////CUSTOMIZE////////////
//SITE name
define("SITE_NAME", "Adsfw");


/*
  |--------------------------------------------------------------------------
  | File and Directory Modes
  |--------------------------------------------------------------------------
  |
  | These prefs are used when checking and setting modes when working
  | with the file system.  The defaults are fine on servers with proper
  | security, but you may wish (or even need) to change the values in
  | certain environments (Apache running a separate process for each
  | user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
  | always be used to set the mode correctly.
  |
 */
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
  |--------------------------------------------------------------------------
  | File Stream Modes
  |--------------------------------------------------------------------------
  |
  | These modes are used when working with fopen()/popen()
  |
 */

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

// music count
define('MUSIC_VIEW_COUNT', 'view_count');
define('MUSIC_COMMENT_COUNT', 'comment_count');
define('MUSIC_LYRICS_COUNT', 'lyrics_count');
define('MUSIC_LIKE_COUNT', 'like_count');
// music point
define('MUSIC_LISTEN_COUNT', 'listen_count');
define('MUSIC_LISTEN_POINT', 'listen_point');
define('MUSIC_VOTE_COUNT', 'vote_count');
define('MUSIC_VOTE_POINT', 'vote_point');
define('MUSIC_SMS_VOTE_COUNT', 'sms_vote_count');
define('MUSIC_SMS_VOTE_POINT', 'sms_vote_point');
// music album count
define('MUSIC_ALBUM_VIEW_COUNT', 'view_count');
define('MUSIC_ALBUM_LIKE_COUNT', 'like_count');

//musics
define("MUSIC_TYPE", 2);
define('MUSIC_RESOURCE_ID', 34);
define("MUSIC_TYPE_ID", 1);
define('MUSIC_RECORDS_PER_PAGE', 10);

//videos
define("VIDEO_TYPE", 4);
define("VIDEO_CATEGORY_ID", 2);
define("VIDEO_TYPE_ID", 2);
define('VIDEO_RECORDS_PER_PAGE', 10);
define('VIDEO_RESOURCE_ID', 34);
define("VIDEO_STATUS_ENABLE", 1);

//articles
define('ARTICLE_TYPE', 1);
//define('ARTICLE_CATEGORY_ID',               2);
define('ARTICLE_RECORDS_PER_PAGE', 10);
define('ARTICLE_RESOURCE_ID', 42);

//photos
define('PHOTO_TYPE', 3);
define('PHOTO_CATEGORY', 4);
define('PHOTO_STATUS_ENABLE', 1);
define('PHOTO_STATUS_DISABLE', 0);
define('PHOTO_ALLOW_COMMENT', 1);
define('PHOTO_NO_ALLOW_COMMENT', 0);
define('PHOTO_RESOURCE_ID', 48);
define('PHOTO_RECORDS_PER_PAGE', 6);


//front-end
//search
define('SEARCH_RECORDS_PER_PAGE', 10);
define('SEARCH_QUERY_NAME', 'q');

//comment
define('COMMENT_RECORDS_PER_PAGE', 1000);
define('COMMENT_CHAT_SESSION_NAME', 'chat');
define('COMMENT_NEED_LOGIN', TRUE);

//vote
define('VOTE_NEED_LOGIN', TRUE);

//view
define('SESS_VIEWED', "viewed");

//config default
define('LIMIT_RECORDS_PER_PAGE', 20);
define('DB_FIELD_COUNTER_COMMENT', 'counter_comment');
define('DB_FIELD_COUNTER_VOTE', 'counter_vote');
define('DB_FIELD_COUNTER_LIKE', 'counter_like');
define('DB_FIELD_COUNTER_VIEW', 'counter_view');

//url
define('URL_LAST_FLAG', 1);
define('URL_LAST_SESS_NAME', 'last_url');
define('URL_LAST_SESS_EXCEPT_METHODS', "login,edit,delete,add");

//statistic
define('STATISTIC_CAMPAIGN_ID', 1);
define("GCHARTPHP_REQUEST_POST", TRUE);

define('DIR_MEDIA_ARTICLE_PHOTOS', FPENGUIN . 'media/filemanager/');

//admin
define('DB_TABLE_1_ALIAS', 't1.');

//ZingMe config
define('ZM_APPNAME', config_item('zm_appname'));
define('ZM_FANNAME', config_item('zm_fanname'));
define('ZM_APIKEY', config_item('zm_apikey'));
define('ZM_SECRETKEY', config_item('zm_secretkey'));

//Facebook config
define('FB_APPID', config_item('fb_appid'));
define('FB_SECRETKEY', config_item('fb_secretkey'));

//Google config
define('GG_CLIENTID', config_item('gg_clientid'));
define('GG_CLIENTSECRET', config_item('gg_clientsecret'));

class ConstUser {

    const flag_write_db_log_insert = 0;
    const flag_write_db_log_update = 0;
    const flag_write_db_log_delete = 0;

}

class ConstUserRole {

    const guest = 1;
    const user = 2;
    const administrator = 3;

}

class ConstFieldType {

    const text = 'TEXT';
    const area = 'AREA';
    const num = 'NUM';
    const date = 'DATE';
    const datetime = 'DATETIME';
    const image = 'IMAGE';

}

class ConstCustomField {

    const defaultName = 'Default';
    const onlyMe = 'PRIVATE';
    const all = 'PUBLIC';

}

class ConstEXTHtmlTemplate {

    const tpl = 'tpl';
    const css = 'css';
    const js = 'js';

}

class ConstFileStaticEdit {

    static $css = array(
        'frontend__css__screen'
    );
    static $js = array(
        'js__common',
        'js__function'
    );

}

// module music
class ConstMusicsStatus {

    const NoApproved = 0;
    const Approved = 1;

}

class ConstUserStatus {

    const Active = 1;
    const InActive = 0;

}

class ConstMusicType {

    const MP3 = 1;
    const Video = 2;

}

class ConstMusicGlobal {

    const VoteTypeID = 1;
    // point
    const VotePercent = 35;
    const SmsPercent = 35;
    const ListenPercent = 30;

}

// module Article
class ConstArticleGlobal {

    const VoteTypeID = 1;

}

// module Comment
class ConstCommentsStatus {

    const NoApproved = 0;
    const Approved = 1;

}

// module Comment
class ConstPhotosStatus {

    const Rejected = 2;
    const Approved = 1;
    const NoApproved = 0;

}

// webservice
class ConstWebservice {

    const Get = 'get';
    const Post = 'post';

}

// Const global
class ConstGlobal {

    const share = 'PUBLIC';
    const onlyme = 'PRIVATE';
    // log
    const log_delete = 1;
    const log_update = 2;
    const log_insert = 3;
    const log_query = 4;

}

// Const ConDuongAmNhac
class f_idol {

    // SMS
    const SmsMo = 0;
    const SmsMt = 1;
    // SMS status for SMS MO
    const WaitingOpen = -100;
    const JustReceived = 1;
    const ReadySendSMS = 2;
    const SentMT = 3;
    const ErrorMoInvalidFormat = -1;
    const ErrorMoInvalidFormatSentMT = -2;
    const ErrorExceedMo = -5;
    const ErrorExceedMoSentMT = -3;
    const ErrorMoSentMT = -4;
    // SMS status for MT
    const SentMtSuccessfully = 1;
    const SentMtError = -1;

}

/* End of file constants.php */
/* Location: ./application/config/constants.php */