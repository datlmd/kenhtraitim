<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Model
 * Function on Comment
 * 
 * @package PenguinFW
 * @subpackage Comment
 * @version 1.0.0
 */

class Comment extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        
        $this->db_table = 'comments';
    }
    
    /**
     * Add Comment
     * 
     * @param array $dataAll
     * @param boolean $check_field 
     */
    public function create($dataAll, $check_field = FALSE)
    {
        $dataAll['username'] = $this->session->userdata('user_username');
        
        return parent::create($dataAll, $check_field);
    }
    
    public function add_comment($dataAll, $check_field = FALSE) {
    	$is_success = parent::create($dataAll, $check_field);
    	
    	if ($is_success) {
    		return $is_success;
    	}
    	
    	return FALSE;
    }
    
    /**
    * add count
    * @author TungCN
    *
    * @param int $resource_id
    * @param int $record_id
    * @param int $type_id
    * @param string $field_update_count
    * @param string $add_subtract
    * 		with 2 values: add -- subtract
    * @return boolean
    */
    public function addOrSubtractCommentCount($resource_id, $record_id, $field_update_count, $add_subtract)
    {
    	if ($field_update_count)
    	{
    		$resource = $this->find('first', array(
    		                'select' => 'm.name',
    		                'from' => 'module_resources m',
    		                'where' => array(
    		                    'm.id' => $resource_id
    		)
    		));
    		
    		if (!$resource)
    		{
    			return FALSE;
    		}
    		
    		if ($add_subtract == 'subtract') {
    			$this->db->query(
    					sprintf("UPDATE %s SET %s = %s - %d WHERE id = %d",
    						$resource->name, $field_update_count, $field_update_count, 1, $record_id
    				));
    		}
    		else {
    			$this->db->query(
    					sprintf("UPDATE %s SET %s = %s + %d WHERE id = %d",
    						$resource->name, $field_update_count, $field_update_count, 1, $record_id
    				));
    		}
    		
    		
    		return TRUE;
    	}
    
    	return FALSE;
    }
}

?>