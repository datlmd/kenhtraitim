<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Reports
 * ...
 * 
 * @package PenguinFW
 * @subpackage reports
 * @version 1.0.0
 */
 
class Reports extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Report';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('reports', lang_web());
            
        $this->load->model('Report');
    }        
}
                
?>