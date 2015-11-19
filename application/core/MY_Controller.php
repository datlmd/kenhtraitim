<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Add MY_Controller with ACL and ...
 * 
 * @package PenguinFW
 * @subpackage Controller
 * @version 1.0.0
 * 
 * @property CI_Loader $load
 * @property CI_Session $session
 * @property MY_Router $router
 * @property CI_Parser $parser
 * @property Layout $layout
 * 
 * @property MY_Input $input
 * @property CI_Form_validation $form_validation
 * @property CI_Table $table
 * 
 * @property CI_DB_active_record $db
 * @property CI_DB_forge $dbforge
 * 
 * @property CI_Email $email
 */
class MY_Controller extends CI_Controller {

    // config query pagination
    protected $paginator = array('limit' => 20);
    // model name
    protected $model_name = '';
    // count all query
    protected $count_record;

    function __construct() {
        parent::__construct();

        //set time zone
        date_default_timezone_set('Asia/Saigon');

        // da login va check remember me
        //$this->_check_remember_login();
        // check user online
        //$this->_check_user_online();
        // load library for admin
        if (is_admin()) {
            $this->load->helper('breadcrumb');
        }

        // check language
        /**
         * @author Hoanhk
         */
        if (!empty($_GET['language'])) {
            $this->load->library('Encryption');
            $lang_encode = $this->encryption->encode($_GET['language']);
            $vn_encode = $this->encryption->encode('vn');
            $eng_encode = $this->encryption->encode('english');

            if ($lang_encode == $vn_encode || $lang_encode == $eng_encode) {
                $cookie_config = array(
                    'name' => 'pg_lang_web_value',
                    'value' => $lang_encode,
                    'expire' => '86400',
                    'domain' => '',
                    'path' => '/',
                    'prefix' => '',
                    'secure' => FALSE
                );
                set_cookie($cookie_config);
            }
            redirect(base_url(uri_string()));
        }

        //Ghi log mọi action trên website của tài khoản admin, nếu tài khoàn user thường thì tuỳ function sẽ gắn hàm
        if ($this->session->userdata('user_id')) {
            if (is_admin()) {
                $this->load->model('tracking_logs/Tracking_log');
                $data_log = array(
                    'username' => $this->session->userdata("user_username"),
                    'module' => $this->router->fetch_module(),
                    'class' => $this->router->fetch_class(),
                    'action' => $this->router->fetch_method(),
                    'post_params' => $_POST,
                    'get_params' => $_GET,
                    'ip' => get_client_ip()
                );
                $this->Tracking_log->write_logs_access($data_log, true);
            }
        }

        //load profiler
        if (config_item('enable_profiler') == 1) {
            $this->output->enable_profiler(TRUE);
        }
		
		//enable profiler by debug=1
		if (isset($_GET["debug"]) && $_GET["debug"] == 1) {
            $this->output->enable_profiler(TRUE);
            unset($_GET["debug"]);
        }
    }

    //get pagination server data
    protected function _ajax_paging_data($data, $ajax_view) {
        if (isset($_POST['is_ajax']) && $_POST['is_ajax'] == 1) {
            $this->layout->disable_layout();

            $html_videos = $this->parser->parse($ajax_view, $data, FALSE);
            $html_links = $data['pages'];

            //unset($data);
            $data = array(
                'records' => $html_videos,
                'pages' => $html_links
            );

            echo json_encode($data);
            die;
            ;
        }
    }

    //get menu server data
    protected function _ajax_menu_data($data, $ajax_view) {
        if (isset($_POST['ajax_menu']) && $_POST['ajax_menu'] == 1) {
            $this->layout->disable_layout();

            $output = $this->parser->parse($ajax_view, $data, FALSE);

            //unset($data);
            $data = array(
                'output' => $output,
            );

            echo json_encode($data);
            die;
            ;
        }
    }

    //filter
    protected function _filter($table) {
        //more point for table
        $table = $table . '.';

        $filters = $this->input->get();

        if ($this->input->get('s')) {
            unset($filters['s']);
        }

        if ($this->input->get('publish_type') !== FALSE) {
            unset($filters['publish_type']);
        }

        if ($this->input->get('p_redirect') !== FALSE) {
            unset($filters['p_redirect']);
        }

        if ($this->input->get('from_date') !== FALSE) {
            unset($filters['from_date']);
        }

        if ($this->input->get('to_date') !== FALSE) {
            unset($filters['to_date']);
        }

        //unset filter articles
        if ($this->input->get('article_category_id') !== FALSE) {
            unset($filters['article_category_id']);

            if ($this->input->get('lang_id') !== FALSE) {
                unset($filters['lang_id']);
            }

            if ($this->input->get('name') !== FALSE) {
                unset($filters['name']);
            }
        }

        if ($filters)
            foreach ($filters as $field => $filter) {
                if (trim($filter) !== NULL) {

                    if ($field == 'created' || $field == 'modified' || $field == 'dob') {
                        $this->paginator['like']['DATE(' . $table . $field . ')'] = standar_date(trim($filter), '-', '-');
                    } else {
                        $this->paginator['like'][$table . $field] = trim($filter);
                    }
                }
            }
    }

