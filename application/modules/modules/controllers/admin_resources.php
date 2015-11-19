<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_resources
 * ...
 * 
 * @package PenguinFW
 * @subpackage Module
 * @version 1.0.0
 * 
 * @property Module_resource        $Module_resource
 */
 
class Admin_resources extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->layout->set_layout('admin');
            
        $this->model_name = 'Module_resource';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('modules', lang_web());
            
        $this->load->model('Module_resource');
    }
    
    /**
     * LIST module resource
     * 
     * @param int $module_id 
     * @param int $cfn_id Custom_field_name ID
     */
    public function index($module_id = 0, $cfn_id = 0)
    {
        // check permission
        $this->PG_ACL('r');
        
        // check module_id
        if ($module_id == 0)
        {
            show_error(lang('Error params'));
        }
        
        // set title
        $this->layout->set_title(lang('Module resource manager'));                
        
        // set conditions
        $this->paginator = array(
            'select' => 'module_resources.*, modules.name as module_id',
            'from' => 'module_resources',
            'join' => array(
                'modules' => 'modules.id = module_resources.module_id'
            ),
            'where' => array(
                'module_resources.module_id' => $module_id
            )
        );
        
        // get module
        $module_resources = $this->pagination(6);         
        
        // check invalid Module_resource
        if (empty ($module_resources))
        {
            show_error(lang('Error params'));
        }
        
        // data to view
        $data = array(
            'list_views' => $module_resources,
            
            'this_resource' => $this->router->class,            
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'link_edit' => array(
                'Edit template' => 'html_templates/admin_html_templates/index/',
                'Field manager' => 'module_fields/admin_module_fields/index/'
            ),
            'pagination_link' => $this->getPaginationLink('/modules/admin_resources/index/' . $module_id . '/' . $cfn_id, 6)
        );
        
        $this->parser->parse($this->router->class . '/index', $data);
    }
    
    /**
     * get list module resource with ajax
     * 
     * @param int $module_id 
     * @param string $view file view name
     */
    public function get_ajax_resource($module_id = 0, $view = 'admin_resources/get_ajax_resource')
    {
        // check layout
        $this->layout->set_layout('empty');
        
        // check permission
        $this->PG_ACL('r');
        
        $resources = $this->Module_resource->get(array('module_id' => $module_id), 'name asc', FALSE, 0);        
        
        $this->parser->parse($view, array(
            'resources' => $resources
        ));
    }
}
                
?>