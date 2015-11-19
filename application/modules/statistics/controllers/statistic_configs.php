<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Statistic_configs
 * ...
 * 
 * @package PenguinFW
 * @subpackage statistics
 * @version 1.0.0
 */
 
class Statistic_configs extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Statistic_config';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('statistics', lang_web());
            
        $this->load->model('Statistic_config');
    }



}
                
?>