    //Sort
    protected function _sort() {
        $sorts = $this->input->get('s');

        if ($sorts) {
            //reset order
            $this->paginator['order'] = array();

            foreach ($sorts as $field => $sort_get) {
                if ($sort_get) {
                    $this->paginator['order'][$field] = $sort_get;
                }
            }
        }
    }

    /**
     * Search belong to category
     * @author danhdvd
     * @param int $type_id category type
     * @param int $cate_id the category id of record belong to
     * @param string $search_url the index search in $_GET show in url  
     * @param int $limit number limit of records per page  
     * @return array query, results, total, pages 
     */
    protected function _search($type_id, $cate_id, $search_url = '', $limit = '') {
        //check search text by GET 
        if (isset($_GET[SEARCH_GET_NAME])) {
            $input = $_GET[SEARCH_GET_NAME];
        } else {
            return FALSE;
        }

        //config
        $this->paginator = array();
        $limit = $limit ? $limit : SEARCH_RECORDS_PER_PAGE;
        $search_url = $search_url ? $search_url : 'search';

        //set type content to search
        if ($type_id == ARTICLE_TYPE) {
            $this->load->model("Articles/Article");
            $this->model_name = "Article";

            $this->paginator['select'] = 'articles.*, ad.subject as subject, ad.teaser as teaser, ad.tags as tags';

            $this->paginator['leftjoin']['article_dictionaries ad'] = 'ad.article_id = articles.id';
            $this->paginator['join']['article_category_relationships acr'] = 'acr.article_id = articles.id';

            $this->paginator['where']['articles.is_delete'] = 0;
            $this->paginator['where']['articles.is_publish'] = 1;
            $this->paginator['where']['articles.publish_date <='] = date('Y-m-d H:i:s');
            $this->paginator['where']['acr.article_category_id'] = $cate_id;

            $this->paginator['order']['articles.publish_date'] = 'DESC';
        } else if ($type_id == VIDEO_TYPE) {
            $this->load->model("Musics/Music");
            $this->model_name = "Music";

            $this->paginator['where']['type_id'] = VIDEO_TYPE_ID;
            $this->paginator['where']['category'] = $cate_id;
            $this->paginator['where']['status_id'] = 1;
        } else if ($type_id == MUSIC_TYPE) {
            $this->load->model("Musics/Music");
            $this->model_name = "Music";

            $this->paginator['where']['type_id'] = MUSIC_TYPE_ID;
            $this->paginator['where']['category'] = $cate_id;
            $this->paginator['where']['status_id'] = 1;
        } else if ($type_id == PHOTO_TYPE) {
            $this->load->model("Photos/Photo");
            $this->model_name = "Photo";

            $this->paginator['where']['photo_status_id'] = 1;
            $this->paginator['where']['is_deleted'] = 0;
            $this->paginator['where']['photo_category_id'] = $cate_id;
        }

        //config paginator
        $this->paginator['like'] = array($field => $input);
        $this->paginator['limit'] = $limit;
        $this->paginator['order']['created'] = 'DESC';

        //get extra link
        $extra_params = get_extra_params_from_url();

        return array(
            'query' => $input,
            'results' => $this->pagination(5),
            'total' => $this->count_record,
            'pages' => $this->getPaginationLink($search_url, 5, $extra_params),
        );
    }

    /**
     * Get comments of a record and params to add comment
     * @author danhdvd
     * @param int $resource resource id in resource table
     * @param int $record id of record need get comment
     * @param int $limit limit comment per page
     * @return array records, pages, total, cparams, clive
     */
    protected function _comment($resource, $record, $page_url = '', $limit = '') {
        //config
        $counter = DB_FIELD_COUNTER_COMMENT;
        $limit = $limit ? $limit : COMMENT_RECORDS_PER_PAGE;

        //get comments
        $this->load->model('Comments/Comment');
        $this->model_name = "Comment";

        $this->paginator = array();

        $this->paginator['where']['is_delete'] = 0;
        $this->paginator['where']['status_id'] = 1;
        $this->paginator['where']['resource_id'] = $resource;
        $this->paginator['where']['record_id'] = $record;

        $this->paginator['limit'] = $limit;

        $this->paginator['order']['created'] = 'DESC';

        //hash params to comment
        $this->load->helper("strhash");

        $params = array(
            'record_id' => $record,
            'resource_id' => $resource,
            'comment_token' => get_token(),
            'field_update_count' => $counter,
        );

        $live = json_encode(array(
            'record_id' => $record,
            'resource_id' => $resource,
        ));

        return array(
            'records' => $this->pagination(5),
            'pages' => ($page_url != '') ? $this->getPaginationLink($page_url) : NULL,
            'total' => $this->count_record,
            'cparams' => string_hash(json_encode($params)),
            'clive' => $live,
        );
    }

