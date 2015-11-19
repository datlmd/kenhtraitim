<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller User_logs
 * ...
 * 
 * @package PenguinFW
 * @subpackage users
 * @version 1.0.0
 */
 
class User_logs extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'User_log';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('users', lang_web());
            
        $this->load->model('User_log');
    }



}
                
?>