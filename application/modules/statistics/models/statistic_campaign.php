<?php

if(!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Model
 * Function on Statistic_campaign
 * 
 * @package PenguinFW
 * @subpackage statistics
 * @version 1.0.0
 */
class Statistic_campaign extends MY_Model {

    function __construct()
    {
        parent::__construct();

        $this->db_table = 'statistic_campaigns';
    }

    public function call_service($params)
    {
        if(!$params)
        {
            echo -1;
            return;
        }

        ob_start();
        $ch = curl_init();
        $method = isset($params['method']) ? $params['method'] : "Create_Project";
        $user_name = isset($params['username']) ? $params['username'] : "campaign";
        $password = isset($params['password']) ? $params['password'] : "campaign@2013";
        $token = isset($params['token']) ? $params['token'] : "7f6a54b23682e349bd1ea208fea91aae";
        $application_name = isset($params['appname']) ? $params['appname'] : "ProjectService";
        $url = isset($params['url']) ? $params['url'] : "http://truecrm.ad.zing.vn/rest/Project/rest.php";

        $camp_id = $params['camp_id'];
        $camp_name = $params['camp_name'];
        $camp_start = date('Y-m-d', strtotime($params['camp_start']));
        $camp_end = date('Y-m-d', strtotime($params['camp_end']));
        $camp_sale = isset($params['camp_sale']) ? $params['camp_sale'] : 'hungtd';
        $camp_desc = isset($params['camp_desc']) ? $params['camp_desc'] : 'VNG';
        $camp_db_host = $params['camp_db_host'];
        $camp_db_name = $params['camp_db_name'];
        $camp_db_user = $params['camp_db_user'];
        $camp_db_pass = isset($params['camp_db_pass']) ? $params['camp_db_pass'] : ' ';

        $data = array(
            'user_auth' => array('user_name' => $user_name, 'password' => md5($password), 'token' => $token),
            'application_name' => $application_name,
            'id' => $camp_id,
            'name' => $camp_name,
            'date_start' => $camp_start,
            'data_end' => $camp_end,
            'sale' => $camp_sale,
            'description' => $camp_desc,
            'db_host' => $camp_db_host,
            'db_user' => $camp_db_user,
            'db_password' => $camp_db_pass,
            'db_name' => $camp_db_name
        );

        // set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        $post_data = 'method=' . $method . '&input_type=JSON&response_type=JSON';
        $jsonEncodedData = json_encode($data, false);
        $post_data = $post_data . "&rest_data=" . $jsonEncodedData;

        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

        $result = curl_exec($ch);
        ob_end_flush();
        curl_close($ch);
        
        $result = json_decode($result, TRUE);
     
        return $result['data'];
    }

}

?>