<?php

if(!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_comments
 * ...
 * 
 * @package PenguinFW
 * @subpackage Comment
 * @version 1.0.0
 * 
 * @property Comment $Comment
 */
class Admin_comments extends MY_Controller {

    function __construct()
    {
        parent::__construct();

        $this->model_name = 'Comment';

        $this->layout->set_layout('admin');

        $this->lang->load('generate', lang_web());
        $this->lang->load('comments', lang_web());

        $this->load->model('Comment');
    }

    /**
     * LIST View
     * 
     * @param string $action index, restore
     * @param string $resource_name
     * @param int $cfn_id
     */
    private function _listView($action = 'index', $resource_name = 0, $cfn_id = 0)
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
        $filter_status_id = $this->input->get('status_id');
        if($filter_status_id)
        {
            if($filter_status_id == -1)
            {
                $filter_status_id = 0;
            }
            $this->paginator['where']['comments.status_id'] = $filter_status_id;
        }
        
        //filter record_id
        $filter_record_id = $this->input->get('record_id');
        if($filter_record_id)
        {
            $this->paginator['where']['comments.record_id'] = $filter_record_id;
        }

        // filter created from date
        $filter_from_date = $this->input->get('from_date');
        if($filter_from_date)
        {
            $this->paginator['where']['DATE(comments.created) >='] = standar_date($filter_from_date, '-', '-');
        }

        // filter created end date
        $filter_to_date = $this->input->get('to_date');
        if($filter_to_date)
        {
            $this->paginator['where']['DATE(comments.created) <='] = standar_date($filter_to_date, '-', '-');
        }

        // filter username
        $filter_username = $this->input->get('username');
        if($filter_username)
        {
            $this->paginator['where']['comments.username'] = $filter_username;
        }

        // set conditions        
        if($action == 'recyclebin')
        { // recycle bin list
            $this->paginator['where']['is_delete'] = 1;
        }
        else // valid list
        {
            $this->paginator['where']['is_delete'] = 0;
        }

        $this->paginator['select'] = 'comments.*, module_resources.name as resource_id';
        $this->paginator['join'] = array(
            'module_resources' => 'module_resources.id = comments.resource_id'
        );

        $this->paginator['order'] = array('comments.id' => 'desc');

        // not empty resource name
        if($resource_name)
        {
            // get resource
            $resource = $this->Comment->find('first', array(
                'select' => 'id',
                'from' => 'module_resources',
                'where' => array('name' => $resource_name)
                    ));

            // resource valid
            if($resource)
            {
                // set conditions
                $this->paginator['where']['module_resources.id'] = $resource->id;
            }
        }

        // get $_GET
        $extra_params = get_extra_params_from_url();

        // get list comment
        $comments = $this->pagination(6);

        $update_field_name = '';

        switch($resource_name)
        {
            case 'articles':
                $update_field_name = 'counter_user_voting';
                break;
        }

        // set data
        return array(
            'list_views' => $comments,
            'cfn_id' => $cfn_id,
            'p_resource_name' => $resource_name,
            'update_field_name' => $update_field_name,
            'this_resource' => $this->router->class,
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'link_edit' => array(
                'View' => 'comments/admin_comments/view/'
            ),
            'pagination_link' => $this->getPaginationLink('/comments/admin_comments/' . $action . '/' . $resource_name . '/' . $cfn_id, 6, $extra_params)
        );
    }

    /**
     * LIST View
     * 
     * @param string $resource_name
     * @param int $cfn_id 
     */
    public function index($resource_name = '', $cfn_id = 0)
    {
        // check permission
        $this->PG_ACL('r');

        // set title
        $this->layout->set_title(lang('Comment manager'));

        // get list view
        $data = $this->_listView('index', $resource_name, $cfn_id);

        //total record
        $data['total_records'] = $this->count_record;

        // set template
        $this->parser->parse($this->router->class . '/index', $data);

        //set last url
        $_SESSION[URL_LAST_SESS_NAME] = full_url();
    }
    
    public function bad_word($action = 'index')
    {
        // check permission
        $this->PG_ACL('r');

        // set title
        $this->layout->set_title(lang('Comment Bad Word'));

        // get list view
        static $filter;

        if (!$filter) {
            $filter = read_file(APPPATH . 'modules/comments/config/bad_words.txt');
            $filter = explode(' ', $filter);
            
            $filter2 = read_file(APPPATH . 'modules/comments/config/bad_sentences.txt');
            $filter2 = explode(';', $filter2);
            

            $bad_words = '';
            
            if ($filter) {
                foreach ($filter as $key => $value) {
                    $bad_words[] = array(
                        'id' => $key,
                        'name' => trim($value)
                    );
                }
            }
            $size = sizeof($bad_words);
            if ($filter2) {
                foreach ($filter2 as $key => $value) {
                    $bad_words[] = array(
                        'id' => $key + $size ,
                        'name' => trim($value)
                    );
                }
            }
        }

        $data = array(
            'list_views' => $bad_words,
            'fields' => array(
                'id' => 'NUM',
               'name' => 'TEXT',
               ),
            'link_edit' => array(
                'Edit' => 'comments/admin_comments/bad_word/edit/',
            ),
        );

        // set template
        $this->parser->parse($this->router->class . '/bad_word', $data);
    }

    /**
     * View comment
     * 
     * @param int $comment_id
     */
    public function view($comment_id = 0)
    {
        // check permission
        $this->PG_ACL('r');

        // set title
        $this->layout->set_title(lang('Comment view'));

        // get comment
        $comment = $this->Comment->get(array('id' => $comment_id));

        $resource = $this->getResourceName($comment->resource_id);
        $module = $this->getModuleName($resource);

        // set template
        $this->parser->parse($this->router->class . '/view', array(
            'data_view' => $comment,
            'module' => $module,
            'resource' => $resource
        ));
    }

    /**
     * LIST Recycle Bin
     * 
     * @param string $resource_name
     * @param int $cfn_id 
     */
    public function recyclebin($resource_name = '', $cfn_id = 0)
    {
        // check permission
        $this->PG_ACL('t');

        // set title
        $this->layout->set_title(lang('Comment manager') . ' - ' . lang('Recycle Bin'));

        // get list view
        $data = $this->_listView('recyclebin', $resource_name, $cfn_id);

        // set template
        $this->parser->parse($this->router->class . '/recyclebin', $data);
    }

    /**
     * PUBLISH          
     */
    public function delete()
    {
        $list_ids = $this->input->post('listViewId');
        $publish_type = $this->input->post('publish_type');
        $update_field_name = $this->input->post('update_field_name');

        // check data valid
        if(empty($list_ids))
        {
            show_error(lang('Error params'));
        }

        if(!empty($list_ids))
        {
            if($publish_type == 1)
            {
                // is_publish
                // check permission
                $this->PG_ACL('p');

                foreach($list_ids as $id)
                {
                    $this->_publish($id, $update_field_name);
                }
            }
            else if($publish_type == -1)
            {
                // un publish
                // check permission
                $this->PG_ACL('p');

                foreach($list_ids as $id)
                {
                    $this->_publish($id, $update_field_name, FALSE);
                }
            }
            else
            {
                // is delete
                // check permission
                $this->PG_ACL('d');

                // delete
                $this->deleteOnListView();
            } // end
            // redirect
            if(isset($_SESSION[URL_LAST_SESS_NAME]))
            {
                $last_url = $_SESSION[URL_LAST_SESS_NAME];
                unset($_SESSION[URL_LAST_SESS_NAME]);
                redirect($last_url);
            }
            else
            {
                $l_redirect = $this->input->post('p_redirect') ? $this->input->post('p_redirect') : '';

                redirect('comments/admin_comments/' . $l_redirect);
            }
        }
    }

    /**
     * RESTORE
     */
    public function restore()
    {
        // check permission
        $this->PG_ACL('t');

        // restore
        $this->restoreOnListView();
    }

    /**
     * chang status
     *
     * @param int $id
     * @param boolean $is_publish
     * @return boolean
     */
    private function _publish($id, $update_field_name, $is_publish = TRUE)
    {
        $comment = $this->Comment->get(array('id' => $id));
        if(!$comment)
        {
            return FALSE;
        }

        // update status
        if($is_publish)
        {
            // increase counter comment
            if(!$comment->status_id)
            {
                $this->Comment->addOrSubtractCommentCount($comment->resource_id, $comment->record_id, $update_field_name, 'add');
            }

            // update status
            $this->Comment->update(array('status_id' => ConstCommentsStatus::Approved), array('id' => $id));
        }
        else
        {
            // decrease counter comment
            if($comment->status_id)
            {
                $this->Comment->addOrSubtractCommentCount($comment->resource_id, $comment->record_id, $update_field_name, 'subtract');
            }
            // update status
            $this->Comment->update(array('status_id' => ConstCommentsStatus::NoApproved), array('id' => $id));
        }

        return TRUE;
    }

}

?>