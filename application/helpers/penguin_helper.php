<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * Cac ham ve field support view
 */
/**
 * Compare two array and write log if any change
 * @author thangtpp
 * @param string $name - log file name
 * @param array $source - source array
 * @param array $compare - compare with source array
 * @return int - success (1) or not (0)
 */
if (!function_exists('write_change_log')) {

    function write_change_log($name, $source, $compare) {
        $id = isset($source['id']) ? $source['id'] : 0;

        if ($id > 0) {
            $content = 'id: ' . $id;
            $change = false;
            foreach ($source as $key => $value) {
                if (isset($compare[$key]) && $compare[$key] != $value) {
                    $content .= "| $key: " . $compare[$key] . " => $value";
                    $change = true;
                }
            }
            //debug($content);
            if ($change) {
                $CI = & get_instance();
                $content .= '| by: ' . $CI->session->userdata('user_username');
                write_log_file($name . date('Y_m_d'), $content);
            }

            return 1;
        } else {
            return 0;
        }
    }

}

//get img
if (!function_exists('get_html_img')) {

    function get_html_img($img_path, $width = 60, $height = 60, $thumb_marker = 'small_thumb') {
        if (!$img_path)
            return '';

        $thumb = get_image_thumb($img_path, $thumb_marker);
        $full_thumb_path = image_url() . $thumb;
        $full_img_path = image_url() . $img_path;

        $thumb_size = getimagesize($full_thumb_path);

        if ($thumb_size[0] >= $width && $thumb_size[1] >= $height)
            $full_path = $full_thumb_path;
        else
            $full_path = $full_img_path;

        return '<img src="' . $full_path . '" width="' . $width . '" height="' . $height . '"/>';
    }

}

//check field data is file or not
if (!function_exists('is_file_link')) {

    function is_file_link($field) {
        $info = pathinfo($field);
        if ($info["extension"] == 'txt' || $info["extension"] == 'TXT' || $info["extension"] == 'rar')
            return TRUE;
        return FALSE;
    }

}

//check field data is log file or not
if (!function_exists('is_log_file_link')) {

    function is_log_file_link($field) {
        $info = pathinfo($field);
        if ($info["extension"] == 'log' || $info['extension'] == 'LOG')
            return TRUE;
        return FALSE;
    }

}

//check field data is image or not
if (!function_exists('is_image_link')) {

    function is_image_link($field) {
        $info = pathinfo($field);
        if ($info["extension"] == 'png' || $info["extension"] == 'PNG' || $info["extension"] == 'jpg' || $info["extension"] == 'JPG')
            return TRUE;
        return FALSE;
    }

}

//check field data is image or not
if (!function_exists('is_audio_link')) {

    function is_audio_link($field) {
        $info = pathinfo($field);
        if ($info["extension"] == 'mp3' || $info["extension"] == 'MP3')
            return TRUE;
        return FALSE;
    }

}

if (!function_exists('is_video_link')) {

    function is_video_link($field) {
        $info = pathinfo($field);
        if ($info["extension"] == 'mp4' || $info["extension"] == 'MP4' || $info["extension"] == 'flv' || $info["extension"] == 'FLV')
            return TRUE;
        return FALSE;
    }

}

//get filter image
if (!function_exists('get_filter_img')) {

    function get_filter_img($field) {
        //config
        //sort field existed, change order way
        if (isset($_GET[$field]) && $_GET[$field] !== '') {
            $html = '<a id="filter_icon_' . $field . '" onclick="delete_filter(\'' . $field . '\')" href="javascript:;" style="background: url(\'' . static_base() . 'img/filter-delete.png\') 0 0 no-repeat; float: right; width: 12px; height: 11px; margin:2px 0px 0 5px;"></a>';
        } else {
            $html = '<a id="filter_icon_' . $field . '" onclick="open_filter(\'' . $field . '\')" href="javascript:;" style="background: url(\'' . static_base() . 'img/filter-icon.png\') 0 0 no-repeat; float: right; width: 12px; height: 11px; margin:2px 0px 0 5px;"></a>';
        }

        return $html;
    }

}

//get sort linked image
if (!function_exists('get_linked_sort_img')) {

    function get_linked_sort_img($field) {
        //config
        $default_sort = 'desc';
        $default_sort_array = 's';

        $x_offset = 0;
        $width = 12;

        $link = full_url();
        $sort = $default_sort_array . '[' . $field . "]=";
        $needle = $sort;

        //sort field existed, change order way
        if (isset($_GET[$default_sort_array][$field])) {
            if ($_GET[$default_sort_array][$field] == 'desc') {
                $sort .= 'asc';
                $needle .= 'desc';
                $width = 6;
            } else if ($_GET[$default_sort_array][$field] == 'asc') {
                $sort .= '';
                $needle .= 'asc';
                $x_offset = -5;
                $width = 6;
            } else {
                $sort .= 'desc';
                $needle .= '';
            }

            $link = str_replace($needle, $sort, $link);
        } else {
            if (($_GET)) {
                $sort = '&' . $default_sort_array . '[' . $field . "]=" . $default_sort;
            } else if (strrpos($link, '?')) {
                $sort = $default_sort_array . '[' . $field . "]=" . $default_sort;
            } else {
                $sort = '?' . $default_sort_array . '[' . $field . "]=" . $default_sort;
            }

            $link .= $sort;
        }

        $html = '<a href="' . $link . '" style="background: url(\'' . base_url() . '/static/default/img/sort_icon.gif\') ' . $x_offset . 'px 0px no-repeat; width: ' . $width . 'px; height: 13px; float:right; margin-top:2px;"></a>';

        return $html;
    }

}

//get some first clause of string
if (!function_exists('shortcut')) {

    function shortcut($string, $limit) {
        if (mb_strlen($string) > $limit) {
            $tmp = mb_strrpos($string, ' ', -(mb_strlen($string) - $limit));
            return mb_substr($string, 0, $tmp) . '...';
        } else {
            return $string;
        }
    }

}

//get sub arrayby key
if (!function_exists('get_sub_array_by_keys')) {

    function get_sub_array_by_keys($array, $keys) {
        $sub_array = array();

        if (is_array($keys)) {
            foreach ($keys as $key) {
                $sub_array[$key] = array();

                foreach ($array as $subarr) {
                    if (isset($subarr[$key])) {
                        $sub_array[$key][] = $subarr[$key];
                    }
                }
            }
        } else {
            foreach ($array as $subarr) {
                if (isset($subarr[$keys]) == FALSE) {
                    return NULL;
                }

                $sub_array[] = $subarr[$keys];
            }
        }

        return $sub_array;
    }

}



