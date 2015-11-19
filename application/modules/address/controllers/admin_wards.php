<?php

if(!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_wards
 * ...
 * 
 * @package PenguinFW
 * @subpackage address
 * @version 1.0.0
 */
class Admin_wards extends MY_Controller {

    function __construct()
    {
        parent::__construct();

        $this->layout->set_layout('admin');

        $this->model_name = 'Ward';

        $this->lang->load('generate', lang_web());
        $this->lang->load('address', lang_web());

        $this->load->model('Ward');
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
        $this->layout->set_title(lang('Ward manager'));

        // get admin_wards
        $this->paginator['leftjoin']['districts'] = 'wards.district_id = districts.id';
        $this->paginator['leftjoin']['regions'] = 'districts.region_id = regions.id';
        $this->paginator['select'] = 'wards.*, districts.name as district_id, regions.name as user_id';
        $admin_wards = $this->pagination(5);

        $data = array(
            'list_views' => $admin_wards,
            'total_records' => $this->count_record,
            'this_resource' => $this->router->class,
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'link_edit' => array(
                'Edit' => 'address/admin_wards/edit/'
            ),
            'pagination_link' => $this->getPaginationLink('/address/admin_wards/index/' . $cfn_id, 5)
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
        $this->layout->set_title(lang('View Ward'));

        $admin_wards = $this->Ward->get(array('id' => $id));

        // set data to view
        $data = array(
            'data_view' => $admin_wards
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
        $this->layout->set_title(lang('Add Ward'));

        //set js
        $this->layout->set_javascript(array(
            'address/wards.js'
        ));

        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('District');
        $this->load->model('Province');

        // form validate
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('district_id', 'District', 'required');

        // get post and check rule
        if($this->input->post() && $this->form_validation->run() == TRUE)
        {
            // save data
            if($this->Ward->create($this->input->post(), TRUE))
            {
                $this->session->set_flashdata('success_message', lang('Success'));
            }
            else
            {
                $this->session->set_flashdata('error_message', lang('Error'));
            }

            // redirect
            redirect('address/admin_wards');
        }

        $data = array(
            'district_ids' => $this->District->find('all'),
            'province_ids' => $this->Province->find('all'),
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
        $this->layout->set_title(lang('Edit Ward'));

        //set js
        $this->layout->set_javascript(array(
            'address/wards.js'
        ));

        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('District');
        $this->load->model('Province');

        // form validate
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('district_id', 'District', 'required');

        // get id
        $id = ($this->input->post('id')) ? $this->input->post('id') : $id;

        // get admin_wards
        $admin_wards = $this->Ward->get(array('id' => $id));

        if(!$admin_wards)
        {
            show_error(lang('Error params'));
        }

        // get post and check rule
        if($this->input->post() && $this->form_validation->run() == TRUE)
        {
            // save data
            if($this->Ward->update($this->input->post(), array('id' => $id), TRUE))
            {
                $this->session->set_flashdata('success_message', lang('Success'));
            }
            else
            {
                $this->session->set_flashdata('error_message', lang('Error'));
            }

            // redirect
            redirect('address/admin_wards');
        }

        //get current province
        $current_region = $this->Province->get_of_district($admin_wards->district_id);

        // data to view
        $data = array(
            'data_edit' => $admin_wards,
            'district_ids' => $this->District->find('all'),
            'province_ids' => $this->Province->find('all'),
            'active_province_id' => (int) $current_region['id'],
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

    public function aj_get($district_id = FALSE)
    {
        // check permission
        $this->PG_ACL('d');

        //disable layout
        $this->layout->disable_layout();

        $options = NULL;
        $output = array();

        if($district_id)
        {
            $options['where']['district_id'] = $district_id;

            $options['order']['name'] = 'ASC';

            $output['ward_ids'] = $this->Ward->find('all', $options);
        }

        $data = $this->parser->parse($this->router->class . '/aj_list', $output);


        echo $data;
        exit();
    }

}

?>