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
 */
class Basic_view_demo extends MY_Controller {

    function __construct() {
        parent::__construct();
    }

    /**
     * demo list ko paging
     */
    public function demo_list() {
        $this->layout->disable_layout();
        $this->load->model('photos/Photo');
        $list_views = $this->Photo->find('all', array(
            'select' => 'photos.id, photos.name, photos.image_name, photos.created',
            'where' => array(
                'photo_status_id' => 1
            ),
            'limit' => 15
        ));

        $data = array(
            'list_views' => $list_views,
            'detail_common_link' => base_url().'frontend/demo/'
        );
        $this->parser->parse('/basic_view_demo/demo_list', $data);
    }

    /**
     * demo list có paging, dùng ajax load list_view_paging
     */
    public function demo_list_paging(){
        $this->layout->disable_layout();
        $this->parser->parse('/basic_view_demo/demo_list_paging', null);
    }

    /**
     * list load paging dùng cho ajax
     */
    public function list_view_paging() {
        $this->layout->disable_layout();
        $page = 1;
        $page_size = 1;
        if(!empty($_GET['page']))
            $page = (int)$_GET['page'];
        if(!empty($_GET['page_size']))
            $page_size = (int)$_GET['page_size'];

        $this->load->model('photos/Photo');
        $get_list_jpaging = $this->Photo->list_view_using_jpaging($page, $page_size, 'frontend','demo', array(
            'select' => 'photos.id, photos.name, photos.image_name, photos.created',
            'where' => array(
                'photo_status_id' => 1
            )
        ));

        $list_views = $get_list_jpaging['list_views'];
        $total_page_button =  $get_list_jpaging['total_page_button'];
        $current_page = $get_list_jpaging['current_page'];
        $detail_common_link = $get_list_jpaging['detail_common_link'];

        $data = array(
            'list_views' => $list_views,
            'total_page_button' => $total_page_button,
            'current_page' => $current_page,
            'detail_common_link' => $detail_common_link
        );

        $this->parser->parse('/basic_view_demo/list_view_paging', $data);
    }

    /**
     * demo Encrypt và Decrypt
     */
    function demo_encrypt()    {
        $this->layout->disable_layout();
        $this->load->library("Encryption");

        $tmp = "Kiểm tra function encrypt";
        $a = $this->encryption->encode($tmp);
        $b = $this->encryption->decode($a);
        $data = array(
            'text' => $tmp,
            'encrypt' =>  $a,
            'decrypt' => $b
        );
        $this->parser->parse('/basic_view_demo/demo_encrypt', $data);
    }

    function  demo_upload_photo(){
        $this->parser->parse('/basic_view_demo/demo_upload_photo', null);
    }
}

?>