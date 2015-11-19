<?php

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Zend ACL and Codeigniter
 * 
 * @package PenguinFW
 * @subpackage ACL
 * @version 1.0.0
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

ini_set('include_path', FPENGUIN . 'application/third_party/Mobile_detect/' . PATH_SEPARATOR . ini_get('include_path'));
require_once "Mobile_Detect.php";

class CI_Mobile_detect extends Mobile_Detect
{   
    function __construct()
    {       
        parent::__construct();
    }
    
    function get_user_agent()
    {
        //check device
        $device = 'Computer';
        if($this->isIphone())
            $device = 'IPhone';
        elseif($this->isMobile())
            $device = 'Phone';
        elseif($this->isTablet())
            $device = 'Tablet';
        
        //check brower
        $brower = 'Other';
        if($this->version('Chrome'))
            $brower = 'Chrome';
        elseif($this->version('MSIE'))
            $brower = 'Internet Explorer';
        elseif($this->version('Safari'))
            $brower = 'Safari';
        elseif($this->version('Firefox'))
            $brower = 'Firefox';
        
        return($device . ' / ' . $brower);
    }
}

?>
