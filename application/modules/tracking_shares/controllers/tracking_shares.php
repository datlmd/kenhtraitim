<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Tracking_shares
 * ...
 * 
 * @package PenguinFW
 * @subpackage tracking_shares
 * @version 1.0.0
 */
 
class Tracking_shares extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Tracking_share';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('tracking_shares', lang_web());
            
        $this->load->model('Tracking_share');
    }



}
                
?>