<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author tungcn <cntung2187@gmail.com> 0909898592
 * @copyright Chung Nhut Tung 2011
 * 
 * Controller Admin_survey_questions
 * ...
 * 
 * @package PenguinFW
 * @subpackage Survey
 * @version 1.0.0
 */
 
class Admin_survey_questions extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->layout->set_layout('admin');
        
        $this->model_name = 'Survey_question';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('surveys', lang_web());
            
        $this->load->model('Survey_question');
        $this->load->model('Survey_question_type');
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
        						'question_status_ids' => $this->_getSurveyStatus(),
    
                                'this_resource' => $this->router->class,
                                'cf_names' => $this->getCustomFieldName(NULL, FALSE),
                                'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
                                'link_edit' => array(
         
                                    'View' => 'surveys/admin_survey_questions/view/',
                                    'Edit' => 'surveys/admin_survey_questions/edit/'
    	),
                                'pagination_link' => $this->getPaginationLink('/surveys/admin_survey_questions/' . $action . '/' . $cfn_id, 5)
    	);
    }
    
    /**
    *
    * Delete Survey Question
    */
    public function delete()
    {
        // check permission
        $this->PG_ACL('d');
        
        // update is_delete = 1
        $this->deleteOnListView();
    }
    
    /**
    *
    * Add Survey Question
    */
    public function add() {
    	// check permission
    	$this->PG_ACL('w');
    
    	// set title
    	$this->layout->set_title(lang('Add Survey Question'));
    
    	// load library form
    	$this->load->helper('form');
    	$this->load->library('form_validation');
    
    	// form validate
    	$this->form_validation->set_rules('name', 'Name', 'trim|required');
    
    	// get post and check rule
    	if ($this->input->post() && $this->form_validation->run() == TRUE) {
    		if ($this->input->post('survey_group')) {
    			$_POST['survey_group'] = implode(',', $this->input->post('survey_group'));
    		}
    		
    		// save data
    		if ($this->Survey_question->create($this->input->post(), TRUE)) {
    			$this->session->set_flashdata('success_message', lang('Success'));
    		}
    		else {
    			$this->session->set_flashdata('error_message', lang('Error'));
    		}
    		
    		// redirect
    		redirect('surveys/admin_survey_questions');
    	}
    	
    	$survey_question_types = $this->Survey_question_type->find('all');
    	$survey_groups = $this->Survey_group->find('all', array(
    						'where' => array('group_status_id' => 1),
    		));
    	
    	// data to view
    	$data = array(
        			'question_status_ids' => $this->_getSurveyStatus(),
        			'survey_question_types' => $survey_question_types,
        			'value_is_ids' => $this->_getValueIs(),
        			'survey_groups' => $survey_groups,
    	);
    
    	// parser
    	$this->parser->parse($this->router->class . '/add', $data);
    }
    
    /**
    *
    * Add Survey Question
    */
    public function edit($id = 0) {
    	// check permission
    	$this->PG_ACL('w');
    
    	// set title
    	$this->layout->set_title(lang('Edit Survey Question'));
    
    	// load library form
    	$this->load->helper('form');
    	$this->load->library('form_validation');
        
    	// form validate
    	$this->form_validation->set_rules('name', 'Name', 'trim|required');
    
    	// get post and check rule
    	if ($this->input->post() && $this->form_validation->run() == TRUE) {
    		if ($this->input->post('survey_group')) {
    			$_POST['survey_group'] = implode(',', $this->input->post('survey_group'));
    		}
    		
    		// save data
    		if ($this->Survey_question->update($this->input->post(), array('id' => $id) , TRUE)) {
    			$this->session->set_flashdata('success_message', lang('Success'));
    		}
    		else {
    			$this->session->set_flashdata('error_message', lang('Error'));
    		}
    		
    		// redirect
    		redirect('surveys/admin_survey_questions');
    	}
    	
    	$survey_question_types = $this->Survey_question_type->find('all');
    	$survey_groups = $this->Survey_group->find('all', array(
    						'where' => array('group_status_id' => 1),
    		));
        
    	
    	// data to view
    	$data = array(
        			'question_status_ids' => $this->_getSurveyStatus(),
        			'survey_question_types' => $survey_question_types,
        			'value_is_ids' => $this->_getValueIs(),
        			'survey_groups' => $survey_groups,
    	);
    
        // get question
        $data['edit_module'] = $this->Survey_question->get_array("*", array('id' => $id));
  
    	// parser
    	$this->parser->parse($this->router->class . '/edit', $data);
    }
    
    
    /**
    *
    * View Survey Question
    * @param int $survey_question_id
    */
    public function view($survey_question_id = 0)
    {
    	// check permission
    	$this->PG_ACL('r');
    
    	// set title
    	$this->layout->set_title(lang('View survey question'));
    
    	// get survey question from database
    	$survey_question = $this->Survey_question->find('first', array(
                                'where' => array('id' => $survey_question_id)
    		));
    	
    	if ($survey_question->survey_group) {
    		$survey_question->survey_group = explode(',', $survey_question->survey_group);
    	}
    	
    	$survey_question_types = $this->Survey_question_type->find('all');
    	$survey_groups = $this->Survey_group->find('all', array(
    	    						'where' => array('group_status_id' => 1),
    		));
    	
    	
    	 
    	// set data to view
    	$data = array(
                            'view_data' => $survey_question,
            				'question_status_ids' => $this->_getSurveyStatus(),
            				'value_is_ids' => $this->_getValueIs(),
					    	'survey_groups' => $survey_groups,
					    	'survey_question_types' => $survey_question_types,
    	);
    
    	// parser
    	$this->parser->parse($this->router->class . '/view', $data);
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
     * Get survey question status
     * @return array
     */
    private function _getSurveyStatus() {
    	return array(
    	array('id' => 0, 'name' => 'Disable'),
    	array('id' => 1, 'name' => 'Enable'),
    	);
    }
    
      /**
     * Delete record from database
     * View on delete list view
     * 
     * @param $is_delete
     * @param $is_restore
     */
    public function deleteRecordOnListView($is_delete = FALSE, $is_restore = FALSE)
    {
        // get model name
        $model = $this->model_name;
        
        // load model if load not yet
        if (!class_exists($model))
        {
            $this->load->model($model);
        }
        
        // get link redirect to manage page
        $link_redirect = $this->router->fetch_module() . '/' . $this->router->class;
        // add params redirect
        if ($this->input->post('p_redirect'))
        {
            $link_redirect .= $this->input->post('p_redirect');
        }
        
        // check post data from form
        if ($this->input->post())
        {
            $list_delete_ids = $this->input->post('listViewId');
            
            if (empty ($list_delete_ids))
            {
                $this->session->set_flashdata('error_message', lang('Error params'));                
                redirect($link_redirect);
            }
            
            foreach ($list_delete_ids as $list_delete_id)
            {
                // if exit field is_delete -> update is_delete = 1
                if ($is_delete == TRUE)
                {
                    // restore recycle bin -> update is_delete = 0
                    if ($is_restore == TRUE)
                    {
                        //$this->$model->delete(array('id' => $list_delete_id));
                        $this->$model->deletion_update($list_delete_id);
                        
                    } else // delete record to recycle bin -> update is_delete = 1
                    {
                        //$this->$model->delete(array('id' => $list_delete_id));
                        $this->$model->deletion_update($list_delete_id);
                    }
                } else // not exit field is_delete -> delete record
                {
                    $this->$model->deleteRecord(array('id' => $list_delete_id));
                }
            }
            
            $this->session->set_flashdata('success_message', lang('Success'));
            redirect($link_redirect);
        } else 
        {
            $this->session->set_flashdata('error_message', lang('Error params'));
            redirect($link_redirect);
        }
    }
}
                
?>