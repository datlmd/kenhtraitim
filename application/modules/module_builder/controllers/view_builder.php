<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * Add View Page with Smarty
 * 
 * @author      hungtd <tdhungit@gmail.com> 0972014011
 * @copyright   Tran Dinh Hung 2011
 * @package     PenguinFW
 * @subpackage  ModuleBuilder
 * @version     1.0.0
 * 
 * @property Xml $xml
 * @property M_builder  $M_builder
 */

class View_builder extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->layout->set_layout('admin');
    }
    
    public function index()
    {
        if (!is_admin())
        {
            redirect('users/admin_users/permission');
        }
        
        $this->load->helper('form');
        $this->load->library('form_validation');        
        
        $this->form_validation->set_rules('resource', 'Resource', 'required');
		$this->form_validation->set_rules('view_name', 'Template name', 'required');
        
        if ($this->input->post() && $this->form_validation->run() == TRUE)
        {
            //process
            // get library
            $this->load->library('xml');
            $this->load->helper('file');
            $this->load->model('M_builder');
            
            // get data from post
            $resource_name      = strtolower($this->input->post('resource'));
            $main_resource_name = strtolower($this->input->post('main_resource'));
            $template_name      = strtolower($this->input->post('view_name'));
            $form_link          = strtolower($this->input->post('form_link'));
            $is_search_form     = $this->input->post('is_search_form');
            $field_search       = strtolower($this->input->post('field_search'));
            $template_view      = strtolower($this->input->post('template_view'));
            
            // get resource
            $this->db->select('module_resources.id, module_resources.module_id, modules.name as module_name');
            $this->db->from('module_resources');
            $this->db->join('modules', 'modules.id = module_resources.module_id');
            $this->db->where(array('module_resources.name' => $resource_name));
            $resource_query = $this->db->get();
            
            if ($resource_query->num_rows() == 0)
            {
                show_error('Resource not exit.');
            }
            
            // get result obj
            $resource_obj = $resource_query->row();
            
            // get table resource id
            if ($main_resource_name)
            {
                $this->db->select('id');
                $main_resource_query = $this->db->get_where('module_resources', array('name' => $main_resource_name));

                if ($main_resource_query->num_rows() == 0)
                {
                    show_error('Main resource not exit.');
                }

                $table_resource_id = $main_resource_query->row()->id;
            } else 
            {
                $table_resource_id = $resource_obj->id;
            }
            
            // get module resource fields              
            $this->db->select('id, name, field_type');
            $this->db->from('module_fields');
            $this->db->order_by('weight asc');
            $this->db->where(array('resource_id' => $table_resource_id));
            $module_fields_query = $this->db->get();
            
            if ($module_fields_query->num_rows() == 0)
            {
                show_error('Main resource not exit.');
            }
            
            $module_fields = $module_fields_query->result_array();
      
            if ($template_view == 'index')
            {
                $this->M_builder->writeIndex($resource_obj->module_name, $resource_name, $is_search_form, $field_search, $form_link, $template_name);
            } else if ($template_view == 'add') // // if template view == index
            { // template == add
                $this->M_builder->writeAdd($resource_obj->module_name, $resource_name, $module_fields, $template_name);
            } else if ($template_view == 'edit') // // template_view = add
            { // template_view = edit
                $this->M_builder->writeEdit($resource_obj->module_name, $resource_name, $module_fields, $template_name);
            } else if ($template_view == 'view') // // template_view = edit
            { // if template view is 'view'
                $this->M_builder->writeView($resource_obj->module_name, $resource_name, $module_fields, $template_name);
            }
        } // // process post
        
        $data = array(
            
        );
        
        $this->load->view('view_builder.php', $data);
    }            
}

?>
