<?php

if(!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_customers
 * ...
 * 
 * @package PenguinFW
 * @subpackage customers
 * @version 1.0.0
 */
class Admin_customers extends MY_Controller {

    function __construct()
    {
        parent::__construct();

        $this->layout->set_layout('admin');

        $this->model_name = 'Customer';

        $this->lang->load('generate', lang_web());
        $this->lang->load('customers', lang_web());

        $this->load->model('Customer');
        $this->load->model("Users/User");
    }

    /**
     * List
     * 
     * @param string $action
     * @param int $cfn_id
     * @return array data to view
     */
    private function _listView($action = 'index', $cfn_id = 0)
    {
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

        // filter users
        // filter user gender id
        $filter_user_genders_id = $this->input->get('user_genders_id');
        if($filter_user_genders_id)
        {
            $this->paginator['where']['gender'] = $filter_user_genders_id - 1;
        }

        // filter user age id
        $filter_user_age_id = $this->input->get('user_age_id');
        if($filter_user_age_id)
        {
            switch($filter_user_age_id)
            {
                case 1:
                    $date_filter = date('Y-m-d', strtotime("1/1 - 13 YEAR"));

                    $this->paginator['where']['dob >='] = $date_filter;
                    break;

                case 2:
                    $date_filter1 = date('Y-m-d', strtotime("1/1 - 13 YEAR"));
                    $date_filter2 = date('Y-m-d', strtotime("1/1 - 15 YEAR"));

                    $this->paginator['where']['dob <'] = $date_filter1;
                    $this->paginator['where']['dob >='] = $date_filter2;

                    break;

                case 3:
                    $date_filter1 = date('Y-m-d', strtotime("1/1 - 15 YEAR"));
                    $date_filter2 = date('Y-m-d', strtotime("1/1 - 17 YEAR"));

                    $this->paginator['where']['dob <'] = $date_filter1;
                    $this->paginator['where']['dob >='] = $date_filter2;
                    break;

                case 4:
                    $date_filter1 = date('Y-m-d', strtotime("1/1 - 17 YEAR"));
                    $date_filter2 = date('Y-m-d', strtotime("1/1 - 23 YEAR"));

                    $this->paginator['where']['dob <'] = $date_filter1;
                    $this->paginator['where']['dob >='] = $date_filter2;
                    break;

                case 5:
                    $date_filter = date('Y-m-d', strtotime("1/1 - 23 YEAR"));

                    $this->paginator['where']['dob <'] = $date_filter;
                    break;
            }
        }

        // filter created from date
        $filter_from_date = $this->input->get('from_date');
        if($filter_from_date)
        {
            $this->paginator['where']['DATE(customers.created) >= '] = standar_date($filter_from_date, '-', '-');
        }

        // filter created end date
        $filter_to_date = $this->input->get('to_date');
        if($filter_to_date)
        {
            $this->paginator['where']['DATE(customers.created) <= '] = standar_date($filter_to_date, '-', '-');
        }

        // filter username
        $filter_username = $this->input->get('name');
        if($filter_username)
        {
            $this->paginator['like']['customers.name'] = $filter_username;
        }

        // filter user regions id
        $filter_user_regions_id = $this->input->get('user_regions_id');
        if($filter_user_regions_id)
        {
            $this->paginator['where']['province'] = $filter_user_regions_id;
        }

        // filter user group id
        $filter_user_groups_id = $this->input->get('user_group_id');
        if($filter_user_groups_id)
        {
            if($filter_user_groups_id == -1)
                $this->paginator['where']['ISNULL(group_id)'] = 1;
            else
                $this->paginator['where']['group_id'] = $filter_user_groups_id;
        }

        //select 
        $this->paginator['select'] = 'customers.*, regions.name as province, g.name as group_id';

        //join
        $this->paginator['leftjoin'] = array(
            'regions' => 'customers.province = regions.id',
            'customer_groups g' => 'customers.group_id = g.id'
        );


        // order
        $this->paginator['order'] = array('customers.created' => 'desc', 'customers.group_id' => 'desc');

        //export data
        if($action == "export")
        {
            $this->paginator['limit'] = 999999999;
            return $this->pagination(5);
        }

        // get user
        $users = $this->pagination(5);

        //$users['province'] = $users['province2'];
        //unset($users['province2']);
        // get user status id
        $regions = $this->User->find('all', array(
            'select' => 'id, name',
            'from' => 'regions',
            'limit' => 0
                ));

        //get groups

        $groups = $this->User->find('all', array(
            'select' => 'id, name',
            'from' => 'customer_groups',
                ));


        // get $_GET
        $extra_params = get_extra_params_from_url();

        // set data view
        return array(
            'list_views' => $users,
            'cfn_id' => $cfn_id,
            'regions' => $regions,
            'groups' => $groups,
            'this_resource' => $this->router->class,
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'pagination_link' => $this->getPaginationLink('/customers/admin_customers/' . $action . '/' . $cfn_id, 5, $extra_params)
        );
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
        $this->layout->set_title(lang('Customer manager'));

        // get admin_customers
        $this->paginator['order'] = array('created' => 'DESC');
        $admin_customers = $this->pagination(5);

        $data = $this->_listView('index', $cfn_id);

        $data['total'] = $this->count_record;

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
        $this->layout->set_title(lang('View Customer'));

        $admin_customers = $this->Customer->get(array('id' => $id));

        // set data to view
        $data = array(
            'data_view' => $admin_customers
        );

        // parser
        $this->parser->parse($this->router->class . '/view', $data);
    }

    /**
     * Add data    
     */
    public function add()
    {
        //no accessable
        $this->session->set_flashdata('error_message', lang('Disabled'));
        redirect('customers/admin_customers');

        // check permission
        $this->PG_ACL('w');

        // set title
        $this->layout->set_title(lang('Add Customer'));

        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');

        // form validate
        $this->form_validation->set_rules('name', 'Name', 'required');

        // get post and check rule
        if($this->input->post() && $this->form_validation->run() == TRUE)
        {
            // save data
            if($this->Customer->create($this->input->post(), TRUE))
            {
                $this->session->set_flashdata('success_message', lang('Success'));
            }
            else
            {
                $this->session->set_flashdata('error_message', lang('Error'));
            }

            // redirect
            redirect('customers/admin_customers');
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
        //no accessable
        $this->session->set_flashdata('error_message', lang('Disabled'));
        redirect('customers/admin_customers');

        // check permission
        $this->PG_ACL('e');

        // set title
        $this->layout->set_title(lang('Edit Customer'));

        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');

        // form validate
        $this->form_validation->set_rules('name', 'Name', 'required');

        // get id
        $id = ($this->input->post('id')) ? $this->input->post('id') : $id;

        // get admin_customers
        $admin_customers = $this->Customer->get(array('id' => $id));

        if(!$admin_customers)
        {
            show_error(lang('Error params'));
        }

        // get post and check rule
        if($this->input->post() && $this->form_validation->run() == TRUE)
        {
            // save data
            if($this->Customer->update($this->input->post(), array('id' => $id), TRUE))
            {
                $this->session->set_flashdata('success_message', lang('Success'));
            }
            else
            {
                $this->session->set_flashdata('error_message', lang('Error'));
            }

            // redirect
            redirect('customers/admin_customers');
        }

        // data to view
        $data = array(
            'data_edit' => $admin_customers
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

}

?>