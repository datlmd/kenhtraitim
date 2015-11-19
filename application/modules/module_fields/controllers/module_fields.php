<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Module_fields
 * ...
 * 
 * @package PenguinFW
 * @subpackage Module_field
 * @version 1.0.0
 */
 
class Module_fields extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->lang->load('generate', lang_web());
        $this->lang->load('module_fields', lang_web());
    }
}
                
?>