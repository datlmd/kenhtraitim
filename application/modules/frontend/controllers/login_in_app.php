<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login_in_app extends MY_Controller{
    function __construct() {
        parent::__construct();
        $this->lang->load('generate', lang_web());
        $this->layout->disable_layout();
        $this->load->model("users/user");
    }
    
    public function login_in_zingme(){
        header('Content-Type: text/html; charset=utf-8');
        
        $this->load->library('Zing_me');
        $Zing_me = new Zing_me();
        $User_info = $Zing_me->get_info_user_logged_in();
//        debug($User_info);

        //Xóa dữ liệu phiên làm việc trước
        $this->session->unset_userdata('user_username');
        $this->session->unset_userdata('user_id');
        
        if (isset($User_info['username']) && $User_info['username'] != "") {

            $this->load->model('users/User');
            $user_data = $this->User->get_by_username($User_info['username']);
            
            if (!$user_data) {
                // chưa có user trong DB
                $user_data = array(
                    'username' => $User_info['username'],
                    'password' => 'g3vng1!223#',
                    'full_name' => $User_info['displayname'],
                    'login_ip' => $this->input->ip_address(),
                    'login_created' => date('Y/m/d', time()),
                    'register_ip' => $this->input->ip_address(),
                    'dob' => $Zing_me->get_dob_user_logged_in(),
                    'gender_id' => $Zing_me->get_gender_user_logged_in(),
                );

                $id_user = $this->User->create($user_data);
                if ($id_user != FALSE) {
                    $this->session->set_userdata('user_id', $id_user);
                    $this->session->set_userdata('user_username', $user_data['username']);
                    $this->session->set_userdata('user_fullname', $user_data['full_name']);
                }
            } else {
                //da co user trong DB
                $this->session->set_userdata('user_id', $user_data->id);
                $this->session->set_userdata('user_username', $user_data->username);
                $this->session->set_userdata('user_fullname', $user_data->full_name);
            }
        }
        
        redirect('frontend');
    }
}