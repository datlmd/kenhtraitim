<?php

if(!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_statistic_configs
 * ...
 * 
 * @package PenguinFW
 * @subpackage statistics
 * @version 1.0.0
 */
class Admin_statistic_configs extends MY_Controller {

    function __construct()
    {
        parent::__construct();

        $this->layout->set_layout('admin');

        $this->model_name = 'Statistic_config';

        $this->lang->load('generate', lang_web());
        $this->lang->load('statistics', lang_web());

        $this->load->model('Statistic_config');
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

//set last url
        set_last_url();

// set title
        $this->layout->set_title(lang('Statistic_config manager'));

//filter
        $filter_campaign_id = $this->input->get('campaign_id');
        if($filter_campaign_id)
        {
            $this->paginator['where']['campaign_id'] = $filter_campaign_id;
        }

// get admin_statistic_configs
        $this->paginator['order']['campaign_id'] = 'ASC';
        $this->paginator['order']['type'] = 'DESC';
        $admin_statistic_configs = $this->pagination(5);

        $data = array(
            'list_views' => $admin_statistic_configs,
//            'campaign_ids' => $this->Statistic_config->find('all', array('from' => 'statistic_campaigns', 'select' => 'id,name')),
            'total_records' => $this->count_record,
            'this_resource' => $this->router->class,
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'link_edit' => array(
                'Edit' => 'statistics/admin_statistic_configs/edit/'
            ),
            'pagination_link' => $this->getPaginationLink('/statistics/admin_statistic_configs/index/' . $cfn_id, 5)
        );

//        debug($data);
        $this->parser->parse($this->router->class . '/index', $data);
    }

    public function clear_cache()
    {
// check permission
        $this->PG_ACL('d');

//load cache model
        $this->load->model('Statistic_cache');

// get link redirect to manage page
//        $link_redirect = $this->router->fetch_module() . '/' . $this->router->class;
//        // add params redirect
//        if($this->input->post('p_redirect'))
//        {
//            $link_redirect .= $this->input->post('p_redirect');
//        }
//change last url
        $link_redirect = get_last_url('/statistics/admin_statistics/');

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
                $this->Statistic_cache->deleteRecord(array('config_id' => $list_delete_id));
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
        $this->layout->set_title(lang('View Statistic_config'));

        $admin_statistic_configs = $this->Statistic_config->get(array('id' => $id));

// set data to view
        $data = array(
            'data_view' => $admin_statistic_configs
        );

// parser
        $this->parser->parse($this->router->class . '/view', $data);
    }

    /**
     * Add data    
     */
    public function add($campaign_id = 0)
    {
// check permission
        $this->PG_ACL('w');

// set title
        $this->layout->set_title(lang('Add Statistic_config'));

// load library form
        $this->load->helper('form');
        $this->load->library('form_validation');

// form validate
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('value', 'Value', 'required');
        $this->form_validation->set_rules('kpi', 'KPI', 'trim|integer');
        $this->form_validation->set_rules('type', 'Type', 'trim|required');

// get post and check rule
        if($this->input->post() && $this->form_validation->run() == TRUE)
        {
// save data
            if($this->Statistic_config->create($this->input->post(), FALSE))
            {
                $this->session->set_flashdata('success_message', lang('Success'));
            }
            else
            {
                $this->session->set_flashdata('error_message', lang('Error'));
            }

// redirect

            redirect(get_last_url());
        }

//default value
        $default_value = "SELECT count(*) FROM users WHERE created >= '@startdate' AND created <= '@enddate'";


        $data = array(
            'campaign_ids' => $this->Statistic_config->find('all', array('from' => 'statistic_campaigns', 'select' => 'id,name', 'where' => array('id' => $campaign_id))),
            'default_value' => $default_value,
            'camp_id' => $campaign_id,
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
        $this->layout->set_title(lang('Edit Statistic_config'));

// load library form
        $this->load->helper('form');
        $this->load->library('form_validation');

//load js
        $this->layout->set_javascript(array(
            'jquery-ui.min.js',
            'dvd/config.js',
            'dvd/function.js',
            'dvd/validate.js',
        ));

// form validate
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('value', 'Value', 'required');
        $this->form_validation->set_rules('kpi', 'KPI', 'trim|integer');
        $this->form_validation->set_rules('type', 'Type', 'trim|required');

// get id
        $id = ($this->input->post('id')) ? $this->input->post('id') : $id;

// get admin_statistic_configs
        $admin_statistic_configs = $this->Statistic_config->get(array('id' => $id));

        if(!$admin_statistic_configs)
        {
            show_error(lang('Error params'));
        }

// get post and check rule
        if($this->input->post() && $this->form_validation->run() == TRUE)
        {
// save data
            if($this->Statistic_config->update($this->input->post(), array('id' => $id), FALSE))
            {
                $this->session->set_flashdata('success_message', lang('Success'));

//request refresh cache
                $this->load->model('Statistic_cache');
                $this->Statistic_cache->set_campaign($_POST['campaign_id']);
                $this->Statistic_cache->refresh($id);
            }
            else
            {
                $this->session->set_flashdata('error_message', lang('Error'));
            }

// redirect
//redirect('statistics/admin_statistic_configs');

            redirect(get_last_url());
        }

// data to view
        $data = array(
            'data_edit' => $admin_statistic_configs,
//            'campaign_ids' => $this->Statistic_config->find('all', array('from' => 'statistic_campaigns', 'select' => 'id,name', 'where' => array('id' => $admin_statistic_configs->campaign_id))),
        );

// parser
        $this->parser->parse($this->router->class . '/edit', $data);
    }

    /**
     * Delete
     */
    public function delete()
    {

        if($this->input->post())
        {
            $list_ids = $this->input->post('listViewId');

            $publish_type = $this->input->post('publish_type');

            if(!empty($list_ids))
            {
                if($publish_type == 1)
                {
                    // is_publish
                    // check permission
                    $this->PG_ACL('p');

                    foreach($list_ids as $id)
                    {
                        $this->_publish($id);
                    }
                }
                else if($publish_type == -1)
                {
                    // un publish
                    // check permission
                    $this->PG_ACL('p');

                    foreach($list_ids as $id)
                    {
                        $this->_publish($id, FALSE);
                    }
                }
                else
                {
                    // is delete
                    // check permission
                    $this->PG_ACL('d');

                    // delete all 
                    $this->deleteRecordOnListView(TRUE);
                } // end
            }
        }
    }

    /**
     * Delete record from database
     * View on delete list view
     * 
     * @param $is_delete
     * @param $is_restore
     */
    public function deleteRecordOnListView($is_delete = FALSE, $is_restore = FALSE)
    {
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

//request refresh cache
                $this->load->model('Statistic_cache');
                $this->Statistic_cache->set_campaign($_POST['campaign_id']);
                $this->Statistic_cache->refresh($list_delete_id);
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

    public function test_sql($campaign_id)
    {
        $this->layout->set_layout('empty');

        if(!isset($_POST['value']) || $_POST['value'] == '')
        {
            echo 0;
            exit();
        }

        $sql = $_POST['value'];

        $test = 0;

        try
        {
//config db
            $campaign = $this->Statistic_config->find('first_array', array('from' => 'statistic_campaigns', 'where' => array('id' => $campaign_id)));

//            $configs['hostname'] = $campaign['db_server'];
//            $configs['username'] = $campaign['db_username'];
//            $configs['password'] = base64_decode($campaign['db_password']);
//            $configs['database'] = $campaign['db_name'];
//            $configs['dbdriver'] = "mysql";
//
//            $dbcamp = $this->load->database($configs, TRUE);

            $sql = $this->set_up_sql($sql);

            $query = $this->db->query($sql);

            if($query == FALSE)
            {
                throw new Exception("Error query.<br/>Check your connection config or sql again!");
            }

            $result = $query->row_array();
            $result = array_values($result);
 
            if(isset($result[0]) && is_numeric($result[0]))
                $test = 1;
        }
        catch(Exception $ex)
        {
            $test = -1;
        }

        echo $test;
        exit();
    }

    private function set_up_sql($value)
    {
        $start = date('Y-m-d');
        $end = date('Y-m-d', strtotime('now + 1 year'));

        $value = str_replace('@startdate', $start, $value);
        $value = str_replace('@enddate', $end, $value);

        return $value;
    }

}

?>