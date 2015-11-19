<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author tungcn <cntung2187@gmail.com> 0909898592
 * @copyright Chung Nhut Tung 2011
 * 
 * Model
 * Function on Article
 * 
 * @package PenguinFW
 * @subpackage Article
 * @version 1.0.0
 */

class Music_singer_category_relationship extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        
        $this->db_table = 'music_singer_category_relationships';
    }
    
    /**
     * 
     * insert more record at the time
     * @param integer $article_id article ID
     * @param array $category_ids List category ID
     * @return boolean
     */
    function insert_music_singer_category_relationship($record_id, $category_ids) {
    	// Init
    	$data = array();
    	
    	foreach ($category_ids as $category_id) {
    		$data[] = array(
    					'singer_id' => $record_id,
    					'singer_cate_id' => $category_id,
    			);
    	}
    	
    	if ($this->db->insert_batch($this->db_table, $data)) {
    		return TRUE;
    	}
    	
    	return FALSE;
    }
}

?>