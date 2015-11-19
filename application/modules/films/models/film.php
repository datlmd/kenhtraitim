<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN_LITE FrameWork
 * @author hoanhk
 * @copyright Huynh Kim Hoan 2013
 * 
 * Model
 * Function on Film
 * 
 * @package Penguin_liteFW
 * @subpackage films
 * @version 2.0.0
 */

class Film extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        
        $this->db_table = 'films';
    }
    
/**
     * Create 
     */
    public function create($dataAll, $check_field = FALSE)
    {
        // get slug
        if (isset($dataAll['slug']) && $dataAll['slug'])
        {
            $dataAll['slug'] = make_slug($dataAll['slug']);
        } else 
        {
            $dataAll['slug'] = strtolower(make_slug($dataAll['name'] . ' ' . $dataAll['name_en']));
        }
        $dataAll['link_download'] = str_replace('http://taiphimhd.net/rd.php?url=','',$dataAll['link_download']);
        parent::create($dataAll, $check_field);
    }
    
    /**
     * Update 
     */
    public function update($dataAll, $where, $check_field = FALSE)
    {
        // get slug
        if (isset($dataAll['slug']) && $dataAll['slug'])
        {
            $dataAll['slug'] = make_slug($dataAll['slug']);
        } else 
        {
            $dataAll['slug'] = strtolower(make_slug($dataAll['name'] . ' ' . $dataAll['name_en']));
        }
        
        parent::update($dataAll, $where, $check_field);
    }
    
	public function update_counter($id,$counter_view) {
		if($counter_view == null || $counter_view == '')
			$this->db->set('counter_view', '1', FALSE);
		else
   			$this->db->set('counter_view', 'counter_view  + 1', FALSE);
   		//$this->db->set('modified', date('Y-m-d H:i:s'));
   		$this->db->where('id', $id);
   		$this->db->update($this->db_table);
   	}
}

?>