<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author tungcn <cntung2187@gmail.com> 0909898592
 * @copyright Chung Nhut Tung 2011
 * 
 * Controller Admin_survey_groups
 * ...
 * 
 * @package PenguinFW
 * @subpackage Surveys
 * @version 1.0.0
 */
 
class Admin_survey_groups extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->layout->set_layout('admin');
        
        $this->model_name = 'Survey_group';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('photos', lang_web());
            
        $this->load->model('Survey_group');
    }
    
    function index($cfn_id = 0) {
    	// check permission
    	$this->PG_ACL('r');
    
    	// set title
    	$this->layout->set_title(lang('Survey Group manager'));
    
    	// get data
    	$data = $this->_listView('index', $cfn_id);
    
    	$this->parser->parse($this->router->class . '/index', $data);
    }
    
    private function _listView($action = 'index', $cfn_id = 0) {
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
    
    	// filter surveys
    	// filter album status id
    	$filter_group_status_id = $this->input->get('group_status_id');
    	if ($filter_group_status_id != '') {
    		$this->paginator['where']['group_status_id'] = $filter_group_status_id;
    	}
    
    	// filter created from date
    	$filter_from_date = $this->input->get('from_date');
    	if ($filter_from_date) {
    		$this->paginator['where']['DATE(created) >='] = standar_date($filter_from_date, '-', '-');
    	}
    
    	// filter created end date
    	$filter_to_date = $this->input->get('to_date');
    	if ($filter_to_date) {
    		$this->paginator['where']['DATE(created) <='] = standar_date($filter_to_date, '-', '-');
    	}
    
    	// filter photo category id
    	$filter_photo_category_id = $this->input->get('photo_category_id');
    	if ($filter_photo_category_id) {
    		$this->paginator['where']['photo_category_id'] = $filter_photo_category_id;
    	}
    	 
    	// filter name
    	$filter_name = $this->input->get('name');
    	if ($filter_name) {
    		$this->paginator['where']['name'] = $filter_name;
    	}
    	 
    	// get Photo Album
    	$question_types = $this->pagination(5);
    
    	// set data view
    	return array(
                            'list_views' => $question_types,                        
                            'cfn_id' => $cfn_id,
    						'group_status_ids' => $this->_getSurveyGroupStatus(),
    
                            'this_resource' => $this->router->class,
                            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
                            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
                            'link_edit' => array(
                                'View' => 'surveys/admin_survey_groups/view/',
                                'Edit' => 'surveys/admin_survey_groups/edit/'
    	),
                            'pagination_link' => $this->getPaginationLink('/surveys/admin_survey_groups/' . $action . '/' . $cfn_id, 5)
    	);
    }
    
    /**
    *
    * Add Survey Group
    */
    public function add() {
    	// check permission
    	$this->PG_ACL('w');
    
    	// set title
    	$this->layout->set_title(lang('Add Survey Group'));
    
    	// load library form
    	$this->load->helper('form');
    	$this->load->library('form_validation');
    
    	// form validate
    	$this->form_validation->set_rules('name', 'Name', 'trim|required');
    
    	// get post and check rule
    	if ($this->input->post() && $this->form_validation->run() == TRUE) {
    		 
    		// save data
    		if ($this->Survey_group->create($this->input->post(), TRUE)) {
    			$this->session->set_flashdata('success_message', lang('Success'));
    		}
    		else {
    			$this->session->set_flashdata('error_message', lang('Error'));
    		}
    
    		// redirect
    		redirect('surveys/admin_survey_groups');
    	}
    
    	// data to view
    	$data = array(
    			'group_status_ids' => $this->_getSurveyGroupStatus(),
    			'value_is_ids' => $this->_getValueIs(),
    		);
    
    	// parser
    	$this->parser->parse($this->router->class . '/add', $data);
    }
    
    /**
    *
    * View Survey Group
    * @param int $survey_group_id
    */
    public function view($survey_group_id = 0)
    {
    	// check permission
    	$this->PG_ACL('r');
    
    	// set title
    	$this->layout->set_title(lang('View survey group'));
    
    	// get user data from database
    	$survey_group = $this->Survey_group->find('first', array(
                            'where' => array('id' => $survey_group_id)
    	));
    	
    	// set data to view
    	$data = array(
                        'view_data' => $survey_group,
        				'group_status_ids' => $this->_getSurveyGroupStatus(),
        				'value_is_ids' => $this->_getValueIs(),
    	);
    
    	// parser
    	$this->parser->parse($this->router->class . '/view', $data);
    }
    
    
    /**
    * EDIT Survey Group
     *
    * @param int $survey_group_id
    */
    public function edit($survey_group_id = 0) {
	    // check permission
	    $this->PG_ACL('e');
	    
	    	// set title
	    $this->layout->set_title(lang('Edit Survey Group'));
	    
	    // set javascript to view
	   	$this->layout->set_javascript(array(
					    'jquery.ui.core.min.js',
					    'jquery.ui.datepicker.min.js',
	    	));
	    
	    // set css to view
	    $this->layout->set_rel(array(
						'jquery.ui.base.css',
						'jquery.ui.datepicker.css',
	    	));
	    
	    // load library form
	    $this->load->helper('form');
	    $this->load->library('form_validation');
    
	    // form validate
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
	     
	    // get post and check rule
	    if ($this->input->post() && $this->form_validation->run() == TRUE) {
    
    		// save data
    		if ($this->Survey_group->update($this->input->post(), array('id' => $survey_group_id), TRUE)) {
        			$this->session->set_flashdata('success_message', lang('Success'));
    		}
    		else {
    			$this->session->set_flashdata('error_message', lang('Error'));
    		}
    
	    	// redirect
	    	redirect('surveys/admin_survey_groups');
    	}
    
    	// get survey group
    	$survey_group = $this->Survey_group->get_array('*', array('id' => $survey_group_id));
    
    	// data to view
    	$data = array(
					'edit_module' => $survey_group,
					'group_status_ids' => $this->_getSurveyGroupStatus(),
        			'value_is_ids' => $this->_getValueIs(),
    		);
    
    	// parser
    	$this->parser->parse($this->router->class . '/edit', $data);
    }
    
    /**
    *
    * List value of IS
    * array 0 => No
    * 		1 => Yes
    */
    private function _getValueIs() {
    	return array(0 => lang('No'), 1 => lang('Yes'));
    }
    
    /**
    *
    * Get survey group status
    * @return array
    */
    private function _getSurveyGroupStatus() {
    	return array(
    	array('id' => 0, 'name' => 'Disable'),
    	array('id' => 1, 'name' => 'Enable'),
    	);
    }
}
                
?>