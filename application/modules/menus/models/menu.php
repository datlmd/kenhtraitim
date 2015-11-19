<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Model
 * Menu
 * 
 * @package PenguinFW
 * @subpackage Menu
 * @version 1.0.0
 */

class Menu extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        
        $this->db_table = 'menus';
    }

    /**
     * Create menu
     * 
     * @param type $data_menus 
     * @return int id
     */
    public function create($data_menus)
    {
       if (empty ($data_menus)) return FALSE;
       
       if (!$data_menus['name'] || !$data_menus['link']) return FALSE;
       
       $this->load->helper('date');
       
       $data_menus['created'] = mdate('%Y-%m-%d %H:%i:%s', now());
       $data_menus['modified'] = mdate('%Y-%m-%d %H:%i:%s', now());
       $data_menus['user_id'] = $this->session->userdata('user_id');
       
       $this->db->insert('menus', $data_menus);
       
       return $this->db->insert_id();
    }
}

?>
