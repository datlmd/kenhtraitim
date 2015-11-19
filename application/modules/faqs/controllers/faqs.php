<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Faqs
 * ...
 * 
 * @package PenguinFW
 * @subpackage faqs
 * @version 1.0.0
 */
 
class Faqs extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Faq';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('faqs', lang_web());
            
        $this->load->model('Faq');
    }

    

}
                
?>