    /**
     * Get votes of a record and params to add vote
     * @author danhdvd
     * @param int $resource_name resource name id in resource table
     * @param int &$record record instance need get vote
     * @param int $type_id vote type id
     * @return array record, vote 
     */
    protected function _vote($resource_name, &$record, $type_id = '') {
        //config default
        $is_voted_name = "is_voted";
        $type_id = $type_id ? $type_id : 1;
        $vote_count = DB_FIELD_COUNTER_VOTE;
        $need_login = VOTE_NEED_LOGIN;

        //if user not login, can not vote anymore
        if ($need_login && !is_login()) {
            return $record;
        }

        //load library
        $this->load->helper("strhash");

        //check voted or not
        $vote = $this->Vote->find("first_array", array(
            'select' => 'id',
            'where' => array('user_id' => $this->session->userdata('user_id'), 'record_id' => $record['id']),
        ));

        if ($vote) {
            $record['vote'][$is_voted_name] = TRUE;
        } else {
            $record['vote'][$is_voted_name] = FALSE;

            //hash params to vote
            $record_id = $record['id'];

            $token = get_token();

            $vote_params = string_hash("$record_id|$resource_name|$type_id|$token|$vote_count");

            $record['vote']['vparams'] = $vote_params;
        }

        return $record;
    }

    /**
     * Get votes of record list and params to add vote list
     * @author danhdvd
     * @param int $resource_name resource name id in resource table
     * @param int &$records record instances need get votes
     * @param int $type_id vote type id
     * @return array records 
     */
    protected function _votes($resource_name, &$records, $type_id = '') {
        //config default
        $is_voted_name = "is_voted";
        $type_id = $type_id ? $type_id : 1;
        $vote_count = DB_FIELD_COUNTER_VOTE;
        $need_login = VOTE_NEED_LOGIN;

        //if user not login, can not vote anymore
        if ($need_login && !is_login()) {
            return $records;
        }

        //load library
        $this->load->helper("strhash");


        $token = get_token();

        //check voted or not
        foreach ($records as $key => $record) {

            $vote = $this->Vote->find("first_array", array(
                'select' => 'id',
                'where' => array('user_id' => $this->session->userdata('user_id'), 'record_id' => $record['id']),
            ));

            $records[$key]['vote'] = array();

            if ($vote) {
                $records[$key]['vote'][$is_voted_name] = TRUE;
            } else {
                $records[$key]['vote'][$is_voted_name] = FALSE;

                //hash params to vote
                $record_id = $record['id'];


                $vote_params = string_hash("$record_id|$resource_name|$type_id|$token|$vote_count");

                $records[$key]['vote']['vparams'] = $vote_params;
            }
        }

        return $records;
    }

    /**
     * Increase view counter of record
     * @author danhdvd
     * @param int $table_name table name
     * @param int $record_id record id need to increase view total
     * @param int $increase_number number quality to add
     * @return boolean 
     */
    protected function _increase_view($table_name, $record_id, $increase_number = '') {
        //set session for user increase view in some time
        if (isset($_SESSION[SESS_VIEWED][$table_name][$record_id]) && $_SESSION[SESS_VIEWED][$table_name][$record_id] === 1) {
            return FALSE;
        }

        //config
        $increase_number = $increase_number ? $increase_number : 1;
        $view_field = DB_FIELD_COUNTER_VIEW;

        $sql = "UPDATE $table_name SET $view_field = $view_field + $increase_number WHERE id = $record_id";

        $this->db->query($sql);

        //set to session
        $_SESSION[SESS_VIEWED][$table_name][$record_id] = 1;

        return TRUE;
    }

    /**
     * Increase view counter of record by ajax
     * @author danhdvd
     * @param int $table_name table name
     * @param int $record_id record id need to increase view total
     * @param int $increase_number number quality to add
     * @return int 0 or 1 
     */
    public function ajax_increase_view($table_name, $record_id, $increase_number = '') {
        //set session for user increase view in some time
        if (isset($_SESSION[SESS_VIEWED][$table_name][$record_id]) && $_SESSION[SESS_VIEWED][$table_name][$record_id] === 1) {
            echo 0;
            die;
        }

        $this->layout->set_layout('empty');

        //config
        $increase_number = $increase_number ? $increase_number : 1;
        $view_field = DB_FIELD_COUNTER_VIEW;

        $sql = "UPDATE $table_name SET $view_field = $view_field + $increase_number WHERE id = $record_id";

        $this->db->query($sql);

        //set to session
        $_SESSION[SESS_VIEWED][$table_name][$record_id] = 1;

        echo 1;
        die;
    }

