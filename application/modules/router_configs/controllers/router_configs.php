<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Router_configs
 * ...
 * 
 * @package PenguinFW
 * @subpackage Router_config
 * @version 1.0.0
 */
 
class Router_configs extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Router_config';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('router_configs', lang_web());
            
        $this->load->model('Router_config');
    }
}
                
?>