<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Events
 * ...
 * 
 * @package PenguinFW
 * @subpackage events
 * @version 1.0.0
 */
 
class Events extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Event';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('events', lang_web());
            
        $this->load->model('Event');
    }



}
                
?>