if (!function_exists('format_date')) {

    function format_date($date, $format = FALSE, $style = FALSE) {
        $style = $style ? $style : 1;
        $format = $format ? $format : 'd/m/y, H:i';

        //format date to compare
        $date = date('Y-m-d H:i:s', strtotime($date));
        $today = date('Y-m-d 00:00:00');

        $formated_date = '';

        switch ($style) {
            case 1:
                if ($today < $date)
                    $format_date = 'Hôm nay ' . date('H:i', strtotime($date));
                else
                    $format_date = date($format, strtotime($date));

                break;
            case 2:
                break;
        }

        return $format_date;
    }

}

//share url
if (!function_exists('share_url')) {

    function share_url($platform) {
        switch ($platform) {
            case 'zm':
                return 'http://link.apps.zing.vn/pro/view/conn/share?u=' . urlencode(full_url());
                break;
            case 'fb':
                return 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode(full_url());
                break;
            case 'tw':
                return 'https://twitter.com/intent/tweet?url=' . full_url() . '&text=my text there';
                break;
            case'google':
                return 'https://plus.google.com/share?url=' . full_url();
                break;
            default:
                return 'http://link.apps.zing.vn/pro/view/conn/share?u=' . urlencode(full_url());
                break;
        }
    }

}

//global alert
if (!function_exists('set_global_alert')) {

    function set_global_alert($content) {
        $SESSION_ALERT = 'alert';

        if (!isset($_SESSION[$SESSION_ALERT])) {
            $_SESSION[$SESSION_ALERT] = $content;
        }
    }

}

//global alert
if (!function_exists('get_global_alert')) {

    function get_global_alert() {
        $SESSION_ALERT = 'alert';

        if (!isset($_SESSION[$SESSION_ALERT])) {
            return FALSE;
        } else {
            $alert = $_SESSION[$SESSION_ALERT];

            //remove session
            unset($_SESSION[$SESSION_ALERT]);

            return alert($alert);
        }
    }

}

//set last url
if (!function_exists('set_last_url')) {

    function set_last_url($except_methods = FALSE) {
        if (URL_LAST_FLAG == 0) {
            return false;
        }

        if ($except_methods) {
            //fetch array
            $except_methods = explode(',', $except_methods);

            $CI = &get_instance();

            $current_method = $CI->router->method;

            foreach ($except_methods as $except) {
                if ($except == $current_method) {
                    return;
                }
            }
        }
        //if(!isset($_SESSION[URL_LAST_SESS_NAME]))
        $_SESSION[URL_LAST_SESS_NAME] = full_url();
    }

}

//set last url sử dụng trong admin
if (!function_exists('get_last_url')) {

    function get_last_url($last_url = FALSE) {
        $last_url = $last_url ? $last_url : base_url();

        if (isset($_SESSION[URL_LAST_SESS_NAME])) {
            $last_url = $_SESSION[URL_LAST_SESS_NAME];

            unset($_SESSION[URL_LAST_SESS_NAME]);
        }
        return $last_url;
    }

}

//get previous url
if (!function_exists('previous_url')) {

    function previous_url() {
        if (isset($_SESSION[URL_LAST_SESS_NAME])) {
            $url = $_SESSION[URL_LAST_SESS_NAME];

            unset($_SESSION[URL_LAST_SESS_NAME]);
        } else {
            $url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : base_url();
        }

        return $url;
    }

}

//get previous url
if (!function_exists('keep_previous_url')) {

    function keep_previous_url() {
        $url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : base_url();

        if (!isset($_SESSION[URL_LAST_SESS_NAME])) {

            $_SESSION[URL_LAST_SESS_NAME] = $url;
        }
    }

}

//get user agent
if (!function_exists('user_agent')) {

    function user_agent() {
        return (isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'Undetected');
    }

}

//get some first clause of string
if (!function_exists('sub_string_for_description')) {

    function sub_string_for_description($str, $demo_length = 120) {
        if ($str == "")
            return "";

        $default_word_length = 10;

        $length = strlen($str);

        if ($length < $demo_length) {
            return $str;
        }

        $demo = substr($str, 0, $demo_length);

        $check = strpos($demo, ' ', $demo_length - $default_word_length);

        if ($check)
            $demo = substr($demo, 0, $check) . ' . . .';

        return $demo;
    }

}

//show jAlert to client
if (!function_exists('alert')) {

    function alert($message, $title = 'Thông báo', $type = 'error', $is_echo = FALSE) {
        $alert = "<script type='text/javascript'>
        $(document).ready(function(){
        jAlert('$type','$message', '$title');})</script>";

        if ($is_echo == FALSE)
            return $alert;
        else
            echo $alert;
    }

}

/**
 * get request url
 * 
 * @param string $uri 
 * @return string full link
 */
function request_url() {
    if (isset($_SERVER['REQUEST_URI'])) {
        return $_SERVER['REQUEST_URI'];
    } else
        return "";
}

/**
 * get link url
 * 
 * @param string $uri 
 * @return string full link
 */
function full_url() {
    $pageURL = 'http';

    if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
        $pageURL .= "s";
    }

    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}

/**
 * get link static
 * 
 * @param string $uri 
 * @return string full link
 */
if (!function_exists('static_url')) {

    function static_url($uri = NULL) {
        return base_url($uri);
    }

}


/**
 * get link img
 * 
 * @param string $uri 
 * @param string full link
 */
if (!function_exists('img_url')) {

    function img_url($uri = NULL) {
        return base_url($uri);
    }

}

/**
 * get link mp3
 * 
 * @param string $uri 
 * @param string full link
 */
if (!function_exists('mp3_url')) {

    function mp3_url($uri = NULL) {
        return base_url($uri);
    }

}

/**
 * get link video
 * 
 * @param string $uri 
 * @param string full link
 */
if (!function_exists('video_url')) {

    function video_url($uri = NULL) {
        return base_url($uri);
    }

}

/**
 * get theme
 * 
 * @return string theme
 */
if (!function_exists('theme_web')) {

    function theme_web() {
        return config_item('penguin_theme');
    }

}

/**
 * get lang
 * @author dungdv3
 * @return lang code
 */
if (!function_exists('lang_web')) {

    function lang_web() {
        $language = get_cookie('pg_lang_web_value');
        if ($language) {
            $Enc = new Encryption();
            return $Enc->decode($language);
        }

        return config_item('language');
    }

}

// link static for con duong am nhac
if (!function_exists('static_base')) {

    function static_base() {
        return static_url() . 'static/' . theme_web() . '/';
    }

}

//Get config base_url of zing domain
if (!function_exists('base_url_zing')) {

    function base_url_zing() {
        $base_url_zing = config_item('base_url_zing');
        if ($base_url_zing == FALSE || $base_url_zing == '') {
            return base_url();
        } else {
            return $base_url_zing;
        }
    }

}

