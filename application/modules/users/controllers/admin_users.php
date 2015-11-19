<?php

if(!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller admin_users
 * ...
 * 
 * @package PenguinFW
 * @subpackage users
 * @version 1.0.0
 * 
 * @property User $User
 */
class admin_users extends MY_Controller {

    function __construct()
    {
        parent::__construct();

        $this->layout->set_layout('admin');

        $this->model_name = 'User';

        $this->lang->load('generate', lang_web());
        $this->lang->load('users', lang_web());

        $this->load->model('User');
    }

    /**
     * Dashboard
     */
    public function dashboard()
    {
        // check permission
        $this->PG_ACL('r');

        // get user login lastest
        $users = $this->User->find('all', array(
            'from' => 'users',
            'select' => 'users.*, user_roles.name as role',
            'join' => array('user_roles' => 'users.user_role_id = user_roles.id'),
            'order' => array('users.login_created' => 'DESC'),
            'limit' => 10
                ));

        $icons = array(
            array('label' => lang('Add New Article'), 'link' => 'articles/admin_articles/add', 'image' => 'icon-48-article-add.png'),
            array('label' => lang('Manage Article'), 'link' => 'articles/admin_articles', 'image' => 'icon-48-article.png'),
            //array('label' => lang(''), 'link' => '', 'image' => ''),
            array('label' => lang('Category Manager'), 'link' => 'articles/admin_article_categories', 'image' => 'icon-48-category.png'),
            array('label' => lang('Photo Manager'), 'link' => 'photos/admin_photos', 'image' => 'icon-48-media.png'),
            array('label' => lang('Menu Manager'), 'link' => 'menus/admin_menus', 'image' => 'icon-48-menumgr.png'),
            array('label' => lang('User Manager'), 'link' => 'users/admin_users', 'image' => 'icon-48-user.png'),
            array('label' => lang('Module Manager'), 'link' => 'modules/admin_modules', 'image' => 'icon-48-module.png'),
            array('label' => lang('Language Manager'), 'link' => 'languages/admin_languages', 'image' => 'icon-48-language.png'),
            array('label' => lang('Global Configuration'), 'link' => 'settings/admin_settings', 'image' => 'icon-48-config.png'),
            array('label' => lang('Template Manager'), 'link' => 'html_templates/admin_html_templates', 'image' => 'icon-48-themes.png'),
        );

        $data = array(
            'icons' => $icons,
            'users' => $users
        );

        $this->layout->set_title(lang('Dashboard'));
        $this->parser->parse('admin_users/dashboard', $data);
    }

    /**
     * List
     * 
     * @param string $action
     * @param int $cfn_id
     * @return array data to view
     */
    private function _listView($action = 'index', $cfn_id = 0)
    {
        // set javascript to view
        $this->layout->set_javascript(array(
            'jquery.ui.core.min.js',
            'jquery.ui.datepicker.min.js'
        ));

        // set css to view
        $this->layout->set_rel(array(
            'jquery.ui.base.css',
            'jquery.ui.datepicker.css'
        ));

        // filter users
        // filter user status id
        $filter_user_status_id = $this->input->get('user_status_id');
        if($filter_user_status_id)
        {
            $this->paginator['where']['user_status_id'] = $filter_user_status_id;
        }

        // filter created from date
        $filter_from_date = $this->input->get('from_date');
        if($filter_from_date)
        {
            $this->paginator['where']['DATE(created) >= '] = standar_date($filter_from_date, '-', '-');
        }

        // filter created end date
        $filter_to_date = $this->input->get('to_date');
        if($filter_to_date)
        {
            $this->paginator['where']['DATE(created) <= '] = standar_date($filter_to_date, '-', '-');
        }

        // filter username
        $filter_username = $this->input->get('username');
        if($filter_username)
        {
            $this->paginator['where']['username'] = $filter_username;
        }

        // only show user not in recycle bin
        // check action is recyclebin
        if($action == 'recyclebin')
        {
            $this->paginator['where']['is_delete'] = 1;
        }
        else
        { // action is index
            $this->paginator['where']['is_delete'] = 0;
        }

        // order
//        $this->paginator['order'] = array('created' => 'desc');

        // get user
        $users = $this->pagination(5);

        // get user status id
        $user_statuses = $this->User->find('all', array(
            'select' => 'id, name',
            'from' => 'user_statuses',
            'limit' => 0
                ));

        // get $_GET
        $extra_params = get_extra_params_from_url();

        // set data view
        return array(
            'list_views' => $users,
            'cfn_id' => $cfn_id,
            'user_statuses' => $user_statuses,
            'this_resource' => $this->router->class,
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'link_edit' => array(
                'View' => 'users/admin_users/view/',
                'Edit' => 'users/admin_users/edit/',
                'Change Pass' => 'users/admin_users/change_password/'
            ),
            'pagination_link' => $this->getPaginationLink('/users/admin_users/' . $action . '/' . $cfn_id, 5, $extra_params)
        );
    }

    /**
     * List
     */
    public function index($cfn_id = 0)
    {
        // check permission
        $this->PG_ACL('r');

        // set title
        $this->layout->set_title(lang('User manager'));
        
        // get data
        $data = $this->_listView('index', $cfn_id);
        
        $data['total_records'] = $this->count_record;

        if($this->input->get('p') == 1)
        {
            $this->layout->set_layout('popup');
            $this->parser->parse($this->router->class . '/popup', $data);
        }
        else
        {
            $this->parser->parse($this->router->class . '/index', $data);
        }
    }

    /**
     * View RecycleBIN
     */
    public function recyclebin($cfn_id = 0)
    {
        // check permission
        $this->PG_ACL('t');

        // set title
        $this->layout->set_title(lang('User manager') . ' - ' . lang('Recycle Bin'));

        // get data
        $data = $this->_listView('recyclebin', $cfn_id);

        $this->parser->parse($this->router->class . '/recyclebin', $data);
    }

    /**
     * VIEW User
     * 
     * @param int $user_id
     */
    public function view($user_id = 0)
    {
        // check permission
        $this->PG_ACL('r');

        // set script
        $this->layout->set_javascript(array(
            'shadowbox/shadowbox.js',
            'shadowbox/init.js'
        ));

        // set style
        $this->layout->set_rel(array(
            'js' => 'shadowbox/shadowbox.css'
        ));

        // set title
        $this->layout->set_title(lang('View user'));

        // get user data from database
        $user = $this->User->find('first', array(
            'select' => 'users.*, genders.name as gender, user_roles.name as role, user_levels.name as level, user_types.name as user_type',
            'from' => 'users',
            'leftjoin' => array(
                'genders' => 'genders.id = users.gender_id',
                'user_roles' => 'user_roles.id = users.user_role_id',
                'user_levels' => 'user_levels.id = users.user_level_id',
                'user_types' => 'user_types.id = users.user_type_id'
            ),
            'where' => array('users.id' => $user_id)
                ));

        // set data to view
        $data = array(
            'user' => $user
        );

        // parser
        $this->parser->parse($this->router->class . '/view', $data);
    }

    /**
     * ADD User
     */
    public function add()
    {
        // check permission
        $this->PG_ACL('w');

        // set title
        $this->layout->set_title(lang('Add user'));

        // set javascript to view
        $this->layout->set_javascript(array(
            'jquery.ui.core.min.js',
            'jquery.ui.datepicker.min.js',
            'ajaxupload.js',
            'users/upload.js',
        ));

        // set css to view
        $this->layout->set_rel(array(
            'jquery.ui.base.css',
            'jquery.ui.datepicker.css'
        ));

        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');

        // form validate
        $this->form_validation->set_rules('username', 'Username', 'trim|required');

        // get post and check rule
        if($this->input->post() && $this->form_validation->run() == TRUE)
        {
            $typeid = $this->input->post('typeid');
            if(!isset($typeid) || empty($typeid))
            {
                $_POST['typeid'] = $this->input->post('username');
            }

            // set default avatar, if empty avatar
            $thumb_image = $this->input->post('thumbnail_image');
            if(!isset($thumb_image) || empty($thumb_image))
            {
                $_POST['thumbnail_image'] = 'avatar_default.jpg';
            }

            // save data
            if($this->User->create($this->input->post(), TRUE))
            {
                $this->session->set_flashdata('success_message', lang('Success'));
            }
            else
            {
                $this->session->set_flashdata('success_message', lang('Error'));
            }

            // redirect
            redirect('users/admin_users');
        }

        // get region
        $region = $this->User->find('all', array(
            'select' => 'id,name',
            'from' => 'regions',
            'order' => array('name' => 'asc')
                ));

        // data to view
        $data = array(
            'passport_region_ids' => $region,
            'gender_ids' => $this->User->find('all', array(
                'select' => 'id,name',
                'from' => 'genders'
            )),
            'region_ids' => $region,
            'married_status_ids' => $this->User->find('all', array(
                'select' => 'id,name',
                'from' => 'married_statuses'
            )),
            'job_ids' => $this->User->find('all', array(
                'select' => 'id,name',
                'from' => 'jobs'
            )),
            'user_type_ids' => $this->User->find('all', array(
                'select' => 'id,name',
                'from' => 'user_types'
            )),
            'user_level_ids' => $this->User->find('all', array(
                'select' => 'id,name',
                'from' => 'user_levels'
            )),
            'user_role_ids' => $this->User->find('all', array(
                'select' => 'id,name',
                'from' => 'user_roles',
                'order' => array('weight' => 'asc')
            )),
            'user_status_ids' => $this->User->find('all', array(
                'select' => 'id,name',
                'from' => 'user_statuses'
            ))
        );

        // parser
        $this->parser->parse($this->router->class . '/add', $data);
    }

    /**
     * EDIT User
     * 
     * @param int $user_id 
     */
    public function edit($user_id = 0)
    {
        // check permission
        $this->PG_ACL('e');

        // set title
        $this->layout->set_title(lang('Edit user'));

        // set javascript to view
        $this->layout->set_javascript(array(
            'jquery.ui.core.min.js',
            'jquery.ui.datepicker.min.js',
            'ajaxupload.js',
            'users/upload.js',
            'shadowbox/shadowbox.js',
            'shadowbox/init.js',
        ));

        // set css to view
        $this->layout->set_rel(array(
            'jquery.ui.base.css',
            'jquery.ui.datepicker.css',
            'js' => 'shadowbox/shadowbox.css',
        ));

        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');

        // form validate
        $this->form_validation->set_rules('username', 'Username', 'required');

        // get user_id
        $user_id = ($this->input->post('user_id')) ? $this->input->post('user_id') : $user_id;

        // get post and check rule
        if($this->input->post() && $this->form_validation->run() == TRUE)
        {
            $typeid = $this->input->post('typeid');
            if(!isset($typeid) || empty($typeid))
            {
                $_POST['typeid'] = $this->input->post('username');
            }

            // set default avatar, if empty avatar
            $thumb_image = $this->input->post('thumbnail_image');
            if(!isset($thumb_image) || empty($thumb_image))
            {
                $_POST['thumbnail_image'] = 'avatar_default.jpg';
            }

            // save data
            if($this->User->update($this->input->post(), array('id' => $user_id), TRUE))
            {
                $this->session->set_flashdata('success_message', lang('Success'));
            }
            else
            {
                $this->session->set_flashdata('success_message', lang('Error'));
            }

            // redirect
            redirect('users/admin_users');
        }

        // get user
        $user = $this->User->get(array('id' => $user_id));

        // get region
        $region = $this->User->find('all', array(
            'select' => 'id,name',
            'from' => 'regions',
            'order' => array('name' => 'asc')
                ));

        // data to view
        $data = array(
            'edit_module' => $user,
            'passport_region_ids' => $region,
            'gender_ids' => $this->User->find('all', array(
                'select' => 'id,name',
                'from' => 'genders'
            )),
            'region_ids' => $region,
            'married_status_ids' => $this->User->find('all', array(
                'select' => 'id,name',
                'from' => 'married_statuses'
            )),
            'job_ids' => $this->User->find('all', array(
                'select' => 'id,name',
                'from' => 'jobs'
            )),
            'user_type_ids' => $this->User->find('all', array(
                'select' => 'id,name',
                'from' => 'user_types'
            )),
            'user_level_ids' => $this->User->find('all', array(
                'select' => 'id,name',
                'from' => 'user_levels'
            )),
            'user_role_ids' => $this->User->find('all', array(
                'select' => 'id,name',
                'from' => 'user_roles',
                'order' => array('weight' => 'asc')
            )),
            'user_status_ids' => $this->User->find('all', array(
                'select' => 'id,name',
                'from' => 'user_statuses'
            ))
        );

        // parser
        $this->parser->parse($this->router->class . '/edit', $data);
    }

    public function change_password($user_id = 0)
    {
        if($this->session->userdata('user_id') && $this->session->userdata('user_id') == $user_id)
        {
            $is_owner = TRUE;
            $user_id = $this->session->userdata('user_id');
        }
        else
        {
            $this->PG_ACL('e');
            $is_owner = FALSE;
            $user_id = ($this->input->post('user_id')) ? $this->input->post('user_id') : $user_id;
        }

        if(!$user_id)
            redirect('users/admin_users');

        $user = $this->User->get(array('id' => $user_id));

        if(!$user)
        {
            $this->session->set_flashdata('error_message', lang('User not exit'));
            redirect('users/admin_users');
        }

        if($this->input->post())
        {
            $this->load->helper('hashpasswd');
            // hash password
            $hashpass = new HashPasswd();

            $old_password = $this->input->post('old_password');
            $new_password = $this->input->post('new_password');
            $again_password = $this->input->post('again_password');

            if($is_owner)
            {
                if($hashpass->CheckPassword($user->password, $old_password)
                        && $new_password == $again_password)
                {
                    $this->User->update(array('password' => $new_password, 'is_administrator' => $user->is_administrator), array('id' => $user->id));
                }
            }
            else
            {
                if($new_password == $again_password)
                {
                    $this->User->update(array('password' => $new_password, 'is_administrator' => $user->is_administrator), array('id' => $user->id));
                }
            }

            $this->session->set_flashdata('success_message', lang('Change password success'));
            redirect('users/admin_users');
        }

        // title
        $this->layout->set_title(lang('Change password') . " {$user->username}");
        $this->parser->parse('admin_users/change_password', array('user' => $user, 'is_owner' => $is_owner));
    }

    /**
     * DELETE User          
     */
    public function delete()
    {
        // check permission
        $this->PG_ACL('d');

        // update is_delete = 1
        $this->deleteOnListView();
    }

    /**
     * RESTORE from Recycle Bin
     */
    public function restore()
    {
        // check permission
        $this->PG_ACL('t');

        // update is_delete = 0
        $this->restoreOnListView();
    }
    
    /**
     * User thoát ra khỏi hệ thống
     */
    public function logout()
    {
        $this->session->sess_destroy();

        if(isset($_SESSION['user']))
            unset($_SESSION['user']);

        $this->load->helper('cookie');
        delete_cookie('pa_lo_cdam');

        $this->db->where('id', $this->session->userdata('user_id'));
        $this->db->update('users', array('is_logout' => 1));

        redirect_to('/root');
    }

    /**
     * LOGIN by Admin
     */
    public function login()
    {
        $this->layout->set_javascript('vng/utility.js');
        
        //get request url
        $request_url = $this->session->userdata('request_url');
      
        if($this->session->userdata('user_id') && $this->session->userdata('is_administrator'))
        {
            if($request_url)
            { 
                $this->session->unset_userdata('request_url');
                redirect($request_url);
            }
            else
            {
                redirect(base_url('admin'));
            }
        }



        $this->load->helper('breadcrumb');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('captcha', 'captcha', 'required');
   
        //set js
        $this->layout->set_javascript(array(
            'vng/config.js',
            'vng/function.js',
            'vng/utility.js'
        ));
        
        if($this->form_validation->run() == TRUE)
        {
            $username = $this->input->post('username');
            $password_type = $this->input->post('password');
            $captcha = $this->input->post('captcha');

            if(check_captcha($captcha) == true)
            {
                if($this->User->login($username, $password_type, FALSE, 'username', TRUE) == TRUE)
                {
                    $this->session->set_flashdata('success_message', lang('You were login success.'));
                    if($this->input->post('rp'))
                    {
                        redirect($this->input->post('rp'));
                    }
                    else
                    {

                        if(isset($request_url) && $request_url)
                        {
                            $this->session->unset_userdata('request_url');
                            redirect($request_url);
                        }
                        else
                        {
                            redirect('users/admin_users/dashboard');
                        }
                    }
                }
                else
                {
                    $this->session->set_flashdata('error_message', lang('The username or password you entered is incorrect.'));

                    redirect('users/admin_users/login');
                }
            }
            else
            {
                $this->session->set_flashdata('error_message', lang('The captcha is incorrect.'));
                redirect('users/admin_users/login');
            }
        }

        $this->parser->parse('admin_users/login', null);
    }

    /**
     * Permission
     */
    public function permission()
    {
        $this->layout->set_title(lang('Not Allow Access'));
        $this->parser->parse($this->router->class . '/permission', null);
    }

}

?>