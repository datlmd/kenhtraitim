<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller admin_custom_field_names
 * ...
 * 
 * @package PenguinFW
 * @subpackage custom_field
 * @version 1.0.0
 * 
 * @property Custom_field_name $Custom_field_name
 * @property Custom_field $Custom_field
 */
 
class admin_custom_field_names extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->model_name = 'Custom_field_name';
        
        $this->layout->set_layout('admin');
        
        $this->lang->load('generate', lang_web());
        $this->lang->load('custom_fields', lang_web());
        
        $this->load->model('Custom_field_name');
    }
    
    /**
     * Admin quản lý custom field of resource
     * 
     * @param string $resource
     * @param int $cfn_id custom field name id
     */
    public function index($resource, $cfn_id = 0)
    {
        // check permission
        $this->PG_ACL('r'); 

        // set title
        $this->layout->set_title(lang('Custom field manager'));
        
        // get resource id
        $resource_id = $this->getResourceID($resource, FALSE);
        
        // get all custom fields name
        $this->paginator = array(
            'select' => 'cfn.*, r.name as resource_id',
            'from' => 'custom_field_names AS cfn',
            'join' => array(
                'module_resources AS r' => 'cfn.resource_id = r.id'
            ),
            'where' => array(
                'r.id' => $resource_id
            )
        );
        
        $cfns = $this->pagination();                

        // get $_GET
        $extra_params = get_extra_params_from_url();

        $data = array(
            'list_views' => $cfns,
            'resource' => $resource,
            
            'this_resource' => $this->router->class,            
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'link_edit' => 'custom_fields/admin_custom_fields/edit/',
            'pagination_link' => $this->getPaginationLink('/custom_fields/admin_custom_field_names/index/' . $cfn_id, 5, $extra_params)
        );

        $this->parser->parse('admin_custom_field_names/index', $data);
    }
    
    /**
     * Delete custom field
     */
    public function delete()
    {
        // check permission
        $this->PG_ACL('d');
        
        // get link redirect to manage page
        $link_redirect = $this->router->fetch_module() . '/' . $this->router->class;
        
        // check post data from form
        if ($this->input->post())
        {
            $list_delete_ids = $this->input->post('listViewId');
            
            if (!empty ($list_delete_ids))
            {
                $this->Custom_field_name->deleteCustomField($list_delete_ids);
            }
            
            redirect($link_redirect . '/index/' . $this->input->post('cf_resource'));
        } else
        {
            $this->session->set_flashdata('error_message', lang('Error params'));
            redirect('users/admin_users/dashboard');
        }                
    }
}
                
?>