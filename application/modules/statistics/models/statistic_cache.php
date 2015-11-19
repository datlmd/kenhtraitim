<?php

if(!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 *
 * Model
 * Function on Statistic_cache
 *
 * @package PenguinFW
 * @subpackage statistics
 * @version 1.0.0
 */
class Statistic_cache extends MY_Model {

    private $campaign_id;
    private $_need_update;
    private $_need_create;
    private $_update_from;
    private $_now;

    function __construct()
    {
        parent::__construct();

        $this->db_table = 'statistic_caches';
        $this->_need_update = FALSE;
        $this->_need_create = FALSE;
        $this->_update_from = FALSE;
        $this->_now = strtotime('now 00:00:00');
    }

    public function set_campaign($campaign_id)
    {
        $this->campaign_id = $campaign_id;
    }

    public function update($config_id, &$data)
    {
//        if(!$this->_need_update)
//            return TRUE;
//        foreach($data as &$da)
//        {
//            $da[0] = strtotime($da[0]);
//        }

        $cache['data'] = json_encode($data);
        $cache['now'] = $this->_now;

        //count total
        $records = get_sub_array_by_keys($data, 1);
        $return_total = array_sum($records);
        $cache['total'] = $return_total;

        return $this->db->update($this->db_table, $cache, array('campaign_id' => $this->campaign_id, 'config_id' => $config_id));
    }

    public function add($config_id, &$data_add)
    {
        $query = $this->db->get_where($this->db_table, array('campaign_id' => $this->campaign_id, 'config_id' => $config_id));
        $cache = $query->row_array();

        if(!$cache)
            return FALSE;

        $data = json_decode($cache['data']);

        $add['data'] = json_encode(array_merge($data, $data_add));
        $add['now'] = $this->_now;

        //add totoal
        $records = get_sub_array_by_keys($data_add, 1);
        $return_total = array_sum($records);
        $add['total'] = $cache['total'] + $return_total;

        return $this->db->update($this->db_table, $add, array('campaign_id' => $this->campaign_id, 'config_id' => $config_id));
    }

    public function create($config_id, &$data)
    {
//        foreach($data as &$da)
//        {
//            $da[0] = strtotime($da[0]);
//        }

        $cache['data'] = json_encode($data);
        $cache['now'] = $this->_now;
        $cache['campaign_id'] = $this->campaign_id;
        $cache['config_id'] = $config_id;

        //count total
        $records = get_sub_array_by_keys($data, 1);
        $return_total = array_sum($records);
        $cache['total'] = $return_total;

        return $this->db->insert($this->db_table, $cache);
    }

    public function get_total($config_id)
    {
        $cache = array();

        if(!$config_id)
        {
            return FALSE;
        }

        $this->db->select('total');
        $query = $this->db->get_where($this->db_table, array('campaign_id' => $this->campaign_id, 'config_id' => $config_id));
        $cache = $query->row_array();

        if($cache)
            return $cache['total'];
        else
            return FALSE;
    }

    public function get($from, $to, $config_id)
    {
        $this->_now = strtotime($to . " +1 day");

        $cache = array();

        if(!$config_id)
        {
            return FALSE;
        }

        $query = $this->db->get_where($this->db_table, array('campaign_id' => $this->campaign_id, 'config_id' => $config_id));
        $cache = $query->row_array();

        if(!$cache)
        {
            $this->_need_create = TRUE;
            return FALSE;
        }

        $data = json_decode($cache['data']);

        //get subarray
        $date_arr = get_sub_array_by_keys($data, 0);

        $cache_start = array_search($from, $date_arr);
        $cache_end = array_search($to, $date_arr);
        $length = count($date_arr);
        $last_index = $length - 1;

        //if date not exist in cache
        if($cache_start === FALSE)
        {
            //can update
            $this->_need_update = TRUE;

            return FALSE;
        }
        elseif($cache_end === FALSE)
        {
            //can update
            $this->_need_update = TRUE;

            //date update
            $this->_update_from = date('d-m-Y', $cache['now']);

            //return data
            $return_data = &$data;

       
            //count total
            if($cache['total'] !== NULL)
                $return_total = $cache['total'];
            else
            {
                $records = get_sub_array_by_keys($return_data, 1);
                $return_total = array_sum($records);
            }

            return array('daily' => $return_data, 'total' => $return_total, 'update' => $this->_update_from);
        }
        else
        {

            $return_data = array_slice($data, $cache_start, ($cache_end - $cache_start + 1));
   
            //count total
            if($cache['total'] !== NULL && ($cache_end == $last_index && ($cache_end - $cache_start + 1) == $length))
                $return_total = $cache['total'];
            else
            {
                $records = get_sub_array_by_keys($return_data, 1);
                $return_total = array_sum($records);
            }

            //no need update
            $this->_need_update = FALSE;

            return array('daily' => $return_data, 'total' => $return_total, 'update' => FALSE);
        }
    }

    public function cache($config_id, $data)
    {
        if($this->_need_create)
        {
            $this->_need_create = FALSE;

            return $this->create($config_id, $data);
        }
        else if($this->_need_update)
        {
            $this->_need_update = FALSE;

            return $this->update($config_id, $data);
        }

        return FALSE;
    }

    public function refresh($config_id)
    {
        $this->db->delete($this->db_table, array('campaign_id' => $this->campaign_id, 'config_id' => $config_id));
    }

}

?>