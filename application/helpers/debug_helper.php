<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * Cac ham ve field support view
 * 
 * @author      hungtd <tdhungit@gmail.com> 0972014011
 * @copyright   Tran Dinh Hung 2011
 * @package     PenguinFW
 * @subpackage  Helper
 * @version     1.0.0
 */

/**
 * show data to debug
 * 
 * @param string $uri 
 * @return string full link
 */
if (!function_exists('debug'))
{
    function debug($obj, $is_die = TRUE)
    {
        echo "<pre>";
        
        var_dump($obj);
        
        echo "</pre>";
        
        if($is_die)
            die;
    }
}

//show jAlert to client by session
if(!function_exists('sess_alert'))
{

    function sess_alert($message, $title = 'Thông báo')
    {
         $CI = & get_instance();
        
        $alert = '<script type="text/javascript">jAlert("error","'.$message.'", "'.$title.'");</script>';
       
       
        $CI->session->set_userdata('alert', $alert);
        
        return $alert;
    }

}

?>