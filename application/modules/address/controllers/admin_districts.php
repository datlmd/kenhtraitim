<?php

if(!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_districts
 * ...
 * 
 * @package PenguinFW
 * @subpackage address
 * @version 1.0.0
 */
class Admin_districts extends MY_Controller {

    function __construct()
    {
        parent::__construct();

        $this->layout->set_layout('admin');

        $this->model_name = 'District';

        $this->lang->load('generate', lang_web());
        $this->lang->load('address', lang_web());

        $this->load->model('District');
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
        $this->layout->set_title(lang('District manager'));

        // get admin_districts
        $this->paginator['leftjoin']['regions'] = 'districts.region_id = regions.id';
        $this->paginator['select'] = 'districts.*, regions.name as province_id';
        $admin_districts = $this->pagination(5);

        $data = array(
            'list_views' => $admin_districts,
            'total_records' => $this->count_record,
            'this_resource' => $this->router->class,
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'link_edit' => array(
                'Edit' => 'address/admin_districts/edit/'
            ),
            'pagination_link' => $this->getPaginationLink('/address/admin_districts/index/' . $cfn_id, 5)
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
        $this->layout->set_title(lang('View District'));

        $admin_districts = $this->District->get(array('id' => $id));

        // set data to view
        $data = array(
            'data_view' => $admin_districts
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
        $this->layout->set_title(lang('Add District'));

        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('Province');

        // form validate
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('province_id', 'Province', 'required');

        // get post and check rule
        if($this->input->post() && $this->form_validation->run() == TRUE)
        {
            $_POST['status_id'] = 1;
            $_POST['order'] = 100;
            
            // save data
            if($this->District->create($this->input->post(), TRUE))
            {
                $this->session->set_flashdata('success_message', lang('Success'));
            }
            else
            {
                $this->session->set_flashdata('error_message', lang('Error'));
            }

            // redirect
            redirect('address/admin_districts');
        }

        $data = array(
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
        $this->layout->set_title(lang('Edit District'));

        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('Province');

        // form validate
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('province_id', 'Province', 'required');

        // get id
        $id = ($this->input->post('id')) ? $this->input->post('id') : $id;

        // get admin_districts
        $admin_districts = $this->District->get(array('id' => $id));

        if(!$admin_districts)
        {
            show_error(lang('Error params'));
        }

        // get post and check rule
        if($this->input->post() && $this->form_validation->run() == TRUE)
        {
            // save data
            if($this->District->update($this->input->post(), array('id' => $id), TRUE))
            {
                $this->session->set_flashdata('success_message', lang('Success'));
            }
            else
            {
                $this->session->set_flashdata('error_message', lang('Error'));
            }

            // redirect
            redirect('address/admin_districts');
        }

        // data to view
        $data = array(
            'data_edit' => $admin_districts,
            'province_ids' => $this->Province->find('all'),
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

    public function aj_get($region_id = FALSE)
    {
        // check permission
        $this->PG_ACL('d');

        //disable layout
        $this->layout->disable_layout();

        $options = NULL;
        $output = array();

        if($region_id)
        {
            $options['where']['region_id'] = $region_id;
            $options['order']['name'] = 'ASC';

            $output['district_ids'] = $this->District->find('all', $options);
        }

        $data = $this->parser->parse($this->router->class . '/aj_list', $output);

        echo $data;
        exit();
    }

}

?>