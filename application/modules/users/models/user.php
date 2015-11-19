<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 *
 * Model
 * Function on User
 *
 * @package PenguinFW
 * @subpackage User
 * @version 1.0.0
 */
class User extends MY_Model
{

    function __construct()
    {
        parent::__construct();

        $this->db_table = 'users';
    }

    /**
     * get all info user has id = $id
     *
     * @param int $id id user
     * @return object account object
     */
    public function get_by_id($id)
    {
        return $this->db->get_where('users', array('id' => $id))->row();
    }

    /**
     * get all info user has username = $username
     *
     * @param string $username username
     * @return object user object
     */
    public function get_by_username($username)
    {
        return $this->db->get_where('users', array('username' => $username))->row();
    }

    /**
     * get all info user has email = $email
     *
     * @param string $email email of user
     * @return object user object
     */
    public function get_by_email($email)
    {
        return $this->db->get_where('users', array('email' => $email))->row();
    }

    /**
     * get all info user has typeid = $typeid
     *
     * @param string $typeid type id (example: ZingID)
     * @return object user object
     */
    public function get_by_typeid($typeid)
    {
        return $this->db->get_where('users', array('typeid' => $typeid))->row();
    }

    /**
     * create a user on Penguin System
     *
     * @param array $data
     */
    public function create($data, $check_field = FALSE)
    {
        // Kiem tra xem cho can check field hay khong
        if ($check_field == TRUE) {
            $userinfo = $this->getFormDataField($data);
        } else {
            $userinfo = $data;
        }

        // check empty data
        if (empty($data)) {
            return FALSE;
        }

        // check username and password
        if (!$userinfo['username'] || !$userinfo['password']) {
            return FALSE;
        }

        // load helper
        $this->load->helper('date');
        $this->load->helper('hashpasswd');

        // hash password
        $hashpass = new HashPasswd();
        $userinfo['password'] = $hashpass->Hash($userinfo['password']);

        // add datetime
        $userinfo['created'] = mdate('%Y-%m-%d %H:%i:%s', now());
        $userinfo['modified'] = mdate('%Y-%m-%d %H:%i:%s', now());

        // update dob
        if (isset($userinfo['dob']) && $userinfo['dob']) {
            $userinfo['dob'] = standar_date($userinfo['dob']);
        }

        // update passport created
        if (isset($userinfo['passport_created']) && $userinfo['passport_created']) {
            $userinfo['passport_created'] = standar_date($userinfo['passport_created']);
        }

        // save data
        if (!$this->db->insert('users', $userinfo)) {
            return FALSE;
        }

        // get id
        return $this->db->insert_id();
    }

    /**
     * Update user
     *
     * @param array $dataAll
     * @param array $where
     * @param boolean $check_field
     * @return boolean
     */
    public function update($dataAll, $where, $check_field = FALSE)
    {
        // update dob
        if (!empty($dataAll['dob'])) {
            $dataAll['dob'] = standar_date($dataAll['dob']);
        }

        // update passport created
        if (!empty($dataAll['passport_created'])) {
            $dataAll['passport_created'] = standar_date($dataAll['passport_created']);
        }

        // update password
        if (!empty($dataAll['password'])) {
            $this->load->helper('hashpasswd');
            // hash password
            $hashpass = new HashPasswd();
            $dataAll['password'] = $hashpass->Hash($dataAll['password']);
        }

        if (empty($dataAll['is_administrator']))
            $dataAll['is_administrator'] = 0;

        // ke thua
        return parent::update($dataAll, $where, $check_field);
    }

    /**
     * Update user
     *
     * @param array $dataAll
     * @param array $where
     * @param boolean $check_field
     * @return boolean
     */
    public function update_info($dataAll, $where, $check_field = FALSE)
    {
        // update dob
        if (!empty($dataAll['dob'])) {
            $dataAll['dob'] = standar_date($dataAll['dob']);
        }

        // ke thua
        return parent::update($dataAll, $where, $check_field);
    }

