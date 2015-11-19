<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Customer_groups
 * ...
 * 
 * @package PenguinFW
 * @subpackage customer_groups
 * @version 1.0.0
 */
 
class Customer_groups extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Customer_group';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('customer_groups', lang_web());
            
        $this->load->model('Customer_group');
    }



}
                
?>