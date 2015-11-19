<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Page_view_manages
 * ...
 * 
 * @package PenguinFW
 * @subpackage pages 
 * @version 1.0.0
 */
 
class Page_view_manages extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Page_view_manage';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('pages ', lang_web());
            
        $this->load->model('Page_view_manage');
    }



}
                
?>