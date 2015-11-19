<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_module_relations
 * ...
 * 
 * @package PenguinFW
 * @subpackage modules
 * @version 1.0.0
 * 
 * @property Module             $Module
 * @property Module_resource    $Module_resource
 * @property Module_field       $Module_field
 * @property Module_relation    $Module_relation
 */
 
class Admin_module_relations extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Module_relation';
        
        $this->layout->set_layout('admin');
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('modules', lang_web());
            
        $this->load->model('Module_relation');
    }
    
    /**
     * List
     *
     * @params int $cfn_id
     */
    public function index($cfn_id = 0)
    {
        // check permission
        $this->PG_ACL('r');
        
        // set title
        $this->layout->set_title(lang('Module relation manager'));
        
        // get module
        $this->paginator = array(
            'select' => 'mr.*, r.name as module_id, rr.name as module_relation_id, mr.module_id as id_1, mr.module_relation_id as id_2',
            'from' => 'module_relations mr',
            'join' => array(
                'module_resources r' => 'mr.module_id = r.id',
                'module_resources rr' => 'mr.module_relation_id = rr.id'
            )
        );
        
        // filter
        // filter resource
        $resource = $this->input->get('resource');
        if ($resource)
        {
            $this->paginator['where']['r.name like'] = '%' . $resource . '%';
        }
        
        $admin_module_relations = $this->pagination(5);
                
        $data = array(
            'list_views' => $admin_module_relations,
            
            'this_resource' => $this->router->class,            
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'link_edit' => array(
                'Edit' => 'modules/admin_module_relations/edit/',
                'Delete' => 'modules/admin_module_relations/delete/'
            ),
            'list_params' => array('id_1', 'id_2'),
            'pagination_link' => $this->getPaginationLink('/modules/admin_module_relations/index/' . $cfn_id, 5)
        );
        
        $this->parser->parse($this->router->class . '/index', $data);
    }                    
                
    /**
     * Add data    
     */
    public function add()
    {   
        // check permission
        $this->PG_ACL('w');
        
        // set title
        $this->layout->set_title(lang('Add Module relation'));
                
        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');
        // lib
        $this->load->model('Module');
        
        // form validate
        $this->form_validation->set_rules('module_id', 'Module', 'required');
        $this->form_validation->set_rules('module_relation_id', 'Module relation', 'required');
        $this->form_validation->set_rules('primary_key', 'Primary key', 'required');
        $this->form_validation->set_rules('foreign_key', 'Foreign key', 'required');
                
        // get post and check rule
        if ($this->input->post() && $this->form_validation->run() == TRUE)
        {
            // save data
            if ($this->Module_relation->create($this->input->post(), TRUE))
            {
                $this->session->set_flashdata('success_message', lang('Success'));
            } else 
            {
                $this->session->set_flashdata('error_message', lang('Error'));
            }
            
            // redirect
            redirect('modules/admin_module_relations');
        }
        
        // get all module resource
        $this->load->model('Module_resource');
        $modules = $this->Module_resource->get(array('main_id' => 0), 'name asc', FALSE, 0);
        
        $data = array(
            'module_ids' => $modules,
            'module_relation_ids' => $modules
        );
                
        // parser
        $this->parser->parse($this->router->class . '/add', $data);
    }
                
    /**
     * Edit data
     *
     * @param int $module_id
     * @param int $module_relation_id
     */
    public function edit($module_id = 0, $module_relation_id = 0)
    {
        // check permission
        $this->PG_ACL('e');
        
        // set title
        $this->layout->set_title(lang('Edit Module relation'));
                
        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        // form validate
        $this->form_validation->set_rules('module_id', 'Module', 'required');
        $this->form_validation->set_rules('module_relation_id', 'Module relation', 'required');
        $this->form_validation->set_rules('primary_key', 'Primary key', 'required');
        $this->form_validation->set_rules('foreign_key', 'Foreign key', 'required');
        
        // get user_id
        $module_id = ($this->input->post('module_id')) ? $this->input->post('module_id') : $module_id;
        $module_relation_id = ($this->input->post('module_relation_id')) ? $this->input->post('module_relation_id') : $module_relation_id;
        
        // get post and check rule
        if ($this->input->post() && $this->form_validation->run() == TRUE)
        {
            // save data
            if ($this->Module_relation->update($this->input->post(), array('module_id' => $module_id, 'module_relation_id' => $module_relation_id), TRUE))
            {
                $this->session->set_flashdata('success_message', lang('Success'));
            } else 
            {
                $this->session->set_flashdata('error_message', lang('Error'));
            }
            
            // redirect
            redirect('modules/admin_module_relations');
        }                        
        
        // get user
        $admin_module_relations = $this->Module_relation->get(array('module_id' => $module_id, 'module_relation_id' => $module_relation_id));

        // get all module resource
        $this->load->model('Module_resource');
        $modules = $this->Module_resource->get(array('main_id' => 0), 'name asc', FALSE, 0);                
        
        // load module field
        $this->load->model('module_fields/Module_field');        

        // data to view
        $data = array(
            'data_edit' => $admin_module_relations,
            'module_ids' => $modules,
            'module_relation_ids' => $modules,
            'fk_list_colums' => $this->Module_field->get(array('resource_id' => $module_id), 'weight asc', FALSE),
            'pk_list_colums' => $this->Module_field->get(array('resource_id' => $module_relation_id), 'weight asc', FALSE)
        );
                
        // parser
        $this->parser->parse($this->router->class . '/edit', $data);
    }
                
    /**
     * Delete
     */
    public function delete($module_id = 0, $module_relation_id = 0)
    {
        // check permission
        $this->PG_ACL('d');
        
        $this->Module_relation->deleteRecord(array('module_id' => $module_id, 'module_relation_id' => $module_relation_id));
        
        // redirect
        redirect('modules/admin_module_relations');
    }
    
    /**
     * get data field in db
     */
    public function data_field($resource_id)
    {
        $this->layout->set_layout('empty');
        
        // check permission
        if (!$this->isACL('r'))
        {
            echo lang('You can not access to this page.');
            exit();
        }
        
        // lib
        $this->load->model('module_fields/Module_field');
        
        // get module field
        $module_fields = $this->Module_field->get(array('resource_id' => $resource_id), 'weight asc', FALSE);
        
        if (!$module_fields)
        {
            echo lang('Not data');
            exit();
        }
        
        // data to view
        $data = array(
            'module_fields' => $module_fields
        );
                
        // parser
        $this->parser->parse($this->router->class . '/data_field', $data);
    }
    
    /**
     * get list module relation 
     * 
     * @method ajax
     * 
     * @param int $resource_id
     * @param string $view file view tpl
     */
    public function get_ajax_relation($resource_id, $view = 'admin_module_relations/get_ajax_relation')
    {
        // check layout
        $this->layout->set_layout('empty');
        
        // check permission
        $this->PG_ACL('r');
        
        $relations = $this->Module_relation->find('all', array(
            'select' => 'mr.*, r.name as resource',
            'from' => 'module_relations mr',
            'join' => array(
                'module_resources r' => 'mr.module_relation_id = r.id'
            ),
            'where' => array(
                'mr.module_id' => $resource_id
            ),
            'limit' => '0'
        ));
        
        $this->parser->parse($view, array(
            'relations' => $relations
        ));
    }
}
                
?>