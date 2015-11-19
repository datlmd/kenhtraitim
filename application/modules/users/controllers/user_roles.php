<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller user_roles
 * ...
 * 
 * @package PenguinFW
 * @subpackage user
 * @version 1.0.0
 * 
 * @property User_role $User_role
 */
 
class User_roles extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'User_role';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('users', lang_web());
            
        $this->load->model('User_role');
    }
}
                
?>