//get cache domain or static
if (!function_exists('static_base_cache')) {

    function static_base_cache() {
        $static_base_zing = config_item('static_base_zing');
        if ($static_base_zing == FALSE || $static_base_zing == '') {
            return base_url() . 'static/default/';
        } else {
            return $static_base_zing . 'static/default/';
        }
    }

}

// static to folder frontend
if (!function_exists('static_frontend')) {

    function static_frontend() {
        return static_base() . 'frontend/';
    }

}

// static to folder frontend
if (!function_exists('static_frontend_cache')) {

    function static_frontend_cache() {
        return static_base() . 'frontend/';
    }

}

// media to folder 
if (!function_exists('media_url')) {

    function media_url() {
        return base_url() . 'media/';
    }

}

// media to folder 
if (!function_exists('media_url_cache')) {

    function media_url_cache() {
        $static_base_zing = config_item('static_base_zing');
        if ($static_base_zing == FALSE || $static_base_zing == '') {
            return base_url() . 'media/';
        } else {
            return $static_base_zing . 'media/';
        }
    }

}

if (!function_exists('image_url')) {

    function image_url() {
        return base_url() . 'media/images/';
    }

}

/**
 * get javascript global 
 * 
 * @return string js global
 */
if (!function_exists('script_global')) {

    function script_global() {
        $CI = & get_instance();

        return '
            var base_url = "' . base_url() . '";
            var static_url = "' . static_base() . '";
            var static_frontend = "' . static_frontend() . '";
            var full_url = "' . full_url() . '";
            var current_url = "' . current_url() . '";
            var request_url = "' . request_url() . '";
            var media_url = "' . media_url() . '";
            var image_url = "' . media_url() . 'images/";
            var img_url = "' . base_url() . '";
            var mp3_url = "' . base_url() . '";
            var video_url = "' . base_url() . '";
            var template = "' . config_item('penguin_theme') . '";
            var global_username = "' . $CI->session->userdata('user_username') . '";
        ';
    }

}

/**
 * check permission
 * 
 * @param int $role_id
 * @param string $resource_name
 * @param string $type
 */
if (!function_exists('is_allow')) {

    function is_allow($role_id, $resource_name, $type = 'r') {
        // check role
        if (!is_numeric($role_id) && !$role_id) {
            return FALSE;
        }

        if (strpos($resource_name, 'admin') !== FALSE && !is_admin()) {
            return FALSE;
        }

        $CI = & get_instance();

        $CI->load->library('acl');

        $is_allow = FALSE;

        $CI->db->select('id');
        $resource = $CI->db->get_where('module_resources', array('name' => $resource_name));

        if ($resource->num_rows() == 0) {
            return FALSE;
        }

        // get resource id
        $resource_id = $resource->row()->id;

        switch ($type) {
            case 'r':
                $is_allow = $CI->acl->is_read($role_id, $resource_id);
                break;
            case 'w':
                $is_allow = $CI->acl->is_write($role_id, $resource_id);
                break;
            case 'e':
                $is_allow = $CI->acl->is_modify($role_id, $resource_id);
                break;
            case 'p':
                $is_allow = $CI->acl->is_publish($role_id, $resource_id);
                break;
            case 'd':
                $is_allow = $CI->acl->is_delete($role_id, $resource_id);
                break;
            case 't':
                $is_allow = $CI->acl->is_trash($role_id, $resource_id);
                break;
            default:
                break;
        }

        return $is_allow;
    }

}

/**
 * check allow access for user online
 * 
 * @param string $resource_name
 * @param string $type
 * @return boolean
 */
if (!function_exists('is_access')) {

    function is_access($resource_name, $type) {
        return is_allow(get_role(), $resource_name, $type);
    }

}

/**
 * check admin login
 */
if (!function_exists('is_admin')) {

    function is_admin() {
        $CI = & get_instance();

        if ($CI->session->userdata('user_id') && $CI->session->userdata('user_username') && $CI->session->userdata('user_user_role_id') > 1 && $CI->session->userdata('user_is_administrator') == 1
        ) {
            return TRUE;
        }

        return FALSE;
    }

}

/**
 * check admin login
 */
if (!function_exists('is_mod')) {

    function is_mod() {
        $CI = & get_instance();

        if ($CI->session->userdata('user_id') && $CI->session->userdata('user_username') && ($CI->session->userdata('user_user_role_id') == 2) && $CI->session->userdata('user_is_administrator') == 1
        ) {
            return TRUE;
        }

        return FALSE;
    }

}

/**
 * check admin login
 */
if (!function_exists('is_user')) {

    function is_user() {
        $CI = & get_instance();

        if ($CI->session->userdata('user_id') && $CI->session->userdata('user_username') && ($CI->session->userdata('user_user_role_id') == 2) && $CI->session->userdata('user_is_administrator') == 1
        ) {
            return TRUE;
        }

        return FALSE;
    }

}

/**
 * Check user login
 */
if (!function_exists('is_login')) {

    function is_login() {
        $CI = & get_instance();
        if ($CI->session->userdata('user_id') && $CI->session->userdata('user_username')) {
            return TRUE;
        }

        return FALSE;
    }

}

/**
 * get User role id
 * 
 * @return int
 */
if (!function_exists('get_role')) {

    function get_role() {
        $CI = & get_instance();

        if ($CI->session->userdata('user_user_role_id')) {
            return $CI->session->userdata('user_user_role_id');
        } else {
            return ConstUserRole::guest;
        }
    }

}

/**
 * In giá trị sau khi check field
 * 
 * @param   string $value
 * @param   int $type 
 * @return  string value
 */
if (!function_exists('pg_field_value')) {

    function pg_field_value($value, $type = 'TEXT', $module = NULL) {
        switch ($type) {
            case ConstFieldType::date:
                $CI = & get_instance();
                // load hepler date
                $CI->load->helper('date');
                // get date
                return mdate(config_item('pg-date-format'), strtotime($value));
                break;
            case ConstFieldType::datetime:
                $CI = & get_instance();
                // load hepler date
                $CI->load->helper('date');
                // get date
                return mdate(config_item('pg-datetime-format'), strtotime($value));
                break;
            case ConstFieldType::image:
                $small_thumb = get_image_thumb($value, 'small_thumb');
                if (is_file(FPENGUIN . "media/images/$small_thumb"))
                    $img = "<img src='" . img_url() . "media/images/$small_thumb' />";
                else if (is_file(FPENGUIN . "media/images/" . get_image_thumb($value, 'medium_thumb'))) {
                    $medium_thumb = get_image_thumb($value, 'medium_thumb');
                    $img = "<img src='" . img_url() . "media/images/$medium_thumb' />";
                } else if ($value == "") {
                    $img = "";
                } else
                    $img = "<img src='" . img_url() . "media/images/$value' />";

                return "<a class='pgImageField' href='" . img_url() . "media/images/$value' rel='shadowbox'>$img</a>";
                break;
            case ConstFieldType::text:
            case ConstFieldType::num:
            default:
                return htmlspecialchars($value);
                break;
        }
    }

}

