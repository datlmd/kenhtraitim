<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Provinces
 * ...
 * 
 * @package PenguinFW
 * @subpackage address
 * @version 1.0.0
 */
 
class Provinces extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Province';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('address', lang_web());
            
        $this->load->model('Province');
    }



}
                
?>