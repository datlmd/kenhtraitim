<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Articles
 * ...
 * 
 * @package PenguinFW
 * @subpackage Article
 * @version 1.0.0
 * 
 * @property Article $Article
 */
 
class Articles extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Article';
        
        $this->layout->set_layout("vnidol");
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('articles', lang_web());
            
        $this->load->model('Article_category');
        $this->load->model('Article');
        $this->load->model('Article_dictionary');
        $this->load->model('Article_category_relationship');
        $this->load->model('Language');
        
        $this->layout->set_javascript(array(
                    	            'swfobject.js',
        ));
    }
    
    function index() {
    	
    	$this->paginator['select'] = array('articles.*, ad.subject as subject, ad.teaser as teaser, ad.tags as tags, ad.slug as slug');
        //join
        $this->paginator['join'] = array(
   					'article_dictionaries ad' => 'ad.article_id = articles.id',
   					'article_category_relationships acr' => 'acr.article_id = articles.id',
   				);
        //where
        $this->paginator['where'] = array(
                                //'acr.article_category_id' => 2,
   				'articles.is_publish' => 1,
   				'ad.lang_id' => 1,
   				'articles.is_delete' => 0,
                                'articles.publish_date <=' => date('Y-m-d H:i:s', time())
   			);
        
        //order
        $this->paginator['order'] = array('articles.publish_date' => 'desc', 'ad.subject' => 'asc');
        
        $this->paginator['limit'] = 15;
        
        $uri_segment = 3;
        // get Article Category
    	$list_articles = $this->pagination($uri_segment);

        $pagination_link = $this->getPaginationCustom('articles', 'index', '', '', $uri_segment);
        
        $data = array(
            'list_articles' => $list_articles,
            'pagination_link' => $pagination_link,
    	);
    	
    	$this->parser->parse('index', $data);
    }
    
    function hot_news() {
    	//
    }
    
    function article_detail($article_id = 0, $slug = NULL) {
    	$aaa = get_link('articles', 'articles', 'article_detail', '1/aaa');
    	var_dump($aaa);
    	// check permission
    	//$this->PG_ACL('r');
    	
    	// check params
    	if ($article_id == 0)
    	{
    		show_404();
    	}
    	
    	$this->load->model('languages/Language');
    	
    	$language = $this->Language->find('first_array', array(
    	        		'where' => array('code' => $this->config->item('language')),
    	));
    	
    	$article = $this->Article->get_publish_article($article_id, $language['id']);
    	
    	// article NOT exist
    	if ( ! $article) {
    		show_404();
    	}
    	
    	// invalid slug
    	if ($article['slug'] != $slug) {
    		redirect_to('articles', 'articles', 'article_detail', $article['article_id'] . '/' . $article['slug']);
    	}
    	
    	// increase counter view
    	$this->_increase_view_counter($article['article_id']);
    	
    	// load helper
    	$this->load->helper('strhash');
    	
    	$params_comment = '';
    	if ($article['is_allow_comment']) {
    		// setup params
    		$params = array(
    				'record_id' => $article['article_id'],
    				'resource_name' => 'articles',
    				'comment_token' => get_token('sys_comment_token'),
    				'field_update_count' => 'counter_user_voting',
    			);
    		
    		// generate param string for comment
    		$params_comment = $this->_generate_param($params);
    	}
    	
    	$data = array(
    			'article' => $article,
    			'params_comment' => $params_comment,
    		);
    	
    	$this->parser->parse('view', $data);
    }
    
	function news_detail($article_id = 0, $slug = NULL) {
    	
    	//$_SESSION['user']['username'] = 'hungtd ';$_SESSION['user']['passportID'] = '123465';
    	$getlink = urlencode('http://mp3.zing.vn/vietnamidol?url=' . get_link('articles', '', 'news_detail', $article_id.'/'.$slug));
    	// check params
    	if ($article_id == 0)
    	{
            show_404();
    	}
    	
    	$this->load->model('languages/Language');
    	
    	$language = $this->Language->find('first_array', array(
    	        		'where' => array('code' => $this->config->item('language')),
    	));
    	
    	$article = $this->Article->get_publish_article($article_id, $language['id']);
        
        $newest_article = $this->Article->get_newest_articles($language['id'],1, 3);

    	// article NOT exist
    	if ( ! $article) {
            show_404();
    	}
    	
    	// invalid slug
    	if ($article['slug'] != $slug) {
            redirect_to('articles', 'articles', 'news_detail', $article['article_id'] . '/' . $article['slug']);
    	}
    	// increase counter view
    	//$this->_increase_view_counter($article['article_id']);
    	
    	
    	
    	
    	$data = array(
    			'getlink' =>$getlink,
    			'article' => $article,
                'newest_article' => $newest_article,    			
    		);
    	
    	$this->parser->parse('news_detail', $data);
    }
    
    /**
     * 
     * increase counter view
     * @param integer $article_id
     */
    private function _increase_view_counter($article_id) {
    	$this->load->library('check_add_view');
    	
    	$is_increase_view = $this->check_add_view->check_lifetime_item_id($article_id);
    	$this->session->unset_userdata('current_article');
    	if ($is_increase_view) {
    		// update view counter in Article DB
    		$this->Article->incrementField(
    				array('id' => $article_id),
    				'counter_view',
    				1
    			);
    		
    		// update view counter in Article Dictionary DB
    		$this->Article_dictionary->incrementField(
    				array('article_id' => $article_id),
    				'counter_view',
    				1
    			);
    		
    		return TRUE;
    	}
    	
    	return FALSE;
    }
    
    /**
     * 
     * generate param vote
     * @param integer $record_id
     * @return string
     */
    private function _generate_param_vote($record_id) {
    	$this->load->helper('strhash');
    	
    	// Init
    	$resource_name = 'articles';
    	$vote_type = ConstArticleGlobal::VoteTypeID;
    	$field_update = 'counter_user_voting';
    	
    	
    	// process vote
    	// get token
    	$vote_token = get_token('sys_vtoken');
    	
    	// param vote record_id|resource_name|type_id|token|field_update_count
    	$params_vote = string_hash($record_id.'|'.$resource_name.'|'.$vote_type.'|'.$vote_token.'|'.$field_update);
    	
    	return $params_vote;
    }
    
    /**
    *
    * generate param for comment and vote
    * @param array $params
    * 		it contains some value record id, resource name, token, field update
    * 		e.g record_id|resource_name|type_id|token|field_update_count
    * @return string
    */
    private function _generate_param($params) {
    	$this->load->helper('strhash');

    	$params_json_encode = json_encode($params);
    	$params_string = string_hash($params_json_encode);
    	
    	return $params_string;
    }
}
                
?>