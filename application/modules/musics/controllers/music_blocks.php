<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Music_blocks
 * ...
 * 
 * @package PenguinFW
 * @subpackage musics
 * @version 1.0.0
 * 
 * @property Music $Music 
 */
 
class Music_blocks extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Music';
        
        $this->layout->set_layout('empty');
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('musics', lang_web());
            
        $this->load->model('Music');
    }        
}
                
?>