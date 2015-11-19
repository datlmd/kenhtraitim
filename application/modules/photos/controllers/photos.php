<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Photos
 * ...
 * 
 * @package PenguinFW
 * @subpackage Photo
 * @version 1.0.0
 * 
 * @property Photo $Photo
 */
 
class Photos extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Photo';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('photos', lang_web());
            
        $this->load->model('Photo');
    }
    
    public function index() {
    	
    }
    
    public function photo_upload() {
    	// set layout
    	 
    	$user_info = (isset($_SESSION['user'])) ? $_SESSION['user'] : FALSE;
    
    	if ( !$user_info) {
    		$this->session->set_flashdata('error_message', lang('Please login to upload your entry.'));
    		redirect_to('photos', '', 'index');
    		exit();
    	}
    	 
    	if ( !$this->_checkCaptcha()) {
    		$this->session->set_flashdata('error_message', lang('Captcha is not match'));
    		redirect_to('photos', '', 'index');
    		exit();
    	}
    
    	$image_allow_type = 'jpg|JPG|jpeg|JPEG|png|PNG';
    	$image_max_size = 2048;
    	// upload
    	$upload = upload_file('inputFile', 'images/photos', $image_allow_type, $image_max_size);
    
    	if ($upload['error'] == 1) {
    		$this->session->set_flashdata('error_message', $upload['message']);
    		redirect_to('photos', '', 'index');
    		exit();
    	}
    	else {
    		$file = $upload['file'];
    
    		//create_thumb($file['full_path'], config_item('photos_avatar_resize_width'), config_item('photos_avatar_resize_height'));
    		create_thumb($file['full_path'], 140, 5000);
    		// medium image
    		create_thumb($file['full_path'], 585, 5000, '_medium_thumb');
    
    		$insert_data = array(
        			'photo_status_id' => 0,
        			'photo_category_id' => 2,
        			'photo_album_id' => 2,
        			'name' => $user_info['username'] . '_' . $file['file_name'],
        			'image_name' => $upload['sort_link'],
        			'username' => $user_info['username'],
    		);
    
    		$this->Photo->create($insert_data, TRUE);
    
    		//echo '##SUCCESS##'. $upload['sort_link'];
    
    		$this->session->set_flashdata('success_message', lang('Chuc mung ban da upload thanh cong, BTC se duyet bai trong thoi gian som nhat.'));
    		redirect_to('photos', '', 'index');
    		exit();
    	}
    }
    
    /**
    * check captcha
    */
    private function _checkCaptcha() {
    	$this->load->helper('strhash');
    	// get captcha
    	$captcha = $this->input->post('captcha');
    	$captcha = strtoupper($captcha);
    
    	// check captcha and session
    	if ($captcha && $captcha == string_hash($this->session->userdata('captcha'), FALSE)) {
    		return TRUE;
    	}
    
    	return FALSE;
    }
}
                
?>