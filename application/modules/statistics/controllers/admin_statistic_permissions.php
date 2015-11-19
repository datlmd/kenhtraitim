<?php

if(!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_statistic_permissions
 * ...
 * 
 * @package PenguinFW
 * @subpackage statistics
 * @version 1.0.0
 */
class Admin_statistic_permissions extends MY_Controller {

    function __construct()
    {
        parent::__construct();

        $this->layout->set_layout('admin');

        $this->model_name = 'Statistic_permission';

        $this->lang->load('generate', lang_web());
        $this->lang->load('statistics', lang_web());

        $this->load->model('Statistic_permission');
    }

    /**
     * List
     *
     * @params int $cfn_id
     */
    public function index($campaign_id, $user_id = FALSE, $cfn_id = 0)
    {
        // check permission
        $this->PG_ACL('r');

        // set title
        $this->layout->set_title(lang('Statistic_permission manager'));

        // process data from form
        if($this->input->post() && $campaign_id)
        {
            $data_update = $this->input->post();

            // check data read/write/modify/publish/delete
            if(!empty($data_update['permission']))
            {

                // update permission new
                if($this->Statistic_permission->updatePermission($campaign_id, $data_update))
                {
                    $this->session->set_flashdata('success_message', lang('Success'));
                }
                else
                {
                    $this->session->set_flashdata('error_message', lang('Error'));
                }
                // redirect to new permission
                redirect(current_url());
            }
        }
        
        //get permission_campaign
        $per_camp = $this->Statistic_permission->get_permission_campaign($campaign_id);

        //get user
//        $accounts = $this->Statistic_permission->find('all', array('from' => 'users', 'select' => 'id, username'));

        //get all campaigns
//        $campaigns = $this->Statistic_permission->find('all', array('from' => 'statistic_campaigns', 'select' => 'id,name'));

        //get current permission
        $current_permissions = $this->Statistic_permission->getPermissions($campaign_id);

        $data = array(
            'users' => $per_camp,
            'current_user_id' => $user_id,
//            'campaigns' => $campaigns,
            'current_permissions' => $current_permissions,
            'this_resource' => $this->router->class,
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'link_edit' => array(
                'Edit' => 'statistics/admin_statistic_permissions/edit/'
            ),
            'pagination_link' => $this->getPaginationLink('/statistics/admin_statistic_permissions/index/' . $cfn_id, 5)
        );

        // set view
        $this->layout->set_javascript(array(
            'jquery-ui.min.js',
            'flexcroll.js'
        ));
        $this->layout->set_rel(array(
            'jquery.ui.base.css',
            'flexcroll.css'
        ));

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
        $this->layout->set_title(lang('View Statistic_permission'));

        $admin_statistic_permissions = $this->Statistic_permission->get(array('id' => $id));

        // set data to view
        $data = array(
            'data_view' => $admin_statistic_permissions
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
        $this->layout->set_title(lang('Add Statistic_permission'));

        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');

        // form validate
        $this->form_validation->set_rules('name', 'Name', 'required');

        // get post and check rule
        if($this->input->post() && $this->form_validation->run() == TRUE)
        {
            // save data
            if($this->Statistic_permission->create($this->input->post(), TRUE))
            {
                $this->session->set_flashdata('success_message', lang('Success'));
            }
            else
            {
                $this->session->set_flashdata('error_message', lang('Error'));
            }

            // redirect
            redirect('statistics/admin_statistic_permissions');
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
        $this->layout->set_title(lang('Edit Statistic_permission'));

        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');

        // form validate
        $this->form_validation->set_rules('name', 'Name', 'required');

        // get id
        $id = ($this->input->post('id')) ? $this->input->post('id') : $id;

        // get admin_statistic_permissions
        $admin_statistic_permissions = $this->Statistic_permission->get(array('id' => $id));

        if(!$admin_statistic_permissions)
        {
            show_error(lang('Error params'));
        }

        // get post and check rule
        if($this->input->post() && $this->form_validation->run() == TRUE)
        {
            // save data
            if($this->Statistic_permission->update($this->input->post(), array('id' => $id), TRUE))
            {
                $this->session->set_flashdata('success_message', lang('Success'));
            }
            else
            {
                $this->session->set_flashdata('error_message', lang('Error'));
            }

            // redirect
            redirect('statistics/admin_statistic_permissions');
        }

        // data to view
        $data = array(
            'data_edit' => $admin_statistic_permissions
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

    public function delete_record($list_delete_id)
    {
        // check permission
        $this->PG_ACL('d');

        // get model name
        $model = $this->model_name;

        // load model if load not yet
        if(!class_exists($model))
        {
            $this->load->model($model);
        }

        // get link redirect to manage page
        $link_redirect = $this->router->fetch_module() . '/' . $this->router->class;
        // add params redirect
        if($this->input->post('p_redirect'))
        {
            $link_redirect .= $this->input->post('p_redirect');
        }

        //change last url
        $link_redirect = get_last_url();

        // check post data from form
        if($list_delete_id)
        {
            if(empty($list_delete_id))
            {
                $this->session->set_flashdata('error_message', lang('Error params'));
                redirect($link_redirect);
            }

            // if exit field is_delete -> update is_delete = 1
            if($is_delete == TRUE)
            {
                // restore recycle bin -> update is_delete = 0
                if($is_restore == TRUE)
                {
                    $this->$model->delete(array('id' => $list_delete_id), TRUE);
                }
                else // delete record to recycle bin -> update is_delete = 1
                {
                    $this->$model->delete(array('id' => $list_delete_id));
                }
            }
            else // not exit field is_delete -> delete record
            {
                $this->$model->deleteRecord(array('id' => $list_delete_id));
            }


            $this->session->set_flashdata('success_message', lang('Success'));
            redirect($link_redirect);
        }
        else
        {
            $this->session->set_flashdata('error_message', lang('Error params'));
            redirect($link_redirect);
        }
    }

}

?>