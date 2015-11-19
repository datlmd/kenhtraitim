<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_votes
 * ...
 * 
 * @package PenguinFW
 * @subpackage Vote
 * @version 1.0.0
 * 
 * @property Vote       $Vote
 * @property Vote_type  $Vote_type
 */
 
class Admin_votes extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Vote';
        
        // set layout
        $this->layout->set_layout('admin');
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('votes', lang_web());
            
        $this->load->model('Vote');
    }
    
    /**
     * LIST
     * 
     * @param int $cfn_id custom field name ID
     */
    public function index($resource_name = 0, $cfn_id = 0)
    {
        // check permission
        $this->PG_ACL('r');
        
        $this->layout->set_javascript(array(
            'jquery.ui.core.min.js',
            'jquery.ui.datepicker.min.js',
        	'jquery.ui.timepicker.js',
            'shadowbox/shadowbox.js',
            'shadowbox/init.js',
        ));

        // set css to view
        $this->layout->set_rel(array(
            'jquery.ui.base.css',
            'jquery.ui.datepicker.css',
        	'jquery.ui.timepicker.css',
            'js' => 'shadowbox/shadowbox.css'
        )); 
        
        // set title
        $this->layout->set_title(lang('Vote manager'));
        
        // filter
        // filter vote type
        $filter_type_id = $this->input->get('type_id');
        if ($filter_type_id)
        {
            $this->paginator['where']['v.type_id'] = $filter_type_id;
        }
        
        // filter username
        $filter_username = $this->input->get('username');
        if ($filter_username)
        {
            $this->paginator['where']['v.username'] = $filter_username;
        }
        
        // filter record_id
        $filter_record_id = $this->input->get('record_id');
        if ($filter_record_id)
        {
            $this->paginator['where']['v.record_id'] = $filter_record_id;
        }
        
    // filter created from date
    	$filter_from_date = $this->input->get('from_date');
    	if ($filter_from_date)
    	{
    		$this->paginator['where']['DATE(v.created) >= '] = standar_date($filter_from_date, '-', '-');    		
    	}
    	 
    	// filter created end date
    	$filter_to_date = $this->input->get('to_date');
    	if ($filter_to_date)
    	{
    		$this->paginator['where']['DATE(v.created) <= '] = standar_date($filter_to_date, '-', '-');
    	}
        
        // conditions
        $this->paginator['select'] = 'v.*, vt.name as type_id, r.name as resource_id';
        $this->paginator['from'] = 'votes as v';
        $this->paginator['join'] = array(
            'vote_types as vt' => 'v.type_id = vt.id',
            'module_resources as r' => 'r.id = v.resource_id'
        );
        
        $this->paginator['where']['r.name'] = $resource_name;
        
        // get all vote
        $votes = $this->pagination(6);
        
        // get $_GET
        $extra_params = get_extra_params_from_url();
        
        // set data
        $data = array(
            'list_views' => $votes,
            'cfn_id' => $cfn_id, 
            'resource_name' => $resource_name,
            'type_ids' => $this->Vote->find('all', array(
                'select' => 'id,name',
                'from' => 'vote_types'
            )),
            
            'this_resource' => $this->router->class,
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'link_edit' => array(                
                'View' => 'votes/admin_votes/view/'
            ),
            'pagination_link' => $this->getPaginationLink('/votes/admin_votes/index/' . $resource_name . '/' . $cfn_id, 6, $extra_params)
        );
        
        //total record
        $data['total_records'] = $this->count_record;
        
        // set template
        $this->parser->parse($this->router->class . '/index', $data);
    }
    
    /**
     * VIEW DETAIL
     * 
     * @param int $id
     */
    public function view($id = 0)
    {
        // check permission
        $this->PG_ACL('r');
        
        // not params
        if ($id == 0)
        {
            show_error(lang('Error params'));
        }
        
        // get votes
        $votes = $this->Vote->find('first', array(
            'from' => 'votes as v',
            'join' => array(
                'vote_types as vt' => 'v.type_id = vt.id',
                'module_resources as r' => 'r.id = v.resource_id'
            ),
            'select' => 'v.*, vt.name as type_id, r.name as resource_id',
            'where' => array(
                'v.id' => $id
            )
        ));
        
        // get record link
        $record_link = $this->getModuleName($votes->resource_id) . '/admin_' . $votes->resource_id . '/view/' . $votes->record_id;
        
        // set data to view
        $data = array(
            'data_view' => $votes,
            'record_link' => $record_link
        );                
        
        // set template
        $this->parser->parse($this->router->class . '/view', $data);
    }
    
    /**
     * DELETE
     */
    public function delete()
    {
        // check permission
        $this->PG_ACL('d');
        
        // delete
        $this->deleteRecordOnListView();
    }
    
    /**
     * Add vote by admin
     * 
     * @param string $resource_name
     * @param int $record_id 
     */
    public function add_vote($resource_name = '', $record_id = 0)
    {
        // set layout
        $this->layout->set_layout('empty');
        
        // check permission
        if (!$this->isACL('w'))
        {
            echo lang('You can not access this page');
            exit();
        }
        
        // set title
        $this->layout->set_title(lang('Add vote by admin'));
        
        // add vote
        if ($this->input->post())
        {
            $resource_name          = $this->input->post('resource_name');
            $record_id              = $this->input->post('record_id');
            $username               = $this->input->post('username');
            $vote_field_count       = $this->input->post('field_count');
            $type_id                = $this->input->post('vote_type_id');
            
            if ($resource_name && $record_id && $username)
            {
                // lib model
                $this->load->model('users/User');
                $this->load->model('Vote_type');
                
                // create user
                $user_id = $this->User->create(array(
                    'username' => $username,
                    'password' => $username,
                    'email' => $username . str_replace(array('http://', '/'), array('@', ''), config_item('penguin_site')),
                    'typeid' => $username
                ));
                
                // create vote
                if ($user_id)
                {
                    $vote_id = $this->Vote->create(array(
                        'record_id' => $record_id,
                        'point' => $this->Vote_type->getPoint($type_id),
                        'type_id' => $type_id,
                        'resource_id' => $this->getResourceID($resource_name),
                        'user_ip' => sprintf('%d.%d.%d.%d', mt_rand(10, 255), mt_rand(1, 255), mt_rand(1, 255), mt_rand(1, 255)),
                        'username' => $username,
                        'user_id' => $user_id
                    ));
                    
                    if ($vote_id)
                    {
                        $this->Vote->addVoteCount($this->getResourceID($resource_name), $record_id, $type_id, $vote_field_count);
                        echo json_encode(array(
                            'status' => 'success',
                            'message' => lang('Add vote for this item is success')
                        ));
                        exit();
                    }
                }
            }
            
            echo json_encode(array(
                'status' => 'error',
                'message' => lang('Can not add vote for this item')
            ));
            exit();
        }
        
        // set template
        $this->parser->parse($this->router->class . '/add_vote', array(
            'resource_name' => $resource_name,
            'record_id' => $record_id
        ));
    }
}
                
?>