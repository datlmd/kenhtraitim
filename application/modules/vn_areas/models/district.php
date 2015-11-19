<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Model
 * Function on District
 * 
 * @package PenguinFW
 * @subpackage vn_areas
 * @version 1.0.0
 */
class District extends MY_Model {

    function __construct() {
        parent::__construct();

        $this->db_table = 'districts';
    }

    /**
     * @author Dung Doan <dungdv3@vng.com.vn>
     * Created date: 04/10/2013
     * @since version penguin_lite
     * @param string $id_region id of region want to get districts
     * @return array contain list districts
     */
    public function get_district_by_region($id_region) {
        $district_option = array(
            'where' => array(
                'region_id' => $id_region
            )
        );
        return $this->find('all', $district_option);
    }

}