<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_upload
 * ...
 * 
 * @package PenguinFW
 * @subpackage Music
 * @version 1.0.0
 */
 
class Admin_upload extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Film';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('films', lang_web());
            
        $this->load->model('Film');
    }
    
    /**
     * Add Avatar 
     */
    public function avatar()
    {
        // set permission
        if (!$this->isACL('w'))
        {
            echo lang('You can not access allow');
            exit();
        }
        
        // set layout
        $this->layout->set_layout('empty');
        
        // upload
        $upload = upload_file('file_name_avatar', 'images', config_item('musics_image_type'), config_item('musics_image_size'));
        
        if ($upload['error'] == 1)
        {            
            echo $upload['message'];
            exit();
        } else
        {            
            $file = $upload['file'];
            
            create_thumb($file['full_path']);
            
            echo '##SUCCESS##'. $upload['sort_link'];
            exit();
        }
    }
    
}
                
?>