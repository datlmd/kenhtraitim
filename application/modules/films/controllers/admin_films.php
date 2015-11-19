<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

/**
 * PENGUIN_LITE FrameWork
 * @author hoanhk
 * @copyright Huynh Kim Hoan 2013
 * 
 * Controller Admin_films
 * ...
 * 
 * @package Penguin_liteFW
 * @subpackage films
 * @version 2.0.0
 */

class Admin_films extends MY_Controller {
	function __construct() {
		parent::__construct ();
		
		$this->layout->set_layout ( 'admin' );
		
		$this->model_name = 'Film';
		
		$this->lang->load ( 'generate', lang_web () );
		$this->lang->load ( 'films', lang_web () );
		
		$this->load->model ( 'Film' );
	}
	
	/**
	 * List
	 *
	 * @params int $cfn_id
	 */
	public function index($cfn_id = 0) {
		// check permission
		$this->PG_ACL ( 'r' );
		
		// set title
		$this->layout->set_title ( lang ( 'Film manager' ) );
		
		// get admin_game_daily_reports
		$data = $this->_listView ( 'index', $cfn_id );
		
		$data ['total_records'] = $this->count_record;
		
		$this->parser->parse ( $this->router->class . '/index', $data );
	
	}
	
	public function _listView($action = 'index', $cfn_id = 0) {
		// set javascript to view
		$this->layout->set_javascript ( array ('jquery.ui.core.min.js', 'jquery.ui.datepicker.min.js' ) );
		
		// set css to view
		$this->layout->set_rel ( array ('jquery.ui.base.css', 'jquery.ui.datepicker.css' ) );
		
		// filter created from date
		$filter_from_date = $this->input->get ( 'from_date' );
		if ($filter_from_date) {
			$this->paginator ['where'] ['DATE(created) >='] = standar_date ( $filter_from_date, '-', '-' );
		}
		
		// filter created end date
		$filter_to_date = $this->input->get ( 'to_date' );
		if ($filter_to_date) {
			$this->paginator ['where'] ['DATE(created) <='] = standar_date ( $filter_to_date, '-', '-' );
		}
		
		$filter_order = $this->input->get ( 'custom_order' );
		
		if ($filter_order) {
			$order = array ($filter_order => 'desc' );
			$this->paginator ['order'] = $order;
		}
		$this->paginator ['order'] = array ('id' => 'desc' );
		if ($action == "export") {
			$this->paginator ['select'] = '*';
			$this->paginator ['limit'] = 999999999;
			return $this->pagination ( 5 );
		}
		$list_views = $this->pagination ( 5 );
		
		//get extra params
		$extra_params = get_extra_params_from_url ();
		
		return array ('list_views' => $list_views, 'extra_params' => $extra_params, 'cfn_id' => $cfn_id, 'total_records' => $this->count_record, 'this_resource' => $this->router->class, 'cf_names' => $this->getCustomFieldName ( NULL, FALSE ), 'fields' => $this->getCustomField ( $this->session->userdata ( 'user_id' ), $cfn_id, NULL, FALSE ), 'link_edit' => array ('Edit' => 'films/admin_films/edit/' ), 'pagination_link' => $this->getPaginationLink ( '/films/admin_films/index/' . $cfn_id, 5, $extra_params ) );
	}
	
	public function export() {
		$contents = $this->_listView ( "export" );
		
		if (empty ( $contents )) {
			$contents [0] = array ('Data' => 'No record' );
		}
		
		$this->load->library ( 'Write_exel' );
		$this->write_exel->write ( $contents, SITE_NAME . '_' . 'films' . '_' . date ( 'Y_m_d_H_i' ) );
		exit ();
	}
	
	/**
	 * View data
	 *
	 * @params int $id
	 */
	public function view($id) {
		// check permission
		$this->PG_ACL ( 'r' );
		
		// set title
		$this->layout->set_title ( lang ( 'View Film' ) );
		
		$admin_films = $this->Film->get ( array ('id' => $id ) );
		
		// set data to view
		$data = array ('data_view' => $admin_films );
		
		// parser
		$this->parser->parse ( $this->router->class . '/view', $data );
	}
	
