<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Model
 * Function on Ward
 * 
 * @package PenguinFW
 * @subpackage vn_areas
 * @version 1.0.0
 */
class Ward extends MY_Model {

    function __construct() {
        parent::__construct();

        $this->db_table = 'wards';
    }

    /**
     * @author Dung Doan <dungdv3@vng.com.vn>
     * Created date: 04/10/2013
     * @since version penguin_lite
     * @param string $id_district id of district want to get ward
     * @return array contain list wards
     */
    public function get_ward_by_district($id_district) {
        $ward_option = array(
            'where' => array(
                'district_id' => $id_district
            )
        );
        return $this->find('all', $ward_option);
    }

}

?>