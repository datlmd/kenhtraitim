<?php

if(!defined('BASEPATH'))
exit('No direct script access allowed');

/**
* PENGUIN FrameWork
* @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 *
 * Controller Frontend
 * ...
 *
 * @package PenguinFW
 * @subpackage Frontend
 * @version 1.0.0
 *
 * @property Article_category       $Article_category
 */
class Loginxsso extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->lang->load('generate', lang_web());
    }

    //Get real ip
    public function getRealIp()
    {
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
        {
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
        {
            $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        else
        {
            $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public function loginsucces()
    {
        $return = 'index';
        if(!empty($_GET["return"]))
            $return = $_GET["return"];
        //save user log
        $this->load->model('Users/User_log');
        $data = array(
            'user_name' => $this->session->userdata('user_username') ? $this->session->userdata('user_username') : 'Guest',
            'user_agent' => user_agent(),
            'user_ip' => $this->getRealIp(),
            'user_url' => get_last_url(),
        );

        $this->User_log->create($data, true);
        $return = str_replace("#error_login"," ", $return);
        //Add tracking login
        redirect(trim($return));
        $this->parser->parse('loginsucces', null);
    }

    public function loginfail()
    {
        $return = '';
        if(!empty($_GET["return"]))
            $return = $_GET["return"];
        redirect($return."#error_login");
        $this->parser->parse('loginfail', null);
    }

    //Xài cho việc đổi domain
    public function check_x_sso()
    {
        $this->load->model('Users/User');
        $return = '';
        if(isset($_GET["return"]))
            $return = $_GET["return"];

        // check XSSO
        $status = $this->User->check_xsso_n_insert_user();
        // check XSSO successfully

        if($status)
        {
            if($_GET["login"]=='succ')
            {
                redirect(base_url().'frontend/loginxsso/loginsucces?return='.$return);
            }
            else
            {
                redirect(base_url().'frontend/loginxsso/loginfail?return='.$return);
            }

        }
        // check XSSO fail
        else
        {
            $this->session->unset_userdata('user_id');
            $this->session->unset_userdata('user_username');
            $this->session->sess_destroy();
            session_destroy();
            $this->load->helper('cookie');
            delete_cookie('pa_lo_cdam');
            setcookie('session_info', '');
            redirect(base_url().'frontend/loginxsso/loginfail?return='.$return);
        }

    }


    public function logout()
    {
        print_r($_GET["return"]);
        unset($_SESSION['user']);
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('user_username');
        $this->session->sess_destroy();
        session_destroy();
        $this->load->helper('cookie');
        delete_cookie('pa_lo_cdam');
        setcookie('session_info', '');
        redirect($_GET["return"]);
    }
}

?>