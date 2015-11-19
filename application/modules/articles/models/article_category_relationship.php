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

class Article_category_relationship extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        
        $this->db_table = 'article_category_relationships';
    }
    
    /**
     * 
     * insert more record at the time
     * @param integer $article_id article ID
     * @param array $category_ids List category ID
     * @return boolean
     */
    function insertArticleCategoryRelationship($article_id, $category_ids) {
    	// Init
    	$data = array();
    	
    	foreach ($category_ids as $category_id) {
    		$data[] = array(
    					'article_id' => $article_id,
    					'article_category_id' => $category_id,
    			);
    	}
    	
    	if ($this->db->insert_batch($this->db_table, $data)) {
    		return TRUE;
    	}
    	
    	return FALSE;
    }
}

?>