	/**
	 * Add data    
	 */
	public function add() {
		$this->load->model ( 'musics/Music_category' );
		//$this->load->model('films/H_Crawl');
		

		include_once ("crawl.php");
		// check permission
		$this->PG_ACL ( 'w' );
		
		// set title
		$this->layout->set_title ( lang ( 'Add Film' ) );
		
		// set javascript to view
		$this->layout->set_javascript ( array (//            'jquery-ui.min.js',
		//            'ajaxupload.js',
		//            'films/upload.js',
		'ckeditor/ckeditor.js' ) );
		
		// load library form
		$this->load->helper ( 'form' );
		$this->load->library ( 'form_validation' );
		
		// form validate
		$this->form_validation->set_rules ( 'name', 'Name', 'required' );
		
		// get post and check rule
		if ($this->input->post () && $this->form_validation->run () == TRUE) {
			// save data
			if ($this->Film->create ( $this->input->post (), FALSE )) {
				$this->session->set_flashdata ( 'success_message', lang ( 'Success' ) );
			} else {
				$this->session->set_flashdata ( 'error_message', lang ( 'Error' ) );
			}
			
			// redirect
			redirect ( 'films/admin_films' );
		}
		
		$meta_key = '';
		$meta_des = '';
		$title = '';
		$download = '';
		$content = '';
		$youtube = '';
		$url = '';
		if (isset ( $_GET ['url'] ))
			$url = $_GET ['url']; // 'http://taiphimhd.net/tai-phim/0084390-dragon-blade-kiem-rong-2015.html';
		

		if ($url) {
			$H_Crawl = new H_Crawl ( );
			
			//$title = $H_Crawl->removeFirstElement($H_Crawl->getTitle($url, 'div.breadcrumb'),'a');
			//echo $title;
			

			$html = $this->runBrowser ( $url );
			
			// /<H1 class=Title(.*?)>(.*?)<\/H1>/ <meta name="keywords" content="
			$meta_key = $this->getTag ( $html, '/<meta name=\"keywords\" content=\"(.*?)\" \/>/' );
			
			$meta_des = $this->getTag ( $html, '/<meta name=\"description\" content=\"(.*?)\" \/>/' );
			$title = $this->getTag ( $html, '/<title>(.*?)<\/title>/' );
			
			//$content = $this->getTag($html,'class=\"serverlist\"(.*?) id=\"phiminfo\"');
			$download = $H_Crawl->getTitle ( $url, 'div.serverlist' );
			//$download = preg_replace('http://taiphimhd.net/rd.php?url=','',$download);
			$content = $H_Crawl->getTitle ( $url, 'div#phiminfo' );
			
			//$img = $this->getTag($content,'/<img(.*?)\/');
			$youtube = $H_Crawl->getTitle ( $url, 'div.field-items' );
		}
		
		$data = array (
			'meta_key' => $meta_key, 
			'meta_des' => $meta_des, 
			'title' => $title, 
			'download' => $download, 
			'content' => $content, 
			'youtube' => $youtube, 
			'parent_ids' => $this->Music_category->getTreeItems ( array (), 'weight asc' ) 
		);
		
		// parser
		$this->parser->parse ( $this->router->class . '/add', $data );
	}
	
	public function runBrowser($url) {
		
		if (function_exists ( 'curl_init' )) {
			
			$ch = curl_init ();
			curl_setopt ( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; Konqueror/4.0; Microsoft Windows) KHTML/4.0.80 (like Gecko)" );
			curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt ( $ch, CURLOPT_URL, $url );
			curl_setopt ( $ch, CURLOPT_TIMEOUT, 60 );
			$response = curl_exec ( $ch );
			curl_close ( $ch );
		} else {
			$response = @file_get_contents ( $url );
		}
		
		return $response;
	}
	public function getTag($data, $pattern) {
		//$pattern = "/<H1 class=Title(.*?)>(.*?)<\/H1>/";
		preg_match ( $pattern, $data, $matches );
		return $matches [1];
	}
	public function getTitle($data) {
		$pattern = "/<H1 class=Title(.*?)>(.*?)<\/H1>/";
		preg_match ( $pattern, $data, $matches );
		return $matches [2];
	}
	
	public function getIntro($data) {
		$pattern = "/<H2 class=Lead(.*?)>(.*?)<\/H2>/";
		preg_match ( $pattern, $data, $matches );
		$noidung = preg_replace ( '#<H2 class=Lead(.*?)>(.*)</H2>#i', '', $matches [2] );
		return $noidung;
	
	}
	
	public function getcontent($data) {
		$data = preg_replace ( '#<H1 class=Title(.*)>(.*)</H1>#i', '', $data );
		$data = preg_replace ( '#<H2 class=Lead(.*)>(.*)</H2>#i', '', $data );
		return $data;
	}
	
	function  getContent_ngoisao(){
		include_once ("crawl.php");
		$H_Crawl = new H_Crawl ( );
		//$html = $this->runBrowser ( 'http://news.zing.vn/phap-luat.html' );
		$html = file_get_html('http://news.zing.vn/phap-luat.html');		
			// /<H1 class=Title(.*?)>(.*?)<\/H1>/ <meta name="keywords" content="
		//$meta_key = $this->getTag($html, 'class=\"cate_content\"(.*?)class=\"cate_sidebar\"');
        //$meta_key = $H_Crawl->getTitle('http://news.zing.vn/phap-luat.html','a');
        $meta_key = $this->getUrlData('http://news.zing.vn/phap-luat.html');
		var_dump($meta_key);
        $html_content = $html; 
                
//        foreach($html->find($att_content) as $e){
//            $content_html = $e->innertext;
//        }
//        $html = str_get_html($content_html);
//       
//        foreach($this->arr_att_clean as $att_clean){
//            // google+
//            foreach($html->find($att_clean) as $e){
//                $e->outertext = '';
//            }
//        }
//        
//        $ret = $html->save();
//        return $ret;
    }
    
