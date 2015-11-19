<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 *
 * Controller Wards
 * ...
 *
 * @package PenguinFW
 * @subpackage vn_areas
 * @version 1.0.0
 */
class Wards extends MY_Controller {

    function __construct() {
        parent::__construct();

        $this->model_name = 'Ward';

        $this->lang->load('generate', lang_web());
        $this->lang->load('vn_areas', lang_web());

        $this->load->model('Ward');
    }

    /**
     * @author Dung Doan <dungdv3@vng.com.vn>
     * Created date: 04/10/2013
     * @since version penguin_lite
     * This is function for ajax call
     * @param type $id_district id of distric want to get ward
     * @return It will return a json string which is contain data of all wards in district
     */
    public function ajax_get_ward($id_district) {
        $this->layout->set_layout('empty');
        header("Content-Type: text/html; charset=utf-8");
        $json_ward = json_encode($this->Ward->get_ward_by_district($id_district));
        echo($json_ward);
    }

}