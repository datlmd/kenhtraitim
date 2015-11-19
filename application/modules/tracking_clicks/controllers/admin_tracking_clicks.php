<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_tracking_clicks
 * ...
 * 
 * @package PenguinFW
 * @subpackage tracking_clicks
 * @version 1.0.0
 */
 
class Admin_tracking_clicks extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->layout->set_layout('admin');
            
        $this->model_name = 'Tracking_click';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('tracking_clicks', lang_web());
            
        $this->load->model('Tracking_click');
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
        $this->layout->set_title(lang('Tracking_click manager'));
        
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
        
        // get admin_tracking_clicks
        $admin_tracking_clicks = $this->pagination(5);
                
        $count_c = $this->Tracking_click->find('count', array(
        		'select' => 'id',        		
        		'where' => $where,
    			'order' => array(
        			'id' => 'desc'
    			),
        	));
        	
        $data = array(
            'list_views' => $admin_tracking_clicks,
            'count_contest'	=> $count_c,
            'this_resource' => $this->router->class,            
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'link_edit' => array(
                'Edit' => 'tracking_clicks/admin_tracking_clicks/edit/'                
            ),
            'pagination_link' => $this->getPaginationLink('/tracking_clicks/admin_tracking_clicks/index/' . $cfn_id, 5)
        );
        
        $this->parser->parse($this->router->class . '/index', $data);
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
        $this->layout->set_title(lang('View Tracking_click'));
                
        $admin_tracking_clicks = $this->Tracking_click->get(array('id' => $id));
                
        // set data to view
        $data = array(
            'data_view' => $admin_tracking_clicks
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
        $this->layout->set_title(lang('Add Tracking_click'));
                
        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        // form validate
        //$this->form_validation->set_rules('name', 'Name', 'required');
                
        // get post and check rule
        if ($this->input->post())
        {
            // save data
            if ($this->Tracking_click->create($this->input->post(), TRUE))
            {
                $this->session->set_flashdata('success_message', lang('Success'));
            } else 
            {
                $this->session->set_flashdata('error_message', lang('Error'));
            }
            
            // redirect
            redirect('tracking_clicks/admin_tracking_clicks');
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
        $this->layout->set_title(lang('Edit Tracking_click'));
                
        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        // form validate
        //$this->form_validation->set_rules('name', 'Name', 'required');
        
        // get id
        $id = ($this->input->post('id')) ? $this->input->post('id') : $id;
                
        // get admin_tracking_clicks
        $admin_tracking_clicks = $this->Tracking_click->get(array('id' => $id));
            
        if (!$admin_tracking_clicks)
        {
            show_error(lang('Error params'));
        }
        
        // get post and check rule
        if ($this->input->post())
        {
            // save data
            if ($this->Tracking_click->update($this->input->post(), array('id' => $id), TRUE))
            {
                $this->session->set_flashdata('success_message', lang('Success'));
            } else 
            {
                $this->session->set_flashdata('error_message', lang('Error'));
            }
            
            // redirect
            redirect('tracking_clicks/admin_tracking_clicks');
        }
                
        // data to view
        $data = array(
            'data_edit' => $admin_tracking_clicks
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