<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Districts
 * ...
 * 
 * @package PenguinFW
 * @subpackage vn_areas
 * @version 1.0.0
 */
class Districts extends MY_Controller {

    function __construct() {
        parent::__construct();

        $this->model_name = 'District';

        $this->lang->load('generate', lang_web());
        $this->lang->load('vn_areas', lang_web());

        $this->load->model('District');
    }

    /**
     * @author Dung Doan <dungdv3@vng.com.vn>
     * Created date: 04/10/2013
     * @since version penguin_lite
     * This is function for ajax call
     * @param type $id_region id of region want to get districts
     * @return It will return a json string which is contain data of districts in a region
     */
    public function ajax_get_district($id_region) {
        $this->layout->set_layout('empty');
        header("Content-Type: text/html; charset=utf-8");
        $district_json = json_encode($this->District->get_district_by_region($id_region));
        echo $district_json;
    }

}