/**
 * Get username from user id
 * 
 * @param int $user_id user ID
 * @return string username
 */
if (!function_exists('user_name')) {

    function user_name($user_id) {
        $CI = & get_instance();

        $CI->db->select('username');
        $user = $CI->db->get_where('users', array('id' => $user_id));

        if ($user->num_rows() == 0)
            return false;

        return $user->row()->username;
    }

}

/**
 * Config and get link pagination
 * 
 * @param string $base_uri
 * @param int $total_rows
 * @param int $per_page
 * @param string $open_tag
 * @param string $close_tag
 * @return string
 */
if (!function_exists('pagination_config')) {

    function pagination_config($base_uri, $total_rows, $per_page = 20, $segment = 5, $open_tag = '', $close_tag = '', $extra_params = '') {
        $CI = & get_instance();

        $CI->load->library('pagination');

        if ($open_tag == '') {
            $open_tag = '<ul class=' . PAGINATION_UL_CLASS . '>';
        }

        if ($close_tag == '') {
            $close_tag = '</u>';
        }

        $config = array(
            'base_url' => base_url($base_uri),
            'total_rows' => $total_rows,
            'per_page' => $per_page,
            'full_tag_open' => $open_tag,
            'full_tag_close' => $close_tag,
            'uri_segment' => $segment
        );

        if ($extra_params != '') {
            $config['first_url'] = $config['base_url'] . '?' . $extra_params;
            $config['suffix'] = '?' . $extra_params;
        }

        $CI->pagination->initialize($config);

        return $CI->pagination->create_links();
    }

}

/**
 * Config and get link pagination
 * 
 * @param string $base_uri
 * @param int $total_rows
 * @param int $per_page
 * @return string
 */
if (!function_exists('pagination_custom')) {

    function pagination_custom($module, $controller, $action, $params, $total_rows, $per_page = 20, $segment = 5, $extra_param = '') {
        $CI = & get_instance();

        $CI->load->library('pagination');

        $link = get_link($module, $controller, $action, $params);
        $config = array(
            'base_url' => $link,
            'total_rows' => $total_rows,
            'per_page' => $per_page,
            'uri_segment' => $segment,
            'num_links' => 10,
            'full_tag_open' => '<ul class="pagination">',
            'full_tag_close' => '</ul>',
            'cur_tag_open' => '<li><a href="javascript:void(0);" class="active"><span><span>',
            'cur_tag_close' => '</span></span></a></li>',
            'num_tag_open' => '<li class="vng_custom"><span><span>',
            'num_tag_close' => '</span></span></li>',
            'prev_link' => '<',
            'prev_tag_open' => '<li class="vng_custom"><span><span>',
            'prev_tag_close' => '</span></span></li>',
            'next_link' => '>',
            'next_tag_open' => '<li class="vng_custom"><span><span>',
            'next_tag_close' => '</span></span></li>',
            'last_link' => '>>',
            'last_tag_open' => '<li class="vng_custom"><span><span>',
            'last_tag_close' => '</span></span></li>',
            'first_link' => '<<',
            'first_tag_open' => '<li><span><span>',
            'first_tag_close' => '</span></span></li>'
        );

        if ($extra_param != '') {
            $config['first_url'] = $link . '?' . $extra_param;
            $config['suffix'] = '?' . $extra_param;
        }

        $CI->pagination->initialize($config);

        return $CI->pagination->create_links(TRUE, '-');
    }

}

/**
 * Config and get link pagination
 * @access ajax
 * 
 * @param string $base_uri
 * @param int $total_rows
 * @param int $per_page
 * @return string
 */
if (!function_exists('pagination_ajax')) {

    function pagination_ajax($module, $controller, $action, $params, $total_rows, $per_page = 20, $segment = 5, $extra_param = '') {
        $CI = & get_instance();

        $CI->load->library('pagination');

        $link = get_link($module, $controller, $action, $params);

        $config = array(
            'base_url' => $link,
            'total_rows' => $total_rows,
            'per_page' => $per_page,
            'uri_segment' => $segment,
            'num_links' => 1,
            'full_tag_open' => '<ul class="JsPagination">',
            'full_tag_close' => '</ul>',
            'cur_tag_open' => '<li><a href="javascript:void(0);" class="active"><span><span>',
            'cur_tag_close' => '</span></span></a></li>',
            'num_tag_open' => '<li class="vng_custom"><span><span>',
            'num_tag_close' => '</span></span></li>',
            'prev_link' => '',
            'prev_tag_open' => '<li class="vng_custom"><span><span>',
            'prev_tag_close' => '</span></span></li>',
            'next_link' => '',
            'next_tag_open' => '<li class="vng_custom"><span><span>',
            'next_tag_close' => '</span></span></li>',
            'last_link' => FALSE,
            'last_tag_open' => '<li class="vng_custom"><span><span>',
            'last_tag_close' => '</span></span></li>',
            'first_link' => FALSE,
            'first_tag_open' => '<li><span><span>',
            'first_tag_close' => '</span></span></li>'
        );

        if ($extra_param != '') {
            $config['first_url'] = $link . '?' . $extra_param;
            $config['suffix'] = '?' . $extra_param;
        }

        $CI->pagination->initialize($config);

        return $CI->pagination->create_links(TRUE, '-');
    }

}

/**
 * Get link action in list view
 * @author dungdv3
 * @param string|array $links
 * @param int|array $ids
 * @param string $class class
 * @param string $prefix char bettween 2 action
 * @return string 
 */