    /**
     * Config chat for comment
     * @author danhdvd
     * @param int $resource_id resource id need to chat in
     * @param int $record_id record id need to increase view total
     * @return null
     */
    protected function _chat($resource_id, $record_id) {
        if ((COMMENT_NEED_LOGIN == TRUE && is_login()) || COMMENT_NEED_LOGIN == FALSE) {
            //config 
            $session_id = COMMENT_CHAT_SESSION_NAME;

            session_write_close();
            session_name('Global');
            session_id($session_id);
            session_start();

            $user_id = $this->session->userdata('user_id');

            if (!isset($_SESSION[$session_id][$resource_id][$record_id][$user_id])) {
                $_SESSION[$session_id][$resource_id][$record_id][$user_id] = array();
            }

            session_write_close();
        }
    }

    //list
    protected function _list($type_id, $cate_id, $page_url, $order = '', $limit = '', $where_more = '', $except_ids = '', $focus = '') {
        $this->paginator = array();

        //set type content to search
        if ($type_id == ARTICLE_TYPE) {
            //config
            $order = $order ? $order : array('articles.publish_date' => 'DESC');

            $this->load->model("Articles/Article");
            $this->model_name = "Article";

            $this->paginator['leftjoin']['article_dictionaries a'] = "articles.id=a.article_id";
            $this->paginator['leftjoin']['article_category_relationships b'] = "articles.id=b.article_id";
            $this->paginator['select'] = "articles.id, thumbnail_image, is_hot, a.teaser, a.subject, publish_date, articles.counter_view";
            $this->paginator['where']['is_delete'] = 0;
            $this->paginator['where']['is_publish'] = 1;
            $this->paginator['where_wild']['publish_date <= '] = 'NOW()';
            $this->paginator['where']['b.article_category_id'] = $cate_id;

            if ($where_more) {
                $this->paginator['where'] = array_merge($this->paginator['where'], $where_more);
            }

            $this->paginator['limit'] = $limit ? $limit : ARTICLE_RECORDS_PER_PAGE;
            $this->paginator['order'] = $order;
        } else if ($type_id == MUSIC_TYPE) {
            //config
            $order = $order ? $order : array('created' => 'DESC');

            $this->load->model("Musics/Music");
            $this->model_name = "Music";

            $this->paginator['where']['type_id'] = MUSIC_TYPE_ID;
            $this->paginator['where']['category'] = $cate_id;
            $this->paginator['where']['status_id'] = 1;

            if ($where_more) {
                $this->paginator['where'] = array_merge($this->paginator['where'], $where_more);
            }

            $this->paginator['limit'] = $limit ? $limit : MUSIC_RECORDS_PER_PAGE;

            $this->paginator['order'] = $order;
        } else if ($type_id == VIDEO_TYPE) {
            //config
            $order = $order ? $order : array('created' => 'DESC');

            $this->load->model("Musics/Music");
            $this->model_name = "Music";

            $this->paginator['where']['type_id'] = VIDEO_TYPE_ID;
            $this->paginator['where']['category'] = $cate_id;
            $this->paginator['where']['status_id'] = 1;

            if ($where_more) {
                $this->paginator['where'] = array_merge($this->paginator['where'], $where_more);
            }

            $this->paginator['limit'] = $limit ? $limit : VIDEO_RECORDS_PER_PAGE;

            $this->paginator['order'] = $order;
        } else if ($type_id == PHOTO_TYPE) {
            //config
            $order = $order ? $order : array('created' => 'DESC');

            $this->load->model("Photos/Photo");
            $this->model_name = "Photo";

            $this->paginator['where']['is_delete'] = 0;
            $this->paginator['where']['photo_status_id'] = 1;
            $this->paginator['where']['photo_category_id'] = $cate_id;

            if ($where_more) {
                $this->paginator['where'] = array_merge($this->paginator['where'], $where_more);
            }

            $this->paginator['limit'] = $limit ? $limit : PHOTO_RECORDS_PER_PAGE;

            $this->paginator['order'] = $order;
        }

        //check excepts id
        if ($type_id == ARTICLE_TYPE) {
            if ($except_ids) {
                if (is_array($except_ids)) {
                    $str = '(';
                    foreach ($except_ids as $except_id) {
                        $str .= $except_id . ',';
                    }
                    $str = substr($str, 0, strlen($str) - 1);
                    $str .= ')';

                    $this->paginator['where_not_in']['articles.id'] = $except_ids;
                } else if (is_numeric($except_ids)) {
                    $this->paginator['where']['articles.id <>'] = $except_ids;
                }
//                  debug($this->paginator);
            }
        } else {
            if ($except_ids) {
                if (is_array($except_ids)) {
                    foreach ($except_ids as $except_id) {
                        $this->paginator['where']['id <>'] = $except_id;
                    }
                } else if (is_numeric($except_ids)) {
                    $this->paginator['where']['id <>'] = $except_ids;
                }
            }
        }

        // get $_GET
        $extra_params = get_extra_params_from_url();

        $data = array(
            'results' => $this->pagination(5),
            'pages' => $this->getPaginationLink($page_url, 5, $extra_params),
        );

        return $data;
    }

