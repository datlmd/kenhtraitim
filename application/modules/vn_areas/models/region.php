<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Model
 * Function on Region
 * 
 * @package PenguinFW
 * @subpackage vn_areas
 * @version 1.0.0
 */
class Region extends MY_Model {

    function __construct() {
        parent::__construct();

        $this->db_table = 'regions';
    }

    /**
     * @author Dung Doan <dungdv3@vng.com.vn>
     * Created date: 04/10/2013
     * @since version penguin_lite
     * @return array list of region
     */
    public function get_all_region() {
        $region_option = array(
            'order' => array(
                'name' => 'asc'
            )
        );
        return $this->find('all', $region_option);
    }

}