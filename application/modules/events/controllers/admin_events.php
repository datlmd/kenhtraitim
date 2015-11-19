<?php

if(!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_events
 * ...
 * 
 * @package PenguinFW
 * @subpackage events
 * @version 1.0.0
 */
class Admin_events extends MY_Controller {

    function __construct()
    {
        parent::__construct();

        $this->layout->set_layout('admin');

        $this->model_name = 'Event';

        $this->lang->load('generate', lang_web());
        $this->lang->load('events', lang_web());

        $this->load->model('Event');
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
        $this->layout->set_title(lang('Event manager'));

        // get admin_events
        $admin_events = $this->pagination(5);

        $data = array(
            'list_views' => $admin_events,
            'total_records' => $this->count_record,
            'this_resource' => $this->router->class,
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'link_edit' => array(
                'Edit' => 'events/admin_events/edit/'
            ),
            'pagination_link' => $this->getPaginationLink('/events/admin_events/index/' . $cfn_id, 5)
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
        $this->layout->set_title(lang('View Event'));

        $admin_events = $this->Event->get(array('id' => $id));

        // set data to view
        $data = array(
            'data_view' => $admin_events
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

        // set javascript to view
        // set javascript to view
        $this->layout->set_javascript(array(
            'jquery.ui.core.min.js',
            'jquery.ui.datepicker.min.js',
            'jquery.ui.timepicker.js',
        ));

        // set css to view
        $this->layout->set_rel(array(
            'jquery.ui.base.css',
            'jquery.ui.datepicker.css',
            'jquery.ui.timepicker.css',
        ));

        // set title
        $this->layout->set_title(lang('Add Event'));

        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');

        // form validate
        $this->form_validation->set_rules('name', 'Name', 'required|is_unique[events.name]');
        $this->form_validation->set_rules('start_date', 'Start date', 'required');
        $this->form_validation->set_rules('end_date', 'End date', 'required');

        // get post and check rule
        if($this->input->post() && $this->form_validation->run() == TRUE)
        {
            $_POST['start'] = date('Y-m-d H:i:s', strtotime($this->input->post('start_date') . ' ' . $this->input->post('start_time')));
            $_POST['end'] = date('Y-m-d H:i:s', strtotime($this->input->post('end_date') . ' ' . $this->input->post('end_time')));

            if($_POST['start'] >= $_POST['end'])
            {
                $this->session->set_flashdata('error_message', lang('Start date must less than end date'));
                redirect(current_url());
                return;
            }
            
            // save data
            if($this->Event->create($this->input->post(), TRUE))
            {
                $this->session->set_flashdata('success_message', lang('Success'));
            }
            else
            {
                $this->session->set_flashdata('error_message', lang('Error'));
            }

            // redirect
            redirect('events/admin_events');
        }

        //get status
        $status = array(
            array('id' => 1, 'name' => 'Public'),
            array('id' => 0, 'name' => 'Hidden'),
        );
        $data = array(
            'status_ids' => $status,
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

        // set javascript to view
        $this->layout->set_javascript(array(
            'jquery.ui.core.min.js',
            'jquery.ui.datepicker.min.js',
            'jquery.ui.timepicker.js',
        ));

        // set css to view
        $this->layout->set_rel(array(
            'jquery.ui.base.css',
            'jquery.ui.datepicker.css',
            'jquery.ui.timepicker.css',
        ));

        // set title
        $this->layout->set_title(lang('Edit Event'));

        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');

        // form validate
        $this->form_validation->set_rules('name', 'Name', 'required|almost_unique[events.name.id.'.$id.']');
        $this->form_validation->set_rules('start_date', 'Start date', 'required');
        $this->form_validation->set_rules('end_date', 'End date', 'required');

        // get id
        $id = ($this->input->post('id')) ? $this->input->post('id') : $id;

        // get admin_events
        $admin_events = $this->Event->get(array('id' => $id));
        $admin_events->start_date = date('d-m-Y', strtotime($admin_events->start));
        $admin_events->start_time = date('H:i', strtotime($admin_events->start));
        $admin_events->end_date = date('d-m-Y', strtotime($admin_events->end));
        $admin_events->end_time = date('H:i', strtotime($admin_events->end));

        if(!$admin_events)
        {
            show_error(lang('Error params'));
        }

        // get post and check rule
        if($this->input->post() && $this->form_validation->run() == TRUE)
        {

            $_POST['start'] = date('Y-m-d H:i:s', strtotime($this->input->post('start_date') . ' ' . $this->input->post('start_time')));
            $_POST['end'] = date('Y-m-d H:i:s', strtotime($this->input->post('end_date') . ' ' . $this->input->post('end_time')));

            if($_POST['start'] >= $_POST['end'])
            {
                $this->session->set_flashdata('error_message', lang('Start date must less than end date'));
                redirect(current_url());
                return;
            }
            
            // save data
            if($this->Event->update($this->input->post(), array('id' => $id), TRUE))
            {
                $this->session->set_flashdata('success_message', lang('Success'));
            }
            else
            {
                $this->session->set_flashdata('error_message', lang('Error'));
            }

            // redirect
            redirect('events/admin_events');
        }

        //get status
        $status = array(
            array('id' => 1, 'name' => 'Public'),
            array('id' => 0, 'name' => 'Hidden'),
        );

        // data to view
        $data = array(
            'data_edit' => $admin_events,
            'status_ids' => $status,
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