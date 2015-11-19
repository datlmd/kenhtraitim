<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller custom_field_names
 * ...
 * 
 * @package PenguinFW
 * @subpackage custom_field
 * @version 1.0.0
 */
 
class custom_field_names extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->lang->load('generate', lang_web());
        $this->lang->load('custom_fields', lang_web());
    }
}
                
?>