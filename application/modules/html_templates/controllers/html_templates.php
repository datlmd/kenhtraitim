<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Html_templates
 * ...
 * 
 * @package PenguinFW
 * @subpackage Html_template
 * @version 1.0.0
 */
 
class Html_templates extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Html_template';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('html_templates', lang_web());
            
        $this->load->model('Html_template');
    }
}
                
?>