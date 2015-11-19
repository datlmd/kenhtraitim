<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_mail_boxs
 * ...
 * 
 * @package PenguinFW
 * @subpackage mail_boxs
 * @version 1.0.0
 */
 
class Admin_mail_boxs extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->layout->set_layout('admin');
            
        $this->model_name = 'Mail_box';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('mail_boxs', lang_web());
            
        $this->load->model('Mail_box');
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
        $this->layout->set_title(lang('Mail_box manager'));
        
        // set javascript to view
        $this->layout->set_javascript(array(
            'jquery.ui.core.min.js',
            'jquery.ui.datepicker.min.js'
        ));

        // set css to view
        $this->layout->set_rel(array(
            'jquery.ui.base.css',
            'jquery.ui.datepicker.css'
        ));

        // set title
        $this->layout->set_title(lang('Mail manager'));

        //filter
        // filter created from date
        $filter_from_date = $this->input->get('from_date');
        if($filter_from_date)
        {
            $this->paginator['where']['DATE(created) >= '] = standar_date($filter_from_date, '-', '-');
        }

        // filter created end date
        $filter_to_date = $this->input->get('to_date');
        if($filter_to_date)
        {
            $this->paginator['where']['DATE(created) <= '] = standar_date($filter_to_date, '-', '-');
        }

        // filter username
        $filter_username = $this->input->get('name');
        if($filter_username)
        {
            $this->paginator['like']['user_name'] = $filter_username;
        }
        
         // filter username
        $filter_email= $this->input->get('email_to');
        if($filter_email)
        {
            $this->paginator['like']['email_to'] = $filter_email;
        }
        
        // get admin_mail_boxs
        $admin_mail_boxs = $this->pagination(5);
        
        //get extra params
        $extra_params = get_extra_params_from_url();
                
        $data = array(
            'list_views' => $admin_mail_boxs,
            'total_records' => $this->count_record,
            'this_resource' => $this->router->class,            
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'link_edit' => array(
                'Edit' => 'mail_boxs/admin_mail_boxs/edit/'                
            ),
            'pagination_link' => $this->getPaginationLink('/mail_boxs/admin_mail_boxs/index/' . $cfn_id, 5, $extra_params)
        );
        
        $this->parser->parse($this->router->class . '/index', $data);
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
        $this->layout->set_title(lang('View Mail_box'));
                
        $admin_mail_boxs = $this->Mail_box->get(array('id' => $id));
                
        // set data to view
        $data = array(
            'data_view' => $admin_mail_boxs
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
        $this->layout->set_title(lang('Add Mail_box'));
                
        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        // form validate
        $this->form_validation->set_rules('name', 'Name', 'required');
                
        // get post and check rule
        if ($this->input->post() && $this->form_validation->run() == TRUE)
        {
            // save data
            if ($this->Mail_box->create($this->input->post(), TRUE))
            {
                $this->session->set_flashdata('success_message', lang('Success'));
            } else 
            {
                $this->session->set_flashdata('error_message', lang('Error'));
            }
            
            // redirect
            redirect('mail_boxs/admin_mail_boxs');
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
        $this->layout->set_title(lang('Edit Mail_box'));
                
        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        // form validate
        $this->form_validation->set_rules('name', 'Name', 'required');
        
        // get id
        $id = ($this->input->post('id')) ? $this->input->post('id') : $id;
                
        // get admin_mail_boxs
        $admin_mail_boxs = $this->Mail_box->get(array('id' => $id));
            
        if (!$admin_mail_boxs)
        {
            show_error(lang('Error params'));
        }
        
        // get post and check rule
        if ($this->input->post() && $this->form_validation->run() == TRUE)
        {
            // save data
            if ($this->Mail_box->update($this->input->post(), array('id' => $id), TRUE))
            {
                $this->session->set_flashdata('success_message', lang('Success'));
            } else 
            {
                $this->session->set_flashdata('error_message', lang('Error'));
            }
            
            // redirect
            redirect('mail_boxs/admin_mail_boxs');
        }
                
        // data to view
        $data = array(
            'data_edit' => $admin_mail_boxs
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