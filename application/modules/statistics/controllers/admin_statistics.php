<?php

if(!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_comments
 * ...
 * 
 * @package PenguinFW
 * @subpackage Comment
 * @version 1.0.0
 * 
 * @property Comment $Comment
 */
class Admin_statistics extends MY_Controller {

    function __construct()
    {
        parent::__construct();

        $this->model_name = 'Statistic';

        $this->layout->set_layout('admin');

        $this->lang->load('generate', lang_web());

        $this->load->model('Statistic');
    }

    /**
     * LIST View
     * 
     * @param string $action index, restore
     * @param string $resource_name
     * @param int $cfn_id
     */
    private function _listView($action = 'index', $cfn_id = 0)
    {
//        // set javascript to view
//        $this->layout->set_javascript(array(
//            'jquery.ui.core.min.js',
//            'jquery.ui.datepicker.min.js'
//        ));
//
//        // set css to view
//        $this->layout->set_rel(array(
//            'jquery.ui.base.css',
//            'jquery.ui.datepicker.css'
//        ));

        //filter date
        $fitler_start = $this->input->get('from_date');
        $fitler_end = $this->input->get('to_date');

        //filter ga date
        $fitler_start_ga = $this->input->get('from_date_ga');
        $fitler_end_ga = $this->input->get('to_date_ga');



        $campaign_id = $this->input->get('campaign_id');

        //get kpis
        $kpis = array();
        $ga_kpis = array();
        $alert = FALSE;
        $campaign = array();


        if($campaign_id)
        {

            //load cache
            $this->load->model('Statistic_cache');
            $this->Statistic_cache->set_campaign($campaign_id);

            $campaign = $this->Statistic->find('first_array', array('from' => 'statistic_campaigns', 'where' => array('id' => $campaign_id)));

            //set default date filter
            $compare_start = date('Y-m-d', strtotime($fitler_start));
            $compare_end = date('Y-m-d', strtotime($fitler_end));
            $compare_start_ga = date('Y-m-d', strtotime($fitler_start_ga));
            $compare_end_ga = date('Y-m-d', strtotime($fitler_end_ga));

            if(!$fitler_start || $compare_start < $campaign['start_date'])
            {
                $fitler_start = $_GET['from_date'] = date('d-m-Y', strtotime($campaign['start_date']));
            }
            if(!$fitler_end || $compare_end > $campaign['end_date'])
            {
                $fitler_end = $_GET['to_date'] = date('d-m-Y', strtotime($campaign['end_date']));
            }
            if(!$fitler_start_ga || $compare_start_ga < $campaign['start_date'])
            {
                $fitler_start_ga = $_GET['from_date_ga'] = date('d-m-Y', strtotime($campaign['start_date']));
            }
            if(!$fitler_end_ga || $compare_end_ga > $campaign['end_date'])
            {
                $fitler_end_ga = $_GET['to_date_ga'] = date('d-m-Y', strtotime($campaign['end_date']));
            }


            //check filter date
            $compare_start = date('Y-m-d', strtotime($fitler_start));
            $compare_end = date('Y-m-d', strtotime($fitler_end));
            $compare_start_ga = date('Y-m-d', strtotime($fitler_start_ga));
            $compare_end_ga = date('Y-m-d', strtotime($fitler_end_ga));

            if($compare_start >= $compare_end || $compare_start_ga >= $compare_end_ga)
            {
                goto flag_ignore_report;
            }

            //improve 
            //if end date more than now, not get now
            $real_end = FALSE;
            $tomorrow = FALSE;
            $compare_now = date('Y-m-d');
            $compare_tomorrow = date('Y-m-d', strtotime('tomorrow'));

            if($compare_end >= $compare_now)
            {
                $real_end = $fitler_end;
                $today = date('d-m-Y');
                $fitler_end = date('d-m-Y', strtotime('yesterday'));

                if($compare_end >= $compare_tomorrow)
                {
                    $tomorrow = date('d-m-Y', strtotime('tomorrow'));
                }
            }

            //get ga kpi report
            try
            {
                //get GA report
                $ga_list = $this->Statistic->find('all', array('from' => 'statistic_configs', 'select' => 'id, name, value, kpi', 'where' => array('campaign_id' => $campaign_id, 'type' => 'Ga')));

                //get Ga values
                $ga_values = array();
                foreach($ga_list as $ga)
                {
                    $ga_values[] = $ga['value'];
                }

                //config
                $ga_kpi_report = FALSE;

                foreach($ga_list as $ga)
                {
                    if($ga['kpi'])
                    {
                        //checking cache
                        $ga_cache_kpi = $this->Statistic_cache->get_total($ga['id']);

                        if($ga_cache_kpi)
                        {

                            $ga_kpis[] = array(
                                'total_kpi' => $ga['kpi'],
                                'current_kpi' => $ga_cache_kpi,
                                'name' => $ga['name'],
                            );
                        }
                        else
                        {
                            if(!$ga_kpi_report)
                            {
                                $this->load->library('ga', array($campaign['ga_username'], base64_decode($campaign['ga_password']), $campaign['ga_id']));

                                //get kpi ga report
                                $ga_kpi_report = $this->ga->get_report($ga_values, $campaign['start_date'], $campaign['end_date']);
                            }

                            //get ga kpis
                            $ga_kpis[] = array(
                                'total_kpi' => $ga['kpi'],
                                'current_kpi' => $ga_kpi_report[$ga['value']],
                                'name' => $ga['name'],
                            );
                        }
                    }
                }
            }
            catch(Exception $ex)
            {

                //echo $ex;
                //$this->session->set_flashdata('error_message', lang('GA config is wrong!'));
                $alert = alert('Cannot connect to Google Analyst!<br/>Errors:' . $ex->getMessage());
            }


            //get db report
            $statistic_configs = $this->Statistic->find('all', array('from' => 'statistic_configs', 'select' => 'id, name, value, kpi', 'where' => array('campaign_id' => $campaign_id, 'type' => 'Db')));

            //config db
//            $configs['hostname'] = $campaign['db_server'];
//            $configs['username'] = $campaign['db_username'];
//            $configs['password'] = base64_decode($campaign['db_password']);
//            $configs['database'] = $campaign['db_name'];
//            $configs['dbdriver'] = "mysql";
//
//            $camps_db = $this->load->database($configs, TRUE);

            try
            {
                foreach($statistic_configs as $key => $db_sql)
                {

                    if($db_sql['value'] && $db_sql['kpi'])
                    {

                        //checking cache
                        $cache_kpi = $this->Statistic_cache->get_total($db_sql['id']);

                        //check today
                        //check if have null records
                        if($real_end)
                        {
                            //get data of today
                            $daily_today = $this->_get_daily_db_report($this->db, $db_sql['value'], $today, $today);

                            $cache_kpi += $daily_today[0][1];
                        }

                        if($cache_kpi)
                        {

                            $kpis[] = array(
                                'total_kpi' => $db_sql['kpi'],
                                'current_kpi' => $cache_kpi,
                                'name' => $db_sql['name'],
                            );
                        }
                        else
                        {
                            //get kpi db reports
                            $sql = $this->set_up_sql($db_sql['value'], $campaign['start_date'], $campaign['end_date']);

                            $query = $this->db->query($sql);

                            if($query == FALSE)
                            {
                                throw new Exception("Error query.<br/>Check your connection config or sql again!");
                            }

                            $result = $query->row_array();
                            $result = array_values($result);


                            if($result)
                            {
                                $kpis[] = array(
                                    'total_kpi' => $db_sql['kpi'],
                                    'current_kpi' => $result[0],
                                    'name' => $db_sql['name'],
                                );
                            }
                            else
                            {
                                throw new Exception("Error query.<br/>Check your connection config or sql again!");
                            }
                        }
                    }
                }
            }
            catch(Exception $ex)
            {
                $alert = alert('Cannot connect to Microsite Database!<br/>Errors:' . $ex->getMessage());
            }
        }

        flag_ignore_report:

        $cp_fields = array(
            'name' => 'TEXT',
            'avatar' => 'TEXT',
            'description' => 'TEXT',
            'start_date' => 'DATE',
            'end_date' => 'DATE'
        );

        $cps = array($campaign);

        // set data
        return array(
//            'campaign_id' => $campaign_id,
            'min_date' => isset($campaign['start_date']) ? date('d-m-Y', strtotime($campaign['start_date'])) : '',
            'max_date' => isset($campaign['end_date']) ? date('d-m-Y', strtotime($campaign['end_date'])) : '',
            'kpis' => $kpis,
            'ga_kpis' => $ga_kpis,
            'cp_list_views' => $cps,
            'cp_fields' => $cp_fields,
            'alert' => $alert,
            'cfn_id' => $cfn_id,
            'this_resource' => $this->router->class,
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
                //'campaign_ids' => $this->Statistic->find('all', array('from' => 'statistic_campaigns', 'select' => 'id,name', 'where' => array('id' => $campaign_id))),
        );
    }

    private function _listView_export_pdf($campaign_id, $fitler_start, $fitler_end, $fitler_start_ga, $fitler_end_ga, $action = 'index', $cfn_id = 0)
    {
        //get kpis
        $kpis = array();
        $ga_kpis = array();
        $alert = FALSE;
        $campaign = array();
        $ga_kpi_report = array();
        $statistics = array();
        $ga_statistics = array();

        if($campaign_id)
        {
            //load cache
            $this->load->model('Statistic_cache');
            $this->Statistic_cache->set_campaign($campaign_id);

            $campaign = $this->Statistic->find('first_array', array('from' => 'statistic_campaigns', 'where' => array('id' => $campaign_id)));

            //set default date filter
            $compare_start = date('Y-m-d', strtotime($fitler_start));
            $compare_end = date('Y-m-d', strtotime($fitler_end));
            $compare_start_ga = date('Y-m-d', strtotime($fitler_start_ga));
            $compare_end_ga = date('Y-m-d', strtotime($fitler_end_ga));

            if(!$fitler_start || $compare_start < $campaign['start_date'])
            {
                $fitler_start = date('d-m-Y', strtotime($campaign['start_date']));
            }
            if(!$fitler_end || $compare_end > $campaign['end_date'])
            {
                $fitler_end = date('d-m-Y', strtotime($campaign['end_date']));
            }
            if(!$fitler_start_ga || $compare_start_ga < $campaign['start_date'])
            {
                $fitler_start_ga = date('d-m-Y', strtotime($campaign['start_date']));
            }
            if(!$fitler_end_ga || $compare_end_ga > $campaign['end_date'])
            {
                $fitler_end_ga = date('d-m-Y', strtotime($campaign['end_date']));
            }


            //check filter date
            $compare_start = date('Y-m-d', strtotime($fitler_start));
            $compare_end = date('Y-m-d', strtotime($fitler_end));
            $compare_start_ga = date('Y-m-d', strtotime($fitler_start_ga));
            $compare_end_ga = date('Y-m-d', strtotime($fitler_end_ga));

            if($compare_start >= $compare_end || $compare_start_ga >= $compare_end_ga)
            {
                goto flag_ignore_report;
            }

            //improve 
            //if end date more than now, not get now
            $real_end = FALSE;
            $real_end_ga = FALSE;
            $compare_now = date('Y-m-d');
            $tomorrow = FALSE;
            $compare_tomorrow = date('Y-m-d', strtotime('tomorrow'));

            if($compare_end >= $compare_now)
            {
                $real_end = $fitler_end;
                $today = date('d-m-Y');
                $fitler_end = date('d-m-Y', strtotime('yesterday'));

                if($compare_end >= $compare_tomorrow)
                {
                    $tomorrow = date('d-m-Y', strtotime('tomorrow'));
                }
            }

            if($compare_end_ga >= $compare_now)
            {
                $real_end_ga = $fitler_end_ga;
                $fitler_end_ga = date('d-m-Y', strtotime('yesterday'));
            }

            //get ga kpi report
            try
            {
                //config
                $load_ga = FALSE;

                //get GA report
                $ga_list = $this->Statistic->find('all', array('from' => 'statistic_configs', 'select' => 'id, name, value, kpi', 'where' => array('campaign_id' => $campaign_id, 'type' => 'Ga')));

                //get Ga values
                $ga_values = array();
                foreach($ga_list as $ga)
                {
                    $ga_values[] = $ga['value'];
                }

                //config
                $ga_kpi_report = FALSE;

                foreach($ga_list as $ga)
                {
                    //get ga kpis
                    if($ga['kpi'])
                    {
                        //checking cache
                        $ga_cache_kpi = $this->Statistic_cache->get_total($ga['id']);

                        if($ga_cache_kpi)
                        {
                            $kpi = $ga['kpi'];
                            $achieve = $ga_cache_kpi;
                            $remain = ($kpi - $achieve) > 0 ? ($kpi - $achieve) : 0;
                            $ga_kpis[] = $this->draw_kpi_chart($ga['name'], $kpi, $achieve, $remain);
                        }
                        else
                        {
                            if(!$ga_kpi_report)
                            {
                                $this->load->library('ga', array($campaign['ga_username'], base64_decode($campaign['ga_password']), $campaign['ga_id']));
                                $load_ga = TRUE;

                                //get kpi ga report
                                $ga_kpi_report = $this->ga->get_report($ga_values, $campaign['start_date'], $campaign['end_date']);
                            }

                            $kpi = $ga['kpi'];
                            $achieve = $ga_kpi_report[$ga['value']];
                            $remain = ($kpi - $achieve) > 0 ? ($kpi - $achieve) : 0;
                            $ga_kpis[] = $this->draw_kpi_chart($ga['name'], $kpi, $achieve, $remain);
                        }
                    }
                }

                //get Ga values
                $report = FALSE;
                $result_report = FALSE;
                $metrics_report = FALSE;


                foreach($ga_list as $ga)
                {
                    $statistic = &$ga_statistics[];

                    //checking cache
                    $cache_data = $this->Statistic_cache->get(date('D, M j', strtotime($fitler_start_ga)), date('D, M j', strtotime($fitler_end_ga)), $ga['id']);

                    if($cache_data)
                    {
                        $daily = $cache_data['daily'];

                        //check if have null records
                        if($real_end_ga)
                        {
                            $null_records = $this->_get_null_records(date('d-m-Y'), $real_end_ga);

                            $daily = array_merge($daily, $null_records);
                        }

                        $statistic = array(
                            'id' => $ga['id'],
                            'name' => $ga['name'],
                            'value' => number_format($cache_data['total']),
                            'chart' => $this->draw_process_chart($daily),
                        );
                    }
                    else
                    {
                        if(!$report)
                        {
                            if($load_ga == FALSE)
                            {
                                $this->load->library('ga', array($campaign['ga_username'], base64_decode($campaign['ga_password']), $campaign['ga_id']));
                                $load_ga = TRUE;
                            }

                            //get kpi ga report
                            $report = $this->ga->get_daily_report($fitler_start_ga, $fitler_end_ga);
                            $result_report = $report['results'];
                            $metrics_report = $report['metrics'];
                        }

                        $statistic['id'] = $ga['id'];
                        $statistic['name'] = $ga['name'];
                        $statistic['value'] = number_format($metrics_report[$ga['value']]);

                        //get daily filter report chart datas
                        $ga_chart_data = array();

                        foreach($result_report as $date_report)
                        {
                            $metric = $date_report->getMetrics();

                            if($metric)
                                $ga_chart_data[] = array(date('D, M j', strtotime($date_report->getDate())), $metric[$ga['value']]);
                        }

                        //check if have null records
                        $daily = $ga_chart_data;

                        if($real_end_ga)
                        {
                            $null_records = $this->_get_null_records(date('d-m-Y'), $real_end_ga);

                            $daily = array_merge($ga_chart_data, $null_records);
                        }

                        $statistic['chart'] = $this->draw_process_chart($daily);
                    }
                }
            }
            catch(Exception $ex)
            {
                $alert = alert('Cannot connect to Google Analyst!<br/>Errors:' . $ex->getMessage());
            }


            //get db report
            $statistic_configs = $this->Statistic->find('all', array('from' => 'statistic_configs', 'select' => 'id, name, value, kpi', 'where' => array('campaign_id' => $campaign_id, 'type' => 'Db')));

            //config db
//            $configs['hostname'] = $campaign['db_server'];
//            $configs['username'] = $campaign['db_username'];
//            $configs['password'] = base64_decode($campaign['db_password']);
//            $configs['database'] = $campaign['db_name'];
//            $configs['dbdriver'] = "mysql";
//
//            $camps_db = $this->load->database($configs, TRUE);

            try
            {
                foreach($statistic_configs as $db_sql)
                {
                    $statistic = &$statistics[];

                    if($db_sql['value'])
                    {
                        if($db_sql['kpi'])
                        {
                            //checking cache
                            $cache_kpi = $this->Statistic_cache->get_total($db_sql['id']);

                            //check if have null records
                            if($real_end)
                            {
                                //get data of today
                                $daily_today = $this->_get_daily_db_report($this->db, $db_sql['value'], $today, $today);

                                $cache_kpi += $daily_today[0][1];
                            }

                            if($cache_kpi)
                            {
                                $kpi = $db_sql['kpi'];
                                $achieve = $cache_kpi;
                                $remain = ($kpi - $achieve) > 0 ? ($kpi - $achieve) : 0;
                                $kpis[] = $this->draw_kpi_chart($db_sql['name'], $kpi, $achieve, $remain);
                            }
                            else
                            {
                                //get kpi db reports
                                $sql = $this->set_up_sql($db_sql['value'], $campaign['start_date'], $campaign['end_date']);

                                $query = $this->db->query($sql);

                                if($query == FALSE)
                                {
                                    throw new Exception("Error query.<br/>Check your connection config or sql again!");
                                }

                                $result = $query->row_array();
                                $result = array_values($result);

                                if($result)
                                {
                                    $kpi = $db_sql['kpi'];
                                    $achieve = $result[0];
                                    $remain = ($kpi - $achieve) > 0 ? ($kpi - $achieve) : 0;
                                    $kpis[] = $this->draw_kpi_chart($db_sql['name'], $kpi, $achieve, $remain);
                                }
                                else
                                {
                                    throw new Exception("Error query.<br/>Check your connection config or sql again!");
                                }
                            }
                        }

                        //get db report daily
                        //checking cache
                        $cache_data = $this->Statistic_cache->get(date('D, M j', strtotime($fitler_start)), date('D, M j', strtotime($fitler_end)), $db_sql['id']);

                        if($cache_data)
                        {
                            $daily = $cache_data['daily'];

                            //check if have null records
                            $total_records = $cache_data['total'];
                            if($real_end)
                            {
                                //get data of today
                                $daily_today = $this->_get_daily_db_report($this->db, $db_sql['value'], $today, $today);

                                $total_records += $daily_today[0][1];

                                if($tomorrow)
                                    $null_records = $this->_get_null_records($tomorrow, $real_end);
                                else
                                    $null_records = array();

                                $daily = array_merge($daily, $daily_today, $null_records);
                            }

                            $statistic['id'] = $db_sql['id'];
                            $statistic['name'] = $db_sql['name'];
                            $statistic['value'] = number_format($total_records);
                            $statistic['chart'] = $this->draw_process_chart($daily);
                        }
                        else
                        {
                            //get filter db report
                            $sql = $this->set_up_sql($db_sql['value'], $fitler_start, $fitler_end);

                            $query = $this->db->query($sql);

                            if($query == FALSE)
                            {
                                throw new Exception("Error query.<br/>Check your connection config or sql again!");
                            }

                            $result = $query->row_array();
                            $result = array_values($result);
                            $daily = $daily_before = $this->_get_daily_db_report($this->db, $db_sql['value'], $fitler_start, $fitler_end);

                            //check if have null records
                            if($real_end)
                            {
                                $null_records = $this->_get_null_records(date('d-m-Y'), $real_end);

                                $daily = array_merge($daily_before, $null_records);
                            }

                            if($result)
                            {
                                $statistic['id'] = $db_sql['id'];
                                $statistic['name'] = $db_sql['name'];
                                $statistic['value'] = number_format($result[0]);
                                $statistic['chart'] = $this->draw_process_chart($daily);
                            }
                            else
                            {
                                $statistic['id'] = $db_sql['id'];
                                $statistic['name'] = $db_sql['name'];
                                $statistic['value'] = 0;
                            }
                        }
                    }
                }
            }
            catch(Exception $ex)
            {
                $alert = alert('Cannot connect to Microsite Database!<br/>Errors:' . $ex->getMessage());
            }
        }

        flag_ignore_report:

        $cp_fields = array(
            'name' => 'TEXT',
            'avatar' => 'TEXT',
            'description' => 'TEXT',
            'start_date' => 'DATE',
            'end_date' => 'DATE'
        );

        $ga_fields = array(
            'name' => 'TEXT',
            'value' => 'INT',
            'chart' => 'TEXT',
        );

        $fields = array(
            'name' => 'TEXT',
            'value' => 'INT',
            'chart' => 'TEXT',
        );

        $cps = array($campaign);

        //validate page break
        $total_db_configs = count($statistics);
        $total_ga_configs = count($ga_statistics);
        $total_db_kpis = count($kpis);
        $total_ga_kpis = count($ga_kpis);

        if($total_db_configs > 4 && $total_db_kpis > 4 || $total_db_configs > 5)
            $db_page_break = TRUE;
        else
            $db_page_break = FALSE;

        if($total_ga_configs > 4 || $total_ga_kpis > 4)
            $ga_page_break = TRUE;
        else
            $ga_page_break = FALSE;

        // set data
        return array(
            'campaign_id' => $campaign_id,
            'ga_page_break' => $ga_page_break,
            'db_page_break' => $db_page_break,
            'start_date' => $fitler_start,
            'end_date' => $real_end,
            'start_date_ga' => $fitler_start_ga,
            'end_date_ga' => $real_end_ga,
            'list_views' => $statistics,
            'fields' => $fields,
            'ga_list_views' => $ga_statistics,
            'ga_fields' => $ga_fields,
            'min_date' => isset($campaign['start_date']) ? date('d-m-Y', strtotime($campaign['start_date'])) : '',
            'max_date' => isset($campaign['end_date']) ? date('d-m-Y', strtotime($campaign['end_date'])) : '',
            'kpis' => $kpis,
            'ga_kpis' => $ga_kpis,
            'cp_list_views' => $cps,
            'cp_fields' => $cp_fields,
            'alert' => $alert,
            'cfn_id' => $cfn_id,
            'this_resource' => $this->router->class,
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
                //'campaign_ids' => $this->Statistic->find('all', array('from' => 'statistic_campaigns', 'select' => 'id,name', 'where' => array('id' => $campaign_id))),
        );
    }

    /**
     * LIST View
     * 
     * @param string $resource_name
     * @param int $cfn_id 
     */
    public function index($cfn_id = 0)
    {

        // check permission
        $this->PG_ACL('r');

        //edit by danhdvd check access
        $this->_check_access_accounts();

        // set javascript to view
        $this->layout->set_javascript(array(
            'jquery.ui.core.min.js',
            'jquery.ui.datepicker.min.js',
            'statistics/statistics.js'
        ));

        // set css to view
        $this->layout->set_rel(array(
            'jquery.ui.base.css',
            'jquery.ui.datepicker.css'
        ));

        // set title
        $this->layout->set_title(lang('Statistics manager'));

        // get list view
        $data = $this->_listView('index', $cfn_id);

        // set template
        $this->parser->parse($this->router->class . '/index', $data);

//        $CI = &get_instance();
//        $output_string = $CI->output->get_output();
//         debug($output_string);
//        $this->export_to_pdf($output_string);
        //set last url
        //$_SESSION[URL_LAST_SESS_NAME] = full_url();
        set_last_url();
    }

    public function clear_cache($campagin_id)
    {
        // check permission
        $this->PG_ACL('r');

        //edit by danhdvd check access
        $this->_check_access_accounts($campagin_id);

        $this->load->model('Statistic_cache');

        $this->Statistic_cache->deleteRecord(array('campaign_id' => $campagin_id));

        redirect('statistics/admin_statistics/index?campaign_id=' . $campagin_id);
    }

    private function _check_access_accounts($access_campaign = FALSE)
    {
        if(!$access_campaign)
            $access_campaign = isset($_GET['campaign_id']) ? $_GET['campaign_id'] : NULL;

        $this->load->model('Statistic_permission');

        if($this->Statistic_permission->check_permission($access_campaign) == FALSE)
        {
            //annouce
            $this->session->set_flashdata('error_message', lang("Sorry, you don't have this campaign access permission"));

            redirect('users/admin_users/dashboard');
        }
    }

    private function set_up_sql($value, $start = FALSE, $end = FALSE)
    {
        $start = $start ? date('Y-m-d 00:00:00', strtotime($start)) : date('Y-m-d 00:00:00', strtotime('now - 10 year'));
        $end = $end ? date('Y-m-d 23:59:59', strtotime($end)) : date('Y-m-d 23:59:59', strtotime('now + 10 year'));

        $value = str_replace('@startdate', $start, $value);
        $value = str_replace('@enddate', $end, $value);

        return $value;
    }

    private function _get_daily_db_report($db, $sql, $start_date, $end_date)
    {

        $max_points = 180;
        $day_seconds = 86400;

        //get dates report
        $reports = array();

        $str_start = strtotime($start_date);
        $str_end = strtotime($end_date);
        $subseconds = $str_end - $str_start;
        $subdays = ($subseconds) / (60 * 60 * 24);

        if($subdays > $max_points)
        {
            return FALSE;
        }

        try
        {
            for($i = $str_start; $i <= $str_end; $i += $day_seconds)
            {
                $date_i = date('Y-m-d', $i);

                $daily_sql = $this->set_up_sql($sql, $date_i, $date_i);

                $query = $db->query($daily_sql);

                if($query == FALSE)
                {
                    throw new Exception("Error query.<br/>Check your connection config or sql again!");
                }

                $result = $query->row_array();
                $result = array_values($result);
                if($result)
                    $reports[] = array(date('D, M j', $i), (int) $result[0]);
                else
                    $reports[] = array(date('D, M j', $i), 0);
            }
        }
        catch(Exception $ex)
        {
            $alert = alert('Cannot connect to Microsite Database!<br/>Errors:' . $ex->getMessage());
        }

        return $reports;
    }

    private function _get_null_records($start_date, $end_date)
    {
        $max_points = 180;
        $day_seconds = 86400;

        //get dates report
        $reports = array();

        $str_start = strtotime($start_date);
        $str_end = strtotime($end_date);
        $subseconds = $str_end - $str_start;
        $subdays = ($subseconds) / (60 * 60 * 24);

        if($subdays > $max_points)
        {
            return FALSE;
        }

        try
        {
            for($i = $str_start; $i <= $str_end; $i += $day_seconds)
            {
                $date_i = date('Y-m-d', $i);

                $reports[] = array(date('D, M j', $i), 0);
            }
        }
        catch(Exception $ex)
        {
            $alert = alert('Cannot connect to Microsite Database!<br/>Errors:' . $ex->getMessage());
        }

        return $reports;
    }

    public function ajax_get_ga_compare($campaign_id, $return = FALSE)
    {
        $this->layout->disable_layout();

        $ga_statistics = array();

        if($campaign_id)
        {
            $campaign = $this->Statistic->find('first_array', array('from' => 'statistic_campaigns', 'where' => array('id' => $campaign_id)));

            $fitler_start_ga = date('d-m-Y', strtotime($campaign['start_date']));
            $fitler_end_ga = date('d-m-Y', strtotime($campaign['end_date']));


            //check filter date
            $compare_start_ga = date('Y-m-d', strtotime($fitler_start_ga));
            $compare_end_ga = date('Y-m-d', strtotime($fitler_end_ga));

            //improve 
            //if end date more than now, not get now
            $real_end = FALSE;
            $compare_now = date('Y-m-d');
            if($compare_end_ga >= $compare_now)
            {
                $real_end = $fitler_end_ga;
                $fitler_end_ga = date('d-m-Y', strtotime('yesterday'));
            }


            //check cache
            $this->load->model('Statistic_cache');
            $this->Statistic_cache->set_campaign($campaign_id);

            //get ga report
            try
            {
                //get GA report
                $ga_list = $this->Statistic->find('all', array('from' => 'statistic_configs', 'select' => 'id, name, value, kpi', 'where' => array('campaign_id' => $campaign_id, 'type' => 'Ga')));

                //get Ga values
                $ga_values = array();
                $ga_cache_error = FALSE;
                $report = FALSE;
                $result_report = FALSE;
                $metrics_report = FALSE;
                $load_ga = FALSE;
                $config_names = array('Date');

                foreach($ga_list as $ga)
                {
                    $statistic = &$ga_statistics[];
                    $config_names[] = $ga['name'];

                    //checking cache
                    $cache_data = $this->Statistic_cache->get(date('D, M j', strtotime($fitler_start_ga)), date('D, M j', strtotime($fitler_end_ga)), $ga['id']);

                    if($cache_data)
                    {
                        //get daily filter report chart datas

                        $statistic = $cache_data['daily'];

                        //check if have null records
                        if($real_end)
                        {
                            $null_records = $this->_get_null_records(date('d-m-Y'), $real_end);

                            $statistic = array_merge($statistic, $null_records);
                        }
                    }
                    else
                    {
                        if(!$report)
                        {
                            if($load_ga == FALSE)
                            {
                                $this->load->library('ga', array($campaign['ga_username'], base64_decode($campaign['ga_password']), $campaign['ga_id']));
                                $load_ga = TRUE;
                            }

                            //get kpi ga report
                            $report = $this->ga->get_daily_report($fitler_start_ga, $fitler_end_ga);
                            $result_report = $report['results'];
                            $metrics_report = $report['metrics'];
                        }

                        //get daily filter report chart datas
                        $ga_chart_data = array();

                        foreach($result_report as $date_report)
                        {
                            $metric = $date_report->getMetrics();

                            if($metric)
                                $ga_chart_data[] = array(date('D, M j', strtotime($date_report->getDate())), $metric[$ga['value']]);
                        }

                        //check if have null records
                        $statistic = $ga_chart_data;

                        if($real_end)
                        {
                            $null_records = $this->_get_null_records(date('d-m-Y'), $real_end);

                            $statistic = array_merge($ga_chart_data, $null_records);
                        }
                    }
                }
            }
            catch(Exception $ex)
            {
//                echo $ex;
                //$this->session->set_flashdata('error_message', lang('GA config is wrong!'));
//                $alert = alert('Cannot connect to Google Analyst!<br/>Errors:' . $ex->getMessage());
                echo json_encode(array('error' => $ex));
                exit();
            }
        }

        //format data
        $compare_datas = array();

        $compare_datas[] = $config_names;
        $total_records = count($ga_statistics[0]);

        for($i = 0; $i < $total_records; $i++)
        {
            $compare_data = &$compare_datas[];
            $flag_header = FALSE;

            foreach($ga_statistics as $config)
            {
                if(!$flag_header)
                {
                    $compare_data[] = $config[$i][0];

                    $flag_header = TRUE;
                }

                $compare_data[] = $config[$i][1];
            }
        }

        if($return)
            return $compare_datas;
        else
        {
            echo json_encode($compare_datas);
            exit();
        }
    }

    public function ajax_get_ga_statistics($campaign_id, $fitler_start_ga, $fitler_end_ga)
    {
        $this->layout->disable_layout();

        $ga_statistics = array();

        if($campaign_id)
        {
            $campaign = $this->Statistic->find('first_array', array('from' => 'statistic_campaigns', 'where' => array('id' => $campaign_id)));

            //set default date filter
            $compare_start_ga = date('Y-m-d', strtotime($fitler_start_ga));
            $compare_end_ga = date('Y-m-d', strtotime($fitler_end_ga));

            if(!$fitler_start_ga || $compare_start_ga < $campaign['start_date'])
            {
                $fitler_start_ga = $_GET['from_date_ga'] = date('d-m-Y', strtotime($campaign['start_date']));
            }
            if(!$fitler_end_ga || $compare_end_ga > $campaign['end_date'])
            {
                $fitler_end_ga = $_GET['to_date_ga'] = date('d-m-Y', strtotime($campaign['end_date']));
            }

            //check filter date
            $compare_start_ga = date('Y-m-d', strtotime($fitler_start_ga));
            $compare_end_ga = date('Y-m-d', strtotime($fitler_end_ga));

            if($compare_start_ga >= $compare_end_ga)
            {
                goto flag_ignore_report;
            }


            //improve 
            //if end date more than now, not get now
            $real_end = FALSE;
            $compare_now = date('Y-m-d');
            if($compare_end_ga >= $compare_now)
            {
                $real_end = $fitler_end_ga;
                $fitler_end_ga = date('d-m-Y', strtotime('yesterday'));
            }


            //check cache
            $this->load->model('Statistic_cache');
            $this->Statistic_cache->set_campaign($campaign_id);

            //get ga report
            try
            {
                //get GA report
                $ga_list = $this->Statistic->find('all', array('from' => 'statistic_configs', 'select' => 'id, name, value, kpi', 'where' => array('campaign_id' => $campaign_id, 'type' => 'Ga')));

                //get Ga values
                $report = FALSE;
                $update_report = FALSE;
                $result_report = FALSE;
                $metrics_report = FALSE;
                $update_result_report = FALSE;
                $update_metrics_report = FALSE;
                $load_ga = FALSE;


                foreach($ga_list as $ga)
                {
                    $statistic = &$ga_statistics[];

                    //checking cache
                    $cache_data = $this->Statistic_cache->get(date('D, M j', strtotime($fitler_start_ga)), date('D, M j', strtotime($fitler_end_ga)), $ga['id']);

                    if($cache_data)
                    {
                        //update more reports
                        $add_ga_chart_data = FALSE;
                        if($cache_data['update'])
                        {
                            $update_start = $cache_data['update'];
                            $update_end = $fitler_end_ga;

                            if(!$update_report)
                            {
                                $this->load->library('ga', array($campaign['ga_username'], base64_decode($campaign['ga_password']), $campaign['ga_id']));
                                $load_ga = TRUE;
                                //get update kpi ga report
                                try
                                {
                                    $update_report = $this->ga->get_daily_report($update_start, $update_end);
                                    $update_result_report = $update_report['results'];
                                    $update_metrics_report = $update_report['metrics'];
                                }
                                catch(Exception $ex)
                                {
                                    
                                }
                            }

                            //get daily filter report chart datas
                            $add_ga_chart_data = array();
                            if($update_result_report)
                            {
                                foreach($update_result_report as $date_report)
                                {
                                    $metric = $date_report->getMetrics();

                                    if($metric)
                                        $add_ga_chart_data[] = array(date('D, M j', strtotime($date_report->getDate())), $metric[$ga['value']]);
                                }

                                $this->Statistic_cache->add($ga['id'], $add_ga_chart_data);
                            }
                        }

                        $daily = $cache_data['daily'];
                        if($add_ga_chart_data)
                        {
                            $daily = array_merge($daily, $add_ga_chart_data);
                        }

                        //check if have null records
                        if($real_end)
                        {
                            $null_records = $this->_get_null_records(date('d-m-Y'), $real_end);

                            $daily = array_merge($daily, $null_records);
                        }

                        $statistic = array(
                            'id' => $ga['id'],
                            'name' => $ga['name'],
                            'value' => number_format($cache_data['total']),
                            'chart' => json_encode($daily),
                        );
                    }
                    else
                    {
                        if(!$report)
                        {
                            if($load_ga == FALSE)
                            {
                                $this->load->library('ga', array($campaign['ga_username'], base64_decode($campaign['ga_password']), $campaign['ga_id']));
                                $load_ga = TRUE;
                            }

                            //get kpi ga report
                            $report = $this->ga->get_daily_report($fitler_start_ga, $fitler_end_ga);
                            $result_report = $report['results'];
                            $metrics_report = $report['metrics'];
                        }

                        $statistic['id'] = $ga['id'];
                        $statistic['name'] = $ga['name'];
                        $statistic['value'] = number_format($metrics_report[$ga['value']]);

                        //get daily filter report chart datas
                        $ga_chart_data = array();

                        foreach($result_report as $date_report)
                        {
                            $metric = $date_report->getMetrics();

                            if($metric)
                                $ga_chart_data[] = array(date('D, M j', strtotime($date_report->getDate())), $metric[$ga['value']]);
                        }

                        //check if have null records
                        $daily = $ga_chart_data;

                        if($real_end)
                        {
                            $null_records = $this->_get_null_records(date('d-m-Y'), $real_end);

                            $daily = array_merge($ga_chart_data, $null_records);
                        }

                        $statistic['chart'] = json_encode($daily);

                        //update cache
                        $this->Statistic_cache->cache($ga['id'], $ga_chart_data);
                    }
                }
            }
            catch(Exception $ex)
            {
//                echo $ex;
                //$this->session->set_flashdata('error_message', lang('GA config is wrong!'));
//                $alert = alert('Cannot connect to Google Analyst!<br/>Errors:' . $ex->getMessage());
            }
        }


        flag_ignore_report:

        $ga_fields = array(
            'name' => 'TEXT',
            'value' => 'INT',
            'chart' => 'TEXT',
        );

        // set data
        $data = array(
            'ga_list_views' => $ga_statistics,
            'this_resource' => $this->router->class,
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'ga_fields' => $ga_fields,
            'campaign_ids' => $this->Statistic->find('all', array('from' => 'statistic_campaigns', 'select' => 'id,name')),
        );

        echo $this->parser->parse($this->router->class . '/ga_list_view', $data);
        exit();
    }

    private function _format_numbers(&$datas)
    {
        foreach($datas as &$data)
        {
            $data[1] = number_format($data[1]);
        }
    }

    public function ajax_get_db_compare($campaign_id, $return = FALSE)
    {
        $this->layout->disable_layout();

        $statistics = array();

        if($campaign_id)
        {
            $campaign = $this->Statistic->find('first_array', array('from' => 'statistic_campaigns', 'where' => array('id' => $campaign_id)));

            //set default date filter
            $fitler_start = date('d-m-Y', strtotime($campaign['start_date']));
            $fitler_end = date('d-m-Y', strtotime($campaign['end_date']));

            //check filter date
            $compare_start = date('Y-m-d', strtotime($fitler_start));
            $compare_end = date('Y-m-d', strtotime($fitler_end));

            //improve 
            //if end date more than now, not get now
            $real_end = FALSE;
            $tomorrow = FALSE;
            $compare_now = date('Y-m-d');
            $compare_tomorrow = date('Y-m-d', strtotime('tomorrow'));

            if($compare_end >= $compare_now)
            {
                $real_end = $fitler_end;
                $today = date('d-m-Y');
                $fitler_end = date('d-m-Y', strtotime('yesterday'));

                if($compare_end >= $compare_tomorrow)
                {
                    $tomorrow = date('d-m-Y', strtotime('tomorrow'));
                }
            }

            //get db report
            $statistic_configs = $this->Statistic->find('all', array('from' => 'statistic_configs', 'select' => 'id, name, value, kpi', 'where' => array('campaign_id' => $campaign_id, 'type' => 'Db')));

            //check cache
            $this->load->model('Statistic_cache');
            $this->Statistic_cache->set_campaign($campaign_id);

            //config db
//            $configs['hostname'] = $campaign['db_server'];
//            $configs['username'] = $campaign['db_username'];
//            $configs['password'] = base64_decode($campaign['db_password']);
//            $configs['database'] = $campaign['db_name'];
//            $configs['dbdriver'] = "mysql";
//
//            $camps_db = $this->load->database($configs, TRUE);

            try
            {
                $config_names = array('Date');

                foreach($statistic_configs as $key => $db_sql)
                {
                    $statistic = &$statistics[];
                    $config_names[] = $db_sql['name'];

                    if(!$db_sql['value'])
                    {
                        $statistic = FALSE;
                    }
                    else
                    {
                        //checking cache
                        $cache_data = $this->Statistic_cache->get(date('D, M j', strtotime($fitler_start)), date('D, M j', strtotime($fitler_end)), $db_sql['id']);

                        if($cache_data)
                        {
                            $statistic = $cache_data['daily'];

                            //check if have null records
                            $total_records = $cache_data['total'];
                            if($real_end)
                            {
                                //get data of today
                                $daily_today = $this->_get_daily_db_report($this->db, $db_sql['value'], $today, $today);

                                $total_records += $daily_today[0][1];

                                if($tomorrow)
                                    $null_records = $this->_get_null_records($tomorrow, $real_end);
                                else
                                    $null_records = array();

                                $statistic = array_merge($statistic, $daily_today, $null_records);
                            }
                        }
                        else
                        {
                            $statistic = $this->_get_daily_db_report($this->db, $db_sql['value'], $fitler_start, $fitler_end);

                            //check if have null records
                            if($real_end)
                            {
                                $null_records = $this->_get_null_records(date('d-m-Y'), $real_end);

                                $statistic = array_merge($statistic, $null_records);
                            }
                        }
                    }
                }
            }
            catch(Exception $ex)
            {
                echo json_encode(array('error' => $ex));
                exit();
            }
        }
        else
        {
            $statistics = NULL;
        }

        //format data
        $compare_datas = array();

        $compare_datas[] = $config_names;
        $total_records = count($statistics[0]);

        for($i = 0; $i < $total_records; $i++)
        {
            $compare_data = &$compare_datas[];
            $flag_header = FALSE;

            foreach($statistics as $config)
            {
                if(!$flag_header)
                {
                    $compare_data[] = $config[$i][0];

                    $flag_header = TRUE;
                }

                $compare_data[] = $config[$i][1];
            }
        }

        if($return)
            return $compare_datas;
        else
        {
            echo json_encode($compare_datas);
            exit();
        }
    }

    public function ajax_get_db_statistics($campaign_id, $fitler_start, $fitler_end)
    {
        $this->layout->disable_layout();

        $statistics = array();

        if($campaign_id)
        {
            $campaign = $this->Statistic->find('first_array', array('from' => 'statistic_campaigns', 'where' => array('id' => $campaign_id)));

            //set default date filter
            $compare_start = date('Y-m-d', strtotime($fitler_start));
            $compare_end = date('Y-m-d', strtotime($fitler_end));

            if(!$fitler_start || $compare_start < $campaign['start_date'])
            {
                $fitler_start = $_GET['from_date'] = date('d-m-Y', strtotime($campaign['start_date']));
            }
            if(!$fitler_end || $compare_end > $campaign['end_date'])
            {
                $fitler_end = $_GET['to_date'] = date('d-m-Y', strtotime($campaign['end_date']));
            }

            //check filter date
            $compare_start = date('Y-m-d', strtotime($fitler_start));
            $compare_end = date('Y-m-d', strtotime($fitler_end));

            if($compare_start >= $compare_end)
            {
                goto flag_ignore_report;
            }

            //improve 
            //if end date more than now, not get now
            $real_end = FALSE;
            $tomorrow = FALSE;
            $compare_now = date('Y-m-d');
            $compare_tomorrow = date('Y-m-d', strtotime('tomorrow'));

            if($compare_end >= $compare_now)
            {
                $real_end = $fitler_end;
                $today = date('d-m-Y');
                $fitler_end = date('d-m-Y', strtotime('yesterday'));

                if($compare_end >= $compare_tomorrow)
                {
                    $tomorrow = date('d-m-Y', strtotime('tomorrow'));
                }
            }

            //get db report
            $statistic_configs = $this->Statistic->find('all', array('from' => 'statistic_configs', 'select' => 'id, name, value, kpi', 'where' => array('campaign_id' => $campaign_id, 'type' => 'Db')));

            //check cache
            $this->load->model('Statistic_cache');
            $this->Statistic_cache->set_campaign($campaign_id);

            //config db
//            $configs['hostname'] = $campaign['db_server'];
//            $configs['username'] = $campaign['db_username'];
//            $configs['password'] = base64_decode($campaign['db_password']);
//            $configs['database'] = $campaign['db_name'];
//            $configs['dbdriver'] = "mysql";
//
//            $camps_db = $this->load->database($configs, TRUE);

            try
            {

                foreach($statistic_configs as $key => $db_sql)
                {
                    $statistic = &$statistics[];

                    if(!$db_sql['value'])
                    {
                        $statistic['id'] = $db_sql['id'];
                        $statistic['name'] = $db_sql['name'];
                        $statistic['value'] = 0;
                    }
                    else
                    {
                        //checking cache
                        $cache_data = $this->Statistic_cache->get(date('D, M j', strtotime($fitler_start)), date('D, M j', strtotime($fitler_end)), $db_sql['id']);

                        if($cache_data)
                        {
                            //update more reports
                            $daily_add = FALSE;
                            if($cache_data['update'])
                            {
                                $update_start = $cache_data['update'];
                                $update_end = $fitler_end;

                                $daily_add = $this->_get_daily_db_report($this->db, $db_sql['value'], $update_start, $update_end);

                                $this->Statistic_cache->add($db_sql['id'], $daily_add);
                            }

                            $daily = $cache_data['daily'];
                            if($daily_add)
                            {
                                $daily = array_merge($daily, $daily_add);
                            }

                            //check if have null records
                            $total_records = $cache_data['total'];
                            if($real_end)
                            {
                                //get data of today
                                $daily_today = $this->_get_daily_db_report($this->db, $db_sql['value'], $today, $today);

                                $total_records += $daily_today[0][1];

                                if($tomorrow)
                                    $null_records = $this->_get_null_records($tomorrow, $real_end);
                                else
                                    $null_records = array();

                                $daily = array_merge($daily, $daily_today, $null_records);
                            }

                            $statistic['id'] = $db_sql['id'];
                            $statistic['name'] = $db_sql['name'];
                            $statistic['value'] = number_format($total_records);
                            $statistic['chart'] = json_encode($daily);
                        }
                        else
                        {
                            //get filter db report
                            $sql = $this->set_up_sql($db_sql['value'], $fitler_start, $fitler_end);

                            $query = $this->db->query($sql);

                            if($query == FALSE)
                            {
                                throw new Exception("Error query.<br/>Check your connection config or sql again!");
                            }

                            $result = $query->row_array();
                            $result = array_values($result);
                            $daily = $daily_before = $this->_get_daily_db_report($this->db, $db_sql['value'], $fitler_start, $fitler_end);

                            //check if have null records
                            if($real_end)
                            {
                                $null_records = $this->_get_null_records(date('d-m-Y'), $real_end);

                                $daily = array_merge($daily_before, $null_records);
                            }

                            if($result)
                            {
                                $statistic['id'] = $db_sql['id'];
                                $statistic['name'] = $db_sql['name'];
                                $statistic['value'] = number_format($result[0]);
                                $statistic['chart'] = json_encode($daily);
                            }
                            else
                            {
                                $statistic['id'] = $db_sql['id'];
                                $statistic['name'] = $db_sql['name'];
                                $statistic['value'] = 0;
                            }

                            //update cache
                            $this->Statistic_cache->cache($db_sql['id'], $daily_before);
                        }
                    }
                }
            }
            catch(Exception $ex)
            {
                $statistic['id'] = $db_sql['id'];
                $statistic['name'] = $db_sql['name'];
                $statistic['value'] = 0;
            }
        }
        else
        {
            $statistics = NULL;
        }

        flag_ignore_report:

        $fields = array(
            'name' => 'TEXT',
            'value' => 'INT',
            'chart' => 'TEXT',
        );

        // set data
        $data = array(
            'list_views' => $statistics,
            'this_resource' => $this->router->class,
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $fields,
        );

        echo $this->parser->parse($this->router->class . '/list_view', $data);
        exit();
    }

    public function ajax_get_db_kpis($campaign_id, $fitler_start, $fitler_end)
    {
        $this->layout->disable_layout();

        $kpis = array();

        if($campaign_id)
        {
            $campaign = $this->Statistic->find('first_array', array('from' => 'statistic_campaigns', 'where' => array('id' => $campaign_id)));

            //check filter date
            $compare_start = date('Y-m-d', strtotime($fitler_start));
            $compare_end = date('Y-m-d', strtotime($fitler_end));

            if($compare_start >= $compare_end)
            {
                goto flag_ignore_report;
            }

            //get db report
            $statistic_configs = $this->Statistic->find('all', array('from' => 'statistic_configs', 'select' => 'id, name, value, kpi', 'where' => array('campaign_id' => $campaign_id, 'type' => 'Db')));

            //config db
//            $configs['hostname'] = $campaign['db_server'];
//            $configs['username'] = $campaign['db_username'];
//            $configs['password'] = base64_decode($campaign['db_password']);
//            $configs['database'] = $campaign['db_name'];
//            $configs['dbdriver'] = "mysql";
//
//            $camps_db = $this->load->database($configs, TRUE);

            try
            {

                foreach($statistic_configs as $key => $db_sql)
                {
                    $statistic = &$statistics[];

                    if(!$db_sql['value'])
                    {
                        $statistic['id'] = $db_sql['id'];
                        $statistic['name'] = $db_sql['name'];
                        $statistic['value'] = 0;
                    }
                    else
                    {
                        //get kpi db reports
                        $sql = $this->set_up_sql($db_sql['value'], $campaign['start_date'], $campaign['end_date']);

                        $query = $this->db->query($sql);

                        if($query == FALSE)
                        {
                            throw new Exception("Error query.<br/>Check your connection config or sql again!");
                        }

                        $result = $query->row_array();
                        $result = array_values($result);

                        if($result)
                        {

                            if($db_sql['kpi'])
                            {
                                $kpis[] = array(
                                    'total_kpi' => $db_sql['kpi'],
                                    'current_kpi' => $result[0],
                                    'name' => $db_sql['name'],
                                );
                            }
                        }
                    }
                }
            }
            catch(Exception $ex)
            {
                $alert = alert('Cannot connect to Microsite Database!<br/>Errors:' . $ex->getMessage());
            }
        }

        flag_ignore_report:

        // set data
        $data = array(
            'kpis' => $kpis,
        );

        echo $this->parser->parse($this->router->class . '/db_kpi_view', $data);
        exit();
    }

    public function export_to_pdf($campaign_id, $fitler_start, $fitler_end, $fitler_start_ga, $fitler_end_ga)
    {

        // check permission
        $this->PG_ACL('r');

        //edit by danhdvd check access
        $this->_check_access_accounts($campaign_id);

        require_once(FPENGUIN . APPPATH . "third_party/dompdf/dompdf_config.inc.php");
        require_once (FPENGUIN . APPPATH . "third_party/g_chart_php/gChart.php");

        $this->load->helper('utf8');
//        $output = utf8_raw_url_decode($_POST['output']);
        //set data 
//        $_GET['campaign_id'] = 11;
//        $_GET['from_date'] = ''

        $data = $this->_listView_export_pdf($campaign_id, $fitler_start, $fitler_end, $fitler_start_ga, $fitler_end_ga);


        $this->layout->set_layout('empty');
        $output = $this->parser->parse($this->router->class . '/pdf', $data);
//
        $dompdf = new DOMPDF();
        $dompdf->set_paper('a2', 'portrait');
        $dompdf->load_html($output);
        $dompdf->render();
        $dompdf->stream("statistics_" . $campaign_id . "_" . date('d_m_Y') . ".pdf");

        echo 1;
        exit();
    }

    public function draw_compare_chart_type($type, $campaign_id)
    {
        require_once (FPENGUIN . APPPATH . "third_party/g_chart_php/gChart.php");

        $data = FALSE;

        if($type == 'ga')
            $data = $this->ajax_get_ga_compare($campaign_id, TRUE);
        else
            $data = $this->ajax_get_db_compare($campaign_id, TRUE);

        return $this->draw_compare_chart($data);
    }

    public function draw_compare_chart($data)
    {
        //colors
        $colors = array("0000FF", "FF0000", "FFA500", "008000", "800080", "00CED1", "EE82EE");

        //label percents
        $label = get_sub_array_by_keys($data, 0);
        array_shift($label);

        $lineChart = new gLineChart(1000, 300);

//        //set legends
        $legends = $data[0];
        array_shift($legends);

        //get total config
        $total_configs = count($legends);

        //add data
        array_shift($data);
        foreach($data as &$record)
        {
            array_shift($record);
        }

        $chm = '';
        $chls = '';
        for($i = 0; $i < $total_configs; $i++)
        {
            $config = get_sub_array_by_keys($data, $i);
            $lineChart->addDataSet($config);

            $chm .= "o,$colors[$i],$i,-1,7";

            if($i < $total_configs - 1)
                $chm .= '|';

            $chls .= "3";

            if($i < $total_configs - 1)
                $chls .= '|';
        }
        //set chart marker
        $lineChart->setProperty('chm', $chm);

        //set line style
        $lineChart->setProperty('chls', $chls);

        $lineChart->setLegend($legends);
        $lineChart->setColors($colors);

        //set chart lables
        $max_record = max(max($data));
        $min_record = min(min($data));
        $max_record = $this->_get_round_upper_number($max_record);
        $min_record = $this->_get_round_lower_number($min_record);

        //set range
        if($min_record != $max_record)
        {
            $lineChart->setDataRange($min_record, $max_record);
            $lineChart->addAxisRange(1, $min_record, $max_record);
        }
        else if($max_record == 0)
        {
            $lineChart->setDataRange(-1, 1);
            $lineChart->addAxisRange(1, -1, 1);
        }

        $total_records = count($data);
        $show_lables = array();

        $show_label_pos = array(0, 0.25, 0.5, 0.75, 1);
        $total_label_indexs = $total_records - 1;
        foreach($show_label_pos as $pos)
        {
            $index = round($pos * $total_label_indexs);
            $show_lables[0][] = $label[$index];
        }

        $lineChart->addAxisLabel(0, $show_lables[0]);
        $sub_record = $max_record - $min_record;
        $y_pos = array(
            round($sub_record * 0.25),
            round($sub_record * 0.5),
            round($sub_record * 0.75),
        );
        $lineChart->setProperty('chxp', "0,0,25,50,75,100|1,0,$y_pos[0],$y_pos[1],$y_pos[2],$max_record");

        $lineChart->setVisibleAxes(array('x', 'y'));

        $lineChart->setGridLines(0, 25, 1, 0);
        $lineChart->setProperty('chxs', '1,808080,11,0,t|0,058dc7,11,-1');

        $lineChart->renderImage(GCHARTPHP_REQUEST_POST);
    }

    private function _get_round_lower_number($number)
    {
        $zeros = pow(10, (strlen((string) $number) - 1));

        $lower = round($number / $zeros) * $zeros;

        return $lower;
    }

    private function _get_round_upper_number($number)
    {
        $zeros = pow(10, (strlen((string) $number) - 1));

        $upper = ceil($number / $zeros) * $zeros;

        return $upper;
    }

    public function draw_kpi_chart($title, $kpi, $achieve, $remain)
    {
        //label percents
        $achieve_percent = round($achieve / $kpi * 100) < 100 ? round($achieve / $kpi * 100) . "%" : "100%";
        $achieve_percent = ($achieve_percent == "0%") ? NULL : $achieve_percent;
        $remain_percent = $achieve_percent == 100 ? NULL : (100 - $achieve_percent) . "%";

        $piChart = new gPieChart();
        $piChart->addDataSet(array(0, $achieve, $remain));
        $piChart->setLegend(array("Kpi : " . number_format($kpi), "Achieve : " . number_format($achieve), "Remain : " . number_format($remain)));
        $piChart->setLabels(array(NULL, $remain_percent, $achieve_percent));
        $piChart->setColors(array('003A88', '058dc7', 'ADD8E6'));
        $piChart->setTitle($title);
        $piChart->setProperty('chp', -1.57);

        return $piChart->getUrl();
    }

    public function draw_process_chart($data)
    {
        //label percents
        $record = get_sub_array_by_keys($data, 1);
        $label = get_sub_array_by_keys($data, 0);
        $total_records = count($record);

        $lineChart = new gLineChart(1000, 200);
        $lineChart->addDataSet($record);

//        $lineChart->setLegend(array("Records"));
        //set chart marker
        $lineChart->setProperty('chm', 'o,058dc7,0,-1,9');

        //set line style
        $lineChart->setProperty('chls', '4');

        //set chart lables
        $show_lables = array();
//        sort($record, SORT_NUMERIC);

        $show_label_pos = array(0, 0.25, 0.5, 0.75, 1);
        $total_label_indexs = $total_records - 1;
        foreach($show_label_pos as $pos)
        {
            $index = round($pos * $total_label_indexs);
            $show_lables[0][] = $label[$index];
            $show_lables[1][] = number_format($record[$index]);
        }

        //set title
        $max = max($record);
        $min = min($record);
        $max = $this->_get_round_upper_number($max);
        $min = $this->_get_round_lower_number($min);
        $sub = $max - $min;
        $y_pos = array(
            round($sub * 0.25),
            round($sub * 0.5),
            round($sub * 0.75),
        );

        //set range
        if($min != $max)
        {
            $lineChart->setDataRange($min, $max);
            $lineChart->addAxisRange(1, $min, $max);
        }
        else if($max == 0)
        {
            $lineChart->setDataRange(-1, 1);
            $lineChart->addAxisRange(1, -1, 1);
        }

        $lineChart->addAxisLabel(0, $show_lables[0]);
//        $lineChart->addAxisLabel(1, $show_lables[1]);

        $lineChart->setProperty('chxp', "0,0,25,50,75,100|1,0,$y_pos[0],$y_pos[1],$y_pos[2],$max");

        $lineChart->setColors(array("058dc7"));
        $lineChart->setVisibleAxes(array('x', 'y'));

        $lineChart->setGridLines(0, 25, 1, 0);
        $lineChart->setProperty('chxs', '1,808080,11,0,t|0,058dc7,11,-1');

        //set fill
        $lineChart->addLineFill('B', 'DFF4FF', 0, 0);

        return $lineChart->getUrl();
    }

}

?>