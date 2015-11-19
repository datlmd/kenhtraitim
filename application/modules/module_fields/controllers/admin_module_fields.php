<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_module_fields
 * ...
 * 
 * @package PenguinFW
 * @subpackage module_fields
 * @version 1.0.0
 * 
 * @property Module_field           $Module_field
 */
 
class Admin_module_fields extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Module_field';
        
        $this->layout->set_layout('admin');
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('module_fields', lang_web());
            
        $this->load->model('Module_field');
    }
    
    /**
     * List
     *
     * @params int $resource_id
     */
    public function index($resource_id = 0)
    {
        // check permission
        $this->PG_ACL('r');
        
        // set title
        $this->layout->set_title(lang('Module field manager'));
        
        // get resource id
        $resource_id = ($this->input->post('resource_id')) ? $this->input->post('resource_id') : $resource_id;
        
        // get module
        $admin_module_fields = $this->Module_field->get(array('resource_id' => $resource_id), 'weight asc', FALSE, 0);
        
        if (!$admin_module_fields)
        {
            $this->load->model('modules/Module_resource');
            $resource = $this->Module_resource->get(array('id' => $resource_id));
            if (!$resource)
            {
                show_error(lang('Error params'));
            } else 
            {
                redirect("module_fields/admin_module_fields/index/$resource->main_id");
            }
        }
        
        // update weight
        if ($this->input->post())
        {
            $weights = $this->input->post('weight');            
            foreach ($weights as $field_id => $weight)
            {
                $this->Module_field->update(array('weight' => $weight), array('id' => $field_id));
            }
            
            redirect("module_fields/admin_module_fields/index/$resource_id");
        }           
                
        $data = array(
            'list_views' => $admin_module_fields,
            'resource_id' => $resource_id,
            'resource_name' => $this->getResourceName($resource_id)
        );
        
        $this->parser->parse($this->router->class . '/index', $data);
    }                    
                
    /**
     * Add data    
     * 
     * @param int $resource_id
     */
    public function add($resource_id = 0)
    {   
        // check permission
        $this->PG_ACL('w');
        
        // set title
        $this->layout->set_title(lang('Add Module field'));
        
        // get resource id
        $resource_id = ($this->input->post('resource_id')) ? $this->input->post('resource_id') : $resource_id;
        
        // get resource
        $this->load->model('modules/Module_resource');
        $resource = $this->Module_resource->get(array('id' => $resource_id, 'main_id' => 0));
        if (!$resource)
        {
            show_error(lang('Error params'));
        }
                
        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        // form validate
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('field_type', 'Field type', 'required');
                
        // get post and check rule
        if ($this->input->post() && $this->form_validation->run() == TRUE)
        {
            // save data
            if ($this->Module_field->create($this->input->post(), TRUE))
            {
                $this->session->set_flashdata('success_message', lang('Success'));
            } else 
            {
                $this->session->set_flashdata('error_message', lang('Error'));
            }
            
            // redirect
            redirect("module_fields/admin_module_fields/$resource_id");
        }
                
        $data = array(
            'resource_id' => $resource_id,
            'resource_name' => $resource->name
        );
                
        // parser
        $this->parser->parse($this->router->class . '/add', $data);
    }
                
    /**
     * Edit data
     *
     * @params int $id
     */
    public function edit($id = 0)
    {
        // check permission
        $this->PG_ACL('e');
        
        // set title
        $this->layout->set_title(lang('Edit Module field'));
                
        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        // form validate
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('field_type', 'Field type', 'required');
        
        // get id
        $id = ($this->input->post('id')) ? $this->input->post('id') : $id;
        
        // get module field
        $admin_module_fields = $this->Module_field->get(array('id' => $id));
        
        if (!$admin_module_fields)
        {
            show_error(lang('Error params'));
        }
        
        // get post and check rule
        if ($this->input->post() && $this->form_validation->run() == TRUE)
        {
            // save data
            if ($this->Module_field->update($this->input->post(), array('id' => $id), TRUE))
            {
                $this->session->set_flashdata('success_message', lang('Success'));
            } else 
            {
                $this->session->set_flashdata('error_message', lang('Error'));
            }
            
            // redirect
            redirect("module_fields/admin_module_fields/index/{$admin_module_fields->resource_id}");
        }                 
                
        // data to view
        $data = array(
            'data_edit' => $admin_module_fields,
            'resource_name' => $this->getResourceName($admin_module_fields->resource_id)
        );
                
        // parser
        $this->parser->parse($this->router->class . '/edit', $data);
    }
                
    /**
     * Delete
     */
    public function delete()
    {
        // check permission
        $this->PG_ACL('d');
        
        $this->deleteRecordOnListView();
    }
}
                
?>