if (!function_exists('link_action')) {

    function link_action($links, $ids = '', $class = 'action', $prefix = '') {
        // has once param
        if (is_numeric($ids)) {
            $id = $ids;
        } else if (is_array($ids)) { // have many params
            $id = '';
            foreach ($ids as $field => $field_id) {
                $id .= $field_id . '/';
            }

            $id = substr($id, 0, strlen($id) - 1);
        }

        // check multi link
        if (is_array($links) && !empty($links)) {
            $result_link = '';

            foreach ($links as $key => $link) {
                if (is_array($link)) {
                    //check no slash
                    if (isset($link['no_slash'])) {
                        $result_link .= '<a href="' . base_url($link['no_slash']) . $id . '" class="' . $class . ' ' . $link['class'] . '" ' . $params . '>' . lang($key) . '</a>';
                    } else {
                        $params = '';
                        // check and add attribute
                        foreach ($link as $attr => $attr_val) {

                            if ($attr != 'uri' && $attr != 'class') {
                                $params .= $attr . '="' . $attr_val . '" ';
                            }
                        }
                        $result_link .= '<a href="' . base_url($link['uri']) . '/' . $id . '?ReturnUrl=' . urlencode(full_url()) . '" class="' . $class . ' ' . $link['class'] . '" ' . $params . '>' . lang($key) . '</a>';
                    }
                } else {
                    // not attribute
                    $result_link .= '<a href="' . base_url($link) . '/' . $id . '?ReturnUrl=' . urlencode(full_url()) . '" class="' . $class . '">' . lang($key) . '</a>';
                }
            }

            return $result_link;
        }

        // default
        if ($links) {
            return '<a href="' . base_url($links) . '/' . $id . '?ReturnUrl=' . urlencode(full_url()) . '" class="' . $class . '">' . lang('Edit') . '</a>';
        }

        return '';
    }

}

/**
 * Debug by PG
 * 
 * @param type $var 
 */
if (!function_exists('pg_debug')) {

    function pg_debug($var, $is_die = TRUE) {
        echo '<pre>';
        print_r($var);
        echo '</pre>';

        if ($is_die == TRUE) {
            exit();
        }
    }

}

/**
 * Chuyển dạng date sang dạng chuẩn SQL
 * 
 * @param string $char_standar Dấu phân cách dạng chuẩn
 * @param string $char Dấu phân cách dạng hiện tại
 * @return string yyyy-mm-dd 
 */
if (!function_exists('standar_date')) {

    function standar_date($date, $char_standar = '-', $char = '/', $show = FALSE) {
        // if show view
        if ($show == TRUE) {
            // check char
            if (strpos($date, $char_standar) === FALSE) {
                return date('Y-m-d', strtotime($date));
            }

            // convert date yy-mm-dd to array
            $date_array = explode($char_standar, $date);

            // return date dd/mm/yy
            $return_date = $date_array[2] . $char . $date_array[1] . $char . $date_array[0];

            if ($return_date != $char . $char) {
                return $return_date;
            }
        } else { // insert db
            // check char
            if (strpos($date, $char) === FALSE) {
                return date('Y-m-d', strtotime($date));
            }

            // convert date dd/mm/yyyy to array
            $date_array = explode($char, $date);

            // return date yyyy/mm/dd
            $return_date = $date_array[2] . $char_standar . $date_array[1] . $char_standar . $date_array[0];

            if ($return_date != $char_standar . $char_standar) {
                return $return_date;
            }
        }

        return '';
    }

}

/**
 * Chuyển tên field sang dạng label
 * 
 * @param $label
 */
if (!function_exists('get_label')) {

    function get_label($label) {
        // remove _id
        $label = str_replace('_id', '', $label);

        // remove _
        $label = str_replace('_', ' ', $label);

        // uppercase head char
        $label = ucfirst($label);

        return lang($label);
    }

}

/**
 * redirect to url
 * 
 * @param string $module
 * @param string $controller
 * @param string $params
 */
if (!function_exists('redirect_to')) {

    function redirect_to($module, $controller = '', $action = 'index', $params = NULL) {
        // get link
        $link = get_link($module, $controller, $action, $params);

        // redirect
        redirect($link);
    }

}

/**
 * get link SEO
 * 
 * @param string $module module name
 * @param string $controller controller name
 * @param string $action action name
 * @param string $params params /
 * @return string link
 */
if (!function_exists('get_link')) {

    function get_link($module, $controller = '', $action = 'index', $params = '') {
        global $PG_Router;

        $r_module = $module;
        $r_resource = $controller;
        $r_action = $action;

        // get module router
        if (isset($PG_Router)) {
            if (isset($PG_Router[$module]['module'])) {
                $r_module = $PG_Router[$module]['module'];
            }

            if (isset($PG_Router[$module]['resource'][$controller])) {
                $r_resource = $PG_Router[$module]['resource'][$controller];
            }

            if (isset($PG_Router[$module]['action'][$action])) {
                $r_action = $PG_Router[$module]['action'][$action];
            }

            if ($module == $controller) {
                $r_resource = '';
            }

            if (!$params && $action == 'index') {
                $r_action = '';
            }
        }

        $link = str_replace('//', '/', "$r_module/$r_resource/$r_action/$params");

        return base_url($link);
    }

}

/**
 * Get folder upload file
 * 
 * @param string $folder_uri /images/avatar
 * @param string $sub_link_file return 
 * @return array 'dir' full path, 'sub_dir' path yyyy/mm/dd
 */
if (!function_exists('get_folder_upload')) {

    function get_folder_upload($folder_uri, $is_make_ymd_folder = TRUE) {
        // get dir path
        $dir = FPENGUIN . 'media/' . $folder_uri;

        // get date
        $sub_folder = ($is_make_ymd_folder) ? date('Y') . '/' . date('m') . '/' . date('d') : '';

        if (is_dir($dir)) {
            $dir_all = ($is_make_ymd_folder) ? $dir . '/' . $sub_folder : $dir;

            // get folder path
            $dir_all = str_replace('//', '/', $dir_all);

            // make dir
            if (!is_dir($dir_all)) {
                mkdir($dir_all, 0775, TRUE);
            }

            return array(
                'dir' => $dir_all,
                'sub_dir' => $sub_folder
            );
        }

        return FALSE;
    }

}

if (!function_exists('get_redim_folder_upload')) {

    function get_redim_folder_upload($folder_uri, $is_make_ymd_folder = TRUE) {
        // get dir path
        $dir = FPENGUIN . 'media/uploads/' . $folder_uri;

        // get date
        $sub_folder = ($is_make_ymd_folder) ? date('Y') . '/' . date('m') . '/' . date('d') : '';

        if (is_dir($dir)) {
            $dir_all = ($is_make_ymd_folder) ? $dir . '/' . $sub_folder : $dir;

            // get folder path
            $dir_all = str_replace('//', '/', $dir_all);

            // make dir
            if (!is_dir($dir_all)) {
                mkdir($dir_all, 0775, TRUE);
            }

            return array(
                'dir' => $dir_all,
                'sub_dir' => $sub_folder
            );
        }

        return FALSE;
    }

}

/**
 * get image thumb
 * 
 * @param string $image_uri yyyy/mm/dd/image
 * @param string thumb_maker
 * @return string yyyy/mm/dd/image_thumb
 */