    /**
     * Get detail of a record
     * @todo increase view of record
     * @author danhdvd
     * @param int $type_id type category
     * @param int $record_id record id need to increase view total
     * @return null
     */
    protected function _detail($type_id, $record_id) {

        if (!is_numeric($record_id)) {
            return FALSE;
        }

        //set type content to get detail
        $options = array();
        $model_name = '';
        $resource_name = '';
        $this->paginator = array();

        if ($type_id == ARTICLE_TYPE) {
            $this->load->model("Articles/Article");
            $options['select'] = 'articles.*, ad.subject as subject, ad.content as content, ad.teaser as teaser, ad.tags as tags';
            $options['join'] = array('article_category_relationships acr' => 'acr.article_id = articles.id');
            $options['leftjoin'] = array('article_dictionaries ad' => 'ad.article_id = articles.id');
            $options['where'] = array(
                'articles.is_delete' => 0,
                'articles.is_publish' => 1,
                'articles.id' => $record_id,
                'articles.publish_date <=' => date('Y-m-d H:i:s'),
            );
            $model_name = 'Article';
            $resource_name = 'articles';
        } else if ($type_id == MUSIC_TYPE) {
            $this->load->model("Musics/Music");
            $options['where'] = array('id' => $record_id, 'status_id' => 1, 'type_id' => MUSIC_TYPE_ID);
            $model_name = 'Music';
            $resource_name = 'musics';
        } else if ($type_id == VIDEO_TYPE) {
            $this->load->model("Musics/Music");
            $options['where'] = array('id' => $record_id, 'status_id' => 1, 'type_id' => VIDEO_TYPE_ID);
            $model_name = 'Music';
            $resource_name = 'musics';
        } else if ($type_id == PHOTO_TYPE) {
            $this->load->model("Photos/Photo");

            $model_name = 'Photo';
            $resource_name = 'photos';

            $options['where'] = array(
                'id' => $record_id,
                'photo_status_id' => 1,
                'type_id' => VIDEO_TYPE_ID,
                'is_delete' => 0,
            );
        }

        //increase view
        $this->_increase_view($resource_name, $record_id);
        return $this->$model_name->find('first_array', $options);
    }

    /**
     * Kiểm tra phân quyền trên từng trang
     * Redirect về trang báo lỗi
     * 
     * @param string $penguin_permission r:read, w:write, e:modify, p:publish, d:delete, t:trash
     */
    public function PG_ACL($penguin_permission = 'r') {

        $is_permission = $this->check_PG_ACL($this->getUserRole(), $this->router->class, $penguin_permission);

        if ($is_permission == FALSE) {
            if (strpos($this->router->class, 'admin') !== FALSE) {
//                if(is_login())
//                {
//                    redirect_to('users', 'users', 'permission');
//                }
//                else
//                {
//                    //save last url
//                    $this->session->set_userdata('request_url', full_url());
//
//                    //redirect('users/admin_users/permission');
//                    redirect(base_url('root'));
//                }
//            }
//            else
//            {
                if (is_login()) {
//                    $last_url = previous_url();
//
//                    if($last_url)
//                        redirect($last_url);
//                    else
                    redirect_to('users', 'admin_users', 'permission');
                } else {
                    $this->session->set_userdata('request_url', full_url());
                    //redirect_to('users', 'users', 'permission');
                    //redirect(base_url('/users/login'));
                    redirect(base_url('root'));
                }
            }
        }
    }

    /**
     * Kiểm tra phân quyền trên từng trang
     * 
     * @param string $penguin_permission r:read, w:write, e:modify, p:publish, d:delete, t:trash
     */
    public function isACL($penguin_permission = 'r') {
        return $this->check_PG_ACL($this->getUserRole(), $this->router->class, $penguin_permission);
    }

    /**
     * Kiểm tra quyền truy cập của user
     * Nếu không được phép truy cập redirect về trang thông báo
     * 
     * @param role id $role_id
     * @param int $resource_name controller name
     * @param string $penguin_permission r:read, w:write, e:modify, p:publish, d:delete
     * @return boolean
     */
    public function check_PG_ACL($role_id, $resource_name, $penguin_permission = 'r') {
        return is_allow($role_id, $resource_name, $penguin_permission);
    }

