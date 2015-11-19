<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_page_view_manages
 * ...
 * 
 * @package PenguinFW
 * @subpackage pages
 * @version 1.0.0
 */
 
class Admin_page_view_manages extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->layout->set_layout('admin');
            
        $this->model_name = 'Page_view_manage';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('pages', lang_web());
            
        $this->load->model('Page_view_manage');
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
        $this->layout->set_title(lang('Page_view_manage manager'));
        
        // get admin_page_view_manages
        $admin_page_view_manages = $this->pagination(5);
                
        $data = array(
            'list_views' => $admin_page_view_manages,
            'total_records' => $this->count_record,
            'this_resource' => $this->router->class,            
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'link_edit' => array(
                'Edit' => 'pages/admin_page_view_manages/edit/'                
            ),
            'pagination_link' => $this->getPaginationLink('/pages/admin_page_view_manages/index/' . $cfn_id, 5)
        );
        
        $this->parser->parse($this->router->class . '/index', $data);
                    
        set_last_url();
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
        $this->layout->set_title(lang('View Page_view_manage'));
                
        $admin_page_view_manages = $this->Page_view_manage->get(array('id' => $id));
                
        // set data to view
        $data = array(
            'data_view' => $admin_page_view_manages
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
        $this->layout->set_title(lang('Add Page_view_manage'));
                
        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        // form validate
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('controller', 'Controller', 'required');
        $this->form_validation->set_rules('action', 'Action', 'required');
        $this->form_validation->set_rules('key', 'Key', 'required');
                
        // get post and check rule
        if ($this->input->post() && $this->form_validation->run() == TRUE)
        {
            $check = $this->Page_view_manage->find('all', array(
                'where' => array(
                    'key' => $this->input->post('key')
                )
            ));

            if(!$check)
            {
                // save data
                if ($this->Page_view_manage->create($this->input->post(), TRUE))
                {
                    $this->session->set_flashdata('success_message', lang('Success'));
                } else
                {
                    $this->session->set_flashdata('error_message', lang('Error'));
                }
            }
            else
            {
                $this->session->set_flashdata('error_message', lang('Key is existed'));
            }
            
            // redirect
            redirect(get_last_url());
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
        $this->layout->set_title(lang('Edit Page_view_manage'));
                
        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');

        // form validate
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('controller', 'Controller', 'required');
        $this->form_validation->set_rules('action', 'Action', 'required');
        $this->form_validation->set_rules('key', 'Key', 'required');
        
        // get id
        $id = ($this->input->post('id')) ? $this->input->post('id') : $id;
                
        // get admin_page_view_manages
        $admin_page_view_manages = $this->Page_view_manage->get(array('id' => $id));
            
        if (!$admin_page_view_manages)
        {
            show_error(lang('Error params'));
        }
        
        // get post and check rule
        if ($this->input->post() && $this->form_validation->run() == TRUE)
        {
            $check = $this->Page_view_manage->find('all', array(
                'where' => array(
                    'key' => $this->input->post('key'),
                    'id !=' => $this->input->post('id')
                )
            ));

            if(!$check)
            {
                // save data
                if ($this->Page_view_manage->update($this->input->post(), array('id' => $id), TRUE))
                {
                    $this->session->set_flashdata('success_message', lang('Success'));
                } else
                {
                    $this->session->set_flashdata('error_message', lang('Error'));
                }
            }
            else
            {
                $this->session->set_flashdata('error_message', lang('Key is used by other id'));
            }
            
            // redirect
            redirect(get_last_url());
        }
                
        // data to view
        $data = array(
            'data_edit' => $admin_page_view_manages
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