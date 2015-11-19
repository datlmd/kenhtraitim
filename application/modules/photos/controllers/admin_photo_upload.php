<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author tungcn <cntung2187@gmail.com> 0909898592
 * @copyright Chung Nhut Tung 2011
 * 
 * Controller Admin_photo_upload
 * ...
 * 
 * @package PenguinFW
 * @subpackage Photo
 * @version 1.0.0
 */
 
class Admin_photo_upload extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Photo';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('photos', lang_web());
            
        $this->load->model('Photo');
    }
    
    /**
    * Add Avatar
    */
    public function avatar()
    {
    	// set permission
    	$this->PG_ACL('w');
    
    	// set layout
    	$this->layout->set_layout('empty');
    
    	// upload
    	$upload = upload_file('file_name_avatar', 'images', config_item('photos_image_type'), config_item('photos_image_size'));
    
    	if ($upload['error'] == 1)
    	{
    		echo $upload['message'];
    	} else
    	{
    		$file = $upload['file'];
    
    		create_thumb($file['full_path']);
    
    		echo '##SUCCESS##'. $upload['sort_link'];
    	}
    }
    
	public function avatar01()
    {
    	// set permission
    	$this->PG_ACL('w');
    
    	// set layout
    	$this->layout->set_layout('empty');
    
    	// upload
    	$upload = upload_file('file_name_avatar', 'images', config_item('photos_image_type'), config_item('photos_image_size'));
    
    	if ($upload['error'] == 1)
    	{
    		echo $upload['message'];
    	} else
    	{
    		$file = $upload['file'];
    		
    		$config = array(
    			'create_thumb' => FALSE,
	            'width' => 495,
    			'height' => 600,
	        );
	        resize_image($file['full_path'],$config);
    		//create_thumb($file['full_path']);
    
    		echo '##SUCCESS##'. $upload['sort_link'];
    	}
    }
}
                
?>