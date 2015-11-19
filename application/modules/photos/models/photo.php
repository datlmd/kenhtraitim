<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Model
 * Function on Photo
 * 
 * @package PenguinFW
 * @subpackage Photo
 * @version 1.0.0
 */

class Photo extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        
        $this->db_table = 'photos';
    }
    
    /**
     * 
     * list avaialbe photos
     * 
     * @param int $category_id
     * @param int $album_id
     * @param datetime $from_date
     * @param datetime $to_date
     * @param int $count
     * @param int $offset
     * @return boolean|array
     */
    public function list_avaiable_photos($category_id, $album_id, $from_date, $to_date, $count = 20, $offset = 0) {
    	
    	return $this->find('all', array(
    		'select' => '*',
    		'where' => array(
    			'photo_status_id' => 1,
    			'is_delete' => 0,
    			'photo_category_id' => $category_id,
    			'photo_album_id' => $album_id,
    			'created >=' => $from_date,
    			'created <=' => $to_date, 
    		),
    		'limit' => $count,
    	    'offset' => $offset
    	));
    }
}

?>