<?php

if(!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_user_logs
 * ...
 * 
 * @package PenguinFW
 * @subpackage users
 * @version 1.0.0
 */
class Admin_user_logs extends MY_Controller {

    function __construct()
    {
        parent::__construct();

        $this->layout->set_layout('admin');

        $this->model_name = 'User_log';

        $this->lang->load('generate', lang_web());
        $this->lang->load('users', lang_web());

        $this->load->model('User_log');
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
        $this->layout->set_title(lang('User_log manager'));

        // get admin_user_logs
        $this->paginator['order']['created'] = 'DESC';
        $admin_user_logs = $this->pagination(5);

        $data = array(
            'list_views' => $admin_user_logs,
            'this_resource' => $this->router->class,
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'link_edit' => array(
                'Edit' => 'users/admin_user_logs/edit/'
            ),
            'pagination_link' => $this->getPaginationLink('/users/admin_user_logs/index/' . $cfn_id, 5),
            'total_records' => $this->count_record,
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
        $this->layout->set_title(lang('View User_log'));

        $admin_user_logs = $this->User_log->get(array('id' => $id));

        // set data to view
        $data = array(
            'data_view' => $admin_user_logs
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
        $this->layout->set_title(lang('Add User_log'));

        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');

        // form validate
        $this->form_validation->set_rules('name', 'Name', 'required');

        // get post and check rule
        if($this->input->post() && $this->form_validation->run() == TRUE)
        {
            // save data
            if($this->User_log->create($this->input->post(), TRUE))
            {
                $this->session->set_flashdata('success_message', lang('Success'));
            }
            else
            {
                $this->session->set_flashdata('error_message', lang('Error'));
            }

            // redirect
            redirect('users/admin_user_logs');
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
        $this->layout->set_title(lang('Edit User_log'));

        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');

        // form validate
        $this->form_validation->set_rules('name', 'Name', 'required');

        // get id
        $id = ($this->input->post('id')) ? $this->input->post('id') : $id;

        // get admin_user_logs
        $admin_user_logs = $this->User_log->get(array('id' => $id));

        if(!$admin_user_logs)
        {
            show_error(lang('Error params'));
        }

        // get post and check rule
        if($this->input->post() && $this->form_validation->run() == TRUE)
        {
            // save data
            if($this->User_log->update($this->input->post(), array('id' => $id), TRUE))
            {
                $this->session->set_flashdata('success_message', lang('Success'));
            }
            else
            {
                $this->session->set_flashdata('error_message', lang('Error'));
            }

            // redirect
            redirect('users/admin_user_logs');
        }

        // data to view
        $data = array(
            'data_edit' => $admin_user_logs
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