    /**
     * Dang nhap vao site voi username
     *
     * @param string $username username
     * @param string $password_type password do user gõ vào
     * @param bool $remember nhớ hay không. mặc định là không ghi nhớ tài khoản
     * @return boolean
     */
    public function login_username($username, $password_type, $remember = FALSE, $is_admin = FALSE)
    {
        $this->load->helper('hashpasswd');
        $hashpasswd = new HashPasswd();

        $user = $this->get_by_username($username);

        // check is administrator
        //if ($is_admin && $user->is_administrator != 1) return FALSE;

        if ($user && $user->is_administrator == 1) {
            $is_admin = TRUE;
        }

        if ($user
            && $user->user_status_id == ConstUserStatus::Active
            && $hashpasswd->CheckPassword($user->password, $password_type) == TRUE
        ) {
            $session_data = array(
                'user_id' => $user->id,
                'user_username' => $user->username,
                'user_email' => $user->email,
                'user_typeid' => $user->typeid,
                'user_user_type_id' => $user->user_type_id,
                'user_user_level_id' => $user->user_level_id,
                'user_user_role_id' => $user->user_role_id,
                'user_is_administrator' => $user->is_administrator
            );

            if ($is_admin && $user->is_administrator == 1)
                $session_data['is_administrator'] = 1;
            $this->session->set_userdata($session_data);

            //set SESSION PHP
            $_SESSION['user']['username'] = $user->username;
            $_SESSION['user']['user_id'] = $user->id;

            // log info
            $this->db->where('id', $user->id);
            $this->db->update('users', array(
                'login_ip' => $this->input->ip_address(),
                'login_created' => date('Y-m-d H:i:s'),
                'is_logout' => 0
            ));

            return TRUE;
        }

        return FALSE;
    }

    /**
     * Dang nhap vao site voi email
     *
     * @param string $email email
     * @param string $password_type password do user gõ vào
     * @param bool $remember nhớ hay không. mặc định là không ghi nhớ tài khoản
     * @return boolean
     */
    public function login_email($email, $password_type, $remember = FALSE, $is_admin = FALSE)
    {
        $this->load->helper('hashpasswd');
        $hashpasswd = new HashPasswd();

        $user = $this->get_by_email($email);

        // check is administrator
        if ($is_admin && $user->is_administrator != 1)
            return FALSE;

        if ($user
            && $user->user_status_id == ConstUserStatus::Active
            && $hashpasswd->CheckPassword($user->password, $password_type) == TRUE
        ) {
            $session_data = array(
                'user_id' => $user->id,
                'user_username' => $user->username,
                'user_email' => $user->email,
                'user_typeid' => $user->typeid,
                'user_user_type_id' => $user->user_type_id,
                'user_user_level_id' => $user->user_level_id,
                'user_user_role_id' => $user->user_role_id
            );
            if ($is_admin && $user->is_administrator == 1)
                $session_data['is_administrator'] = 1;
            $this->session->set_userdata($session_data);

            // log info
            $this->db->where('id', $user->id);
            $this->db->update('users', array(
                'login_ip' => $this->input->ip_address(),
                'login_created' => date('Y-m-d H:i:s'),
                'is_logout' => 0
            ));

            return TRUE;
        }

        return FALSE;
    }

    /**
     * Dang nhap vao site
     *
     * @param string $userlogin
     * @param string $password_type
     * @param boolean $remember
     * @param string $config_userlogin
     * @return boolean
     */
    public function login($userlogin, $password_type, $remember = FALSE, $config_userlogin = 'username', $is_admin = FALSE)
    {
        if ($config_userlogin == 'email')
            return $this->login_email($userlogin, $password_type, $remember, $is_admin);
        else
            return $this->login_username($userlogin, $password_type, $remember, $is_admin);
    }

