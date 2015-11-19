<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Model
 * Function on Music_category
 * 
 * @package PenguinFW
 * @subpackage Music
 * @version 1.0.0
 */

class Music_category extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        
        $this->db_table = 'music_categories';
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
            $dataAll['slug'] = make_slug($dataAll['name']);
        }
        
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
            $dataAll['slug'] = make_slug($dataAll['name']);
        }
        
        parent::update($dataAll, $where, $check_field);
    }
    
    /**
     * get Category 
     * 
     * @param string $category category id,
     * @return array
     */
    public function getCategory($category)
    {
        $category_ids = explode(',', $category);
        
        return $this->find('all', array(
            'select' => 'name',
            'where_in' => array(
                'id' => $category_ids
            )
        ));
    }
    
    /**
     * get String category
     * 
     * @param string $category category id,
     * @return string category name
     */
    public function getStringCategory($category)
    {
        $categories = $this->getCategory($category);
        
        $string_category = '';
        
        if ($categories)
        {
            foreach ($categories as $cate)
            {                
                $string_category .= $cate['name'] . ',';             
            }
        }
        
        if ($string_category)
        {
            return substr($string_category, 0, -1);
        }
        
        return FALSE;
    }
    
    /**
     * get all category
     * 
     * @return array
     */
    public function getAll()
    {
        return $this->find('all', array(
            'select' => 'id,name',
            'from' => 'music_categories',
            'limit' => 0,
            'order' => array('weight' => 'asc')
        ));
    }
    
/**
     * get Category 
     * 
     * @param string $category category id,
     * @return array
     */
    public function getCategoryParent_id($category)
    {        
        return $this->find('all', array(
            'select' => '*',
            'where_in' => array(
                'parent_id' => $category
            ),
            'order' => array('weight' => 'asc')
        ));
    }
    
}

?>