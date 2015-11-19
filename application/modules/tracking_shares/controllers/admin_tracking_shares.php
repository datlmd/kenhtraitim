<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_tracking_shares
 * ...
 * 
 * @package PenguinFW
 * @subpackage tracking_shares
 * @version 1.0.0
 */
 
class Admin_tracking_shares extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->layout->set_layout('admin');
            
        $this->model_name = 'Tracking_share';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('tracking_shares', lang_web());
            
        $this->load->model('Tracking_share');
    }
    
    /**
     * List
     *
     * @params int $cfn_id
     */
    public function index($cfn_id = 0)
    {
        // check permission
        $this->PG_ACL('r');
        
        // set title
        $this->layout->set_title(lang('Tracking_share manager'));
        
        // set javascript to view
        $this->layout->set_javascript(array(
            'jquery.ui.core.min.js',
            'jquery.ui.datepicker.min.js',
            'shadowbox/shadowbox.js',
            'shadowbox/init.js',
        ));

        // set css to view
        $this->layout->set_rel(array(
            'jquery.ui.base.css',
            'jquery.ui.datepicker.css',
            'js' => 'shadowbox/shadowbox.css'
        )); 
        
        $where = array();
        
        
    	// filter created from date
    	$filter_from_date = $this->input->get('from_date');
    	if ($filter_from_date) {
    		$this->paginator['where']['DATE(created) >='] = standar_date($filter_from_date, '-', '-');
    		$where['DATE(created) >='] = standar_date($filter_from_date, '-', '-');
    	}
    
    	// filter created end date
    	$filter_to_date = $this->input->get('to_date');
    	if ($filter_to_date) {
    		$this->paginator['where']['DATE(created) <='] = standar_date($filter_to_date, '-', '-');
    		$where['DATE(created) <='] = standar_date($filter_to_date, '-', '-');
    	}
        $this->paginator['order'] = array('id' => 'desc');
        
        // get admin_tracking_shares
        $admin_tracking_shares = $this->pagination(5);

        $count_c = $this->Tracking_share->find('count', array(
        		'select' => 'id',        		
        		'where' => $where,
    			'order' => array(
        			'id' => 'desc'
    			),
        	));
        
        $data = array(
            'list_views' => $admin_tracking_shares,
            'count_contest'	=> $count_c,
            'this_resource' => $this->router->class,            
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'link_edit' => array(
                'Edit' => 'tracking_shares/admin_tracking_shares/edit/'                
            ),
            'pagination_link' => $this->getPaginationLink('/tracking_shares/admin_tracking_shares/index/' . $cfn_id, 5)
        );
        
        $this->parser->parse($this->router->class . '/index', $data);
    }
    
	public function report($cfn_id = 0)
    {
        // check permission
        $this->PG_ACL('r');
        
        // set title
        $this->layout->set_title(lang('Report manager'));
        
        // set javascript to view
        $this->layout->set_javascript(array(
            'jquery.ui.core.min.js',
            'jquery.ui.datepicker.min.js',
            'shadowbox/shadowbox.js',
            'shadowbox/init.js',
        ));

        // set css to view
        $this->layout->set_rel(array(
            'jquery.ui.base.css',
            'jquery.ui.datepicker.css',
            'js' => 'shadowbox/shadowbox.css'
        )); 
        
        $this->load->model('users/User');
        $where = array();

    	$filter_username = $this->input->get('username');
    	if ($filter_username) {   
    		$user = $this->User->get_by_username($filter_username); 		
    		$where['user_id'] = $user->id;
    	}
    	
        
    	// filter created from date
    	$filter_from_date = $this->input->get('from_date');
    	if ($filter_from_date) {    		
    		$where['DATE(created) >='] = standar_date($filter_from_date, '-', '-');
    	}
    
    	// filter created end date
    	$filter_to_date = $this->input->get('to_date');
    	if ($filter_to_date) {    		
    		$where['DATE(created) <='] = standar_date($filter_to_date, '-', '-');
    	}
        $this->paginator['order'] = array('id' => 'desc');
        
        $this->load->model('users/User');
        $count_user = $this->User->find('count', array(
        		'select' => 'id',        		
        		'where' => $where,
    			'order' => array(
        			'id' => 'desc'
    			),
        	));
        $this->load->model('tracking_logs/Tracking_log');
        $count_log = $this->Tracking_log->find('count', array(
        		'select' => 'id',        		
        		'where' => $where,
    			'order' => array(
        			'id' => 'desc'
    			),
        	));
		$where_share = $where;
		$where_share['share_name'] = 'zm';	
        $count_share_zm = $this->Tracking_share->find('count', array(
        		'select' => 'id',        		
        		'where' => $where_share,        		
    			'order' => array(
        			'id' => 'desc'
    			),
        	));
        $where_share_fb = $where;
		$where_share_fb['share_name'] = 'fb';	
        $count_share_fb = $this->Tracking_share->find('count', array(
        		'select' => 'id',        		
        		'where' => $where_share_fb,
        		
    			'order' => array(
        			'id' => 'desc'
    			),
        	));        	
        
        $this->load->model('content_contests/Content_contest');
        $where_contest_noact = $where;
		$where_contest_noact['status'] = 0;
        $count_contests_notact = $this->Content_contest->find('count', array(
        		'select' => 'id',        		
        		'where' => $where_contest_noact,        		
    			'order' => array(
        			'id' => 'desc'
    			),
        	));     
		
        $where_contest_consider = $where;
		$where_contest_consider['status'] = 2;
        $count_contests_consider = $this->Content_contest->find('count', array(
        		'select' => 'id',        		
        		'where' => $where_contest_consider,        		
    			'order' => array(
        			'id' => 'desc'
    			),
        	));
        	
       	$where_contest_act = $where;
		$where_contest_act['status'] = 1;
        $count_contests_act = $this->Content_contest->find('count', array(
        		'select' => 'id',        		
        		'where' => $where_contest_act,
    			'order' => array(
        			'id' => 'desc'
    			),
        	));
        	
        $where_contest_not = $where;
		$where_contest_not['status'] = -1;
        $count_contests_not = $this->Content_contest->find('count', array(
        		'select' => 'id',        		
        		'where' => $where_contest_not,
    			'order' => array(
        			'id' => 'desc'
    			),
        	));
        	
        $count_contests_user = $this->Content_contest->find('all', array(
        		'select' => 'username',        		
        		'where' => $where,      		
        		'groupby' => array('username'),
        	));  
       	$this->load->model('comments/Comment');
       	$where_comment_act = $where;
		$where_comment_act['resource_id'] = 93;
		$where_comment_act['status_id'] = 1;
        $count_comment_act = $this->Comment->find('count', array(
        		'select' => 'id',        		
        		'where' => $where_comment_act,
    			'order' => array(
        			'id' => 'desc'
    			),
        	));
        	
        
        $where_comment_noact = $where;
		$where_comment_noact['resource_id'] = 93;
		$where_comment_noact['status_id'] = 0;
        $count_comment_notact = $this->Comment->find('count', array(
        		'select' => 'id',        		
        		'where' => $where_comment_noact,        		
    			'order' => array(
        			'id' => 'desc'
    			),
        	));
        $this->load->model('coke_promotion_chats/Coke_promotion_chat');
        $count_chat = $this->Coke_promotion_chat->find('count', array(
        		'select' => 'id',        		
        		'where' => $where,
    			'order' => array(
        			'id' => 'desc'
    			),
        	));
        $query_count_user_act = '
    	SELECT user_id, count(user_id) as count_user
        FROM content_contests
    	GROUP BY user_id
    	UNION ALL
    	SELECT user_id, count(user_id) as count_user
        FROM comments
        where resource_id = 93
    	GROUP BY user_id
    	UNION ALL
    	SELECT user_id, count(user_id) as count_user
        FROM coke_promotion_chats
    	GROUP BY user_id
    	UNION ALL
    	SELECT user_id, count(user_id) as count_user
        FROM tracking_shares
    	GROUP BY user_id
    	UNION ALL
    	SELECT user_id, count(user_id) as count_user
        FROM votes
    	GROUP BY user_id
			';
    	if ($filter_from_date && $filter_to_date)
        {
        	$query_count_user_act = "
    	SELECT user_id, count(user_id) as count_user
        FROM content_contests
        WHERE DATE(created) >= '" . standar_date($filter_from_date, '-', '-') . "'
				and DATE(created) <= '" . standar_date($filter_to_date, '-', '-') . "'
    	GROUP BY user_id
    	UNION ALL
    	SELECT user_id, count(user_id) as count_user
        FROM comments
        where resource_id = 93
        and DATE(created) >= '" . standar_date($filter_from_date, '-', '-') . "'
				and DATE(created) <= '" . standar_date($filter_to_date, '-', '-') . "'
    	GROUP BY user_id
    	UNION ALL
    	SELECT user_id, count(user_id) as count_user
        FROM coke_promotion_chats
        WHERE DATE(created) >= '" . standar_date($filter_from_date, '-', '-') . "'
				and DATE(created) <= '" . standar_date($filter_to_date, '-', '-') . "'
    	GROUP BY user_id    	
    	UNION ALL
    	SELECT user_id, count(user_id) as count_user
        FROM tracking_shares
        WHERE DATE(created) >= '" . standar_date($filter_from_date, '-', '-') . "'
				and DATE(created) <= '" . standar_date($filter_to_date, '-', '-') . "'
    	GROUP BY user_id
    	UNION ALL
    	SELECT user_id, count(user_id) as count_user
        FROM votes
        WHERE DATE(created) >= '" . standar_date($filter_from_date, '-', '-') . "'
				and DATE(created) <= '" . standar_date($filter_to_date, '-', '-') . "'
    	GROUP BY user_id
			";        	
        }
        $count_user_act = $this->Content_contest->query($query_count_user_act);
        
        $query_count_user_act_ip = '
    	SELECT user_id, count(user_id) as count_user
        FROM content_contests
    	GROUP BY ip
    	UNION ALL
    	SELECT user_id, count(user_id) as count_user
        FROM comments
        where resource_id = 93
    	GROUP BY user_ip
    	UNION ALL
    	SELECT user_id, count(user_id) as count_user
        FROM coke_promotion_chats
    	GROUP BY ip
    	UNION ALL
    	SELECT user_id, count(user_id) as count_user
        FROM tracking_shares
    	GROUP BY ip
    	UNION ALL
    	SELECT user_id, count(user_id) as count_user
        FROM votes
    	GROUP BY user_ip
			';
        
        if ($filter_from_date && $filter_to_date)
        {
        	$query_count_user_act_ip = "
    	SELECT user_id, count(user_id) as count_user
        FROM content_contests
        WHERE DATE(created) >= '" . standar_date($filter_from_date, '-', '-') . "'
				and DATE(created) <= '" . standar_date($filter_to_date, '-', '-') . "'
    	GROUP BY ip
    	UNION ALL
    	SELECT user_id, count(user_id) as count_user
        FROM comments
        where resource_id = 93
        and DATE(created) >= '" . standar_date($filter_from_date, '-', '-') . "'
				and DATE(created) <= '" . standar_date($filter_to_date, '-', '-') . "'
    	GROUP BY user_ip
    	UNION ALL
    	SELECT user_id, count(user_id) as count_user
        FROM coke_promotion_chats
        WHERE DATE(created) >= '" . standar_date($filter_from_date, '-', '-') . "'
				and DATE(created) <= '" . standar_date($filter_to_date, '-', '-') . "'
    	GROUP BY ip    	
    	UNION ALL
    	SELECT user_id, count(user_id) as count_user
        FROM tracking_shares
        WHERE DATE(created) >= '" . standar_date($filter_from_date, '-', '-') . "'
				and DATE(created) <= '" . standar_date($filter_to_date, '-', '-') . "'
    	GROUP BY ip
    	UNION ALL
    	SELECT user_id, count(user_id) as count_user
        FROM votes
        WHERE DATE(created) >= '" . standar_date($filter_from_date, '-', '-') . "'
				and DATE(created) <= '" . standar_date($filter_to_date, '-', '-') . "'
    	GROUP BY user_ip
			";        	
        }
        $count_user_act_ip = $this->Content_contest->query($query_count_user_act_ip);
        	
        $this->load->model('votes/Vote');
        $count_vote = $this->Vote->find('count', array(
        		'select' => 'id',        		
        		'where' => $where,
    			'order' => array(
        			'id' => 'desc'
    			),
        	));
        	
        $this->load->model('tracking_clicks/Tracking_click');
        $count_click = $this->Tracking_click->find('all', array(
        		'select' => 'click_name, count(click_name) as count_name',        		
        		'where' => $where,
    			'groupby' => array(
        			'click_name'
    			),
        	));
        	
        $data = array(
            'count_user'	=> $count_user,
        	'count_log'	=> $count_log,
        	'count_chat'	=> $count_chat,
        	'count_clicks'	=> $count_click,
        	'count_vote'	=> $count_vote,
        	'count_share_zm'	=> $count_share_zm,
        	'count_share_fb'	=> $count_share_fb,
        	'count_user_act'	=> count($count_user_act),
        	'count_user_act_ip'	=> count($count_user_act_ip),
        	'count_contests_notact'	=> $count_contests_notact,
        	'count_contests_not'	=> $count_contests_not,
        	'count_contests_consider'	=> $count_contests_consider,
        	'count_contests_act'	=> $count_contests_act,
        	'count_contests_user'	=> count($count_contests_user),
        	'count_comment_act'	=> $count_comment_act,
        	'count_comment_notact'	=> $count_comment_notact,
            'this_resource' => $this->router->class,          
        );
        
        $this->parser->parse($this->router->class . '/report', $data);
    }
    
	public function export_user() {
    	// check permission
    	$this->PG_ACL('r');
    
    	// set layout
    	$this->layout->set_layout('empty');
    	$this->load->model('users/User');
    	// condition to get data export
    	$where = array(); 
    	 
    	// filter created from date
    	$filter_from_date = $this->input->get('from_date');
    	if ($filter_from_date)
    	{
    		$where['created >= '] = standar_date($filter_from_date, '-', '-') . ' 00:00:00';
    	}
    	 
    	// filter created end date
    	$filter_to_date = $this->input->get('to_date');
    	if ($filter_to_date)
    	{
    		$where['created <= '] = standar_date($filter_to_date, '-', '-') . ' 23:59:59';
    	}
    	 
    	$query_count_user_act = '
    	SELECT u.username, u.full_name, u.email, u.phone, u.address, SUM(v.count_user) as total
    	FROM users u,(
    	SELECT user_id, count(user_id) as count_user
        FROM content_contests
    	GROUP BY user_id
    	UNION ALL
    	SELECT user_id, count(user_id) as count_user
        FROM comments
        where resource_id = 93
    	GROUP BY user_id
    	UNION ALL
    	SELECT user_id, count(user_id) as count_user
        FROM coke_promotion_chats
    	GROUP BY user_id
    	UNION ALL
    	SELECT user_id, count(user_id) as count_user
        FROM tracking_shares
    	GROUP BY user_id
    	UNION ALL
    	SELECT user_id, count(user_id) as count_user
        FROM votes
    	GROUP BY user_id) v
    	WHERE u.id = v.user_id
    	GROUP BY v.user_id
    	ORDER BY SUM(v.count_user) desc
    	LIMIT 50
			';
    	if ($filter_from_date && $filter_to_date)
        {
        	$query_count_user_act = "
    	SELECT u.username, u.full_name, u.email, u.phone, u.address, SUM(v.count_user) as total
    	FROM users u,(
    	SELECT user_id, count(user_id) as count_user
        FROM content_contests
        WHERE DATE(created) >= '" . standar_date($filter_from_date, '-', '-') . "'
				and DATE(created) <= '" . standar_date($filter_to_date, '-', '-') . "'
    	GROUP BY user_id
    	UNION ALL
    	SELECT user_id, count(user_id) as count_user
        FROM comments
        where resource_id = 93
        and DATE(created) >= '" . standar_date($filter_from_date, '-', '-') . "'
				and DATE(created) <= '" . standar_date($filter_to_date, '-', '-') . "'
    	GROUP BY user_id
    	UNION ALL
    	SELECT user_id, count(user_id) as count_user
        FROM coke_promotion_chats
        WHERE DATE(created) >= '" . standar_date($filter_from_date, '-', '-') . "'
				and DATE(created) <= '" . standar_date($filter_to_date, '-', '-') . "'
    	GROUP BY user_id
    	UNION ALL
    	UNION ALL
    	SELECT user_id, count(user_id) as count_user
        FROM tracking_shares
        WHERE DATE(created) >= '" . standar_date($filter_from_date, '-', '-') . "'
				and DATE(created) <= '" . standar_date($filter_to_date, '-', '-') . "'
    	GROUP BY user_id
    	SELECT user_id, count(user_id) as count_user
        FROM votes
        WHERE DATE(created) >= '" . standar_date($filter_from_date, '-', '-') . "'
				and DATE(created) <= '" . standar_date($filter_to_date, '-', '-') . "'
    	GROUP BY user_id) v
    	WHERE u.id = v.user_id
    	GROUP BY v.user_id
    	ORDER BY SUM(v.count_user) desc
    	LIMIT 50
			";        	      	
        }
        $count_user_act = $this->User->query($query_count_user_act);
    	//echo '<pre>';var_dump($datas);die();
    	//var_dump($datas);die();
    	// export
    	$this->load->library('Write_exel');
    	$this->write_exel->write($count_user_act, 'data_user_' . '_' . date('Y_m_d_H'));
    	exit();
    }
                
    /**
     * View data
     *
     * @params int $id
     */
    public function view($id)
    {
        // check permission
        $this->PG_ACL('r');
        
        // set title
        $this->layout->set_title(lang('View Tracking_share'));
                
        $admin_tracking_shares = $this->Tracking_share->get(array('id' => $id));
                
        // set data to view
        $data = array(
            'data_view' => $admin_tracking_shares
        );
        
        // parser
        $this->parser->parse($this->router->class . '/view', $data);
    }
                
    /**
     * Add data    
     */
    public function add()
    {   
        // check permission
        $this->PG_ACL('w');
        
        // set title
        $this->layout->set_title(lang('Add Tracking_share'));
                
        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        // form validate
        //$this->form_validation->set_rules('name', 'Name', 'required');
                
        // get post and check rule
        if ($this->input->post())
        {
            // save data
            if ($this->Tracking_share->create($this->input->post(), TRUE))
            {
                $this->session->set_flashdata('success_message', lang('Success'));
            } else 
            {
                $this->session->set_flashdata('error_message', lang('Error'));
            }
            
            // redirect
            redirect('tracking_shares/admin_tracking_shares');
        }
                
        $data = array();
                
        // parser
        $this->parser->parse($this->router->class . '/add', $data);
    }
                
    /**
     * Edit data
     *
     * @params int $id
     */
    public function edit($id = 0)
    {
        // check permission
        $this->PG_ACL('e');
        
        // set title
        $this->layout->set_title(lang('Edit Tracking_share'));
                
        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        // form validate
        //$this->form_validation->set_rules('name', 'Name', 'required');
        
        // get id
        $id = ($this->input->post('id')) ? $this->input->post('id') : $id;
                
        // get admin_tracking_shares
        $admin_tracking_shares = $this->Tracking_share->get(array('id' => $id));
            
        if (!$admin_tracking_shares)
        {
            show_error(lang('Error params'));
        }
        
        // get post and check rule
        if ($this->input->post())
        {
            // save data
            if ($this->Tracking_share->update($this->input->post(), array('id' => $id), TRUE))
            {
                $this->session->set_flashdata('success_message', lang('Success'));
            } else 
            {
                $this->session->set_flashdata('error_message', lang('Error'));
            }
            
            // redirect
            redirect('tracking_shares/admin_tracking_shares');
        }
                
        // data to view
        $data = array(
            'data_edit' => $admin_tracking_shares
        );
                
        // parser
        $this->parser->parse($this->router->class . '/edit', $data);
    }
                
    /**
     * Delete
     */
    public function delete()
    {
        // check permission
        $this->PG_ACL('d');
        
        $this->deleteRecordOnListView();
    }
}
                
?>