    /**
     * Lấy role của user
     * Nếu user chưa đăng nhập thì role là guest
     * 
     * @return int role_id
     */
    public function getUserRole() {
        if ($this->session->userdata('user_id') > 0)
            return $this->session->userdata('user_user_role_id');
        else
            return ConstUserRole::guest;
    }

    /**
     * get Custom field show on page
     * 
     * @param int $user_id user id 
     * @param int $cfn_id custom field name id
     * @param boolean $is_main
     * @return array fields
     */
    public function getCustomField($user_id, $cfn_id = 0, $resource_name = '', $is_main = TRUE) {
        $resource_name = ($resource_name) ? $resource_name : $this->router->class;

        $resource_id = $this->getResourceID($resource_name, $is_main);

        if ($cfn_id == 0) {
            $conditions = array(
                'custom_field_names.resource_id' => $resource_id,
                'custom_field_names.share' => ConstCustomField::all,
                'custom_field_names.user_id' => $user_id
            );
        } else {
            $conditions = array(
                'custom_field_names.resource_id' => $resource_id,
                'custom_field_names.id' => $cfn_id,
                'custom_field_names.user_id' => $user_id
            );
        }

        // get custom field for resource
        $this->db->select('module_fields.name, module_fields.field_type');
        $this->db->from('custom_fields');
        $this->db->join('custom_field_names', 'custom_fields.name_id = custom_field_names.id');
        $this->db->join('module_fields', 'custom_fields.field_id = module_fields.id');
        $this->db->order_by('module_fields.weight', 'asc');
        $this->db->where($conditions);

        $module_fields = $this->db->get();

        $fields = array();

        // custom field of user
        if ($module_fields->num_rows() > 0) {
            foreach ($module_fields->result() as $fieldObj) {
                $fields[$fieldObj->name] = $fieldObj->field_type;
            }
        } else { // custom field public
            $conditions = array(
                'custom_field_names.resource_id' => $resource_id,
                'custom_field_names.share' => ConstCustomField::all
            );

            // get custom field for resource
            $this->db->select('module_fields.name, module_fields.field_type');
            $this->db->from('custom_fields');
            $this->db->join('custom_field_names', 'custom_fields.name_id = custom_field_names.id');
            $this->db->join('module_fields', 'custom_fields.field_id = module_fields.id');
            $this->db->where($conditions);

            $module_field_public = $this->db->get();

            // check valid
            if ($module_field_public->num_rows() > 0) {
                foreach ($module_field_public->result() as $fieldObj) {
                    $fields[$fieldObj->name] = $fieldObj->field_type;
                }
            }
        }

        if (empty($fields)) {
            return false;
        }

        return $fields;
    }

    /**
     * get all custom field name
     * 
     * @param string $resource_name
     * @param boolean $is_main
     * @return array
     */
    public function getCustomFieldName($resource_name = '', $is_main = TRUE) {
        $resource_name = ($resource_name) ? $resource_name : $this->router->class;

        $resource_id = $this->getResourceID($resource_name, $is_main);

        $this->db->select('id, name');
        $cf_names = $this->db->get_where('custom_field_names', array('resource_id' => $resource_id, 'user_id' => $this->session->userdata('user_id')));

        if ($cf_names->num_rows() > 0) {
            return $cf_names->result_array();
        }

        $this->db->select('id, name');
        $cf_names = $this->db->get_where('custom_field_names', array('resource_id' => $resource_id, 'share' => ConstCustomField::all));
    }

    /**
     * get ID resource 
     * 
     * @param string $resource_name
     * @param boolean $is_main
     * @return int id resource
     */
    public function getResourceID($resource_name = '', $is_main = TRUE) {
        $resource_name = ($resource_name) ? $resource_name : $this->router->class;

        if ($is_main == TRUE) {
            $this->db->select('id');
            $resource = $this->db->get_where('module_resources', array('name' => $resource_name));
        } else {
            $this->db->select('main_id AS id');
            $resource = $this->db->get_where('module_resources', array('name' => $resource_name));
        }

        if ($resource->num_rows() == 0) {
            return false;
        }

        return $resource->row()->id;
    }

    /**
     * get Name resource from ID
     * 
     * @param int $resource_id
     * @return string
     */
    public function getResourceName($resource_id) {
        $this->db->select('name');
        $this->db->from('module_resources');
        $this->db->where(array('id' => $resource_id));
        $resource_query = $this->db->get();

        if ($resource_query->num_rows() == 0) {
            return FALSE;
        }

        return $resource_query->row()->name;
    }

