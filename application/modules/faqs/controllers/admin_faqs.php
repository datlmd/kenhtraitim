<?php

if(!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_faqs
 * ...
 * 
 * @package PenguinFW
 * @subpackage faqs
 * @version 1.0.0
 */
class Admin_faqs extends MY_Controller {

    function __construct()
    {
        parent::__construct();

        $this->layout->set_layout('admin');

        $this->model_name = 'Faq';

        $this->lang->load('generate', lang_web());
        $this->lang->load('faqs', lang_web());

        $this->load->model('Faq');
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
        $this->layout->set_title(lang('Faq manager'));

        // get admin_faqs
        $this->paginator['order']['status'] = "DESC";
        $this->paginator['order']['created'] = "DESC";
        $admin_faqs = $this->pagination(5);

//        $this->load->library('typography');
//        $this->typography->protect_braced_quotes = TRUE;
//
//        foreach($admin_faqs as $key => $faq)
//        {
//            if(isset($admin_faqs[$key]['answer']))
//                $admin_faqs[$key]['answer'] = strip_quotes($admin_faqs[$key]['answer']);
//        }


        //get extra params
        $extra_params = get_extra_params_from_url();
        
        $data = array(
            'list_views' => $admin_faqs,
            'this_resource' => $this->router->class,
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'link_edit' => array(
                'Answer' => 'faqs/admin_faqs/answer/',
                'Edit' => 'faqs/admin_faqs/edit/'
            ),
            'pagination_link' => $this->getPaginationLink('/faqs/admin_faqs/index/' . $cfn_id, 5, $extra_params)
        );
        
        $data['total_records'] = $this->count_record;

        $this->parser->parse($this->router->class . '/index', $data);
    }

    //answer
    public function answer($id)
    {
        // check permission
        $this->PG_ACL('w');

        // set title
        $this->layout->set_title(lang('Answer Faq'));

        // set javascript to view
        $this->layout->set_javascript(array(
            'ckeditor/ckeditor.js',
        ));

        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');

        // form validate
        $this->form_validation->set_rules('answer', 'Answer', 'trim|required');

        // get id
        $id = ($this->input->post('id')) ? $this->input->post('id') : $id;

        // get admin_faqs
        $admin_faqs = $this->Faq->get(array('id' => $id));

        if(!$admin_faqs)
        {
            show_error(lang('Error params'));
        }

        // get post and check rule
        if($this->input->post() && $this->form_validation->run() == TRUE)
        {
            // save data
            if($this->Faq->update($this->input->post(), array('id' => $id), TRUE))
            {
                $this->session->set_flashdata('success_message', lang('Success'));
            }
            else
            {
                $this->session->set_flashdata('error_message', lang('Error'));
            }

            // redirect
            redirect('faqs/admin_faqs');
        }

        // data to view
        $data = array(
            'data_edit' => $admin_faqs
        );

        // parser
        $this->parser->parse($this->router->class . '/answer', $data);
    }

    //aprove item
    public function approve()
    {
        // check permission
        $this->PG_ACL('w');

        //enable
        $data = array('status' => 1);

        // check post data from form
        if($this->input->post())
        {
            $list_delete_ids = $this->input->post('listViewId');

            if(empty($list_delete_ids))
            {
                $this->session->set_flashdata('error_message', lang('Error params'));

                redirect(base_url('faqs/admin_faqs'));
            }

            foreach($list_delete_ids as $list_delete_id)
            {
                $this->Faq->update($data, array('id' => $list_delete_id));
            }

            $this->session->set_flashdata('success_message', lang('Success'));
            redirect(base_url('faqs/admin_faqs'));
        }
        else
        {
            $this->session->set_flashdata('error_message', lang('Error params'));
            redirect(base_url('faqs/admin_faqs'));
        }
    }

    //aprove item
    public function disapprove()
    {
        // check permission
        $this->PG_ACL('w');

        //enable
        $data = array('status' => 0);

        // check post data from form
        if($this->input->post())
        {
            $list_delete_ids = $this->input->post('listViewId');

            if(empty($list_delete_ids))
            {
                $this->session->set_flashdata('error_message', lang('Error params'));

                redirect(base_url('faqs/admin_faqs'));
            }

            foreach($list_delete_ids as $list_delete_id)
            {
                $this->Faq->update($data, array('id' => $list_delete_id));
            }

            $this->session->set_flashdata('success_message', lang('Success'));
            redirect(base_url('faqs/admin_faqs'));
        }
        else
        {
            $this->session->set_flashdata('error_message', lang('Error params'));
            redirect(base_url('faqs/admin_faqs'));
        }
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
        $this->layout->set_title(lang('View Faq'));

        $admin_faqs = $this->Faq->get(array('id' => $id));

        // set data to view
        $data = array(
            'data_view' => $admin_faqs
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
        $this->layout->set_title(lang('Add Faq'));

        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');

        // form validate
        $this->form_validation->set_rules('name', 'Name', 'required');

        // get post and check rule
        if($this->input->post() && $this->form_validation->run() == TRUE)
        {
            // save data
            if($this->Faq->create($this->input->post(), TRUE))
            {
                $this->session->set_flashdata('success_message', lang('Success'));
            }
            else
            {
                $this->session->set_flashdata('error_message', lang('Error'));
            }

            // redirect
            redirect('faqs/admin_faqs');
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
        $this->layout->set_title(lang('Edit Faq'));

        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');

        // form validate
        $this->form_validation->set_rules('name', 'Name', 'required');

        // get id
        $id = ($this->input->post('id')) ? $this->input->post('id') : $id;

        // get admin_faqs
        $admin_faqs = $this->Faq->get(array('id' => $id));

        if(!$admin_faqs)
        {
            show_error(lang('Error params'));
        }

        // get post and check rule
        if($this->input->post() && $this->form_validation->run() == TRUE)
        {
            // save data
            if($this->Faq->update($this->input->post(), array('id' => $id), TRUE))
            {
                $this->session->set_flashdata('success_message', lang('Success'));
            }
            else
            {
                $this->session->set_flashdata('error_message', lang('Error'));
            }

            // redirect
            redirect('faqs/admin_faqs');
        }

        // data to view
        $data = array(
            'data_edit' => $admin_faqs
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