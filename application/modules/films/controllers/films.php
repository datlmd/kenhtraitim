<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN_LITE FrameWork
 * @author hoanhk
 * @copyright Huynh Kim Hoan 2013
 * 
 * Controller Films
 * ...
 * 
 * @package Penguin_liteFW
 * @subpackage films
 * @version 2.0.0
 */
 
class Films extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Film';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('films', lang_web());
            
        $this->load->model('Film');
    }



}
                
?>