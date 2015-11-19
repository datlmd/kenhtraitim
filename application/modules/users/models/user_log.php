<?php

if(!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Model
 * Function on User_log
 * 
 * @package PenguinFW
 * @subpackage users
 * @version 1.0.0
 */
class User_log extends MY_Model {

    function __construct()
    {
        parent::__construct();

        $this->db_table = 'user_logs';
    }

    public function create($dataAll)
    {

        $data = $dataAll;

        // check empty data
        if(empty($data))
        {
            return FALSE;
        }

        $this->load->helper('date');

        // field default: created / modified / user_id
        $data['created'] = mdate('%Y-%m-%d %H:%i:%s', now());
        $data['modified'] = mdate('%Y-%m-%d %H:%i:%s', now());

        if(empty($data['user_id']) || $data['user_id'] < 0)
        {
            $data['user_id'] = $this->session->userdata('user_id');
        }

        if(empty($data['user_name']) || $data['user_name'] < 0)
        {
            $data['user_name'] = $this->session->userdata('user_username');
        }

        if(empty($data['user_agent']) || $data['user_agent'] < 0)
        {
            $this->load->library('mobile_detect');
            $data['user_agent'] = $this->mobile_detect->get_user_agent();
        }

        if(empty($data['user_ip']) || $data['user_ip'] < 0)
        {
            $data['user_ip'] = $this->input->ip_address();
        }

        // insert record
        if($this->db->insert($this->db_table, $data))
        {
            // get id
            return $this->db->insert_id();
        }

        return FALSE;
    }

}

?>