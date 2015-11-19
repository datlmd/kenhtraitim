<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Vote_types
 * ...
 * 
 * @package PenguinFW
 * @subpackage Vote_type
 * @version 1.0.0
 * 
 * @property Vote       $Vote
 * @property Vote_type  $Vote_type
 */
 
class Vote_types extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Vote_type';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('votes', lang_web());
            
        $this->load->model('Vote_type');
    }        
}
                
?>