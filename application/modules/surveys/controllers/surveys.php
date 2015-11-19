<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Surveys
 * ...
 * 
 * @package PenguinFW
 * @subpackage Survey
 * @version 1.0.0
 */
 
class Surveys extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Survey';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('surveys', lang_web());
            
        $this->load->model('Survey');
        $this->load->model('Survey_question');
        $this->load->model('Survey_answer');
    }
    
    public function submit()
    {

       $inputs = $_POST["survey"];
        
       $this->Survey->insert($inputs, TRUE , TRUE , TRUE);       
        
        echo 1;die;
    }
}
                
?>