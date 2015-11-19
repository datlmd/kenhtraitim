<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Sms_logs
 * ...
 * 
 * @package PenguinFW
 * @subpackage votes
 * @version 1.0.0
 */
 
class Sms_logs extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Sms_log';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('votes', lang_web());
            
        $this->load->model('Sms_log');
    }



}
                
?>