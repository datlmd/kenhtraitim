<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Music_albums
 * ...
 * 
 * @package PenguinFW
 * @subpackage Music
 * @version 1.0.0
 */
 
class Music_albums extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Music_album';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('musics', lang_web());
            
        $this->load->model('Music_album');
    }
}
                
?>