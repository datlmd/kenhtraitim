<?php

if (!defined('BASEPATH'))
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
class Open_login extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->lang->load('generate', lang_web());
        $this->layout->disable_layout();
        $this->load->model("users/user");
    }

    public function ajax_login() {
        if ($_POST || $_GET['code']) {
            $user_profile = array();
            $avatar = "";
            $user_type_id = 1;

            if ($_POST && $_POST["from"] == "facebook") { //login from facebook
                $this->load->library(array("facebook_login"));
                $uid = $this->facebook_login->getFBUserId();
                $user_profile = $this->facebook_login->getFBUserProfile($uid);

                if (!$user_profile) {
                    echo "Facebook authenticate failed!";
                    return false;
                }
                $avatar = "https://graph.facebook.com/" . $uid . "/picture?type=normal";
                $user_type_id = 2;
            } else if ($_POST && $_POST["from"] == "google") { //login from google
                $ch = curl_init();
                $url = 'https://www.googleapis.com/oauth2/v1/userinfo?access_token=' . $_POST['access_token'];

                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1");
                curl_setopt($ch, CURLOPT_AUTOREFERER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
                curl_setopt($ch, CURLOPT_TIMEOUT_MS, 2000);
                curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
                if (config_item('use_proxy') != '') {
                    echo(config_item('use_proxy'));
                    curl_setopt($ch, CURLOPT_PROXY, config_item('use_proxy'));
                }

                $userDetails = curl_exec($ch);
                curl_close($ch);

                if (!$userDetails) {
                    echo "Google authenticate failed!";
                    return false;
                }
                $user_profile = (array) json_decode($userDetails);
                $avatar = $user_profile["picture"];
                $user_type_id = 3;
            } else { //login from zing
                $auth_code = $_GET['code'];
                $this->load->library('zing_me');
                $user_info = $this->zing_me->get_info_user_sso($auth_code);

                $user_profile['id'] = $user_info['username'];
                $user_profile['name'] = $user_info['displayname'];
                $user_profile['email'] = '';
                $avatar = $user_info['tinyurl'];
                $user_profile['dob'] = date("Y-m-d", $user_info['dob']);

                if ($user_info['gender'] == 1) {
                    $user_profile['gender'] = 'female';
                } else {
                    $user_profile['gender'] = 'male';
                }
            }

            if ($_POST) {
                $userData['username'] = $user_profile['id'] . "@" . $_POST['from'];
            } else {//zing me
                $userData['username'] = $user_profile['id'];
                $userData['dob'] = $user_profile['dob'];
            }

            $userData['name'] = $user_profile['name'];
            if (isset($user_profile['email'])) {
                $userData['email'] = $user_profile['email'];
            } else {
                $userData['email'] = '';
            }

            if ($user_profile['gender'] == 'male') {
                $userData['gender_id'] = 1;
            } else if ($user_profile['gender'] == 'female') {
                $userData['gender_id'] = 0;
            } else {
                $userData['gender_id'] = -1;
            }

            $newsUser = array(
                'username' => $userData['username'],
                'password' => md5($userData['username']),
                'full_name' => $userData['name'],
                'email' => $userData['email'],
                'gender_id' => $userData['gender_id'],
                'user_type_id' => $user_type_id
            );

            if (isset($user_profile['dob'])) {
                $newsUser['dob'] = $user_profile['dob'];
            }

            // check exit data on user table
            $userData = $this->user->get_by_username($newsUser['username']);
            if ($userData) {
                $this->session->set_userdata('user_id', $userData->id);
                $this->session->set_userdata('user_username', $userData->username);
                $this->session->set_userdata('user_fullname', $userData->full_name);
                $this->session->set_userdata('user_email', $userData->email);
                $this->session->set_userdata('user_gender', $userData->gender_id);
            } else {
                $userId = $this->user->create($newsUser);
                $this->session->set_userdata('user_id', $userId);
                $this->session->set_userdata('user_username', $newsUser['username']);
                $this->session->set_userdata('user_fullname', $newsUser['full_name']);
                $this->session->set_userdata('user_email', $newsUser['email']);
                $this->session->set_userdata('user_gender', $newsUser['gender_id']);
            }
            $this->session->set_userdata('user_avatar', $avatar);
            $this->session->set_userdata('user_type_id', $user_type_id);
            $array = array(
                'fullname' => $this->session->userdata('user_fullname'),
                'avatar' => $avatar,
                'user_type_id' => $user_type_id
            );

            if ($_POST) {
                echo json_encode($array);
            } else {
                echo '<script type="text/javascript">'
                , 'parent.menu_profile(' . json_encode($array) . ');'
                , 'parent.show_alert("success", "Đăng nhập thành công!", function () {
                        console.log(typeof parent.login_completed);
                        if (typeof parent.login_completed !== \'undefined\') {
                            parent.login_completed();}
                        });'
                , 'window.parent.closeModal();'
                , '</script>'
                ;
            }
        } else {
            echo "Authenticate failed!";
        }
    }

    public function logout($type_id = 1) {
        $this->db->where('id', $this->session->userdata('user_id'));
        $this->db->update('users', array('is_logout' => 1));
        $this->session->sess_destroy();

        if ($type_id == 1) {
            if (isset($_GET["url"])) {
                redirect('http://logout.brand.zing.vn/zing_logout?ReturnUrl=' . $_GET["url"]);
            } else {
                redirect('http://logout.brand.zing.vn/zing_logout?ReturnUrl=' . base_url_zing());
            }
        } else {
            if (isset($_GET["url"])) {
                redirect($_GET["url"]);
            } else {
                redirect(base_url_zing());
            }
        }
    }

    public function is_login() {
        if ($this->session->userdata('user_id')) {
            echo '1';
        } else {
            echo '0';
        }
    }

}

?>