    /**
     * Get moduleID of resource
     * 
     * @param string $resource_name
     * @return int
     */
    public function getModuleID($resource_name = '') {
        $resource_name = ($resource_name) ? $resource_name : $this->router->class;
        $this->db->select('module_id');
        $resource = $this->db->get_where('module_resources', array('name' => $resource_name));

        if ($resource->num_rows() == 0) {
            return FALSE;
        }

        return $resource->row()->module_id;
    }

    /**
     * Get Module Name from resource name
     * 
     * @param string $resource_name
     * @param int $module_id
     * @return string module name
     */
    public function getModuleName($resource_name = '', $module_id = 0) {
        // if is module ID
        if ($module_id) {
            $this->db->select('name');
            $module = $this->db->get_where('modules', array('id' => $module_id));

            if ($module->num_rows() == 0) {
                return FALSE;
            }

            return $module->row()->name;
        }

        // get resource name
        $resource_name = ($resource_name) ? $resource_name : $this->router->class;

        // get resource
        if (is_numeric($resource_name)) { // param is id
            $this->db->select('module_id');
            $resource = $this->db->get_where('module_resources', array('id' => $resource_name));
        } else { // param is name
            $this->db->select('module_id');
            $resource = $this->db->get_where('module_resources', array('name' => $resource_name));
        }

        // check exit
        if ($resource->num_rows() == 0) {
            return FALSE;
        }

        // get module
        $this->db->select('name');
        $module = $this->db->get_where('modules', array('id' => $resource->row()->module_id));

        // check exit
        if ($module->num_rows() == 0) {
            return FALSE;
        }

        return $module->row()->name;
    }

    /**
     * Pagination
     * 
     * @param int $segment
     * @return array
     */
    public function pagination($segment = 5, $force_offset = FALSE) {
        if (is_router($this->router->class, FALSE)) {
            $segment++;
        }

        // get model name
        $model = $this->model_name;

        if ($model) {
            // load model if load not yet
            if (!class_exists($model)) {
                $this->load->model($model);
            }
        }

        //edit by danhdvd
        //sort if admin
        if (is_admin()) {
            $this->_sort();
            $this->_filter($this->$model->getTable());
        }

        if ($this->config->item('enable_named_strings') === TRUE) {
            $offset = $this->input->named('page');
        } else {
            $offset = $this->uri->segment($segment);
        }

        //edit by danhdvd
        if ($force_offset !== FALSE) {
            $offset = (int) $force_offset;
        }

        // get option query
        $options = $this->paginator;

        // check offset
        if (!is_numeric($offset)) {
            $offset = '';
        }

        // set limit
        if (!(isset($options['limit']) && $options['limit'])) {
            $options['limit'] = 20;
        }

        // set offset
        $options['offset'] = $offset;



        // check exit
        if ($model) {

            // get result
            $result = $this->$model->find('all', $options);
            // get total count            
            $this->count_record = $this->$model->find('count', $options);

            return $result;
        }

        return array();
    }

    /**
     * Get link pagination 
     * 
     * @param string $uri
     * @return string 
     */
    public function getPaginationLink($uri, $segment = 5, $extra_params = '') {
        $check_uri = is_router($uri);
        if (!empty($check_uri)) {
            $uri = $check_uri;
            $segment++;
        }

        if (isset($this->paginator['limit']) && $this->paginator['limit']) {
            $limit = $this->paginator['limit'];
        } else {
            $limit = 20;
        }

        return pagination_config($uri, $this->count_record, $limit, $segment, $open_tag = '', $close_tag = '', $extra_params);
    }

    /**
     * Get link pagination 
     * @access ConDuongAmNhac
     * 
     * @param string $uri = get_link $module/$controller/$action/$params
     * @param boolean $is_ajax
     * @return string 
     */
    public function getPaginationCustom($module, $controller, $action, $params, $segment = 5, $is_ajax = FALSE, $extra_param = '') {
        if (isset($this->paginator['limit']) && $this->paginator['limit']) {
            $limit = $this->paginator['limit'];
        } else {
            $limit = 20;
        }

        if ($is_ajax == TRUE) {
            return pagination_ajax($module, $controller, $action, $params, $this->count_record, $limit, $segment, $extra_param);
        } else {
            return pagination_custom($module, $controller, $action, $params, $this->count_record, $limit, $segment, $extra_param);
        }
    }

