<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Music_report_types
 * ...
 * 
 * @package PenguinFW
 * @subpackage Music
 * @version 1.0.0
 * 
 * @property Music_report_type      $Music_report_type
 * @property Music_report           $Music_report
 */
 
class Music_report_types extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Music_report_type';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('musics', lang_web());
            
        $this->load->model('Music_report_type');
    }
        
}
                
?>