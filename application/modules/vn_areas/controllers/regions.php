<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 *
 * Controller Regions
 * ...
 *
 * @package PenguinFW
 * @subpackage vn_areas
 * @version 1.0.0
 */
class Regions extends MY_Controller {

    function __construct() {
        parent::__construct();

        $this->model_name = 'Region';

        $this->lang->load('generate', lang_web());
        $this->lang->load('vn_areas', lang_web());

        $this->load->model('Region');
    }

    /*
     * @author Dung Doan <dungdv3@vng.com.vn>
     * Created date: 04/10/2013
     * @since version penguin_lite
     * This is function for ajax call
     * @return It will return a json string which is contain data of all regions
     */
    public function ajax_get_region() {
        $this->layout->set_layout('empty');
        header("Content-Type: text/html; charset=utf-8");
        $json_region = json_encode($this->model_name->get_all_region());
        echo($json_region);
    }

}

?>