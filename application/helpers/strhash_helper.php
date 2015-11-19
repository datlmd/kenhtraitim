<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * Các hàm về hash string
 * 
 * @author      hungtd <tdhungit@gmail.com> 0972014011
 * @copyright   Tran Dinh Hung 2011
 * @package     PenguinFW
 * @subpackage  Helper
 * @version     1.0.0
 */

/**
 * hash string
 * 
 * @param string $string hash
 * @param boolean $encode
 * @return string hash
 */
if (!function_exists('string_hash'))
{
    function string_hash($string, $encode = TRUE)
    {
        if ($encode)
        {
            $string_base = @base64_encode(@convert_uuencode($string));
            $time_convert = @base64_encode(@convert_uuencode(time()));
            
            $string_rand = $string_base . '|' . $time_convert;
            
            return @base64_encode(@base64_encode(@convert_uuencode($string_rand)));
        } else 
        {
            $string_rand = @convert_uudecode(@base64_decode(@base64_decode($string)));
            
            $string_array = explode('|', $string_rand);
            
            $string_base = $string_array[0];
            
            return @convert_uudecode(@base64_decode($string_base));
        }
        
        return FALSE;
    }
}

/**
 * set token
 */
if (!function_exists('get_token'))
{
    function get_token($session_name = 'sys_token')
    {
        $CI =& get_instance();
        $token = str_replace(' ', '', md5(uniqid(rand(),true)));
        $CI->session->set_userdata($session_name, $token);
        return $token;
    }
}

/**
 * check token
 */
if (!function_exists('check_token'))
{
    function check_token($client_token ,$session_name = 'sys_token')
    {
        $CI =& get_instance();
        $token = $CI->session->get_userdata($session_name);

        if($client_token == $token)
            return TRUE;
        
        return FALSE;
    }
}

/**
 * set token cookie
 */
if (!function_exists('get_ctoken'))
{
    function get_ctoken($cookie_name = 'systkbhyt')
    {
        $token = str_replace(' ', '', md5(uniqid(rand(),true)));
        set_cookie($cookie_name, $token, time()+3600);
        return $token;
    }
}

/**
 * set token session
 */
if (!function_exists('get_stoken'))
{
    function get_stoken($session_name = 'sys_session_token')
    {
        $token = str_replace(' ', '', md5(uniqid(rand(),true)));
        $_SESSION[$session_name] = $token;
        return $token;
    }
}