    /**
     * @author TungCN
     * modified_date 2012-03-06 10:17
     *
     * get account info via Passport
     * @param string $username
     * @return boolean|array
     */
    public function passport_get_accountinfo($username)
    {

        if (empty($username)) {
            return FALSE;
        }

        try {
            $soap = new SoapClient('http://auth.passport.zing.vn/PassportServices/PassportService.asmx?WSDL');
            $send_passport_data = array(
                'requestId' => rand(),
                'userIP' => $_SERVER['REMOTE_ADDR'],
                'clientType' => $_SERVER['HTTP_USER_AGENT'],
                'wsAccount' => 'g3depart',
                'wsPassword' => 'g3depart2)1))7!#',
                'productId' => 72,
                'serviceName' => 'GET_ACCOUNT_INFO',
                'body' => array(
                    array('ACC', $username)
                )
            );

            $result = $soap->__soapCall('RequestService', array($send_passport_data));
            $result_user_info = $result->RequestServiceResult->string;

            // success
            if ($result_user_info[0] == 1) {
                return $result_user_info;
            } // failure
            else {
                write_log_file('pp_check_auth', json_encode('check_failure | ' . $send_passport_data));
                return FALSE;
            }
        } catch (SoapFault $f) {
            write_log_file('pp_check_auth', json_encode('exception | ' . $f->getMessage()));
        }

        return FALSE;
    }

    /**
     * @author TungCN
     * modified_date 2012-03-06 10:17
     *
     * check login SSO
     * insert account user into out DB
     * @return boolean
     */
    public function check_sso_n_insert_user()
    {
        $CI = & get_instance();

        $is_loggedin_sso = FALSE;

        try {
            $is_loggedin_sso = $CI->vng_sso->check_sso();
        } catch (Exception $ex) {
            //echo "<div style='color:red;width:100%;padding:5px;text-align:center;font-weight:bold;'>Không thể kết nối đến hệ thống Zing</div>";
        }

        // login via SSO successfully
        if ($is_loggedin_sso) {

            $_SESSION['user']['username'] = $_SESSION['user_pp']['accLogin'];
            $_SESSION['user']['passport_id'] = $_SESSION['user_pp']['passportID'];

            unset($_SESSION['user_pp']);

            $user = $this->get_array('*', array('username' => $_SESSION['user']['username']));

            // user chua co trong DB
            if (!$user) {
                // get account info via Passport
                $result_user_info = $this->passport_get_accountinfo($_SESSION['user']['username']);

                if (is_array($result_user_info) && $result_user_info[0] == 1) {
                    // passport return value is as 16/12/2010 09:28:20 1300
                    $result_user_info[21] = explode(' ', $result_user_info[21]);
                    // get only date
                    $result_user_info[21] = $result_user_info[21][0];

                    $user_data = array(
                        'username' => $_SESSION['user']['username'],
                        'password' => 'g3vng1!223#',
                        'email' => $result_user_info[3],
                        'passport' => $result_user_info[1],
                        'passport_region_id' => $result_user_info[17],
                        'passport_created' => $result_user_info[21],
                        'full_name' => $result_user_info[10],
                        'gender_id' => $result_user_info[11],
                        'dob' => $result_user_info[12],
                        'phone' => $result_user_info[14],
                        'address' => $result_user_info[13],
                    );

                    if ($id_new_user = $this->create($user_data)) {
                        $_SESSION['user']['user_id'] = $id_new_user;

                        $this->session->set_userdata('user_id', $id_new_user);
                        $this->session->set_userdata('user_username', $user_data['username']);
                        $this->session->set_userdata('user_fullname', $user_data['full_name']);
                        return TRUE;
                    }
                } else {
                    unset($_SESSION['user']);
                }
            } // user da co' trong DB
            else {
                $_SESSION['user']['user_id'] = $user['id'];
                $this->session->set_userdata('user_id', $user['id']);
                $this->session->set_userdata('user_username', $user['username']);
                $this->session->set_userdata('user_fullname', $user['full_name']);
                return TRUE;
            }

            return FALSE;
        } else {
            unset($_SESSION['user']);
            $this->session->unset_userdata('user_id');
            $this->session->unset_userdata('user_username');
        }
    }
}

?>
