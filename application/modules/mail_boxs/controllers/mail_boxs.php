<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Mail_boxs
 * ...
 * 
 * @package PenguinFW
 * @subpackage mail_boxs
 * @version 1.0.0
 */
 
class Mail_boxs extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Mail_box';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('mail_boxs', lang_web());
            
        $this->load->model('Mail_box');
    }



}
                
?>