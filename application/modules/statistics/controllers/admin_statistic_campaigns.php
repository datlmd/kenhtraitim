<?php

if(!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_statistic_campaigns
 * ...
 * 
 * @package PenguinFW
 * @subpackage statistics
 * @version 1.0.0
 */
class Admin_statistic_campaigns extends MY_Controller {

    function __construct()
    {
        parent::__construct();

        $this->layout->set_layout('admin');

        $this->model_name = 'Statistic_campaign';

        $this->lang->load('generate', lang_web());
        $this->lang->load('statistics', lang_web());

        $this->load->model('Statistic_campaign');
    }

    /**
     * List
     *
     * @params int $cfn_id
     */
    public function index($cfn_id = 0)
    {
        show_404();
        
        // check permission
        $this->PG_ACL('r');

        // set title
        $this->layout->set_title(lang('Statistic_campaign manager'));

        //edit by danhdvd piattos
        $this->_check_access_accounts();

        // get admin_statistic_campaigns
        $admin_statistic_campaigns = $this->pagination(5);

        if(is_mod())
        {
            $links = array(
                'Report' => array('no_slash' => 'statistics/admin_statistics/index?campaign_id='),
                'Edit' => 'statistics/admin_statistic_campaigns/edit/',
                'Config' => array('no_slash' => 'statistics/admin_statistic_configs/index?campaign_id='),
//                'Permission' => array('no_slash' => 'statistics/admin_statistic_permissions/?campaign_id='),
            );
        }
        else
        {
            $links = array(
                'Report' => array('no_slash' => 'statistics/admin_statistics/index?campaign_id='),
            );
        }

        $data = array(
            'list_views' => $admin_statistic_campaigns,
//        'total_records' => $this->count_record,
            'this_resource' => $this->router->class,
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'link_edit' => $links,
            'pagination_link' => $this->getPaginationLink('/statistics/admin_statistic_campaigns/index/' . $cfn_id, 5)
        );

        $this->parser->parse($this->router->class . '/index', $data);
    }

    private function _check_access_accounts()
    {
        $this->load->model('Statistic_permission');

        $camp_ids = $this->Statistic_permission->get_permited_camp_ids();

        if($camp_ids)
        {
            $this->paginator['where_in']['id'] = $camp_ids;
        }
        else
        {
            $this->paginator['where']['id'] = '';

            //annouce
//            $this->session->set_flashdata('error_message', lang("Sorry, you don't have any campaign access permission"));           
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
        $this->PG_ACL('w');

        // set title
        $this->layout->set_title(lang('Campaign Information'));

        $admin_statistic_campaigns = $this->Statistic_campaign->get(array('id' => $id));

        // set data to view
        $data = array(
            'data_view' => $admin_statistic_campaigns
        );

        // parser
        $this->parser->parse($this->router->class . '/view', $data);
    }

    /**
     * Add data    
     */
    public function add()
    {
        
        show_404();
        
        // check permission
        $this->PG_ACL('w');

        // set title
        $this->layout->set_title(lang('Add Statistic_campaign'));

        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');



        $this->layout->set_javascript(array(
            'jquery.ui.core.min.js',
            'jquery.ui.datepicker.min.js',
            'ajaxupload.js',
            'musics/upload.js',
        ));

        // set css to view
        $this->layout->set_rel(array(
            'jquery.ui.base.css',
            'jquery.ui.datepicker.css',
        ));

        // form validate
        $this->form_validation->set_rules('name', 'Name', 'required|is_unique[campaigns.name]|trim');
        $this->form_validation->set_rules('start_date', 'Start date', 'required|trim');
        $this->form_validation->set_rules('end_date', 'End date', 'required|trim');
        $this->form_validation->set_rules('ga_username', 'Ga username', 'required|trim');
        $this->form_validation->set_rules('ga_password', 'Ga password', 'required|trim');
        $this->form_validation->set_rules('avatar', 'Avatar', 'required|trim');
        $this->form_validation->set_rules('ga_id', 'Ga id', 'trim');
        $this->form_validation->set_rules('description', 'Description', 'trim');
        $this->form_validation->set_rules('db_username', 'Db username', 'required|trim');
        $this->form_validation->set_rules('db_password', 'Db password', 'trim');
        $this->form_validation->set_rules('db_server', 'Db server', 'required|trim');
        $this->form_validation->set_rules('db_name', 'Db name', 'required|trim');
        $this->form_validation->set_rules('saler', 'Saler', 'required|trim');

        // get post and check rule
        if($this->input->post() && $this->form_validation->run() == TRUE)
        {
            //format the date
            $_POST['start_date'] = date('Y-m-d', strtotime($_POST['start_date']));
            $_POST['end_date'] = date('Y-m-d', strtotime($_POST['end_date']));

            //ma hoa pass
            $_POST['db_password'] = base64_encode($_POST['db_password']);
            $_POST['ga_password'] = base64_encode($_POST['ga_password']);

            $saler = $this->input->post('saler');
            unset($_POST['saler']);
            // save data
            if(($id = $this->Statistic_campaign->create($this->input->post(), FALSE)))
            {
                //create core config items db
                $this->load->model('Statistic_config');
                $config_name_list = array(
                    'Login total',
                    'Unique login total',
                    'User generated content',
                    'Participant',
                    'Active users'
                );

                //default value
                $default_value = "SELECT count(*) FROM users WHERE created >= '@startdate' AND created <= '@enddate'";

                foreach($config_name_list as $config_name)
                {
                    $data_config = array(
                        'campaign_id' => $id,
                        'name' => $config_name,
                        'value' => $default_value,
                        'type' => 'Db',
                    );

                    $this->Statistic_config->create($data_config, FALSE);
                }

                //created core config ga items
                $config_name_list = array(
                    'Page Views' => 'pageviews',
                    'Visits' => 'visits',
                    'Visitors' => 'visitors',
                    'New Vistors' => 'newVisits',
                );

                foreach($config_name_list as $key => $config_name)
                {
                    $data_config = array(
                        'campaign_id' => $id,
                        'name' => $key,
                        'value' => $config_name,
                        'type' => 'Ga',
                    );

                    $this->Statistic_config->create($data_config, FALSE);
                }


                $this->session->set_flashdata('success_message', lang('Success'));

                //call CRM service
                $result = $this->Statistic_campaign->call_service(array(
                    'camp_id' => $id,
                    'camp_name' => $this->input->post('name'),
                    'camp_start' => $this->input->post('start_date'),
                    'camp_end' => $this->input->post('end_date'),
                    'camp_sale' => $saler,
                    'camp_desc' => $this->input->post('description'),
                    'camp_db_host' => $this->input->post('db_server'),
                    'camp_db_user' => $this->input->post('db_username'),
                    'camp_db_pass' => $this->input->post('db_password'),
                    'camp_db_name' => $this->input->post('db_name'),
                        ));

                if($result['error_code'] == 5000)
                {
                    $this->Statistic_campaign->call_service(array(
                        'camp_id' => $id,
                        'camp_name' => $this->input->post('name'),
                        'camp_start' => $this->input->post('start_date'),
                        'camp_end' => $this->input->post('end_date'),
                        'camp_sale' => 'hungtd',
                        'camp_desc' => $this->input->post('description'),
                        'camp_db_host' => $this->input->post('db_server'),
                        'camp_db_user' => $this->input->post('db_username'),
                        'camp_db_pass' => $this->input->post('db_password'),
                        'camp_db_name' => $this->input->post('db_name'),
                    ));
                }
            }
            else
            {
                $this->session->set_flashdata('error_message', lang('Error'));
            }

            // redirect
            redirect('statistics/admin_statistic_campaigns');
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
        $this->layout->set_title(lang('Edit Statistic_campaign'));

        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');


        $this->layout->set_javascript(array(
            'jquery.ui.core.min.js',
            'jquery.ui.datepicker.min.js',
            'ajaxupload.js',
            'musics/upload.js',
        ));

        // set css to view
        $this->layout->set_rel(array(
            'jquery.ui.base.css',
            'jquery.ui.datepicker.css',
        ));

        // form validate
        $this->form_validation->set_rules('name', 'Name', 'required|almost_unique[statistic_campaigns.name.id.' . $id . ']|trim');
        $this->form_validation->set_rules('start_date', 'Start date', 'required|trim');
        $this->form_validation->set_rules('end_date', 'End date', 'required|trim');
        $this->form_validation->set_rules('ga_username', 'Ga username', 'required|trim');
        $this->form_validation->set_rules('ga_password', 'Ga password', 'trim');
        $this->form_validation->set_rules('avatar', 'Avatar', 'required|trim');
        $this->form_validation->set_rules('ga_id', 'Ga id', 'trim');
        $this->form_validation->set_rules('description', 'Description', 'trim');
//        $this->form_validation->set_rules('db_username', 'Db username', 'required|trim');
//        $this->form_validation->set_rules('db_password', 'Db password', 'trim');
//        $this->form_validation->set_rules('db_server', 'Db server', 'required|trim');
//        $this->form_validation->set_rules('db_name', 'Db name', 'required|trim');

        // get id
        $id = ($this->input->post('id')) ? $this->input->post('id') : $id;

        // get admin_statistic_campaigns
        $admin_statistic_campaigns = $this->Statistic_campaign->get(array('id' => $id));
        $admin_statistic_campaigns->start_date = date('d-m-Y', strtotime($admin_statistic_campaigns->start_date));
        $admin_statistic_campaigns->end_date = date('d-m-Y', strtotime($admin_statistic_campaigns->end_date));


        if(!$admin_statistic_campaigns)
        {
            show_error(lang('Error params'));
        }

        // get post and check rule
        if($this->input->post() && $this->form_validation->run() == TRUE)
        {

            //format the date
            $_POST['start_date'] = date('Y-m-d', strtotime($_POST['start_date']));
            $_POST['end_date'] = date('Y-m-d', strtotime($_POST['end_date']));

            // save data
//            if($this->input->post('db_password') == '')
//            {
//                $_POST['db_password'] = $admin_statistic_campaigns->db_password;
//            }
//            else
//            {
//                $_POST['db_password'] = base64_encode($_POST['db_password']);
//            }

            if($this->input->post('ga_password') == '')
            {
                $_POST['ga_password'] = $admin_statistic_campaigns->ga_password;
            }
            else
            {
                $_POST['ga_password'] = base64_encode($_POST['ga_password']);
            }

            if($this->Statistic_campaign->update($this->input->post(), array('id' => $id), FALSE))
            {
                $this->session->set_flashdata('success_message', lang('Success'));
            }
            else
            {
                $this->session->set_flashdata('error_message', lang('Error'));
            }

            // redirect
            redirect('statistics/admin_statistic_campaigns/view/' . STATISTIC_CAMPAIGN_ID);
        }

        $data = array(
            'data_edit' => $admin_statistic_campaigns,
        );


        // parser
        $this->parser->parse($this->router->class . '/edit', $data);
    }

    /**
     * Delete
     */
    public function delete()
    {
        show_404();
        
        // check permission
        $this->PG_ACL('d');

        // get model name
        $model = $this->model_name;
        $this->load->model('Statistic_config');

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
        $link_redirect = 'statistics/admin_statistic_campaigns';

        // check post data from form
        if($this->input->post())
        {
            $list_delete_ids = $this->input->post('listViewId');

            if(empty($list_delete_ids))
            {
                $this->session->set_flashdata('error_message', lang('Error params'));
                redirect($link_redirect);
            }

            foreach($list_delete_ids as $list_delete_id)
            {
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

                //delete all configs of campaigns
                $this->Statistic_config->deleteRecord(array('campaign_id' => $list_delete_id));
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