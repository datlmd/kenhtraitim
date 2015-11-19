<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Categories
 * ...
 * 
 * @package PenguinFW
 * @subpackage Article
 * @version 1.0.0
 */
 
class Categories extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Article';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('articles', lang_web());
            
        $this->load->model('Article');
    }
}
                
?>