if (!function_exists('get_image_thumb')) {

    function get_image_thumb($image_uri, $thumb_maker) {
        $img_to_array = explode('.', $image_uri);

        $length = count($img_to_array);
        //full url img
        if ($length > 2) {
            $ext = $img_to_array[$length - 1];
            unset($img_to_array[$length - 1]);

            $url = implode('.', $img_to_array);

            $image_thumb = $url . '_' . $thumb_maker . '.' . $ext;
        } else
            $image_thumb = $img_to_array[0] . '_' . $thumb_maker . '.' . $img_to_array[1];

        return $image_thumb;
    }

}

/**
 * Resize image
 * 
 * @param string $image_path 
 * @param array $config_options
 */
if (!function_exists('resize_image')) {

    function resize_image($src_image_path, $config_options = array()) {
        $CI = & get_instance();

        $config = array(
            'image_library' => 'gd2',
            'source_image' => $src_image_path,
            'create_thumb' => TRUE,
            'maintain_ratio' => TRUE,
            'quality' => 100,
            'width' => 150,
            'height' => 150,
        );

        if (!is_array($config_options)) {
            return FALSE;
        }

        foreach ($config_options as $key => $value) {
            $config[$key] = $value;
        }

        if ($config['create_thumb']) {
            if (!$config['thumb_marker']) {
                $config['thumb_marker'] = '_' . $config['width'] . 'x' . $config['height'];
            }
        }

        // load lib
        $CI->load->library('image_lib');
        $CI->image_lib->clear();
        $CI->image_lib->initialize($config);

        // resize image
        if (!$CI->image_lib->resize()) {
            return FALSE;
        }

        return TRUE;
    }

}

/**
 * Upload file
 * 
 * @param string $field_name
 * @param string $upload_uri example images/avatar
 * @param string $type jpg|png
 * @param int max_size
 * @param int max_width
 * @param int max_height
 * @param boolean $is_make_ymd_folder
 * @return array 'error' 1|0, 'message' error, 'file' file info, 'sort_link' yyyy/mm/dd/path  
 */
if (!function_exists('upload_file')) {

    function upload_file($field_name, $upload_uri, $type = 'jpg|JPG|jpge|JPGE', $max_size = '2000', $max_width = '1024', $max_height = '1024', $is_make_ymd_folder = TRUE) {
        $CI = & get_instance();

        $dir_upload = get_folder_upload($upload_uri, $is_make_ymd_folder);

        $config = array(
            'upload_path' => $dir_upload['dir'],
            'allowed_types' => $type,
            'max_size' => $max_size,
            'max_width' => $max_width,
            'max_height' => $max_height,
            'encrypt_name' => TRUE
        );

        $CI->load->library('upload', $config);

        if (!$CI->upload->do_upload($field_name)) {
            return array(
                'error' => 1,
                'message' => $CI->upload->display_errors()
            );
        } else {
            $file = $CI->upload->data();

            return array(
                'error' => 0,
                'file' => $file,
                'sort_link' => $dir_upload['sub_dir'] . '/' . $file['file_name']
            );
        }
    }

}

/**
 * Resize Thumb
 * modified 2011-11-30 9:50 by TungCN
 * 
 * @param string $img_path 
 */
if (!function_exists('create_thumb')) {

    function create_thumb($img_path, $width = 60, $height = 60, $thumb_marker = '_small_thumb') {
        $resize_config = array(
            'width' => $width,
            'height' => $height,
            'thumb_marker' => $thumb_marker,
            'create_thumb' => TRUE,
        );
        resize_image($img_path, $resize_config);
    }

}

/**
 * @author TungCN
 * make slug
 * 
 * replace space with - symbol
 * replace TiengViet
 *
 * @param string $string
 * @param string $remove_special // hungtd
 * @return string
 */
if (!function_exists('make_slug')) {

    function make_slug($string, $remove_special = FALSE) {
        $CI = & get_instance();

        $CI->load->helper('text');
        $CI->load->helper('url');

        if ($string) {
            $string = url_title(convert_accented_characters($string));
            // add by hungtd
            // remove special char
            $special_array = array(
                '.',
            );
            $replace_array = array(
                ''
            );
            $string = str_replace($special_array, $remove_special, $string);
        }

        return $string;
    }

}

/**
 * @author TungCN
 * draw tree category
 *
 * @param array $category
 * @param integer $level
 * @param string $input_html
 * 		example <option value="##VALUE##">##INDENT_SYMBOL####NAME##</option>
 * @param string $indent_symbol
 * 		example '-&nbsp'
 * @param array $selected_value
 * @return string
 */
if (!function_exists('draw_tree_category_block')) {

    function draw_tree_category_block($category, $input_html, $level = 0, $indent_symbol = '-&nbsp;', $selected_value = array(), $href_uri = '') {
        $output = '';
        foreach ($category['items'] as $cat) {
            // Init
            $each_category_html = $input_html;

            $indent = '';
            for ($i = 0; $i <= $level; $i++) {
                $indent .= $indent_symbol;
            }

            $selected = (count($selected_value) && in_array($cat['id'], $selected_value)) ? 'selected' : '';


            $find_replace = array(
                '##VALUE##' => $cat['id'],
                '##INDENT_SYMBOL##' => $indent,
                '##NAME##' => $cat['name'],
                '##SELECTED##' => $selected,
                '##HREF##' => $href_uri
            );

            $output .= strtr($each_category_html, $find_replace);

            if (isset($cat['items'])) {
                $output .= draw_tree_category_block($cat, $input_html, $level + 1, $indent_symbol, $selected_value, $href_uri);
            }
        }

        return $output;
    }

}
/**
 * Add/Subtract time
 * @param datetime $date
 * @param int $time time add
 * @param boolean $is_add
 */
if (!function_exists('add_time')) {

    function add_time($date, $time, $is_add = TRUE) {
        $date_convert_time = strtotime($date);
        if ($is_add) {
            $date_added = $date_convert_time + $time;
        } else {
            $date_added = $date_convert_time - $time;
        }
        return date('Y-m-d H:i:s', $date_added);
    }

}

/**
 * create captcha
 * @param int $width
 * @param int $height
 * @param type $length 
 * @return string tag img
 */
