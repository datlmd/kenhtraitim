<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * Model
 * Custom Field
 * 
 * @author      hungtd <tdhungit@gmail.com> 0972014011
 * @copyright   Tran Dinh Hung 2011
 * @package     PenguinFW
 * @subpackage  CustomField
 * @version     1.0.0
 */

class Custom_field extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        
        $this->db_table = 'custom_fields';
    }        
    
    /**
     * get Custom field from custom field name
     * 
     * @param int $cfn_id
     * @return false || array
     */
    public function getCustomField($cfn_id)
    {
        $this->db->select('custom_fields.*, module_fields.name as name');
        $this->db->from('custom_fields');
        $this->db->join('module_fields', 'custom_fields.field_id = module_fields.id');
        $this->db->where(array('custom_fields.name_id' => $cfn_id));
        $cf_query = $this->db->get();
        
        if ($cf_query->num_rows() == 0)
        {
            return false;
        }
        
        return $cf_query->result_array();
    }
    
    /**
     * get all fields of resource
     * 
     * @param type $resource_id
     * @return array
     */
    public function getModuleField($resource_id)
    {
        $this->db->order_by('weight', 'asc');
        $module_field_query = $this->db->get_where('module_fields', array('resource_id' => $resource_id));
       
        if ($module_field_query->num_rows() == 0)
        {
            return FALSE;
        }
        
        return $module_field_query->result_array();
    }
}

?>
