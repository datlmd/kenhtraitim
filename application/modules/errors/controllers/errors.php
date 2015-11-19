<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Errors
 * ...
 * 
 * @package PenguinFW
 * @subpackage Error
 * @version 1.0.0
 */
 
class Errors extends MY_Controller
{
    function __construct()
    {
        parent::__construct();                    
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('errors', lang_web());                    
    }
    
    /**
     * Show error 404
     * 
     * @param string $page 
     */
    public function error_404($page = '')
    {
        // set title
        $this->layout->set_title(lang('Page Not Found'));
        
        $page = str_replace('__', '/', $page);
        
        $data = array(
            'error_code' => lang('404 Page Not Found'),
            'error_link' => base_url($page),
            'error_message' => lang('The page you requested was not found.')
        );
        
        $this->parser->parse('error_404', $data);
    }
    
    /**
     * Show page off
     */
    public function maintenance()
    {
        // set title
        $this->layout->set_title(lang('Maintenance'));
        
        $this->parser->parse('maintenance', array());
    }
    
    public function error_playing()
    {
        // set title
        $this->layout->set_title(lang('Error playing'));
        
        $this->parser->parse('error_playing', array());
    }
}
                
?>