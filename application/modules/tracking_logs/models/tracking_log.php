<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Model
 * Function on Tracking_log
 * 
 * @package PenguinFW
 * @subpackage tracking_logs
 * @version 1.0.0
 */
class Tracking_log extends MY_Model {

    function __construct() {
        parent::__construct();

        $this->db_table = 'tracking_logs';
    }

    //Ghi logs mọi hành động trên hệ thống
    function write_logs_access($message = '', $is_admin = false) {
        $file_name = 'log_access_' . date('Ymd') . '.log';
        if ($is_admin == true) {
            $file_name = 'admin_' . $file_name;
        }

        //Tên file lưu data
        $file_name_save_to_data = 'access/' . date('Y') . '/' . date('m') . '/' . date('d') . '/' . $file_name;
        $check_have_data_file = $this->get(array('file_name' => $file_name_save_to_data));
        if (empty($check_have_data_file)) {//Kiểm tra data  có file này chưa, nếu chưa thì ghi vào
            $data = array(
                'username' => '',
                'user_agents' => '',
                'referal_or_page' => '',
                'file_name' => $file_name_save_to_data
            );

            $this->create($data); //Lưu data để quản lý
        }
        $this->write_log_file($file_name, $message);
    }

    private function write_log_file($filename = 'error', $message = NULL) {
        $CI = & get_instance();
        $CI->load->helper('file');
        
//        $directory = FPENGUIN . "media/logs/access/" . date('Y') . '/';
//        if (!is_dir($directory)) {
//            mkdir($directory);
//        }
//
//        $directory = FPENGUIN . "media/logs/access/" . date('Y') . '/' . date('m') . '/';
//        if (!is_dir($directory)) {
//            mkdir($directory);
//        }

        $directory = FPENGUIN . "media/logs/access/" . date('Y') . '/' . date('m') . '/' . date('d') . '/';
        if (!is_dir($directory)) {
            mkdir($directory, 0777, TRUE);
        }

        if (is_array($message))
            $message = json_encode($message);
        $message = date('d/m/Y H:i:s') . ":\t$message" . ">>>>>" . "\n";
        write_file($directory . $filename, $message, 'a');
    }

}

?>