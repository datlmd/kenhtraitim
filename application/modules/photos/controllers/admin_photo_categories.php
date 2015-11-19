<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author tungcn <cntung2187@gmail.com> 0909898592
 * @copyright Chung Nhut Tung 2011
 * 
 * Controller Admin_photo_categories
 * ...
 * 
 * @package PenguinFW
 * @subpackage Photo
 * @version 1.0.0
 */
 
class Admin_photo_categories extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->layout->set_layout('admin');
        
        $this->model_name = 'Photo_category';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('photos', lang_web());
            
        $this->load->model('Photo_category');
    }
    
    function index($cfn_id = 0) {
    	// check permission
    	$this->PG_ACL('r');
    	 
    	// set title
    	$this->layout->set_title(lang('Photo Category manager'));
    	 
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
    	 
    	// Init
    	$condition = array();
    	
    	// filter users
    	// filter user status id
    	$filter_category_status_id = $this->input->get('category_status_id');
    	if (is_numeric($filter_category_status_id)) {
    		$condition['category_status_id'] = $filter_category_status_id;
    	}
    	
    	// filter created from date
    	$filter_from_date = $this->input->get('from_date');
    	if ($filter_from_date) {
    		$condition['DATE(created) >='] = standar_date($filter_from_date, '-', '-');
    	}
    	 
    	// filter created end date
    	$filter_to_date = $this->input->get('to_date');
    	if ($filter_to_date) {
    		$condition['DATE(created) <='] = standar_date($filter_to_date, '-', '-');
    	}
    	 
    	// filter name
    	$filter_name = $this->input->get('name');
    	if ($filter_name) {
    		$condition['name'] = $filter_name;
    	}
    	 
    	// only show user not in recycle bin
    	// check action is recyclebin
    	if ($action == 'recyclebin') {
    		$condition['is_delete'] = 1;
    	}
    	else { // action is index
    		$condition['is_delete'] = 0;
    	}
    	 
    	// get Photo Category
    	$categories = $this->Photo_category->getTreeCategories($condition);
    	//pg_debug($categories);
    	// set data view
    	return array(
                    'list_views' => $categories,                        
                    'cfn_id' => $cfn_id,
                    'category_status_ids' => $this->_getPhotoCategoryStatus(),
    
                    'this_resource' => $this->router->class,
                    'cf_names' => $this->getCustomFieldName(NULL, FALSE),
                    'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
                    'link_edit' => array(
                        'View' => 'photos/admin_photo_categories/view/',
                        'Edit' => 'photos/admin_photo_categories/edit/'
    	),
                    'pagination_link' => $this->getPaginationLink('/photos/admin_photo_categories/' . $action . '/' . $cfn_id, 5)
    	);
    }
    
    /**
    *
    * Add Photo Category
    */
    public function add() {
    	// check permission
    	$this->PG_ACL('w');
    
    	// set title
    	$this->layout->set_title(lang('Add Photo Category'));
    	 
    	// load library form
    	$this->load->helper('form');
    	$this->load->library('form_validation');
    
    	// form validate
    	$this->form_validation->set_rules('name', 'Name', 'trim|required');
    
    	// get post and check rule
    	if ($this->input->post() && $this->form_validation->run() == TRUE) {
    		if ( ! $slug = $this->input->post('slug')) {
    			$_POST['slug'] = $this->input->post('name');
    		}
    
    		$_POST['slug'] = make_slug($_POST['slug']);
    
    		// save data
    		if ($this->Photo_category->create($this->input->post(), TRUE)) {
    			$this->session->set_flashdata('success_message', lang('Success'));
    		}
    		else {
    			$this->session->set_flashdata('error_message', lang('Error'));
    		}
    
    		// redirect
    		redirect('photos/admin_photo_categories');
    	}
    	 
    	// data to view
    	$data = array(
                    'category_status_ids' => $this->_getPhotoCategoryStatus(),
        			'categories' => $this->Photo_category->getTreeCategories(),
    	);
    
    	// parser
    	$this->parser->parse($this->router->class . '/add', $data);
    }
    
    /**
    * EDIT Photo Photo
    *
    * @param int $photo_category_id
    */
    public function edit($photo_category_id = 0) {
    	// check permission
    	$this->PG_ACL('e');
    
    	// set title
    	$this->layout->set_title(lang('Edit Photo Category'));
    
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
    
    	// load library form
    	$this->load->helper('form');
    	$this->load->library('form_validation');
    
    	// form validate
    	$this->form_validation->set_rules('name', 'Name', 'trim|required');
    
    	// get post and check rule
    	if ($this->input->post() && $this->form_validation->run() == TRUE)
    	{
    		if ( ! $slug = $this->input->post('slug')) {
    			$_POST['slug'] = $this->input->post('name');
    		}
    
    		$_POST['slug'] = make_slug($_POST['slug']);
    
    		// save data
    		if ($this->Photo_category->update($this->input->post(), array('id' => $photo_category_id), TRUE))
    		{
    			$this->session->set_flashdata('success_message', lang('Success'));
    		} else
    		{
    			$this->session->set_flashdata('error_message', lang('Error'));
    		}
    
    		// redirect
    		redirect('photos/admin_photo_categories');
    	}
    
    	// get photo category
    	$photo_category = $this->Photo_category->get_array('*', array('id' => $photo_category_id));
    	 
    	// data to view
    	$data = array(
                    'edit_module' => $photo_category,
        			'category_status_ids' => $this->_getPhotoCategoryStatus(),
        			'categories' => $this->Photo_category->getTreeCategories(),
    	);
    
    	// parser
    	$this->parser->parse($this->router->class . '/edit', $data);
    }
    
    /**
    *
    * View Photo Category
    * @param int $photo_category_id
    */
    public function view($photo_category_id = 0)
    {
    	// check permission
    	$this->PG_ACL('r');
    
    	// set title
    	$this->layout->set_title(lang('View photo category'));
    
    	// get user data from database
    	$photo_category = $this->Photo_category->find('first', array(
                    'select' => 'photo_categories.*',
                    'from' => 'photo_categories',
                    'where' => array('photo_categories.id' => $photo_category_id)
    	));
    
    	// Get parent category
    	if ( ! $photo_category->parent_id) {
    		$photo_category->parent_name = lang('No Parent');
    	}
    	else {
    		$photo_category_parent = $this->Photo_category->find('first', array(
        				'select' => 'photo_categories.*',
        		        'from' => 'photo_categories',
        		        'where' => array('photo_categories.id' => $photo_category->parent_id)
    		));
    
    		$photo_category->parent_name = $photo_category_parent->name;
    	}
    	// Get photo category status
    	$photo_category->category_status_name = ($photo_category->category_status_id == 1) ? lang('Enable') : lang('Disable');
    	 
    	// Get delete
    	//$photo_category->delete_name = ($photo_category->is_delete == 1) ? lang('Removed') : lang('No');
    	 
    	// set data to view
    	$data = array(
                    'view_data' => $photo_category
    	);
    
    	// parser
    	$this->parser->parse($this->router->class . '/view', $data);
    }
    
    /**
    * Delete on list view
    */
    public function delete() {
    	if ($this->input->post()) {
    		
    		$list_ids = $this->input->post('listViewId'); 
    		$publish_type = $this->input->post('publish_type');
    		
    		if ( ! empty($list_ids)) {
    			if ($publish_type == 1) {
    				// is_publish
    				// check permission
    				$this->PG_ACL('p');
    				 
    				foreach ($list_ids as $id) {
    					$this->_publish($id);
    				}
    			} 
    			elseif ($publish_type == -1) {
    				// un publish
    				// check permission
    				$this->PG_ACL('p');
    				 
    				foreach ($list_ids as $id) {
    					$this->_publish($id, FALSE);
    				}
    			}
    			else {
    				// is delete
    				// check permission
    				$this->PG_ACL('d');
    				 
    				foreach ($list_ids as $id) {
    					$this->_delete($id);
    				}
    			} // end
    		}
    	}
    	 
    	redirect('photos/admin_photo_categories');
    }
    
    /**
     * 
     * delete photo
     * @param integer $id
     */
    private function _delete($id) {
    	$record = $this->Photo_category->get_array('*', array('id' => $id));
    
    	if (!$record) {
    		return FALSE;
    	}
    
    	$this->Photo_category->delete(array('id' => $id));
    }
    
    /**
    * chang status
    *
    * @param int $id
    * @param boolean $is_publish
    * @return boolean
    */
    private function _publish($id, $is_publish = TRUE) {
    	$record = $this->Photo_category->get_array('*', array('id' => $id));
    
    	if (!$record) {
    		return FALSE;
    	}
    
    	$status = '';
    	if ($is_publish) {
    		$status = ConstPhotosStatus::Approved;
    	} 
    	else {
    		$status = ConstPhotosStatus::NoApproved;
    	}
    	
    	$this->Photo_category->update(array('category_status_id' => $status), array('id' => $id));
    }
    
    /**
    *
    * Get photo category status
    * @return array
    */
    private function _getPhotoCategoryStatus() {
    	return array(
    	array('id' => 0, 'name' => 'Disable'),
    	array('id' => 1, 'name' => 'Enable'),
    	);
    }
}
                
?>