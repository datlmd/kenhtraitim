<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author tungcn <cntung2187@gmail.com> 0909898592
 * @copyright Chung Nhut Tung 2011
 * 
 * Controller Admin_categories
 * ...
 * 
 * @package PenguinFW
 * @subpackage Article
 * @version 1.0.0
 */
 
class Admin_article_categories extends MY_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->layout->set_layout('admin');
        
        $this->model_name = 'Article_category';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('articles', lang_web());
        
        $this->load->model('Article_category');
    }
    
    function index($cfn_id = 0) {
    	// check permission
    	$this->PG_ACL('r');
    	
    	// set title
    	$this->layout->set_title(lang('Article Category manager'));
    	
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
    	
    	// get Article Category
    	$categories = $this->Article_category->getTreeArticlesCategories($condition);
    	
    	// set data view
    	return array(
                'list_views' => $categories,                        
                'cfn_id' => $cfn_id,
                'category_status_ids' => $this->_getArticleCategoryStatus(),
    
                'this_resource' => $this->router->class,
                'cf_names' => $this->getCustomFieldName(NULL, FALSE),
                'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
                'link_edit' => array(
                    'View' => 'articles/admin_article_categories/view/',
                    'Edit' => 'articles/admin_article_categories/edit/'
    	),
                'pagination_link' => $this->getPaginationLink('/articles/admin_article_categories/' . $action . '/' . $cfn_id, 5)
    	);
    }
    
    /**
     * 
     * Add Article Category
     */
    public function add() {
    	// check permission
    	$this->PG_ACL('w');
    
    	// set title
    	$this->layout->set_title(lang('Add Article Category'));
    	
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
    		if ($this->Article_category->create($this->input->post(), TRUE)) {
    			$this->session->set_flashdata('success_message', lang('Success'));
    		}
    		else {
    			$this->session->set_flashdata('error_message', lang('Error'));
    		}
    
    		// redirect
    		redirect('articles/admin_article_categories');
    	}
    	
    	// data to view
    	$data = array(
                'category_status_ids' => $this->_getArticleCategoryStatus(),
    			'categories' => $this->Article_category->getTreeArticlesCategories(),
    	);
    
    	// parser
    	$this->parser->parse($this->router->class . '/add', $data);
    }
    
    /**
     * 
     * View Article Category
     * @param int $article_category_id
     */
    public function view($article_category_id = 0)
    {
    	// check permission
    	$this->PG_ACL('r');
    
    	// set title
    	$this->layout->set_title(lang('View article category'));
    
    	// get user data from database
    	$article_category = $this->Article_category->find('first', array(
                'select' => 'article_categories.*',
                'from' => 'article_categories',
                'where' => array('article_categories.id' => $article_category_id)
    		));
    
    	// Get parent category
    	if ( ! $article_category->parent_id) {
    		$article_category->parent_name = lang('No Parent');
    	}
    	else {
    		$article_category_parent = $this->Article_category->find('first', array(
    				'select' => 'article_categories.*',
    		        'from' => 'article_categories',
    		        'where' => array('article_categories.id' => $article_category->parent_id)
    			));
    		
    		$article_category->parent_name = $article_category_parent->name;
    	}
    	// Get article category status
    	$article_category->category_status_name = ($article_category->category_status_id == 1) ? lang('Enable') : lang('Disable');
    	
    	// Get delete
    	//$article_category->delete_name = ($article_category->is_delete == 1) ? lang('Removed') : lang('No');
    	
    	// set data to view
    	$data = array(
                'article_category' => $article_category
    	);
    
    	// parser
    	$this->parser->parse($this->router->class . '/view', $data);
    }
    
    /**
    * DELETE Category
    */
    public function delete() {
    	// check permission
    	$this->PG_ACL('d');
    
    	// update is_delete = 1
    	$this->deleteOnListView();
    }
    
    /**
    * EDIT Article Category
    *
    * @param int $article_category_id
    */
    public function edit($article_category_id = 0) {
    	// check permission
    	$this->PG_ACL('e');
    
    	// set title
    	$this->layout->set_title(lang('Edit Article Category'));
    
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
    
    	// get article_category_id
    	$article_category_id = ($this->input->post('article_category_id')) ? $this->input->post('$article_category_id') : $article_category_id;
    
    	// get post and check rule
    	if ($this->input->post() && $this->form_validation->run() == TRUE)
    	{
    		if ( ! $slug = $this->input->post('slug')) {
    			$_POST['slug'] = $this->input->post('name');
    		}
    		
    		$_POST['slug'] = make_slug($_POST['slug']);
    		
    		// save data
    		if ($this->Article_category->update($this->input->post(), array('id' => $article_category_id), TRUE))
    		{
    			$this->session->set_flashdata('success_message', lang('Success'));
    		} else
    		{
    			$this->session->set_flashdata('error_message', lang('Error'));
    		}
    
    		// redirect
    		redirect_previous_url('articles/admin_article_categories');
    	}
    
    	// get article category
    	$article_category = (array)$this->Article_category->get(array('id' => $article_category_id));
    	
    	// data to view
    	$data = array(
                'edit_module' => $article_category,
    			'category_status_ids' => $this->_getArticleCategoryStatus(),
    			'categories' => $this->Article_category->getTreeArticlesCategories(),
    		);
    
    	// parser
    	$this->parser->parse($this->router->class . '/edit', $data);
    }
    
    /**
     * 
     * Get article category status
     * @return array
     */
    private function _getArticleCategoryStatus() {
    	return array(
                	array('id' => 0, 'name' => 'Disable'),
    				array('id' => 1, 'name' => 'Enable'),
                );
    }
}
                
?>