if (!function_exists('print_captcha')) {

    function print_captcha($width = '100', $height = '50', $length = 6) {
        $CI = & get_instance();
        $CI->load->helper('captcha');
        $CI->load->helper('strhash');

        if (!is_dir(FPENGUIN . 'static/captcha/')) {
            mkdir(FPENGUIN . 'static/captcha/', 0777, TRUE);
        }

        $vals = array(
            'word' => strtoupper(random_string($length)),
            'img_path' => FPENGUIN . 'static/captcha/',
            'img_url' => base_url('static/captcha') . '/',
            'font_path' => FPENGUIN . 'system/fonts/TAHOMA.TTF',
            'img_width' => $width,
            'img_height' => $height,
            'expiration' => 300
        );

        $cap = create_captcha($vals);
        // create session
        $_SESSION['captcha'] = string_hash($cap['word']);
        $link_recaptcha = base_url() . 'users/recaptcha';
        $script_recaptcha = '<script>function js_recaptcha(){$.get("' . $link_recaptcha . '",function(data){$("#ci_captcha_image").html(data);});}' . '</script>';
        return '<div id="ci_captcha_image" style="width:' . ($width + 20) . 'px;height:' . $height . 'px;">' . $cap['image'] . '<a href="#" class="JsReCaptcha" onclick="js_recaptcha();return false;"><img src="' . static_url() . 'static/default/images/reCaptcha.png' . '" /></a>' . '</div>' . '<br />' . $script_recaptcha;
    }

}


/**
 * create captcha
 * @param int $width
 * @param int $height
 * @param type $length 
 * @return string tag img
 */
if (!function_exists('print_captcha_without_recapt')) {

    function print_captcha_without_recapt($width = '100', $height = '50', $length = 6) {
        $CI = & get_instance();
        $CI->load->helper('captcha');
        $CI->load->helper('strhash');

        $vals = array(
            'word' => strtoupper(random_string($length)),
            'img_path' => FPENGUIN . 'static/captcha/',
            'img_url' => base_url('static/captcha') . '/',
            'font_path' => FPENGUIN . 'system/fonts/TAHOMA.TTF',
            'img_width' => $width,
            'img_height' => $height,
            'expiration' => 300
        );

        $cap = create_captcha($vals);
        // create session
        $_SESSION['captcha'] = string_hash($cap['word']);
        return '<div id="ci_captcha_image" style="width:' . $width . 'px;height:' . $height . 'px; float:left">' . $cap['image'] . '</div>';
    }

}

/**
 * RECAPTCHA USING AJAX
 * @param int $width
 * @param int $height
 * @param type $length
 * @return string tag img
 */
if (!function_exists('print_re_captcha')) {

    function print_re_captcha($width = '100', $height = '50', $length = 6) {
        $CI = & get_instance();
        $CI->load->helper('captcha');
        $CI->load->helper('strhash');

        $vals = array(
            'word' => strtoupper(random_string($length)),
            'img_path' => FPENGUIN . 'static/captcha/',
            'img_url' => base_url('static/captcha') . '/',
            'font_path' => FPENGUIN . 'system/fonts/TAHOMA.TTF',
            'img_width' => $width,
            'img_height' => $height,
            'expiration' => 300
        );

        $cap = create_captcha($vals);
        // create session
        $_SESSION['captcha'] = string_hash($cap['word']);
        return $cap['image'] . '<a href="#" class="JsReCaptcha" onclick="js_recaptcha();return false;"><img src="' . static_url() . 'static/default/images/reCaptcha.png' . '" /></a>';
    }

}

/**
 * check captcha
 * @param string $captcha
 * @return string tag img
 */
