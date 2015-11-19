<?php

if(!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Comments
 * ...
 * 
 * @package PenguinFW
 * @subpackage Comment
 * @version 1.0.0
 * 
 * @property Comment $Comment
 */
class Comments extends MY_Controller {

    function __construct()
    {
        parent::__construct();

        $this->model_name = 'Comment';

        $this->lang->load('generate', lang_web());
        $this->lang->load('comments', lang_web());

        $this->load->model('Comment');
    }

    /**
     * add comment
     * 
     * @param string (string_hash) break |
     *  params: 
     *  params: $record_id|$resource_name|$parent_id|$field_update_count
     *  comment:
     */
    public function add()
    {
        // check permission
        if(!$this->isACL('w'))
        {
            $result = array(
                'status' => 'error',
                'message' => lang('You can not comment for this record. Please contact to administator')
            );
            echo json_encode($result);
            exit();
        }

        // set layout
        $this->layout->set_layout('empty');

        // process data
        if($this->input->post())
        {
            $params_hash = $this->input->post('params');
            $comment = $this->input->post('comment');

            // check params hash
            if(isset($params_hash) && isset($comment))
            {
                // load helper
                $this->load->helper('htmlpurifier');

                // trim data
                $comment = trim($comment);

                // HTML clearly
                $comment = purify($comment);

                // check maximum char
                if(strlen($comment) < config_item('comments_max_char'))
                {
                    $result = array(
                        'status' => 'error',
                        'message' => sprintf(lang('Please input more %d char'), config_item('comments_max_char'))
                    );
                    echo json_encode($result);
                    exit();
                }

                // load helper
                $this->load->helper('smiley');
                // insert smiley
                $comment = parse_smileys($comment, img_url() . "static/default/images/smileys/");

                // check params hash value
                if($params_hash && $comment)
                {
                    // lib
                    $this->load->helper('strhash');

                    $params_convert = string_hash($params_hash, FALSE);

                    // check param format
                    if($params_convert && strpos($params_convert, '|') !== FALSE)
                    {
                        // get params
                        $params = explode('|', $params_convert);
                        // recode id
                        $record_id = (isset($params[0]) && $params[0]) ? $params[0] : 0;
                        // resource name
                        $resource_name = (isset($params[1]) && $params[1]) ? $params[1] : '';
                        // resource id
                        $resource_id = 0;
                        if($resource_name)
                        {
                            $resource_id = $this->getResourceID($resource_name);
                        }
                        // parent id
                        $parent_id = (isset($params[2]) && $params[2]) ? $params[2] : 0;
                        // get field_update_count
                        $field_update_count = (isset($params[3]) && $params[3]) ? $params[3] : '';

                        // save comment
                        if($record_id && $resource_id)
                        {
                            $comment_save = array(
                                'record_id' => $record_id,
                                'comment' => $comment,
                                'resource_id' => $resource_id,
                                'user_ip' => $this->input->ip_address(),
                                'parent_id' => $parent_id
                            );

                            // default status
                            if(config_item('comments_is_automatic_approval'))
                            {
                                $comment_save['status_id'] = 1;
                            }

                            // save
                            if($this->Comment->create($comment_save))
                            {
                                // add count
                                if(config_item('comments_is_automatic_approval') && $field_update_count)
                                {
                                    $this->Comment->addOrSubtractCommentCount($resource_id, $record_id, $field_update_count, 'add');

                                    $result = array(
                                        'status' => 'success',
                                        'message' => lang('Your comment is added success')
                                    );
                                    echo json_encode($result);
                                    exit();
                                }
                                else
                                {
                                    $result = array(
                                        'status' => 'warning',
                                        'message' => lang('Your comment is waiting to approve')
                                    );
                                    echo json_encode($result);
                                    exit();
                                }
                            }
                        }
                    }
                }
            }

            $result = array(
                'status' => 'error',
                'message' => lang('Your comment can not add. Please try again')
            );
            echo json_encode($result);
            exit();
        }
    }

    /**
     * @author TungCN
     * 
     * Add comment
     * 
     * @param array (json_decode)
     */
    public function add_comment()
    {
        // set permission
        $need_login = $this->input->post('need_login');

        if($need_login == TRUE && !$this->isACL('w'))
        {
            $result = array(
                'status' => 'error',
                'message' => lang('You dont have permission to comment.')
            );

            echo json_encode($result);
            exit();
        }

        // set layout
        $this->layout->set_layout('empty');

        // lib
        $this->load->helper('strhash');
        $this->load->helper('htmlpurifier');

        // comment
        if($this->input->post())
        {
            // Init
            $data_add = array();

            $data_add['comment'] = purify(trim($this->input->post('comment_content')));
            $data_add['username'] = $this->session->userdata('user_username') ? $this->session->userdata('user_username') : $this->input->post('comment_username');
            $data_add['user_email'] = $this->input->post('comment_email');

            if($need_login == FALSE)
            {
                $data_add['username'] = $data_add['username'] ? $data_add['username'] : 'Guest';
                $data_add['user_email'] = $data_add['user_email'] ? $data_add['user_email'] : 'guest@zing.vn';
            }

            $comment_type = $this->input->post('comment_type');

            $params_hash = $this->input->post('cparams');
            $params_string = string_hash($params_hash, FALSE);

            if($params_string && $data_add['comment'] != '')
            {

                // record_id|resource_name|token|field_update_count
                //$params = @explode('|', $params_string);
                $params = json_decode($params_string, TRUE);

                if(is_array($params))
                {

                    $data_add['record_id'] = $params['record_id'];

                    //if have resource id, no need resource name
                    $data_add['resource_id'] = $params['resource_id'];

                    if($data_add['resource_id'] == FALSE)
                    {
                        $data_add['resource_name'] = $params['resource_name'];

                        // get resource_id
                        if($data_add['resource_name'])
                        {
                            $data_add['resource_id'] = $this->getResourceID($data_add['resource_name']);
                        }
                    }

                    $token = $params['comment_token'];

                    $data_add['field_update_count'] = $params['field_update_count'];

                    if($data_add['resource_id'] && $token)
                    {
                        $data_add['user_id'] = $this->session->userdata('user_id');

                        $data_add['user_ip'] = getRealIp();//$this->input->ip_address();

                        $data_add['status_id'] = ($this->config->item('comments_is_automatic_approval')) ? 1 : 0;
                        
                        $data_add['created'] = date('Y-m-d H:i:s');
                        
             
                        if(($id = $this->Comment->add_comment($data_add, TRUE)))
                        {
                            if(config_item('comments_is_automatic_approval') && $data_add['field_update_count'])
                            {
                                $this->Comment->addOrSubtractCommentCount($data_add['resource_id'], $data_add['record_id'], $data_add['field_update_count'], 'add');

                                //filter bad word
                                $data_add['comment'] = filter_bad_word_comment_content(nl2br($data_add['comment']));
                                
                                if($comment_type == 'drop')
                                {
                                    $result = array(
                                        'status' => 'success',
                                        'message' => lang('Your comment is added successfully'),
                                        'record' => $this->parser->parse('item', $data_add),
                                    );
                                }
                                else
                                {
                                    $result = array(
                                        'status' => 'success',
                                        'message' => lang('Your comment is added successfully'),
                                    );
                                }

                                //set to session to update
                                
                                $session_id = COMMENT_CHAT_SESSION_NAME;
                                session_write_close();
                                session_name('Global');
                                session_id($session_id);
                                session_start();


                                if(!isset($_SESSION[$session_id][$data_add['resource_id']][$data_add['record_id']]))
                                {

                                    $_SESSION[$session_id][$data_add['resource_id']][$data_add['record_id']] = array();
                                }

                                $comments = $_SESSION[$session_id][$data_add['resource_id']][$data_add['record_id']];


                                foreach($comments as $key => $comment)
                                {
                                    if($key != $data_add['user_id'])
                                    {
                                        $comments[$key][] = array(
                                            'username' => $data_add['username'],
                                            //'user_id' => $data_add['user_id'],
                                            'comment' => $data_add['comment'],
                                             'date' => format_date( $data_add['created'], 'M j, H:i'),
                                        );
                                    }
                                }

                                if(!isset($comments[$data_add['user_id']]))
                                {
                                    $comments[$data_add['user_id']] = array();
                                }

                                $_SESSION[$session_id][$data_add['resource_id']][$data_add['record_id']] = $comments;
                                //debug($_SESSION['comment_update']);
                                session_write_close();
                                //session_name("Private");
                                //session_start();
                            }
                            else
                            {
                                $result = array(
                                    'status' => 'warning',
                                    'message' => lang('Your comment is waiting to approve')
                                );
                            }

                            echo json_encode($result);
                            exit();
                        }
                    }
                } //// check params
            } //// get params
        } // // vote post data


        $result = array(
            'status' => 'error',
            'message' => lang('Your comment can not add. Please try again')
        );

        echo json_encode($result);
        exit();
    }

    /**
     * @author TungCN
     * 
     * Add comment
     * 
     * @param array (json_decode)
     */
    public function get()
    {
        // set layout
        $this->layout->set_layout('empty');

        // lib
        $this->load->helper('strhash');
        $this->load->helper('htmlpurifier');

        // get comment
        if($this->input->post())
        {
            // Init
            $data_get = array();

            $params_hash = $this->input->post('cparams');
            $params_string = string_hash($params_hash, FALSE);

            if($params_string)
            {

                //get current url
                $page_url = $this->input->post('page_url');

                // record_id|resource_name|token|field_update_count
                //$params = @explode('|', $params_string);
                $params = json_decode($params_string, TRUE);

                if(is_array($params))
                {
                    $data_get['record_id'] = $params['record_id'];

                    $data_get['resource_name'] = $params['resource_name'];

                    // get resource_id
                    if($data_get['resource_name'])
                    {
                        $data_get['resource_id'] = $this->getResourceID($data_get['resource_name']);
                    }

                    $token = $params['comment_token'];


                    if($data_get['record_id'] && $data_get['resource_id'] && $token)
                    {

                        //get comments
                        $this->load->model('Comments/Comment');
                        $this->model_name = "Comment";

                        $this->paginator['where'] = array(
                            'is_delete' => 0,
                            'resource_id' => $data_get['resource_id'],
                            'record_id' => $data_get['record_id'],
                            'status_id' => 1,
                        );
                        $this->paginator['order'] = array(
                            'created' => 'desc',
                        );
                        $this->paginator['limit'] = PHOTO_COMMENT_RECORDS_PER_PAGE;

                        if(($data['comments'] = $this->pagination(5)))
                        {

                            $data['pages_link'] = $this->getPaginationLink($page_url, 5);

                            $data['total_comments'] = $this->count_record;

                            $result = array(
                                'status' => 'success',
                                'message' => lang('Comments is get successfully'),
                                'data' => $this->parser->parse('list', $data, TRUE),
                            );
                        }
                        else
                        {
                            $result = array(
                                'status' => 'success',
                                'message' => 'Không có comment nào',
                                'data' => ''
                            );
                        }

                        echo json_encode($result);
                        exit();
                    }
                }
            } //// check params
        } //// get params


        $result = array(
            'status' => 'error',
            'message' => lang('Can not load comments for this article. Please try again'),
            'data' => '',
        );

        echo json_encode($result);
        exit();
    }

    public function ajax_live($resource_id = '', $record_id = '')
    {
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        
        
        //check url
        if(!$resource_id || !$record_id)
        {
            die;
        }

        //check login
        $user_id = $this->session->userdata('user_id');

        if($user_id == '')
        {
            die;
        }
        
        $this->layout->disable_layout();

        //update set session global
        $session_id = COMMENT_CHAT_SESSION_NAME;

        session_write_close();
        session_name('Global');
        session_id($session_id);
        session_start();
        //unset($_SESSION['comment_update']);

        if(isset($_SESSION[$session_id][$resource_id][$record_id][$user_id]) && $_SESSION[$session_id][$resource_id][$record_id][$user_id])
        {

            $comments = $_SESSION[$session_id][$resource_id][$record_id][$user_id];

            $response = '';

            foreach($comments as $cmt)
            {
                //if($cmt['username'] != $username && $cmt['user_id'] != $user_id)
                $response .= $this->parser->parse('item', $cmt);
            }

            echo "data: $response<body>\n\n</body>";

            //update once time
            unset($_SESSION[$session_id][$resource_id][$record_id][$user_id]);
            $_SESSION[$session_id][$resource_id][$record_id][$user_id] = array();
        
        }

        session_write_close();
        flush();
    }

    public function ajax_update($resource_id = '', $record_id = '')
    {

        header('Cache-Control: no-cache');

        //check url
        if(!$resource_id || !$record_id)
        {
            die;
        }

        //check login
        $user_id = $this->session->userdata('user_id');

        if($user_id == '')
        {
            die;
        }

        $this->layout->set_layout("empty");

        //update set session global
        $session_id = COMMENT_CHAT_SESSION_NAME;

        session_write_close();
        session_name('Global');
        session_id($session_id);
        session_start();
        //unset($_SESSION['comment_update']);
        //debug($_SESSION['comment_update'][$resource_id][$record_id]);
        if(isset($_SESSION[$session_id][$resource_id][$record_id][$user_id]))
        {

            $comments = $_SESSION[$session_id][$resource_id][$record_id][$user_id];

            $response = '';

            foreach($comments as $cmt)
            {
                //if($cmt['username'] != $username && $cmt['user_id'] != $user_id)
                $response .= $this->parser->parse('item', $cmt);
            }


            //update once time
            unset($_SESSION[$session_id][$resource_id][$record_id][$user_id]);
            $_SESSION[$session_id][$resource_id][$record_id][$user_id] = array();
            //debug($_SESSION['comment_update'][$resource_id][$record_id]);          
        }

        if($response)
            echo $response;
        else
            echo 0;

        session_write_close();
        flush();
    }

}

?>