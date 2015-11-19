<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 *
 * Controller Frontend
 * ...
 *
 * @package PenguinFW
 * @subpackage Frontend
 * @version 1.0.0
 *
 * @property Article_category       $Article_category
 */
class Common_function extends MY_Controller {

    function __construct() {

        parent::__construct();
    }

    public function upload_photo(){
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
}

?>