<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_modules
 * ...
 * 
 * @package PenguinFW
 * @subpackage Module
 * @version 1.0.0
 * 
 * @property Module             $Module
 * @property Module_resource    $Module_resource
 * @property Module_field       $Module_field
 */
 
class Admin_modules extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Module';
        
        $this->layout->set_layout('admin');
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('modules', lang_web());
            
        $this->load->model('Module');
    }
    
    /**
     * LIST module
     * 
     * @param int $cfn_id Custom_field_name ID
     */
    public function index($cfn_id = 0)
    {
        // check permission
        $this->PG_ACL('r');
        
        // set title
        $this->layout->set_title(lang('Module manager'));                
        
        // get module
        $modules = $this->pagination(5);
        
        $data = array(
            'list_views'        => $modules,            
            'this_resource'     => $this->router->class,            
            'cf_names'          => $this->getCustomFieldName(NULL, FALSE),
            'fields'            => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'link_edit'         => array(
                'View resource'     => 'modules/admin_resources/index/',
                'Publish'           => 'modules/admin_modules/publish/',
                'Delete'            => 'modules/admin_modules/delete/',
            ),
            'pagination_link' => $this->getPaginationLink('/modules/admin_modules/index/' . $cfn_id, 5)
        );
        
        $this->parser->parse($this->router->class . '/index', $data);
    } 
    
    /**
     * Publish or No Publish Module
     * 
     * @param int $module_id 
     */
    public function publish($module_id = 0)
    {
        // check permission
        $this->PG_ACL('p');
        
        // check params module ID
        if ($module_id == 0)
        {
            show_error(lang('Error params'));
        }
        
        // get module
        $module = $this->Module->get_select('id, is_publish', array('id' => $module_id));
        
        // check module exit
        if (empty ($module))
        {
            show_error(lang('Error params'));
        }
        
        // update is_publish
        // if is_publish == 1
        if ($module->is_publish == 1)
        {
            $this->Module->update(
                array('is_publish' => 0), 
                array('id' => $module_id)
            );
        } else // is_publish == 0
        {
            $this->Module->update(
                array('is_publish' => 1), 
                array('id' => $module_id)
            );
        }
        
        redirect('modules/admin_modules');
    }

    
    public function delete($module_id = 0)
    {
        $this->PG_ACL('d');
        
        // get module name
        $module = $this->Module->get(array('id' => $module_id));
        
        if (!$module) show_error('Error param');
        
        // get resource
        $resources = $this->Module->find('all', array(
            'from'      => 'module_resources',
            'where'     => array('module_id' => $module_id)
        ));
        
        if (!$resources) show_error('Module resource error');
        
        $this->load->model('module_fields/Module_field');
        $this->load->model('Module_resource');
        foreach ($resources as $resource)
        {
            $this->Module_field->deleteRecord(array('resource_id' => $resource['id']));
            $this->Module_resource->deleteRecord(array('id' => $resource['id']));
        }
        $this->Module->deleteRecord(array('id' => $module_id));
        $this->Module->query("DROP TABLE {$module->name}", TRUE);
        
        // delete folder
        $this->load->helper('file');
        delete_directory(FPENGUIN . APPPATH . "modules/{$module->name}");
        delete_directory(FPENGUIN . APPPATH . "views/" . theme_web() . "/{$module->name}");
        
        redirect('modules/admin_modules');
    }
    
    
}
                
?>