<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Model
 * Function on Province
 * 
 * @package PenguinFW
 * @subpackage address
 * @version 1.0.0
 */

class Province extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        
        $this->db_table = 'regions';
    }
	
	function get_of_district($district_id)
    {
        $this->load->model('Campaigns/District');
        
        $district = $this->District->find('first_array', array('where' => array('id' => $district_id)));
        
        $region = $this->Province->find('first_array', array('where' => array('id' => $district['region_id'])));
        
        return $region;
    }
}

?>