    /**
     * Delete record from database
     * View on delete list view
     * 
     * @param $is_delete
     * @param $is_restore
     */
    public function deleteRecordOnListView($is_delete = FALSE, $is_restore = FALSE) {
        // get model name
        $model = $this->model_name;

        // load model if load not yet
        if (!class_exists($model)) {
            $this->load->model($model);
        }

        // get link redirect to manage page
        $link_redirect = $this->router->fetch_module() . '/' . $this->router->class;
        // add params redirect
        if ($this->input->post('p_redirect')) {
            $link_redirect .= $this->input->post('p_redirect');
        }

        $link_redirect = $link_redirect;

        // check post data from form
        if ($this->input->post()) {
            $list_delete_ids = $this->input->post('listViewId');

            if (empty($list_delete_ids)) {
                $this->session->set_flashdata('error_message', lang('Error params'));
                redirect($link_redirect);
            }

            foreach ($list_delete_ids as $list_delete_id) {
                // if exit field is_delete -> update is_delete = 1
                if ($is_delete == TRUE) {
                    // restore recycle bin -> update is_delete = 0
                    if ($is_restore == TRUE) {
                        $this->$model->delete(array('id' => $list_delete_id), TRUE);
                    } else { // delete record to recycle bin -> update is_delete = 1
                        $this->$model->delete(array('id' => $list_delete_id));
                    }
                } else { // not exit field is_delete -> delete record
                    $this->$model->deleteRecord(array('id' => $list_delete_id));
                }
            }

            $this->session->set_flashdata('success_message', lang('Success'));
            redirect($link_redirect);
        } else {
            $this->session->set_flashdata('error_message', lang('Error params'));
            redirect($link_redirect);
        }
    }

    /**
     * DELETE
     * UPDATE record is_delete = 1
     */
    public function deleteOnListView() {
        $this->deleteRecordOnListView(TRUE);
    }

    /**
     * RESTORE
     * UPDATE record is_delete = 0
     */
    public function restoreOnListView() {
        $this->deleteRecordOnListView(TRUE, TRUE);
    }

    /**
     *
     * set item per page for pagination
     *
     * @author TungCN
     * @param integer $item_per_page
     */
    public function setItemPerPage($item_per_page) {
        $this->paginator['limit'] = $item_per_page;
    }

    /**
     * 
     * check cookie, if user remember to login, we login
     * 
     * @author TungCN
     */
    private function _check_remember_login() {
        $this->load->helper('cookie');

        $hash_string = get_cookie('pa_lo_cdam');

        if ($hash_string) {
            $this->load->helper('strhash');

            $params = string_hash($hash_string, FALSE);
            $params = explode('|', $params);

            if (!is_array($params) || count($params) < 3 || $params['0'] != 'remember') {
                return FALSE;
            }

            $this->load->model('Users/User');
            $this->User->login($params[1], $params[2]);
        }
    }

    private function _check_user_online() {
        // load helper
        $this->load->helper('file');

        $session_id = session_id();
        //echo $session_id;
        $current_time = time();
        $expired_time = $current_time + 10 * 60;


        $filename = 'sys_user_online';
        $filepath = FPENGUIN . 'application/cache/' . $filename;

        // Init
        $contents = '';
        $list_sessions = array();

        // read file
        $contents = read_file($filepath);

        // json decode
        $list_sessions = json_decode($contents, TRUE);

        if (is_array($list_sessions) && count($list_sessions) > 0) {
            foreach ($list_sessions as $key => $session) {
                // this session is expried
                // remove that
                if ($current_time > $session['expried_time']) {
                    unset($list_sessions[$key]);
                    continue;
                }
            }
        }

        $list_sessions[$session_id] = array(
            'session_id' => $session_id,
            'expried_time' => $expired_time,
        );

        // json encode
        $contents = json_encode($list_sessions);

        // write file
        write_file($filepath, $contents);
    }

    /**
     * @author TungCN
     *
     * check SSO, and insert into DB if user is new
     */
    protected function _check_sso() {
        //var_dump($_SESSION['user']);
        // chua co session user
        // can check SSO
        if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
            // load model
            $this->load->model('users/User');
            // check SSO
            $status = $this->User->check_sso_n_insert_user();
        } else {
            $cookie_auth = get_cookie('vngauth');
            $cookie_uin = get_cookie('uin');

            if (empty($cookie_auth) || empty($cookie_uin) || strpos($cookie_uin, strval($_SESSION['user']['passport_id'])) === FALSE) {

                unset($_SESSION['user']);


                $this->session->unset_userdata('user_id');
                $this->session->unset_userdata('user_username');
                $this->session->unset_userdata('is_administrator');


                if (!empty($cookie_auth) && !empty($cookie_uin)) {

                    // load model
                    $this->load->model('users/User');
                    // check SSO
                    $status = $this->User->check_sso_n_insert_user();
                }
            }
            //co session va full acceess
            else if (isset($_SESSION['user']['user_id'])) {
                $this->session->set_userdata('user_id', $_SESSION['user']['user_id']);
                $this->session->set_userdata('user_username', $_SESSION['user']['username']);
            }
        }
    }

}

?>
