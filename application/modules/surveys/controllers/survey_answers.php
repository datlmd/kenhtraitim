<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Survey_answers
 * ...
 * 
 * @package PenguinFW
 * @subpackage Survey
 * @version 1.0.0
 */
 
class Survey_answers extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Survey';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('surveys', lang_web());
            
        $this->load->model('Survey');
    }
}
                
?>