	function getUrlData($url)
	{
	    $result = false;
	   
	    $contents = file_get_html($url);
	    preg_match('/<title>(.*?)<\/title>/', $contents, $match );
		var_dump($match);
	    if (isset($contents))
	    {
	        $title = null;
	        $metaTags = null;
	       
	        preg_match('/<title>(.*?)<\/title>/', $contents, $match );
			//var_dump($contents);
	        if (isset($match) && is_array($match) && count($match) > 0)
	        {
	            $title = strip_tags($match[1]);
	        }
	       
	        preg_match_all('/<[\s]*meta[\s]*name="?' . '([^>"]*)"?[\s]*' . 'content="?([^>"]*)"?[\s]*[\/]?[\s]*>/si', $contents, $match);
	       
	        if (isset($match) && is_array($match) && count($match) == 3)
	        {
	            $originals = $match[0];
	            $names = $match[1];
	            $values = $match[2];
	           
	            if (count($originals) == count($names) && count($names) == count($values))
	            {
	                $metaTags = array();
	               
	                for ($i=0, $limiti=count($names); $i < $limiti; $i++)
	                {
	                    $metaTags[$names[$i]] = array (
	                        'html' => htmlentities($originals[$i]),
	                        'value' => $values[$i]
	                    );
	                }
	            }
	        }
	       
	        $result = array (
	            'title' => $title,
	            'metaTags' => $metaTags
	        );
	    }
	   
	    return $result;
	}
function getUrlContents($url, $maximumRedirections = null, $currentRedirection = 0)
{
    $result = false;
   
    $contents = @file_get_contents($url);
   
    // Check if we need to go somewhere else
   
    if (isset($contents) && is_string($contents))
    {
        preg_match_all('/<[\s]*meta[\s]*http-equiv="?REFRESH"?' . '[\s]*content="?[0-9]*;[\s]*URL[\s]*=[\s]*([^>"]*)"?' . '[\s]*[\/]?[\s]*>/si', $contents, $match);
       
        if (isset($match) && is_array($match) && count($match) == 2 && count($match[1]) == 1)
        {
            if (!isset($maximumRedirections) || $currentRedirection < $maximumRedirections)
            {
                return getUrlContents($match[1][0], $maximumRedirections, ++$currentRedirection);
            }
           
            $result = false;
        }
        else
        {
            $result = $contents;
        }
    }
   
    return $contents;
}
	
	/**
	 * Edit data
	 *
	 * @params int $id
	 */
	public function edit($id = 0) {
		// check permission
		$this->PG_ACL ( 'e' );
		
		$this->load->model ( 'musics/Music_category' );
		
		// set javascript to view
		$this->layout->set_javascript ( array (//            'jquery-ui.min.js',
		//            'ajaxupload.js',
		//            'films/upload.js',
		'ckeditor/ckeditor.js' ) );
		
		// set title
		$this->layout->set_title ( lang ( 'Edit Film' ) );
		
		// load library form
		$this->load->helper ( 'form' );
		$this->load->library ( 'form_validation' );
		
		// form validate
		$this->form_validation->set_rules ( 'name', 'Name', 'required' );
		
		// get id
		$id = ($this->input->post ( 'id' )) ? $this->input->post ( 'id' ) : $id;
		
		// get admin_films
		$admin_films = $this->Film->get ( array ('id' => $id ) );
		
		if (! $admin_films) {
			show_error ( lang ( 'Error params' ) );
		}
		
		// get post and check rule
		if ($this->input->post () && $this->form_validation->run () == TRUE) {
			// save data
			if ($this->Film->update ( $this->input->post (), array ('id' => $id ), TRUE )) {
				$this->session->set_flashdata ( 'success_message', lang ( 'Success' ) );
			} else {
				$this->session->set_flashdata ( 'error_message', lang ( 'Error' ) );
			}
			
			// redirect
			redirect_previous_url ( 'films/admin_films' );
		}
		
		// data to view
		$data = array (
			'data_edit' => $admin_films,
			'parent_ids' => $this->Music_category->getTreeItems ( array (), 'weight asc' ) 
		);
		
		// parser
		$this->parser->parse ( $this->router->class . '/edit', $data );
	}
	
	/**
	 * Delete
	 */
	public function delete() {
		// check permission
		$this->PG_ACL ( 'd' );
		
		$this->deleteRecordOnListView ();
	}
}

?>