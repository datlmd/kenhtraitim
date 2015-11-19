<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_webservices
 * ...
 * 
 * @package PenguinFW
 * @subpackage webservices
 * @version 1.0.0
 */
 
class Admin_webservices extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Webservice';
        
        // set layout
        $this->layout->set_layout('admin');
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('webservices', lang_web());
            
        $this->load->model('Webservice');
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
        $this->layout->set_title(lang('Webservice manager'));
        
        // filter
        // filter username
        $username = $this->input->get('username');
        if ($username)
        {
            $this->paginator['where']['username like'] = '%' . $username . '%';
        }
        
        // get module
        $webservices = $this->pagination(5);
                
        // get $_GET
        $extra_params = get_extra_params_from_url();
        
        $data = array(
            'list_views' => $webservices,
            
            'this_resource' => $this->router->class,            
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'link_edit' => array(
                'Edit' => 'webservices/admin_webservices/edit/'
            ),
            'pagination_link' => $this->getPaginationLink('/webservices/admin_webservices/index/' . $cfn_id, 5, $extra_params)
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
        $this->layout->set_title(lang('Add webservices'));
                
        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        // form validate
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('public_key', 'Public key', 'required');
        $this->form_validation->set_rules('secret_key', 'Secret Key', 'required');
        $this->form_validation->set_rules('service', 'Service', 'required');
                
        // get post and check rule
        if ($this->input->post() && $this->form_validation->run() == TRUE)
        {
            // save data
            if ($this->Webservice->create($this->input->post(), TRUE))
            {
                $this->session->set_flashdata('success_message', lang('Success'));
            } else
            {
                $this->session->set_flashdata('success_message', lang('Error'));
            }
            
            // redirect
            redirect('webservices/admin_webservices');
        }
                
        $data = array(
            'type_get' => ConstWebservice::Get,
            'type_post' => ConstWebservice::Post
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
        $this->layout->set_title(lang('Edit webservices'));
                
        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        // form validate
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('public_key', 'Public key', 'required');
        $this->form_validation->set_rules('secret_key', 'Secret Key', 'required');
        $this->form_validation->set_rules('service', 'Service', 'required');
        
        // get user_id
        $id = ($this->input->post('id')) ? $this->input->post('id') : $id;
        
        // get post and check rule
        if ($this->input->post() && $this->form_validation->run() == TRUE)
        {
            // save data
            if ($this->Webservice->update($this->input->post(), array('id' => $id), TRUE))
            {
                $this->session->set_flashdata('success_message', lang('Success'));
            } else 
            {
                $this->session->set_flashdata('success_message', lang('Error'));
            }
            
            // redirect
            redirect('webservices/admin_webservices');
        }                        
        
        // get user
        $webservice = $this->Webservice->get(array('id' => $id));
                
        // data to view
        $data = array(
            'data_edit' => $webservice,
            'type_get' => ConstWebservice::Get,
            'type_post' => ConstWebservice::Post
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