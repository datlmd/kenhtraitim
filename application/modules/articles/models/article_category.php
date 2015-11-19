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

class Article_category extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        
        $this->db_table = 'article_categories';
    }
    
    /**
     * 
     * get Tree category
     * @param array $where
     * @return array
     */
    /**
    * Parse all the categories to array, following the structure:
    * 	[0] => Parent_Category_1 => Array ( [0] => Child_Category ,
    * 									 	[1] => Child_Category ,
    * 										...
    * 								)
    * 	[1] => Parent_Category_2 => Array ( [0] => Child_Category ,
    * 									 	[1] => Child_Category ,
    * 										...
    * 								)
    *  @return array
    */
    function getTreeArticlesCategories($where = array()) {
    	
    	if ( ! isset($where['is_delete'])) {
    		$where['is_delete'] = 0;
    	}
    	
    	$categories = $this->find('all', array(
						    			'where' => $where,
						    			'order' => array('parent_id' => 'asc', 'weight' => 'asc', 'name' => 'asc'),
		   	));
    	
    	if (count($categories) == 0) {
    		return NULL;
    	}
    	
    	$cont = TRUE;
    	$result = array();
    	$first_parent_id = $categories[0]['parent_id'];
    	while ($cont) {
    		$cont = FALSE;
    		
    		foreach ($categories as &$category) {
    			if ( ! isset($category['checked']) || ! $category['checked']) {
	    			if ($category['parent_id'] == $first_parent_id) {
	    				$result['items'][] = $category;
	    				$category['checked'] = TRUE;
	    				$cont = TRUE;
	    			}
	    			else {
	    				$x = $this->_searchCategory($result, $category);
	    				if ($x) {   
	    					$category['checked'] = TRUE;
	    					$cont = TRUE;
	    				}
	    			}
	    		}
    		}
    	}
    	
    	return $result;
    }
    
    private function _searchCategory(&$arr, $c) {
    	if (isset($arr['id']) && $arr['id'] == $c['parent_id']) {
    		if ( ! isset($arr['items'])) {
    			$arr['items'] = array();
    		}
    		$arr['items'][] = $c;
    		return TRUE;
    	}
    	 
    	if (!isset($arr['items'])) {
    		return NULL;
    	}
    	 
    	foreach ($arr['items'] as &$item) {
    		$x = $this->_searchCategory($item,$c);
    
    		if ($x) {
    			return $x;
    		}
    	}
    }
    
    /**
     * 
     * get all categories (active) by parent id
     * 
     * @param integer $parent_id
     * @return array
     */
    public function get_categories_by_parent_id($parent_id) {
    	$categories = $this->find('all', array(
    			'select' => '*',
    			'where' => array(
    				'parent_id' => $parent_id,
    				'category_status_id' => 1,
    				'is_delete' => 0,
    			),
    			'order' => array('weight' => 'asc'),
    		));
    	
    	return $categories;
    }
    
    public function get_avaiable_category($category_id) {
    	$category = $this->get_array(
    			'*', 
    			array(
    				'id' => $category_id,
    				'category_status_id' => 1,
    				'is_delete' => 0,
    			)
    		);
    	
    	return $category;
    }
}

?>