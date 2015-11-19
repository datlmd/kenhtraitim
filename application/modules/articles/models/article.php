<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Model
 * Function on Article
 * 
 * @package PenguinFW
 * @subpackage Article
 * @version 1.0.0
 */

class Article extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        
        $this->db_table = 'articles';
    }
    
    //
    public function get_publish_article($article_id, $lang_id) {
    	$select = 'ad.*, articles.is_allow_comment AS is_allow_comment, articles.publish_date as publish_date, articles.data_category as data_category, articles.counter_user_voting as article_counter_user_voting, articles.total_voting_point as article_total_voting_point';
    	$article = $this->find('first_array', array(
    			'select' => $select,
    			'leftjoin' => array('article_dictionaries ad' => 'ad.article_id = articles.id'),
    			'where' => array(
    				'articles.id' => $article_id, 
    				'ad.lang_id' => $lang_id,
    				'articles.is_delete' => 0,
    				'articles.is_publish' => 1,
    				'articles.publish_date <=' => date('Y-m-d H:i:s')),
    		));
    	
    	return $article;
    }
    
    /**
     * 
     * search articles by language, category (optional: and date publish)
     * 
     * @param integer $lang_id
     * @param mix $category_id
     * @param datetime $from_datetime (optional)
     * @param datetime $to_datetime (optional)
     * @param integer $count
     * @param integer $offset
     * @return array
     */
   	function search_by_category_and_date($lang_id, $category_ids, $from_datetime = NULL, $to_datetime = NULL, $count = 10, $offset = 0) {
   		
   		if ( ! is_array($category_ids)) {
   			$category_ids = array($category_ids);
   		}
   		
   		$where = array(
   				'articles.is_publish' => 1,
   				'ad.lang_id' => $lang_id,
   				'articles.is_delete' => 0,
   			);
   		
   		if ($from_datetime) {
   			$where['articles.publish_date >='] = $from_datetime;
   		}
   		
   		$current_datetime = date('Y-m-d H:i:s', time());
   		if ($to_datetime && $to_datetime <= $current_datetime) {
   			$where['articles.publish_date <='] = $to_datetime;
   		}
   		else {
   			$where['articles.publish_date <='] = $current_datetime;
   		}
   		
   		$articles = $this->find('all', array(
   				'select' => 'articles.*, ad.subject as subject, ad.teaser as teaser, ad.tags as tags, ad.slug as slug',
   				'leftjoin' => array(
   					'article_dictionaries ad' => 'ad.article_id = articles.id',
   					'article_category_relationships acr' => 'acr.article_id = articles.id',
   				),
   				'where' => $where,
   				'where_in' => array('acr.article_category_id' => $category_ids),
   				'groupby' => array('articles.id'),
   				'order' => array('articles.publish_date' => 'desc', 'ad.subject' => 'asc'),
   				'limit' => $count,
   				'offset' => $offset,
   			));
   		
   		return $articles;
   	}
   	
   	/**
   	 * 
   	 * Search articles by tag
   	 * 
   	 * @param integer $lang_id
   	 * @param string $tag
   	 * @param integer $count
   	 * @param integer $offset
   	 * @return array
   	 */
   	function search_by_tag($lang_id, $tag, $count = 10, $offset = 0) {
   		$tag = str_replace(' ', '+', $tag);
   		$tag = '+' . $tag;
   		
   		$where = array(
   	   			'articles.is_publish' => 1,
   	   			'ad.lang_id' => $lang_id,
   	   			'articles.is_delete' => 0,
   	   			'articles.publish_date <=' => date('Y-m-d H:i:s'),
   	   			'MATCH(ad.tags) AGAINST ("'.$tag.'" IN BOOLEAN MODE) >' => 0,
   			);
   		
   		$articles = $this->find('all', array(
   	   			'select' => 'articles.*, ad.subject as subject, ad.teaser as teaser, ad.tags as tags, ad.slug as slug',
   	   			'leftjoin' => array(
   	   				'article_dictionaries ad' => 'ad.article_id = articles.id',
   	   				'article_category_relationships acr' => 'acr.article_id = articles.id',
   				),
   	   			'where' => $where,
   	   			'groupby' => array('articles.id'),
   	   			'order' => array('articles.publish_date' => 'desc', 'ad.subject' => 'asc'),
   	   			'limit' => $count,
   	   			'offset' => $offset,
   			));
   		 
   		return $articles;
   	}
   	
   	/**
   	 * 
   	 * get hot articles
   	 * 
   	 * @param integer $lang_id
   	 * @param integer $category_id
   	 * @param integer $limit
   	 * @param integer $offset
   	 * @return array
   	 */
   	function get_hot_articles($lang_id, $category_id, $count = 10, $offset = 0) {
   		$articles = $this->find('all', array(
   		   		'select' => 'articles.*, ad.subject as subject, ad.teaser as teaser, ad.tags as tags, ad.slug as slug',
   		   		'leftjoin' => array(
   		   			'article_dictionaries ad' => 'ad.article_id = articles.id',
   		   			'article_category_relationships acr' => 'acr.article_id = articles.id',
   				),
   		   		'where' => array(
   		   			'acr.article_category_id' => $category_id,
   		   			'articles.is_publish' => 1,
   					'articles.is_hot >=' => 1,
   		   			'ad.lang_id' => $lang_id,
   		   			'articles.is_delete' => 0,
   					'articles.publish_date <=' => date('Y-m-d H:i:s', time()),
   				),
   		   		'groupby' => array('articles.id'),
   		   		'order' => array('articles.publish_date' => 'desc', 'ad.subject' => 'asc'),
   		 		'limit' => $count,
   				'offset' => $offset,
   			));
   		
   		return $articles;
   	}
   	
   	/**
   	 * 
   	 * get the most view articles
   	 * @param integer $lang_id
   	 * @param integer $category_id
   	 * @param integer $count
   	 * @param integer $offset
   	 * @return array
   	 */
   	public function get_newest_articles($lang_id, $category_id, $count = 10, $offset = 0) {
   		$articles = $this->find('all', array(
   				'select' => 'articles.*, ad.subject as subject, ad.teaser as teaser, ad.tags as tags, ad.slug as slug',
   				'leftjoin' => array(
   					'article_dictionaries ad' => 'ad.article_id = articles.id',
   					'article_category_relationships acr' => 'acr.article_id = articles.id',
   				),
   				'where' => array(
   					'acr.article_category_id' => $category_id,
   					'articles.is_publish' => 1,
   					'ad.lang_id' => $lang_id,
   					'articles.is_delete' => 0,
   					'articles.publish_date <=' => date('Y-m-d H:i:s', time()),
   				),
   				'groupby' => array('articles.id'),
   				'order' => array('articles.publish_date' => 'desc', 'ad.subject' => 'asc'),
   				'limit' => $count,
   				'offset' => $offset,
   			));
   	
   		return $articles;
   	}
   	
   	/**
   	 * 
   	 * get the most view articles
   	 * 
   	 * @param integer $lang_id
   	 * @param integer $category_id
   	 * @param integer $count
   	 * @param integer $offset
   	 * @return array
   	 */
   	function get_most_view_articles($lang_id, $category_id, $count = 10, $offset = 0) {
   		$articles = $this->find('all', array(
				'select' => 'articles.*, ad.subject as subject, ad.teaser as teaser, ad.slug as slug',
				'leftjoin' => array(
					'article_dictionaries ad' => 'ad.article_id = articles.id',
					'article_category_relationships acr' => 'acr.article_id = articles.id',
				),
				'where' => array(
   					'acr.article_category_id' => $category_id,
					'articles.is_publish' => 1,
					'ad.lang_id' => $lang_id,
					'articles.is_delete' => 0,
					'articles.publish_date <=' => date('Y-m-d H:i:s', time()),
				),
				'groupby' => array('articles.id'),
				'order' => array('articles.counter_view' => 'desc', 'ad.subject' => 'asc'),
				'limit' => $count,
   				'offset' => $offset,
			));
   		
   		return $articles;
   	}
   	
   	public function update_voting($article_id, $score) {
   		$this->db->set('counter_user_voting', 'counter_user_voting + 1', FALSE);
   		$this->db->set('total_voting_point', 'total_voting_point + ' . $score, FALSE);
   		$this->db->set('modified', date('Y-m-d H:i:s'));
   		$this->db->where('id', $article_id);
   		$this->db->update($this->db_table);
   	}
}

?>