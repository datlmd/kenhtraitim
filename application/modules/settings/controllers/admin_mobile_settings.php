<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author dungdv3
 * create 13/12/2013
 * Edit setting to change CSS of mobile version
 */
class Admin_mobile_settings extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->layout->set_layout('admin');

        $this->lang->load('generate', lang_web());
    }

    public function index() {
        if (isset($_POST['code'])) {
            file_put_contents('static/default/mobile/css/wrapper.css', $_POST['code']);
            
            $this->session->set_flashdata('success_message', lang('Edit setting success'));
            
            redirect('settings/admin_mobile_settings');
        }

        // set title
        $this->layout->set_title(lang('Admin mobile settings'));

        $content_file = file_get_contents('static/default/mobile/css/wrapper.css');

        $data['content_css'] = $content_file;

        $this->parser->parse($this->router->class . '/index', $data);
    }

}
