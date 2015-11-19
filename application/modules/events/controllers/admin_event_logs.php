<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_event_logs
 * ...
 * 
 * @package PenguinFW
 * @subpackage events
 * @version 1.0.0
 */
class Admin_event_logs extends MY_Controller {

    function __construct() {
        parent::__construct();

        $this->layout->set_layout('admin');

        $this->model_name = 'Event_log';

        $this->lang->load('generate', lang_web());
        $this->lang->load('events', lang_web());

        $this->load->model('Event_log');
    }

    /**
     * List
     *
     * @params int $cfn_id
     */
    public function index($resource = FALSE, $cfn_id = 0) {
        // check permission
        $this->PG_ACL('r');

        //set config
        $resource = $resource ? $resource : 'music_singers';
        $this->paginator['select'] = "*, event_logs.id as id";

        // set title
        $this->layout->set_title(lang('Event_log manager'));


        //filter
        //
        //filter events
        $filter_event = $this->input->get('event_id');
        if ($filter_event) {
            $this->paginator['where']['event_id'] = $filter_event;
        }

        // filter record_id
        $filter_record_id = $this->input->get('record_id');
        if ($filter_record_id)
        {
            $this->paginator['where']['record_id'] = $filter_record_id;
        }

        //filter resource
        $filter_resource = $this->input->get('resource_id');
        if ($filter_resource) {
            $this->paginator['where']['resource_id'] = $filter_resource;

            //get resource name
            $resource_name = $this->getResourceName($filter_resource);

            //get name record
            $this->paginator['leftjoin'][$resource_name] = "event_logs.record_id = $resource_name.id";
            $this->paginator['select'] = "event_logs.*, $resource_name.name as record_id";
        }

        //get event name
        $this->paginator['join']['events'] = 'event_logs.event_id = events.id';
        $this->paginator['select'] .= ',events.name as event_id';

        //get resource name
        $this->paginator['leftjoin']['module_resources'] = 'event_logs.resource_id = module_resources.id';
        $this->paginator['select'] .= ',module_resources.name as resource_id, event_logs.vote_count + event_logs.vote_cheat + event_logs.sms_count as total_vote';
		
        $filter_order_id = $this->input->get('order_id');
        if ($filter_order_id) {
        	if ($filter_order_id == 1)
        		$this->paginator['order'] = array('event_logs.view_count' => 'desc');
        	if ($filter_order_id == 2)
        		$this->paginator['order'] = array('event_logs.vote_count' => 'desc');
        	if ($filter_order_id == 3)
        		$this->paginator['order'] = array('event_logs.sms_count ' => 'desc');
        	if ($filter_order_id == 4)
        		$this->paginator['order'] = array('event_logs.total_vote' => 'desc');
        }

        $this->paginator['where']['event_logs.status_id'] = 1;
        // get admin_event_logs
        $admin_event_logs = $this->pagination(5);

        //get params
        $extras = get_extra_params_from_url();

        //get events
        $events = $this->Event_log->find('all', array('from' => 'events'));

        $data = array(
            'list_views' => $admin_event_logs,
            'events' => $events,
            'total_records' => $this->count_record,
            'this_resource' => $this->router->class,
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'link_edit' => array(
                'Edit' => 'events/admin_event_logs/edit/'
            ),
            'pagination_link' => $this->getPaginationLink('/events/admin_event_logs/index/' . $cfn_id, 5, $extras)
        );

        $this->parser->parse($this->router->class . '/index', $data);
    }

    /**
     * View data
     *
     * @params int $id
     */
    public function view($id) {
        // check permission
        $this->PG_ACL('r');

        // set title
        $this->layout->set_title(lang('View Event_log'));

        $admin_event_logs = $this->Event_log->get(array('id' => $id));

        // set data to view
        $data = array(
            'data_view' => $admin_event_logs
        );

        // parser
        $this->parser->parse($this->router->class . '/view', $data);
    }

    /**
     * Add data    
     */
    public function add() {
        // check permission
        $this->PG_ACL('w');

        // set title
        $this->layout->set_title(lang('Add Event_log'));

        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');

        // form validate
        $this->form_validation->set_rules('name', 'Name', 'required');

        // get post and check rule
        if ($this->input->post() && $this->form_validation->run() == TRUE) {
            // save data
            if ($this->Event_log->create($this->input->post(), TRUE)) {
                $this->session->set_flashdata('success_message', lang('Success'));
            } else {
                $this->session->set_flashdata('error_message', lang('Error'));
            }

            // redirect
            redirect('events/admin_event_logs');
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
    public function edit($id = 0) {
        // check permission
        $this->PG_ACL('e');

        // set title
        $this->layout->set_title(lang('Edit Event_log'));

        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');

        // form validate
        //$this->form_validation->set_rules('', '', 'required');
        // get id
        $id = ($this->input->post('id')) ? $this->input->post('id') : $id;

        // get admin_event_logs
        $admin_event_logs = $this->Event_log->get(array('id' => $id));
        if (!$admin_event_logs) {
            show_error(lang('Error params'));
        }

        // data to view
        $data = array(
            'data_edit' => $admin_event_logs
        );

        // get post and check rule
        //if ($this->input->post() == TRUE && $this->form_validation->run() == TRUE)
        if ($this->input->post() == TRUE) {
            // save data
            if ($this->Event_log->update($this->input->post(), array('id' => $id), TRUE)) {
                $this->session->set_flashdata('success_message', lang('Success'));
                $post_data = $this->input->post();
                write_log_file('votes_log_' . date('Y_m_d'), 'id: ' . $post_data['id'] . '| view: ' . $admin_event_logs->view_cheat . '=>' . $post_data['view_cheat'] . '| vote: ' . $admin_event_logs->vote_cheat . '=>' . $post_data['vote_cheat'] . '| by: ' . $this->session->userdata('user_username'));
            } else {
                $this->session->set_flashdata('error_message', lang('Error'));
            }

            // redirect
            redirect('events/admin_event_logs');
        }

        // parser
        $this->parser->parse($this->router->class . '/edit', $data);
    }

    /**
     * Delete
     */
    public function delete() {
        // check permission
        $this->PG_ACL('d');

        $this->deleteRecordOnListView();
    }

}

?>