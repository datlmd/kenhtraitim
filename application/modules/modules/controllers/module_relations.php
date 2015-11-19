<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Module_relations
 * ...
 * 
 * @package PenguinFW
 * @subpackage modules
 * @version 1.0.0
 */
 
class Module_relations extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Module_relation';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('modules', lang_web());
            
        $this->load->model('Module_relation');
    }        
}
                
?>