<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author tungcn <cntung2187@gmail.com> 0909898592
 * @copyright Chung Nhut Tung 2011
 * 
 * Controller Admin_survey_question_types
 * ...
 * 
 * @package PenguinFW
 * @subpackage Survey
 * @version 1.0.0
 */
 
class Admin_survey_question_types extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->layout->set_layout('admin');
        
        $this->model_name = 'Survey_question_type';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('surveys', lang_web());
            
        $this->load->model('Survey_question_type');
    }
    
	function index($cfn_id = 0) {
    	// check permission
    	$this->PG_ACL('r');
    
    	// set title
    	$this->layout->set_title(lang('Survey Question Type manager'));
    
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
    	$filter_album_status_id = $this->input->get('album_status_id');
    	if ($filter_album_status_id != '') {
    		$this->paginator['where']['album_status_id'] = $filter_album_status_id;
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
    
                        'this_resource' => $this->router->class,
                        'cf_names' => $this->getCustomFieldName(NULL, FALSE),
                        'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
                        'link_edit' => array(
                            'View' => 'surveys/admin_survey_question_types/view/',
                            'Edit' => 'surveys/admin_survey_question_types/edit/'
    	),
                        'pagination_link' => $this->getPaginationLink('/surveys/admin_survey_question_types/' . $action . '/' . $cfn_id, 5)
    	);
    }
    
    
    /**
    *
    * Add Survey Question Type
    */
    public function add() {
    // check permission
    	$this->PG_ACL('w');
    
    	// set title
    	$this->layout->set_title(lang('Add Survey Question Type'));
    
    	// load library form
        $this->load->helper('form');
    	$this->load->library('form_validation');
        
    	// form validate
    	$this->form_validation->set_rules('name', 'Name', 'trim|required');
    	$this->form_validation->set_rules('photo_category_id', 'Photo Album', 'required|greater_than[0]');
        
        	// get post and check rule
        	if ($this->input->post() && $this->form_validation->run() == TRUE) {
    	
    	// save data
    	if ($this->Photo_album->create($this->input->post(), TRUE)) {
        			$this->session->set_flashdata('success_message', lang('Success'));
    	}
    	else {
    	$this->session->set_flashdata('error_message', lang('Error'));
        		}
        
    	// redirect
    	redirect('photos/admin_photo_albums');
    	}
    
    	// data to view
        $data = array(
    		);
    
    	// parser
    	$this->parser->parse($this->router->class . '/add', $data);
    }
}
                
?>