<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Quản lý roles cho user
 * 
 * @package PenguinFW
 * @subpackage User
 * @version 1.0.0
 * 
 * @property User_role          $User_role
 * @property User               $User
 * @property User_permission    $User_permission
 */

class Admin_roles extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->model_name = 'User_role';
        
        $this->layout->set_layout('admin');
        
        $this->lang->load('generate', lang_web());
        $this->lang->load('users', lang_web());        
        
        $this->load->model('User_role');
    }
    
    /**
     * List
     */
    public function index($cfn_id = 0)
    {
        // set permission
        $this->PG_ACL('r');
        
        // set title
        $this->layout->set_title(lang('Role manager'));
        
//        $this->paginator['order'] = array('weight' => 'asc');
        
        // get user roles
        $user_roles = $this->pagination(5);
        
        // get $_GET
        $extra_params = get_extra_params_from_url();
        
        $data = array(
            'list_views' => $user_roles,
            
            'this_resource' => $this->router->class,            
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'link_edit' => array(
                'Edit' => 'users/admin_roles/edit/',
                'Permission' => 'users/admin_roles/permission/'
            ),
            'pagination_link' => $this->getPaginationLink('/users/admin_roles/index/' . $cfn_id, 5, $extra_params)
        );
        
        $this->parser->parse('admin_roles/index', $data);
    }
    
    /**
     * ADD
     */
    public function add()
    {
        // check permission
        $this->PG_ACL('w');
        
        // set title
        $this->layout->set_title(lang('Add') . ' ' . lang('User role'));
        
        // load helper form and form validate
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        // set role validate
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('user_role_cp_id', 'Role copy', 'required');
        
        // process post data
        if ($this->input->post() && $this->form_validation->run() == TRUE)
        {            
            $data_add = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'weight' => $this->input->post('weight'),
            );
            
            // insert new role
            $user_role_id = $this->User_role->create($data_add);
            
            // copy role from role old
            if ($user_role_id > 0)
            {
                $this->User_role->copyRole($user_role_id, $this->input->post('user_role_cp_id'));
            }
        }
        
        // get all user role
        // user cp role permission
        $all_roles = $this->User_role->get_select('id, name', NULL, 'weight asc', FALSE, 0);
        
        // set data to view
        $data = array(
            'all_roles' => $all_roles
        );
        
        // set view
        $this->parser->parse($this->router->class . '/add', $data);
    }
    
    /**
     * EDIT
     * 
     * @param int $role_id ID user_roles
     */
    public function edit($role_id = 0)
    {
        // check permission
        $this->PG_ACL('e');
        
        // set title_page
        $this->layout->set_title(lang('Edit') . ' ' . lang('User role'));
        
        // load helper form and form validate
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        // set role validate
        $this->form_validation->set_rules('name', 'Name', 'required');        
        
        // get role_id
        $role_id = ($this->input->post('role_id')) ? $this->input->post('role_id') : $role_id;
        
        // process data from form
        if ($this->input->post() && $this->form_validation->run() == TRUE)
        {
            // get data update
            $data_update = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'weight' => $this->input->post('weight'),
            );
            
            // update role
            $this->User_role->update($data_update, array('id' => $role_id));
            
            // redirect to manager page
            redirect('users/admin_roles');
        }
        
        // get current user_role
        $current_role = $this->User_role->get(array('id' => $role_id));
        
        // check exit
        if (!$current_role)
        {
            show_error(lang('Error params'));
        }
        
        // data to view
        $data = array(
            'current_role' => $current_role
        );
        
        $this->parser->parse($this->router->class . '/edit', $data);
    }
    
    /**
     * Set permission
     * 
     * @param int $role_id ID user_roles
     */
    public function permission($role_id = 0)
    {
        // check permission
        $this->PG_ACL('e');
        
        // load model User_permission
        $this->load->model('User_permission');
        
        // get role_id
        $role_id = ($this->input->post('role_id')) ? $this->input->post('role_id') : $role_id;
        
        // process data from form
        if ($this->input->post())
        {
            // get data read/write/modify/publish/delete from form
            $data_update = $this->input->post();
            
            // check data read/write/modify/publish/delete
            if (!empty ($data_update['read']) && !empty ($data_update['write'])
                && !empty ($data_update['modify']) && !empty ($data_update['publish']) 
                && !empty ($data_update['delete']) && !empty ($data_update['trash']))
            {
                // update permission new
                $this->User_permission->updatePermission($role_id, $this->input->post());
                
                // redirect to new permission
                redirect('users/admin_roles/permission/' . $role_id);
            }
        }
        
        // get User_role
        $user_role = $this->User_role->get(array('id' => $role_id));                        
        
        // check user role
        if (empty ($user_role))
        {
            show_error(lang('Error params'));
        }
        
        // set title
        $this->layout->set_title(lang('Permission') . ': ' . $user_role->name);
        
        // get list Module and Module_resource        
        $resource_permissions = $this->User_permission->getModuleAndResource();
        
        // get current permission
        $current_resource_permissions = $this->User_permission->getRolePermission($role_id);        
        
        // set data to view
        $data = array(
            'user_role' => $user_role,
            'resource_permissions' => $resource_permissions,
            'current_resource_permissions' => $current_resource_permissions
        );
        
        // set view
        $this->layout->set_javascript(array(
            'jquery-ui.min.js'
        ));
        $this->layout->set_rel(array(
            'jquery.ui.base.css'
        ));
        $this->parser->parse($this->router->class . '/permission', $data);
    }
    
    /**
     * DELETE
     * 
     * @param int $id ID user_roles
     */
    public function delete()    
    {
        // check permission
        $this->PG_ACL('d');                
        
        // load model user_permission
        $this->load->model('User_permission');
        
        // delete permission role
        if ($this->input->post())
        {
            // get list id delete
            $role_delete_ids = $this->input->post('listViewId');
            
            // check permission not detele
            if (in_array(ConstUserRole::administrator, $role_delete_ids)
                || in_array(ConstUserRole::user, $role_delete_ids) 
                    || in_array(ConstUserRole::guest, $role_delete_ids))
                {
                    // set error
                    $this->session->set_flashdata('error_message', lang('Can not delete some Role system'));
                    
                    // redirect
                    redirect('users/admin_roles'); 
            }
            
            foreach ($role_delete_ids as $role_delete_id)
            {
                $this->User_permission->deletePermission($role_delete_id);
            }
        }
        
        // delete role
        $this->deleteRecordOnListView();
    }
}

?>
