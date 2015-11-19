<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.3.1
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Unit Testing Class
 *
 * Simple testing class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	UnitTesting
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/uri.html
 */

class Check_add_view {
	public function check_lifetime_item_id($item_id) {
		
		$this->CI =& get_instance();
		
		$this->CI->load->helper('cookie');
		
		if ( ! $item_id) {
			return FALSE;
		}
		
		// get article id from cookie
		$article_id = $this->CI->input->cookie('article');
		
		if ($article_id) {
			if ($article_id == $item_id) {
				return FALSE;
			}
		}
		
		// get article id from session
		$article_info = $this->CI->session->userdata('current_article');
		$article_id = ($article_info['expired_time'] >= time()) ? $article_info['article_id'] : 0;
		
		if ($article_id) {
			if ($article_id == $item_id) {
				return FALSE;
			}
		}
		$this->CI->session->set_userdata(array('aaa' => 'bbb'));
		
		// period time to limit time
		$period_time = 30*60; // 30 mins * 60 sec
		
		// Set session
		$this->CI->session->set_userdata(array(
					'current_article' => array(
						'article_id' => $item_id, 
						'expired_time' => time() + $period_time,
					)
			));
		
		// Set cookie
		$cookie = array(
			    'name'   => 'article',
			    'value'  => $item_id,
			    'expire' => $period_time,
			);
		
		$this->CI->input->set_cookie($cookie);
		
		return TRUE;
	}
}

/* End of file Check_add_view.php */
/* Location: ./modules/articles/libraries/Check_add_view.php */