if (!function_exists('check_captcha')) {

    function check_captcha($captcha = '') {
        $CI = & get_instance();
        $CI->load->helper('captcha');
        $CI->load->helper('strhash');
        if (!empty($captcha)) {
            if (strtolower($captcha) == strtolower(string_hash($_SESSION['captcha'], false))) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}

/**
 * create random string
 * @param int $length
 */
if (!function_exists('random_string')) {

    function random_string($length = 6) {
        $base = 'ABCDEFGHKLMNOPQRSTWXYZabcdefghjkmnpqrstwxyz123456789';
        $max = strlen($base) - 1;

        mt_srand((double) microtime() * 1000000);

        $activatecode = '';
        while (strlen($activatecode) < $length) {
            $activatecode .= $base{mt_rand(0, $max)};
        }

        return $activatecode;
    }

}

/**
 * Show maintenance page
 */
if (!function_exists('show_maintenance')) {

    function show_maintenance() {
        redirect_to('errors', '', 'maintenance');
    }

}

/**
 * write log file
 */
if (!function_exists('write_log_file')) {

    function write_log_file($filename = 'error', $message = NULL) {
        $CI = & get_instance();
        $CI->load->helper('file');

        if (is_array($message))
            $message = json_encode($message);

        $message = date('d/m/Y H:i:s') . ":\t$message\n";

        write_file(FPENGUIN . config_item('log_path') . $filename . '.log', $message, 'a');
    }

}

/**
 * write custom cache
 */
if (!function_exists('write_html_cache')) {

    function write_html_cache($key, $output_cache) {
        $CI = & get_instance();
        $CI->load->helper('file');
        write_file(FPENGUIN . APPPATH . "cache/html/cache__html__$key.html", $output_cache);
    }

}

/**
 * get custom cache
 */
if (!function_exists('get_html_cache')) {

    function get_html_cache($key) {
        @include FPENGUIN . APPPATH . "cache/html/cache__html__$key.html";
    }

}

/**
 * @author TungCN
 * 
 * get extra Params from $_GET
 */
if (!function_exists('get_extra_params_from_url')) {

    function get_extra_params_from_url() {
        $params = $_GET;
        $return_extra_params = '';
        if (count($params) > 0) {
            $tempt = 0;
            foreach ($params as $key => $value) {
                if ($key != 's') {
                    if ($tempt == 0)
                        $return_extra_params = $return_extra_params . $key . '=' . $value;
                    else
                        $return_extra_params = $return_extra_params . '&' . $key . '=' . $value;
                    $tempt = $tempt + 1;
                }
                else {
                    $params_sort = $params['s'];
                    foreach ($params_sort as $key_sort => $value_sort) {
                        if ($tempt == 0)
                            $return_extra_params = $return_extra_params . 's[' . $key_sort . ']' . '=' . $value_sort;
                        else
                            $return_extra_params = $return_extra_params . '&' . 's[' . $key_sort . ']' . '=' . $value_sort;
                        $tempt = $tempt + 1;
                    }
                }
                $tempt = $tempt + 1;
            }
        }
        return $return_extra_params;
    }

}

/**
 * @author 
 * edit 25/11/2013 by dungdv3
 * Hàm giúp tạo token theo thời gian. Chạy hàm khi khởi tạo trang chi tiết cần vote.
 * @param int $resource_name tên của resource.
 * @param int $record_id id của item.
 * @param int $vote_type id của kiểu vote.
 * @param int $field_update_count tên field cập nhật số count.
 * @param int $point số điểm tăng lên mỗi lần vote.
 * @return string chuỗi mã hóa thông tin các biến tương ứng item cần voting
 */
if (!function_exists('generate_voting_params')) {

    function generate_voting_params($resource_name, $record_id, $vote_type, $field_update_count, $point) {

        $CI = & get_instance();
        $CI->load->helper('strhash');

        $token = sha1($resource_name . $record_id . $vote_type . microtime(true));
        $_SESSION["sys_vt_{$resource_name}_{$record_id}_{$vote_type}"] = $token;

        $params_vote = string_hash(json_encode(array(
            'record_id' => $record_id,
            'resource_name' => $resource_name,
            'type_id' => $vote_type,
            'voting_token' => $token,
            'field_update_count' => $field_update_count,
            'point' => $point,
        )));

        return $params_vote;
    }

}

/**
 * @author dungdv3
 * created date 25/11/2013
 * Hàm kiểm tra thông tin vote hợp lệ hay không:
 * - Kiểm tra chuỗi thông tin đã được mã hóa.
 * - Sau khi kiểm tra thì hủy Session tương ứng.
 * @param string chuỗi mã hóa thông tin các biến tương ứng item cần voting.
 * @return array Mảng chứa thông tin cần thiết.
 * @return false Thông tin chuỗi mã hóa không hợp lệ hoặc sai token.
 */
if (!function_exists('check_voting_params')) {

    function check_voting_params($string_param_vote) {

        $CI = & get_instance();
        $CI->load->helper('strhash');

        $params_vote = json_decode(string_hash($string_param_vote, false), true);

        if ($params_vote != null) {
            if (isset($params_vote['voting_token']) && $_SESSION["sys_vt_{$params_vote['resource_name']}_{$params_vote['record_id']}_{$params_vote['type_id']}"] == $params_vote['voting_token']) {
                unset($_SESSION["sys_vt_{$params_vote['resource_name']}_{$params_vote['record_id']}_{$params_vote['type_id']}"]);
                return $params_vote;
            }
            unset($_SESSION["sys_vt_{$params_vote['resource_name']}_{$params_vote['record_id']}_{$params_vote['type_id']}"]);
        }
        return false;
    }

}

/**
 * check route
 */
if (!function_exists('is_router')) {

    function is_router($param_uri, $is_uri = TRUE) {
        $CI = & get_instance();
        if (!empty($CI->router->routes['root/([a-zA-Z]+)/(:any)'])) {
            if ($is_uri) {
                if (strpos($param_uri, 'admin_') !== FALSE) {
                    $param_uri = str_replace('admin_', '', $param_uri);
                    $param_uri = "root/$param_uri";
                    return $param_uri;
                }

                return FALSE;
            } else {
                if (strpos($param_uri, 'admin_') !== FALSE) {
                    return TRUE;
                }

                return FALSE;
            }
        }
    }

}

/**
 * get ip
 */
if (!function_exists('get_client_ip')) {

    function get_client_ip() {
        $ip = '';
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from gateway
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

}

/**
 * @author dungdv3@vng.com.vn
 * Create date 1/11/2013
 * This funtion help to remove bad word in comment. This function include two steps:
 * 1. Remove bad tokens which is defined in file bad_words.txt
 * 2. Remove bad part of sentence which is defined in file bad_sentences.txt
 */
if (!function_exists('remove_bad_words_in_comment')) {

    function remove_bad_words_in_comment($comment) {

        //filter token
        $comment_tokens_array = explode(' ', $comment);
        $filter_badword = read_file(APPPATH . 'modules/comments/config/bad_words.txt');
        $filter_badword = explode(' ', $filter_badword);
        $fixed_comment = '';
        foreach ($comment_tokens_array as $token) {
            if (!in_array($token, $filter_badword)) {
                $fixed_comment.=$token . ' ';
            } else {
                for ($i = 1; $i <= mb_strlen($token); $i++) {
                    $fixed_comment.='*';
                }
                $fixed_comment.=' ';
            }
        }

        //filter part of sentence
        $filter_sentence = read_file(APPPATH . 'modules/comments/config/bad_sentences.txt');
        $filter_sentence = explode(';', $filter_sentence);

        $fixed_comment = str_replace($filter_sentence, '*****', $fixed_comment);

        return $fixed_comment;
    }

}

/**
 * Create URL Title
 *
 * Takes a "title" string as input and creates a
 * human-friendly URL string with either a dash
 * or an underscore as the word separator.
 *
 * @access	public
 * @param	string	the string
 * @param	string	the separator: dash, or underscore
 * @return	string
 */
if (!function_exists('url_title')) {

    function url_title($str, $separator = 'dash', $lowercase = FALSE) {
        if ($separator == 'dash') {
            $search = '_';
            $replace = '-';
        } else {
            $search = '-';
            $replace = '_';
        }

        $trans = array(
            '&\#\d+?;' => '',
            '&\S+?;' => '',
            '\s+' => $replace,
            '[^a-z0-9\-\._]' => '',
            $replace . '+' => $replace,
            $replace . '$' => $replace,
            '^' . $replace => $replace,
            '\.+$' => ''
        );

        $str = strip_tags($str);

        foreach ($trans as $key => $val) {
            $str = preg_replace("#" . $key . "#i", $val, $str);
        }

        if ($lowercase === TRUE) {
            $str = strtolower($str);
        }

        return trim(stripslashes($str));
    }

}


/**
 * Gửi email
 */
if (!function_exists('send_email')) {

    function send_email($to_email, $title, $body, $reply_to = '', $bcc = '') {
        //Gửi mail
        try {
            $from = 'contact@zingads.vn';

            // config
            $config = array(
                'useragent' => 'CornettoValentine2015',
                'protocol' => 'smtp',
                'smtp_host' => '10.30.12.52',
                'smtp_port' => '25',
                'mailtype' => 'html',
            );

            $CI = & get_instance();
            $CI->load->library('email', $config);

            $CI->email->subject($title);
            $CI->email->message($body);
            $CI->email->from($from, 'Adtima');
            $CI->email->to($to_email);
            $CI->email->reply_to($reply_to);
            $CI->email->bcc($bcc);

            $result = $CI->email->send();
            return $result;
        } catch (Exception $ex) {
            return 0;
        }
    }

}

/**
 * redirect_previous_url
 * @author dungdv3
 */
if (!function_exists('redirect_previous_url')) {

    function redirect_previous_url($url) {
        if (isset($_GET['ReturnUrl']) && $_GET['ReturnUrl'] != '') {
            redirect(urldecode($_GET['ReturnUrl']));
        } else {
            redirect(base_url($url));
        }
    }

}

/**
 * function to get login url from zingme
 */
if (!function_exists('get_zingme_sso_url')) {

    function get_zingme_sso_url() {
        $CI = & get_instance();
        $CI->load->library('zing_me');
        return($CI->zing_me->zm_get_login_url(base_url_zing() . "open_login/ajax_login"));
    }

}