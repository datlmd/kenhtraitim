<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_customer_groups
 * ...
 * 
 * @package PenguinFW
 * @subpackage customer_groups
 * @version 1.0.0
 */
 
class Admin_customer_groups extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->layout->set_layout('admin');
            
        $this->model_name = 'Customer_group';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('customer_groups', lang_web());
            
        $this->load->model('Customer_group');
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
        $this->layout->set_title(lang('Customer_group manager'));
        
        // get admin_customer_groups
        $this->paginator['leftjoin'] = array('customers c' => 'customer_groups.leader = c.id');
        $this->paginator['select'] = 'customer_groups.*, c.name as leader';
        $admin_customer_groups = $this->pagination(5);
                
        $data = array(
            'list_views' => $admin_customer_groups,
            
            'this_resource' => $this->router->class,            
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'link_edit' => array(
                'Edit' => 'customer_groups/admin_customer_groups/edit/'                
            ),
            'pagination_link' => $this->getPaginationLink('/customer_groups/admin_customer_groups/index/' . $cfn_id, 5)
        );
        
        $data['total_records'] = $this->count_record;
        
        $this->parser->parse($this->router->class . '/index', $data);
    }
    
    private function _listView($action = 'index', $cfn_id = 0) {
    
        //export data
        if($action == "export")
        {
             $this->paginator['leftjoin'] = array('customers c' => 'customer_groups.leader = c.id');
            $this->paginator['select'] = 'customer_groups.id, customer_groups.name,  c.name as leader,  customer_groups.created';     
            $this->paginator['order']['id'] = "ASC";
            $this->paginator['limit'] = 999999999;
            return $this->pagination(5);
        }

   
    }
    
    public function export()
    {
        $contents = array();

        $contents = $this->_listView("export");
  
        if(empty($contents))
        {

            $contents[0] = array('Data' => 'No record');
        }  
    
        $this->load->library('Write_exel');
        $this->write_exel->write($contents, SITE_NAME . '_' . date('Y_m_d_H'));
        exit();
    }
                
    /**
     * View data
     *
     * @params int $id
     */
    public function view($id)
    {
        // check permission
        $this->PG_ACL('r');
        
        // set title
        $this->layout->set_title(lang('View Customer_group'));
                
        $admin_customer_groups = $this->Customer_group->get(array('id' => $id));
                
        // set data to view
        $data = array(
            'data_view' => $admin_customer_groups
        );
        
        // parser
        $this->parser->parse($this->router->class . '/view', $data);
    }
                
    /**
     * Add data    
     */
    public function add()
    {   
        // check permission
        $this->PG_ACL('w');
        
        // set title
        $this->layout->set_title(lang('Add Customer_group'));
                
        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        // form validate
        $this->form_validation->set_rules('name', 'Name', 'required');
                
        // get post and check rule
        if ($this->input->post() && $this->form_validation->run() == TRUE)
        {
            // save data
            if ($this->Customer_group->create($this->input->post(), TRUE))
            {
                $this->session->set_flashdata('success_message', lang('Success'));
            } else 
            {
                $this->session->set_flashdata('error_message', lang('Error'));
            }
            
            // redirect
            redirect('customer_groups/admin_customer_groups');
        }
                
        $data = array();
                
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
        $this->layout->set_title(lang('Edit Customer_group'));
                
        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        // form validate
        $this->form_validation->set_rules('name', 'Name', 'required');
        
        // get id
        $id = ($this->input->post('id')) ? $this->input->post('id') : $id;
                
        // get admin_customer_groups
        $admin_customer_groups = $this->Customer_group->get(array('id' => $id));
            
        if (!$admin_customer_groups)
        {
            show_error(lang('Error params'));
        }
        
        // get post and check rule
        if ($this->input->post() && $this->form_validation->run() == TRUE)
        {
            // save data
            if ($this->Customer_group->update($this->input->post(), array('id' => $id), TRUE))
            {
                $this->session->set_flashdata('success_message', lang('Success'));
            } else 
            {
                $this->session->set_flashdata('error_message', lang('Error'));
            }
            
            // redirect
            redirect('customer_groups/admin_customer_groups');
        }
                
        // data to view
        $data = array(
            'data_edit' => $admin_customer_groups
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