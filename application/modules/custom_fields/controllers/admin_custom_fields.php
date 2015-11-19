<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * Controller
 * Xử lý phần admin chỉnh sửa custom field
 * 
 * @author      hungtd <tdhungit@gmail.com> 0972014011
 * @copyright   Tran Dinh Hung 2011
 * @package     PenguinFW
 * @subpackage  Custom Field
 * @version     1.0.0
 * 
 * @property Custom_field $Custom_field
 * @property Custom_field_name $Custom_field_name
 */

class Admin_custom_fields extends MY_Controller
{
    function __construct() 
    {
        parent::__construct();
        $this->layout->set_layout('admin');
        
        $this->model_name = 'Custom_field';
        
        $this->lang->load('generate', lang_web());
        $this->lang->load('custom_fields', lang_web());
        
        $this->load->model('Custom_field');
    }        
    
    /**
     * Add custom field on resource
     * 
     * @param   $string module resource name
     */
    public function add($resource = null)
    {
        $this->PG_ACL('w');
        
        if ($this->input->post('resource')) 
        {
            $resource = $this->input->post('resource');
        }
        
        if (!$resource) 
        {
            show_error(lang('Error params'));
        }
        
        if ($this->input->post())
        {        
            // process post data
            $p_name = $this->input->post('name');
            $p_module_id = $this->input->post('module_id');
            $p_fields = $this->input->post('field_choose');

            if ($p_module_id && $p_fields) {
                $this->load->model('Custom_field_name');        
                $name_id = $this->Custom_field_name->create(array('name' => $p_name, 'resource_id' => $p_module_id));

                if ($name_id > 0) {
                    foreach ($p_fields as $field_id) {
                        $this->Custom_field->create(array('name_id' => $name_id, 'field_id' => $field_id));
                    }
                }
                
                $this->session->set_flashdata('success_message', lang('Add custom field name success'));
                redirect("custom_fields/admin_custom_field_names/index/$resource");
            } else 
            {
                $this->session->set_flashdata('error_message', lang('Error params'));
                redirect('custom_fields/admin_custom_fields/add/' . $resource);
            }
        }
        
        $resource_id = $this->getResourceID($resource, FALSE);
        $module_id = $this->getModuleID();
                
        $module_fields = $this->Custom_field->getModuleField($resource_id);
        
        $data = array(
            'module_fields' => $module_fields,
            'resource' => $resource,
            'module_id' => $module_id
        );
        
        $this->parser->parse('admin_custom_fields/add', $data);
    }
    
    /**
     * Edit custom field
     * 
     * @param int $cfn_id custom field name id
     */
    public function edit($cfn_id = 0)
    {
       $this->PG_ACL('e');
       
       // get custom field name ID
       $cfn_id = ($this->input->post('cfn_id')) ? $this->input->post('cfn_id') : $cfn_id;
       
       if ($cfn_id == 0 || !is_numeric($cfn_id))
       {
           $this->session->set_flashdata('error_message', lang('Error params'));
           
           redirect('users/dashboard');
       }
       
       // check data post form
       if ($this->input->post())
       {
           $resource_id = $this->input->post('resource_id');
           $resource_name = $this->getResourceName($resource_id);
           $module_name = $this->getModuleName($resource_name);
           
           $post_cfn = $this->input->post('cfn_name');
           $post_field_choose = $this->input->post('field_choose');
           
           if ($post_cfn || !empty ($post_field_choose))
           {
               // update name
               $this->load->model('Custom_field_name');
               $this->Custom_field_name->update(array('name' => $post_cfn), array('id' => $cfn_id));
               
               // delete custom field old
               $this->Custom_field->deleteRecord(array('name_id' => $cfn_id));
               
               // insert new field
               foreach ($post_field_choose as $p_field_id)
               {
                   $this->Custom_field->create(array('name_id' => $cfn_id, 'field_id' => $p_field_id));
               }
               
               $this->session->set_flashdata('success_message', lang('Edit custom field name success'));
               redirect("$module_name/admin_$resource_name");
           } else 
           {
                $this->session->set_flashdata('error_message', lang('Error params'));                
                redirect('custom_fields/admin_custom_fields/edit/' . $cfn_id);
           }
       }
       
       // load model custom field name
       $this->load->model('Custom_field_name');
       
       // get / check custom field name on system
       $cfn_obj = $this->Custom_field_name->get_select('id, name, resource_id', array('id' => $cfn_id));
       
       if (!$cfn_obj)
       {
           show_error(lang('Error params'));
       }
       
       // get module field
       $module_fields = $this->Custom_field->getModuleField($cfn_obj->resource_id);
       
       // get custom fields
       // @pro
       $this->load->model('Custom_field');
       $custom_fields = $this->Custom_field->getCustomField($cfn_id);
       
       // set data
       $data = array(
           'cfn_id' => $cfn_id,
           'cfn_obj' => $cfn_obj,
           'module_fields' => $module_fields,
           'custom_fields' => $custom_fields
       );
       
       $this->parser->parse('admin_custom_fields/edit', $data);
    }
    
    /**
     * DELETE
     */
    public function delete()
    {
        // check permission
        $this->PG_ACL('d');
    }
	
	public function is_check($field, $fields){ 
        foreach($fields as $item){
            //var_dump($item['name']);die();
            if ($field == $item['name']){
                return true;
            }
        }
        return false;
    }
}

?>
