<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author tungcn <cntung2187@gmail.com> 0909898592
 * @copyright Chung Nhut Tung 2011
 * 
 * Controller Admin_Articles
 * ...
 * 
 * @package PenguinFW
 * @subpackage Article
 * @version 1.0.0
 * 
 * @property Article $Article
 * @property Article_category_relationship $Article_category_relationship
 * @property Article_category $Article_category
 * @property Language $Language
 */
 
class Admin_articles extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->layout->set_layout('admin');
        
        $this->model_name = 'Article';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('articles', lang_web());

        $this->load->model('Article_category');
        $this->load->model('Article');
        $this->load->model('Article_dictionary');
        $this->load->model('Article_category_relationship');
        $this->load->model('Language');
        
        // set javascript to view
        $this->layout->set_javascript(array(
            'jquery.ui.core.min.js',
            'jquery.ui.datepicker.min.js',
            'jquery.tabs.js',
            'shadowbox/shadowbox.js',
            'shadowbox/init.js',
        ));

        // set css to view
        $this->layout->set_rel(array(
            'jquery.ui.base.css',
            'jquery.ui.datepicker.css',
            'js' => 'shadowbox/shadowbox.css'
        ));
    }
    
	function index($cfn_id = 0) {
    	// check permission
    	$this->PG_ACL('r');
    	
    	// set title
    	$this->layout->set_title(lang('Article manager'));
    	
    	// get data
    	$data = $this->_listView('index', $cfn_id);
    	
        
        $data['total_records'] = $this->count_record;
        
    	$this->parser->parse($this->router->class . '/index', $data);
    }
    
    private function _listView($action = 'index', $cfn_id = 0) {
    	
    	$this->paginator['leftjoin'] = array(
    			'article_category_relationships acr' => 'acr.article_id = articles.id',
    		);
    	
    	$this->paginator['join'] = array(
    	    	'article_dictionaries ad' => 'ad.article_id = articles.id',
    	);
    	
    	// filter articles
    	//filter language
    	$lang = array();
    	$filter_lang_id = $this->input->get('lang_id');
    	if (is_numeric($filter_lang_id)) {
    		$this->paginator['where']['ad.lang_id'] = $filter_lang_id;
    	}
    	else {
    		$lang = $this->Language->get_array('*', array('code' => config_item('language')));
    		if ( ! $lang) {
    			die('No default language in our DB.');
    		}
    		
    		$this->paginator['where']['ad.lang_id'] = $lang['id'];
    	}
    	
    	//filter category
    	$filter_article_category_id = $this->input->get('article_category_id');
        if(!empty($filter_article_category_id) && $filter_article_category_id != '')
        {
            if (is_numeric($filter_article_category_id)) {
                $this->paginator['where']['acr.article_category_id'] = $filter_article_category_id;
            }
        }
    	
    	//filter article is_public
        $is_publish = $this->input->get('is_publish');
        if(!empty($is_public) && $is_public != '')
        {
            if (is_numeric($is_public))
            {
                $this->paginator['where']['is_publish'] = $is_publish;//$filter_article_status_id;
            }
        }
    	
    	// filter created from date
    	$filter_from_date = $this->input->get('from_date');
    	if(!empty($filter_from_date))
        {
            if ($filter_from_date) {
                $this->paginator['where']['DATE(articles.created) >='] = standar_date($filter_from_date, '-', '-');
            }
        }
    	// filter created end date
    	$filter_to_date = $this->input->get('to_date');
        if(!empty($filter_to_date))
        {
            if ($filter_to_date)
            {
                $this->paginator['where']['DATE(articles.created) <='] = standar_date($filter_to_date, '-', '-');
            }
        }
    	
    	// filter name
    	$filter_name = $this->input->get('name');
        if(!empty($filter_name) && $filter_name != '')
        {
            if ($filter_name) {
                $this->paginator['like']['ad.subject'] = $filter_name;
            }
        }
    	
    	// only show user not in recycle bin
    	// check action is recyclebin
    	if ($action == 'recyclebin') {
    		$this->paginator['where']['articles.is_delete'] = 1;
    	} 
    	else { // action is index
    		$this->paginator['where']['articles.is_delete'] = 0;
    	}


    	// group article
    	$this->paginator['groupby'] = array('articles.id');

    	// select
    	$this->paginator['select'] = array('articles.*, ad.subject as pg_article_subject');
    	
    	// get $_GET
    	$extra_params = get_extra_params_from_url();
    	
    	// get Article Category
    	$articles = $this->pagination(5);
    	//echo $this->db->last_query($this->pagination(5));
    	// get all language
    	$list_langs = $this->Language->find('all');

    	// set data view
    	return array(
                'list_views' => $articles,                        
                'cfn_id' => $cfn_id,
    			'is_publish' => $this->_getArticleStatus(),
    			'list_langs' => $list_langs,
    			'current_lang' => $lang,
		    	'categories' => $this->Article_category->getTreeArticlesCategories(array('category_status_id' => 1)),
    
                'this_resource' => $this->router->class,
                'cf_names' => $this->getCustomFieldName(NULL, FALSE),
                'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
                'link_edit' => array(
//                     'View' => 'articles/admin_articles/view/',
                    'Edit' => 'articles/admin_articles/edit/'
    	),
                'pagination_link' => $this->getPaginationLink('/articles/admin_articles/' . $action . '/' . $cfn_id, 5, $extra_params)
    	);
    }
    
    /**
    *
    * Add Article
    */
    public function add() {
    	// check permission
    	$this->PG_ACL('w');
    	
    	// set javascript to view
    	$this->layout->set_javascript(array(
    	            	            'jquery.ui.core.min.js',
    	            	            'jquery.ui.datepicker.min.js',
    								'jquery.ui.timepicker.js',
    	            	            'jquery.tabs.js',
    	            	            'ckeditor/ckeditor.js',
    	        					'ajaxupload.js',
    	                    		'articles/upload.js',
    		));
    	
    	// set css to view
    	$this->layout->set_rel(array(
    	            	            'jquery.ui.base.css',            
    	            	            'jquery.ui.datepicker.css',
    	            	            'jquery.ui.timepicker.css',
    	));
    	
    	
    	// set title
    	$this->layout->set_title(lang('Add Article'));
    	
    	// Get all language from DB
    	$lang_list = $this->Language->find('all');
    	
    	// load library form
    	$this->load->helper('form');
    	$this->load->library('form_validation');
    	
    	// Get config language in config.php
    	$language_config = $this->config->item('language');
    	
    	// form validate
    	$this->form_validation->set_rules("thumbnail_image", "Thumbnail Image", 'trim|required');
    	$this->form_validation->set_rules("subject_$language_config", "Subject (in $language_config)", 'trim|required');
    	$this->form_validation->set_rules("content_$language_config", "Content (in $language_config)", 'trim|required');
        $this->form_validation->set_rules("is_allow_comment", "Is allow comment", 'trim');
        $this->form_validation->set_rules("is_hot", "Is hot", 'trim');
        $this->form_validation->set_rules("publish_date", "Publish date", 'trim|required');
        $this->form_validation->set_rules("publish_time", "Publish time", 'trim|required');
        $this->form_validation->set_rules("is_publish", "Is publish", 'trim');
        $this->form_validation->set_rules("teaser_$language_config", "Teaser", 'trim');
        $this->form_validation->set_rules("tags", "Tags", 'trim');
        $this->form_validation->set_rules("slug", "Slug", 'trim');


    	// get post and check rule
    	if ($this->input->post() && $this->form_validation->run() == TRUE) {
    		// get parent id of category IDs
    		$result_tmp = array();
    		$this->_get_category_parent_id($this->input->post('category_ids'), $result_tmp);
    		// clear
    		$_POST['category_ids'] = array_unique($result_tmp);
    		
    		// save general article
    		$article_id = $this->_saveGeneralArticle($this->input->post());
    		
    		// FALSE
    		if ( ! $article_id) {
    			$this->session->set_flashdata('error_message', lang('Error'));
    			// redirect
    			redirect('articles/admin_articles');
    		}
    		
    		// Save article category relationship
    		if ($this->input->post('category_ids')) {
    		$this->_saveArticleCategoryRelationship($article_id, $this->input->post('category_ids'));
    		}
    		
    		foreach ($lang_list as $language) {
    			// Save article Dictionary
    			$article_dictionary_id = $this->_saveArticleDictionary($this->input->post(), $article_id, $language);
    			
    			if ($article_dictionary_id) {
    				$this->session->set_flashdata('success_message', lang('Success'));
    			}
    			elseif ($article_dictionary_id === FALSE) {
    				$this->session->set_flashdata('error_message', lang('Error save article'));
    			}
    		}
    		
    		// redirect
    		redirect('articles/admin_articles');
    	}
    	 
    	// data to view
    	$data = array(
    				'categories' => $this->Article_category->getTreeArticlesCategories(array('category_status_id' => 1)), // get available category
                    'lang_list' => $lang_list,
                    'comment_ids' => $this->_getValueIs(),
    				'hot_ids' => $this->_getValueIs(),
    				'publish_ids' => $this->_getValueIs(),
    				'parent_category_ids' => $this->Article_category->find('all', array(
                    	'select' => 'id,name',              
    				)),
    		);
    	//pg_debug($data['categories']);
    	// parser
    	$this->parser->parse($this->router->class . '/add', $data);
    }
    
    /**
    *
    * Edit Article
    */
    public function edit($article_id = 0) {
    	// check permission
    	$this->PG_ACL('e');
    	
    	// set javascript to view
    	$this->layout->set_javascript(array(
						'jquery.ui.core.min.js',
						'jquery.ui.datepicker.min.js',
    					'jquery.ui.timepicker.js',
						'jquery.tabs.js',
						'ckeditor/ckeditor.js',
						'ajaxupload.js',
						'articles/upload.js',
    		));
    	
    	// set css to view
    	$this->layout->set_rel(array(
						'jquery.ui.base.css',
						'jquery.ui.datepicker.css',
						'jquery.ui.timepicker.css',
    	));
    	
    	// set title
    	$this->layout->set_title(lang('Edit Article'));
    	
    	// Get all language from DB
    	$lang_list = $this->Language->find('all');
    	 
    	// load library form
    	$this->load->helper('form');
    	$this->load->library('form_validation');
    	 
    	// Get config language in config.php
    	$language_config = $this->config->item('language');
    	 
    	// form validate
    	// form validate
    	$this->form_validation->set_rules("thumbnail_image", "Thumbnail Image", 'trim|required');
    	$this->form_validation->set_rules("subject_$language_config", "Subject (in $language_config)", 'trim|required');
    	$this->form_validation->set_rules("content_$language_config", "Content (in $language_config)", 'trim|required');
        $this->form_validation->set_rules("is_allow_comment", "Is allow comment", 'trim');
        $this->form_validation->set_rules("is_hot", "Is hot", 'trim');
        $this->form_validation->set_rules("publish_date", "Publish date", 'trim|required');
        $this->form_validation->set_rules("publish_time", "Publish time", 'trim|required');
        $this->form_validation->set_rules("is_publish", "Is publish", 'trim');
        $this->form_validation->set_rules("teaser_$language_config", "Teaser", 'trim');
        $this->form_validation->set_rules("tags", "Tags", 'trim');
        $this->form_validation->set_rules("slug", "Slug", 'trim');

    	// get post and check rule
    	if ($this->input->post() && $this->form_validation->run() == TRUE) {
    		// get parent id of category IDs
    		$result_tmp = array();
    		$this->_get_category_parent_id($this->input->post('category_ids'), $result_tmp);
    		// clear
    		$_POST['category_ids'] = array_unique($result_tmp);
    		
    		// save general article
    		$_POST['article_id'] = $article_id;
    		$article_id = $this->_saveGeneralArticle($this->input->post());
    	
    		// FALSE
    		if ( ! $article_id) {
    			$this->session->set_flashdata('error_message', lang('Error'));
    			// redirect
    			redirect_previous_url('articles/admin_articles');
    		}
    		
    		// Save article category relationship
    		if ($this->input->post('category_ids')) {
    		$this->_saveArticleCategoryRelationship($article_id, $this->input->post('category_ids'));
    		}
    	
    		foreach ($lang_list as $language) {
    			$article_dictionary_id = $this->_saveArticleDictionary($this->input->post(), $article_id, $language);
    			 
    			if ($article_dictionary_id) {
    				$this->session->set_flashdata('success_message', lang('Success'));
    			}
    			elseif ($article_dictionary_id === FALSE) {
    				$this->session->set_flashdata('error_message', lang('Error save article'));
    			}
    		}
    	
    		// redirect
    		redirect_previous_url('articles/admin_articles');
    	}
    	
    	$articles = $this->Article->find('all', array(
    			'select' => 'article_dictionaries.*, articles.thumbnail_image as thumbnail_image, articles.is_allow_comment as is_allow_comment, articles.is_hot as is_hot, articles.is_publish as is_publish, articles.counter_vote as counter_user_voting, articles.vote_point as total_voting_point, articles.counter_like as counter_like, articles.publish_date as publish_date, articles.counter_comment as counter_comment, articles.counter_view as counter_view',
    			'leftjoin' => array('article_dictionaries' => 'article_dictionaries.article_id=articles.id'),
    			'where' => array('articles.id' => $article_id),
    		));
    	
    	// Have article
    	if (count($articles)) {
    		$tmp_articles = $articles;
    		$articles = array();
    		$general_info = array();
    		foreach ($tmp_articles as $article) {
    			$articles[$article['lang_id']] = $article;
    		}
    		$general_info = $article;
    	}
    	
    	// get article category relationship
    	$selected_category_ids = $this->Article_category_relationship->find('all', array(
    									'where' => array('article_id' => $article_id),
    		));
    	
    	$tmp = $selected_category_ids;
    	$selected_category_ids = array();
    	foreach ($tmp as $value) {
    		$selected_category_ids[] = $value['article_category_id'];
    	}
    	
    	// data to view
    	$data = array(
    			'selected_category_ids' => $selected_category_ids,
    			'categories' => $this->Article_category->getTreeArticlesCategories(),
    			'lang_list' => $lang_list,
    			'articles' => $articles,
    			'general_info' => $general_info,
    			'comment_ids' => $this->_getValueIs(),
    			'hot_ids' => $this->_getValueIs(),
    			'publish_ids' => $this->_getValueIs(),
    			'parent_category_ids' => $this->Article_category->find('all', array(
    				'select' => 'id,name',              
    			)),
    		);
    	
    	// parser
    	$this->parser->parse($this->router->class . '/edit', $data);
    }
    
    /**
    * Delete on list view
    */
    public function delete() {
    	if ($this->input->post()) {
    		$list_ids = $this->input->post('listViewId');
    		 
    		$publish_type = $this->input->post('publish_type');
    		
    		if (!empty ($list_ids)) {
    			if ($publish_type == 1) {
    				// is_publish
    				// check permission
    				$this->PG_ACL('p');
    				 
    				foreach ($list_ids as $id) {
    					$this->_publish($id);
    				}
    			} else if ($publish_type == -1) {
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
    				 
    				// delete all 
        			$this->deleteRecordOnListView(TRUE);
    			} // end
    		}
    	}
    	 
    	redirect('articles/admin_articles');
    }
    
    private function _saveGeneralArticle($data) {
    	$data['user_ip'] = $_SERVER['REMOTE_ADDR'];
    	
    	if ($data['publish_date']) {
    		// append time to date
    		$data['publish_date'] .= ($data['publish_time']) ? ' ' . $data['publish_time'] : '';
    		
    		// change format datetime to yyyy-mm-dd H:i:s
    		$data['publish_date'] = date('Y-m-d H:i:s', strtotime($data['publish_date']));
    	}
    	
    	if ($data['is_publish'] && ! $data['publish_date']) {
    		$data['publish_date'] = date('Y-m-d H:i:s', time());
    	}
    	
    	$categories = array();
    	if ( ! empty($data['category_ids']) && $data['category_ids']) {
    	$categories = $this->Article_category->find('all', array(
    			'where_in' => array('id' => $data['category_ids']),
    		));
    	}
    	
    	$tmp = array();
    	foreach ($categories as $category) {
    		$tmp[$category['id']] = array('id' => $category['id'], 'name' => $category['name']);
    	}
    	$data['data_category'] = serialize($tmp);
    	
    	// Update 
    	if (isset($data['article_id'])) {
    		if ($this->Article->update($data, array('id' => $data['article_id']), TRUE)) {
    			$article_id = $data['article_id'];
    		}
    		else {
    			$article_id = FALSE;
    		}
    	}
    	// Insert
    	else {
    		$article_id = $this->Article->create($data, TRUE);
    	}
    	
    	// Save article successfully
    	if ($article_id) {
    		// This is hot news
    		if ($data['is_hot'] && $data['thumbnail_image']) {
    			$dir_upload = get_folder_upload('images/articles', FALSE);
    			// resize 305 x 220
    			create_thumb($dir_upload['dir'] . '/' . $data['thumbnail_image'], config_item('articles_avatar_resize_width_hot'), config_item('articles_avatar_resize_height_hot'), '_hot_thumb');
    		}
    	}
    	
    	
    	return $article_id;
    }
    
    /**
     * 
     * Save article category relation ship
     * @param integer $article_id
     * @param array $category_ids
     */
    private function _saveArticleCategoryRelationship($article_id, $category_ids) {
    	// Remove article_category_relationship
    	$this->Article_category_relationship->deleteRecord(array('article_id' => $article_id));
    	
    	// insert Article_category_relationship
    	$this->Article_category_relationship->insertArticleCategoryRelationship($article_id, $category_ids);
    }
    
    /**
     * 
     * Save Article Dictionary
     * @param array $data
     * @param integer $article_id
     * @param array $language
     * 	with id: lang ID
     * 	with code lang code
     * @return integer $article_dictionary_id if successful,
     * 		FALSE if any failure
     */
    private function _saveArticleDictionary($data, $article_id, $language) {
    	$data['article_id'] = $article_id;
    	$data['lang_id'] = $language['id'];
    	
    	if ( ! $data['subject_'. $language['code']] && ! $data['content_'. $language['code']]) {
    		return NULL;
    	}
    	
    	// Validate
    	// ERR: subject
    	if ( ! $data['subject_'. $language['code']]) {
    		return FALSE;
    	}
    	// ERR: content
    	if ( ! $data['content_'. $language['code']]) {
    		return FALSE;
    	}
    	
    	$has_data = FALSE;
    	foreach ($data as $key => $value) {
    		if ((($position = strrpos($key, $language['code'])) !== FALSE)) {
    			$data[substr($key, 0, $position-1)] = $value;
    			$has_data = TRUE;
    		}
    	}
    	
    	// No data article for this language
    	if ( ! $has_data) {
    		return NULL;
    	}

    	// assign subject to slug if it is empty
    	if ( ! $data['slug']) {
    		$data['slug'] = $data['subject'];
    	}
    	
    	// make slug
    	$data['slug'] = make_slug($data['slug']);
    	
    	// Update
    	if (isset($data['article_dictionary_id']) && !empty ($data['article_dictionary_id'])) {
    		if ($this->Article_dictionary->update($data, array('id' => $data['article_dictionary_id']), TRUE)) {
    			$article_dictionary_id = $data['article_dictionary_id'];
    		}
    		else {
    			$article_dictionary_id = FALSE;
    		}
    	}
    	// Insert
    	else {
    		$article_dictionary_id = $this->Article_dictionary->create($data, TRUE);
    	}
    	
    	return $article_dictionary_id;
    }
    
    /**
     * 
     * get all category parent id
     * 
     * @param array $category_ids
     * @return array
     */
    private function _get_category_parent_id($category_ids, &$result) {
    	if ($category_ids) {
    		foreach ($category_ids as $category_id) {
    			$category = $this->Article_category->get_array('*', array('id' => $category_id));
    			
    			$result[] = $category['id'];
    			
    			if ($category['parent_id'] != 0) {
    				$this->_get_category_parent_id(array($category['parent_id']), $result);
    			}
    		}
    	}
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
    * Get article status
    * @return array
    */
    private function _getArticleStatus() {
    	return array(
                array('id' => '', 'name' => 'All'),
		    	array('id' => 1, 'name' => 'Publish'),
                array('id' => 0, 'name' => 'Draft'),
    		);
    }
}
                
?>