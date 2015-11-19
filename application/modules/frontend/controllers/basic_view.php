<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Class basic_view
 * There are many basic view to use:
 * - register_form
 * Author: dungdv3@vng.com.vn
 * Created date: 24/09/2013
 */
class basic_view extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->layout->set_layout('default');
        $this->load->helper('penguin_helper');
        $this->load->helper('strhash_helper');
    }

    /**
     * @author Dung Doan <dungdv3@VNG.COM.VN>
     * Created Date: 24/09/2013
     * This is the basic register form include all validation for common user.
     */
    public function register_form()
    {
        if (isset($_SESSION['user']['user_id'])) {
            redirect(base_url() . 'frontend/basic_view/profile_form');
        }

        header("Content-Type: text/html; charset=utf-8");

        $this->load->model('Users/User');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p>', '</p>');

        $this->form_validation->set_message('required', '* Bạn phải nhập thông tin này');
        $this->form_validation->set_message('matches', '* Xác nhận mật khẩu phải giống mật khẩu');
        $this->form_validation->set_message('valid_emails', '* Email không đúng');
        $this->form_validation->set_message('is_natural', '* Số điện thoại không hợp lệ');
        $this->form_validation->set_message('min_length', '* Số điện thoại không hợp lệ');
        $this->form_validation->set_message('max_length', '* Số điện thoại không hợp lệ');
        $this->form_validation->set_message('is_natural_no_zero', '* Bạn cần chọn Tỉnh/Thành phố');

        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|callback_check_vietnamese|callback_check_username_is_exited');
        $this->form_validation->set_rules('password', 'Password', 'required|callback_check_vietnamese');
        $this->form_validation->set_rules('re_password', 'RePassword', 'required|matches[password]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_emails|callback_check_email_is_exited');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|is_natural|min_length[10]|max_length[11]');
        $this->form_validation->set_rules('region', 'Region', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('captcha', 'Captcha', 'callback_check_captcha');

        if ($this->form_validation->run() == FALSE) {
            //get regions
            $this->load->model('vn_areas/Region');
            $region_option = array(
                'order' => array(
                    'name' => 'asc'
                )
            );
            $region = $this->Region->find('all', $region_option);
            $data = array(
                'region_array' => $region
            );

            if ($this->input->post()) {
                $data['post'] = $this->input->post();

                if ($data['post']['region'] != -1) {
                    $this->load->model('vn_areas/District');
                    $district_option = array(
                        'where' => array(
                            'region_id' => $data['post']['region']
                        )
                    );
                    $district = $this->District->find('all', $district_option);
                    $data['district_array'] = $district;
                }

                if ($data['post']['district'] != -1) {
                    $this->load->model('vn_areas/Ward');
                    $district_option = array(
                        'where' => array(
                            'district_id' => $data['post']['district']
                        )
                    );
                    $ward = $this->Ward->find('all', $district_option);
                    $data['ward_array'] = $ward;
                }
                if ($this->check_birthday($data['post']) == FALSE) {
                    $data['post']['birthday'] = "<p>* Ngày sinh không hợp lệ</p>";
                }
            }
            $this->layout->set_layout('default');
            $this->parser->parse('/basic_view/register_form', $data);
        } else {
            $data = $this->input->post();

//            debug($data);
            $data_user['username'] = $data['username'];
            $data_user['password'] = $data['password'];
            $data_user['email'] = $data['email'];

            $data_user['full_name'] = $data['name'];
            $data_user['region_id'] = (int)$data['region'];
            $data_user['district_id'] = (int)$data['district'];
            $data_user['ward_id'] = (int)$data['ward'];

            $data_user['address'] = $data['address'];
            $data_user['phone'] = $data['phone'];

//            debug($data_user);
            if ($data['sex'] == 'male') {
                $data_user['gender_id'] = 1;
            } else {
                $data_user['gender_id'] = 0;
            }
            $data_user['dob'] = $data['yName1'] . '-' . $data['mName1'] . '-' . $data['dName1'];

//            debug($data_user);

            if ($this->User->create($data_user, TRUE) == TRUE) {
                redirect_to('users', '', 'login');
            } else {
                show_404();
            }
        }
    }

    /**
     * @author Dung Doan <dungdv3@VNG.COM.VN>
     * Created date: 01/10/2013
     * This is the basic login form include all validation for common user.
     */
    public function login_form()
    {
        if (isset($_SESSION['user']['user_id'])) {
            redirect(base_url() . 'frontend/basic_view/profile_form');
        }

        header("Content-Type: text/html; charset=utf-8");
        $this->load->model('Users/User');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p>', '</p>');

        $this->form_validation->set_message('required', '* Bạn phải nhập thông tin này');

        $this->form_validation->set_rules('captcha', 'Captcha', 'callback_check_captcha');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|callback_check_vietnamese');
        $this->form_validation->set_rules('password', 'Password', 'required|callback_check_vietnamese');

        $data = array();
        $data['check_login'] = '';
        if ($this->form_validation->run() == TRUE) {

            if ($this->User->login($this->input->post('username'), $this->input->post('password')) == TRUE) {

                $username = $this->input->post('username');
                $password_type = $this->input->post('password');
                $remember = ($this->input->post('remember') == 'on' ? TRUE : FALSE);
                // set cookie if remember
                if ($remember) {
                    $this->load->helper('strhash');
                    $cookie = array(
                        'name' => 'pa_lo_cdam',
                        'value' => string_hash('remember|' . $username . '|' . $password_type),
                        'expire' => '86500',
                    );

                    $this->input->set_cookie($cookie);
                }
                redirect('frontend/basic_view/profile_form');
            } else {
                $data['check_login'] = '<p>* Tên đăng nhập/Mật khẩu không chính xác.</p>';
            }
        }

        if ($this->input->post()) {
            $data['post'] = $this->input->post();
        }
        $this->layout->set_layout('default');
        $this->parser->parse('/basic_view/login_form', $data);
    }

    /**
     * @author Dung Doan <dungdv3@VNG.COM.VN>
     * Created date: 03/10/2013
     * Logout function clear Session.
     */
    public function logout()
    {

        $this->load->model('Users/User');
        $this->User->update(array('is_logout' => 1), array('id' => $_SESSION['user']['user_id']));

        $this->session->sess_destroy();
        if (isset($_SESSION['user']))
            unset($_SESSION['user']);

        $this->load->helper('cookie');
        delete_cookie('pa_lo_cdam');

        redirect_to('frontend/basic_view/login_form');
    }

    /**
     * @author Dung Doan <dungdv3@VNG.COM.VN>
     * Created date: 03/10/2013
     * This is the basic login form show all infomations of user.
     */
    public function profile_form()
    {

        if (!isset($_SESSION['user']['user_id'])) {
            redirect(base_url() . 'frontend/basic_view/login_form');
        }

        header("Content-Type: text/html; charset=utf-8");
        $this->load->model('Users/User');
        $user = $this->User->find('first', array(
            'select' => 'users.*, genders.name as gender, user_roles.name as role, user_levels.name as level, user_types.name as user_type, regions.name as region, districts.name as district, wards.name as ward',
            'from' => 'users',
            'leftjoin' => array(
                'genders' => 'genders.id = users.gender_id',
                'user_roles' => 'user_roles.id = users.user_role_id',
                'user_levels' => 'user_levels.id = users.user_level_id',
                'user_types' => 'user_types.id = users.user_type_id',
                'regions' => 'regions.id = users.region_id',
                'districts' => 'districts.id = users.district_id',
                'wards' => 'wards.id = users.ward_id'
            ),
            'where' => array('users.id' => $_SESSION['user']['user_id'])
        ));

        // set data to view
        $data = $user;

        $this->layout->set_layout('default');
        $this->parser->parse('/basic_view/profile_form', $data);
    }

    /**
     * @author Dung Doan <dungdv3@VNG.COM.VN>
     * Created date: 04/10/2013
     * This is the basic form to change password of user.
     */
    public function change_pass_form()
    {
        if (!isset($_SESSION['user']['user_id'])) {
            redirect(base_url() . 'frontend/basic_view/login_form');
        } else {
            $id = $_SESSION['user']['user_id'];
        }

        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p>', '</p>');

        $this->form_validation->set_message('required', '* Bạn phải nhập thông tin này');
        $this->form_validation->set_message('matches', '* Xác nhận mật khẩu phải giống mật khẩu');

        $this->form_validation->set_rules('old_password', 'OldPassword', 'required|callback_check_vietnamese');
        $this->form_validation->set_rules('new_password', 'NewPassword', 'required|callback_check_vietnamese');
        $this->form_validation->set_rules('re_password', 'RePassword', 'required|matches[new_password]');

        if ($this->form_validation->run() == TRUE) {

            $this->load->helper('hashpasswd');
            $this->load->model('Users/User');
            // hash password
            $hashpass = new HashPasswd();

            $old_password = $this->input->post('old_password');
            $new_password = $this->input->post('new_password');
            $again_password = $this->input->post('re_password');

            $user = $this->User->get_by_id($id);

            if ($hashpass->CheckPassword($user->password, $old_password)
                && $new_password == $again_password
            ) {
                $this->User->update(array('password' => $new_password), array('id' => $id));
                redirect(base_url() . 'frontend/basic_view/profile_form');
            }
        }

        $this->layout->set_layout('default');
        $this->parser->parse('/basic_view/change_pass_form', null);
    }

    public function change_info_form()
    {

        if (!isset($_SESSION['user']['user_id'])) {
            redirect(base_url() . 'frontend/basic_view/login_form');
        } else {
            $id = $_SESSION['user']['user_id'];
        }
        header("Content-Type: text/html; charset=utf-8");

        $this->load->model('Users/User');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p>', '</p>');

        $this->form_validation->set_message('required', '* Bạn phải nhập thông tin này');
        $this->form_validation->set_message('is_natural', '* Số điện thoại không hợp lệ');
        $this->form_validation->set_message('min_length', '* Số điện thoại không hợp lệ');
        $this->form_validation->set_message('max_length', '* Số điện thoại không hợp lệ');
        $this->form_validation->set_message('is_natural_no_zero', '* Bạn cần chọn Tỉnh/Thành phố');

        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|is_natural|min_length[10]|max_length[11]');
        $this->form_validation->set_rules('region', 'Region', 'trim|required|is_natural_no_zero');

        if ($this->form_validation->run() == FALSE) {
            //get regions
            $this->load->model('vn_areas/Region');
            $region = $this->Region->get_all_region();
            $data['region_array'] = (array)$region;

            $user_info = (array)$this->User->find('first', array(
                'select' => 'users.*',
                'from' => 'users',
                'leftjoin' => array(
                    'genders' => 'genders.id = users.gender_id',
                    'user_roles' => 'user_roles.id = users.user_role_id',
                    'user_levels' => 'user_levels.id = users.user_level_id',
                    'user_types' => 'user_types.id = users.user_type_id',
                    'regions' => 'regions.id = users.region_id',
                    'districts' => 'districts.id = users.district_id',
                    'wards' => 'wards.id = users.ward_id'
                ),
                'where' => array('users.id' => $id)
            ));
            if ($user_info['dob'] != '0000-00-00') {
                $birthday = explode("-", $user_info['dob']);
                $user_info['yName1'] = $birthday['0'];
                $user_info['mName1'] = $birthday['1'];
                $user_info['dName1'] = $birthday['2'];
            }
//            debug($user_info);
            $data['user_info'] = $user_info;

            if ($user_info['district_id'] != '') {
                $this->load->model('vn_areas/District');
                $district = $this->District->get_district_by_region($user_info['region_id']);
                $data['district_array'] = (array)$district;
            }

            if ($user_info['ward_id'] != '') {
                $this->load->model('vn_areas/Ward');
                $ward = $this->Ward->get_ward_by_district($user_info['district_id']);
                $data['ward_array'] = (array)$ward;
            }

            if ($this->input->post()) {
                $data['post'] = $this->input->post();

                if ($data['post']['region'] != -1) {
                    $this->load->model('vn_areas/District');
                    $district_option = array(
                        'where' => array(
                            'region_id' => $data['post']['region']
                        )
                    );
                    $district = $this->District->find('all', $district_option);
                    $data['district_array'] = $district;
                }

                if ($data['post']['district'] != -1) {
                    $this->load->model('vn_areas/Ward');
                    $district_option = array(
                        'where' => array(
                            'district_id' => $data['post']['district']
                        )
                    );
                    $ward = $this->Ward->find('all', $district_option);
                    $data['ward_array'] = $ward;
                }
                if ($this->check_birthday($data['post']) == FALSE) {
                    $data['post']['birthday'] = "<p>* Ngày sinh không hợp lệ</p>";
                }
            }
            $this->layout->set_layout('default');
            $this->parser->parse('/basic_view/change_info_form', $data);
        } else {
            $data = $this->input->post();
            $data_user['full_name'] = $data['name'];
            $data_user['region_id'] = (int)$data['region'];
            $data_user['district_id'] = (int)$data['district'];
            $data_user['ward_id'] = (int)$data['ward'];
            $data_user['address'] = $data['address'];
            $data_user['phone'] = $data['phone'];
            $data_user['gender_id'] = $data['sex'];
            $data_user['dob'] = $data['yName1'] . '-' . $data['mName1'] . '-' . $data['dName1'];

//            debug($data_user);

            if ($this->User->update($data_user, array('id' => $id), TRUE) == TRUE) {
                redirect(base_url() . 'frontend/basic_view/profile_form');
            } else {
                show_404();
            }
        }
    }

    /**
     * @author Dung Doan <dungdv3@VNG.COM.VN>
     * Created date: 24/09/2013
     * This function is validation which check spell name of user
     * @param $word : name
     * @return bool : True if this name is right, otherwise false
     */
    public function check_name($word)
    {
        $this->layout->set_layout('empty');

        $lower_word = mb_strtolower($word);

        $word_parser = explode(" ", $lower_word);

        foreach ($word_parser as $small_word) {
            $query_text = "SELECT * FROM words WHERE word REGEXP BINARY '^" . $small_word . "'";
            $result = $this->User->query($query_text);
            if ($result == FALSE) {
                $this->form_validation->set_message('check_name', '* Tên bạn không đúng');
                return FALSE;
            }
        }
        return TRUE;
    }

    /**
     * @author Dung Doan <dungdv3@VNG.COM.VN>
     * Created date: 24/09/2013
     * This function is validation which check the username, password is string but not in Vietnamese
     * @param $string: username or password
     * @return bool :return true or false
     */
    public function check_vietnamese($string)
    {
        $reg = '/[ ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ]/';
        if (preg_match($reg, $string)) {
            $this->form_validation->set_message('check_vietnamese', '* Không nhập tiếng Việt có dấu');
            return FALSE;
        }
        return TRUE;
    }

    /**
     * @author Dung Doan <dungdv3@VNG.COM.VN>
     * Created date: 24/09/2013
     * This function is validation which check Captcha
     * @return boolean return TRUE if the captcha is matched, return FALSE if not.
     */
    public function check_captcha($string)
    {
        if (check_captcha($string)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('check_captcha', '* Mã bảo vệ không chính xác');
            return FALSE;
        }
    }

    /**
     * @author Dung Doan <dungdv3@VNG.COM.VN>
     * Created date: 24/09/2013
     * This function is validation which check birthday valid
     * @param $data: Birthday
     * @return bool: true if valid, false if invalid
     */
    public function check_birthday($data)
    {
        $date = $data['dName1'];
        $month = $data['mName1'];
        $year = $data['yName1'];

        if ($date == -1 || $month == -1 || $year == -1) {
            return FALSE;
        }
        $d = date('j');
        $m = date('n');
        $y = date('Y');
        if ($date < 1 || $date > 31 || $year < 1900)
            return FALSE;
        if ($year > $y)
            return FALSE;
        if ($year == $y) {
            if ($month > $m)
                return FALSE;
            if ($month == $m)
                if ($date > $d || $date == $d)
                    return FALSE;
        }

        if (!is_nan($year) && ($year != "") && ($year < 10000)) {
            if (($month == 4 || $month == 6 || $month == 9 || $month == 11) && $date == 31)
                return FALSE;
            if ($month == 2) { // check for february 29th
                $isleap = ($year % 4 == 0 && ($year % 100 != 0 || $year % 400 == 0));
                if ($date > 29 || ($date == 29 && !$isleap))
                    return FALSE;
            }
        }
        return TRUE;
    }

    /**
     * @author Dung Doan <dungdv3@VNG.COM.VN>
     * Created date: 24/09/2013
     * This function is validation which check the username is exited or not in database
     * @param String $username
     * @return boolean return FALSE if this username is exited, return TRUE if not exit and available to add.
     */
    public function check_username_is_exited($username)
    {
        if ($this->User->get_by_username($username)) {
            $this->form_validation->set_message('check_username_is_exited', '* Tên đăng nhập đã có người dùng');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * @author Dung Doan <dungdv3@VNG.COM.VN>
     * Created date: 24/09/2013
     * This function is validation which check the email is exited or not in database
     * @param String $email
     * @return boolean return FALSE if this email is exited, return TRUE if not exit and available to add.
     */
    public function check_email_is_exited($email)
    {
        if ($this->User->get_by_email($email)) {
            $this->form_validation->set_message('check_email_is_exited', '* Email đã có người dùng');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}