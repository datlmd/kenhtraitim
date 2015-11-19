<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * Model
 * Function on table: custom_field_names
 * 
 * @author      hungtd <tdhungit@gmail.com> 0972014011
 * @copyright   Tran Dinh Hung 2011
 * @package     PenguinFW
 * @subpackage  Custom Field
 * @version     1.0.0
 * 
 * @property Custom_field $Custom_field
 */

class Custom_field_name extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        
        $this->db_table = 'custom_field_names';
    }
     
    /**
     * Delete custom field
     * 
     * @param array $cfn_ids array contain ID custom field name
     * @return boolean
     */
    public function deleteCustomField($cfn_ids)
    {
        // check array custom field name ID
        if (empty ($cfn_ids))
        {
            return FALSE;
        }
        
        // delete custom field name from custom field name ID and custom field
        $this->load->model('Custom_field');
        foreach ($cfn_ids as $cfn_id)
        {
            // delete custom field recoed
            $this->Custom_field->deleteRecord(array('name_id' => $cfn_id));
            // delete custom field name
            $this->deleteRecord(array('id' => $cfn_id));            
        }
        
        return TRUE;
    }
}

?>
