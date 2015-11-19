<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 *
 * Controller Users
 * User View
 *
 * @package PenguinFW
 * @subpackage User
 * @version 1.0.0
 *
 * @property User           $User
 */
class Users extends MY_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->model_name = 'User';

        $this->lang->load('generate', lang_web());
        $this->lang->load('users', lang_web());

        $this->load->model('User');
    }

    /**
     * index
     */
    public function index()
    {
        // set permission
        $this->PG_ACL('r');

        redirect_to('frontend');
    }

    /**
     * Trang báo lỗi truy cập trang không cho phép
     */
    public function permission()
    {
        $this->layout->set_title(lang('Not Allow Access'));
        $this->parser->parse('permission');
    }

    /**
     * Register on Site
     */
    public function register()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_message('required', lang('invalid field required'));
        $this->form_validation->set_message('matches', lang('invalid matches field'));
        $this->form_validation->set_message('valid_email', lang('invalid email field'));

        $this->form_validation->set_rules('username', 'lang:Username', 'trim|required');
        $this->form_validation->set_rules('password', 'lang:Password', 'trim|required|matches[passconf]');
        $this->form_validation->set_rules('passconf', 'lang:Confirm password', 'trim|required');
        $this->form_validation->set_rules('email', 'lang:Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('captcha', 'lang:Captcha', 'trim|required');
        $this->form_validation->set_rules('agreement', 'lang:Read Agreement', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->parser->parse('register');
        } else {

            $data_users = array(
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'email' => $this->input->post('email'),
                'typeid' => $this->input->post('username'),
                'captcha' => $this->input->post('captcha'),
            );

            if (strtolower($data_users['captcha']) != strtolower($this->session->userdata('captcha'))) {

                $this->session->set_flashdata('error_message', lang('Invalid captcha'));
                redirect_to('users', 'users', 'register');
            }

            $this->load->model('User');

            if ($this->User->get_by_username($data_users['username'])) {
                $this->session->set_flashdata('error_message', lang('Username is registered.'));
                redirect_to('users', 'users', 'register');
            }

            if ($this->User->get_by_email($data_users['email'])) {
                $this->session->set_flashdata('error_message', lang('Email is registered.'));
                redirect_to('users', 'users', 'register');
            }

            if ($this->User->create($data_users, TRUE) == TRUE) {
                $this->session->set_flashdata('success_message', lang('You were register successfully.'));
                redirect_to('users', '', 'login');
            } else {
                //$this->session->set_flashdata('error_message', lang('Error'));
                show_404();
            }
        }
    }

    /**
     * User Login on Site
     */
    public function login()
    {
        //get request url
        $request_url = $this->session->userdata('request_url');

        if ($this->session->userdata('user_id')) {
            if (!isset($request_url))
                redirect_to('frontend');
            else {
                $this->session->unset_userdata('request_url');
                redirect($request_url);
            }
        }

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');


        if ($this->form_validation->run() == TRUE) {
            $this->load->model('User');
            $username = $this->input->post('username');
            $password_type = $this->input->post('password');

            $remember = ($this->input->post('remember') == 'on' ? TRUE : FALSE);

            if ($this->User->login($username, $password_type) == TRUE) {
                // set cookie
                if ($remember) {
                    $this->load->helper('strhash');
                    $cookie = array(
                        'name' => 'pa_lo_cdam',
                        'value' => string_hash('remember|' . $username . '|' . $password_type),
                        'expire' => '86500',
                    );

                    $this->input->set_cookie($cookie);
                }

                $this->session->set_flashdata('success_message', lang('You were login success.'));
                if ($this->input->post('rp'))
                    redirect($this->input->post('rp'));
                else {
                    if (!isset($request_url))
                        redirect_to('frontend');
                    else {
                        $this->session->unset_userdata('request_url');
                        redirect($request_url);
                    }
                }
            } else {
                $this->session->set_flashdata('error_message', lang('The username or password you entered is incorrect.'));
                redirect_to('users', 'users', 'login');
            }
        }

        $this->parser->parse('login', null);
    }

    /**
     * User thoát ra khỏi hệ thống
     */
    public function logout()
    {
        $this->session->sess_destroy();

        $this->load->helper('cookie');
        delete_cookie('pa_lo_cdam');

        $this->db->where('id', $this->session->userdata('user_id'));
        $this->db->update('users', array('is_logout' => 1));

        redirect_to('');
    }

    public function recaptcha()
    {
        $this->layout->set_layout('empty');
        echo print_re_captcha();
        exit(0);
    }

    public function ax_sso_login()
    {
        $this->layout->set_layout("empty");

        if (isset($_GET['error']) && $_GET['error']) {
            echo 0;
            exit();
        }

        $message = $this->input->get("mess");

        if ($message == "succ") {
            echo 1;
            exit();
        }

        echo 0;
        exit();
    }

    public function is_login()
    {
        if (is_login()) {
            echo 1;
            die;
        } else {
            echo 0;
            die;
        }
    }

    public function ajax_get_user_info()
    {
        $this->load->model('Users/User');
        $this->layout->set_layout('empty');

        $username = $this->session->userdata('user_username');

        if ($username == FALSE) {
            echo 0;
            return FALSE;
        }

        $user = $this->User->find('first_array', array(
            'select' => 'email, cmnd, university, phone',
            'where' => array('username' => $username),
        ));

        echo json_encode($user);
        return TRUE;
    }

    public function ajax_update_user_info()
    {
        $this->load->model('Users/User');
        $this->layout->set_layout('empty');

        //check user login or not
        $username = $this->session->userdata('user_username');

        if ($username == FALSE) {
            echo "User not login";
            return FALSE;
        }

        $user = $this->input->post();

        if ($user == FALSE) {
            echo "Empty infomation";
            return FALSE;
        }

        //update info

        $this->User->update_info($user, array('username' => $username));

        echo 1;
        return TRUE;
    }

    /**
     * author: dungdv3@vng.com.vn
     * created date: 23/09/2013
     * This is function to check spell of name of user.
     * It will return TRUE if this name is right spell in Vietnamese, FALSE if not.
     */
    public function ajax_check_spell()
    {
        header("Content-Type: text/html; charset=utf-8");

        $this->load->model('Users/User');
        $this->layout->set_layout('empty');

        $word = $this->input->post('name');

        if ($word == '') {
            return;
        }

        $lower_word = mb_strtolower($word);

        $word_parser = explode(" ", $lower_word);

        $flag_right_word = true;
        $wrong_token = array();
        foreach ($word_parser as $small_word) {
            $query_text = "SELECT * FROM words WHERE word REGEXP BINARY '^" . $small_word . "'";
            $result = $this->User->query($query_text);
            if ($result == FALSE) {
                $flag_right_word = false;
                array_push($wrong_token, $small_word);
            }
        }
        echo($flag_right_word);
        /*
         * Get token which is wrong spell
        if ($flag_right_word == TRUE) {
            echo 'Bạn nhập đúng';
        } else {
            $output = 'Bạn nhập sai từ: ';
            foreach ($wrong_token as $wrong) {
                $output .= $wrong . ', ';
            }
            echo $output;
        }
        */
    }
}

?>
