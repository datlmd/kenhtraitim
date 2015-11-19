<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Photo_categories
 * ...
 * 
 * @package PenguinFW
 * @subpackage Photo
 * @version 1.0.0
 */
 
class Photo_categories extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Photo';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('photos', lang_web());
            
        $this->load->model('Photo');
    }
}
                
?>