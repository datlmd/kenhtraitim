<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_vote_types
 * ...
 * 
 * @package PenguinFW
 * @subpackage Vote
 * @version 1.0.0
 * 
 * @property Vote_type      $Vote_type
 * @property Vote           $Vote
 */
 
class Admin_vote_types extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Vote_type';
        
        // set layout
        $this->layout->set_layout('admin');
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('votes', lang_web());
            
        $this->load->model('Vote_type');
    }
    
    /**
     * List
     * 
     * @param int $cfn_id
     */
    public function index($cfn_id = 0)
    {
        // check permission
        $this->PG_ACL('r');
        
        // set title
        $this->layout->set_title(lang('Vote type manager'));
        
        // filter
        // filter name
        $filter_name = $this->input->get('name');
        if ($filter_name)
        {
            $this->paginator['where']['name like'] = '%' . $filter_name . '%';
        }
        
        // get all vote type
        $vote_types = $this->pagination(5);
        
        // get $_GET
		$extra_params = get_extra_params_from_url();

        // set data
        $data = array(
            'list_views' => $vote_types,
            'cfn_id' => $cfn_id,            
            
            'this_resource' => $this->router->class,
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'link_edit' => array(                
                'Edit' => 'votes/admin_vote_types/edit/'
            ),
            'pagination_link' => $this->getPaginationLink('/votes/admin_vote_types/index/' . $cfn_id, 5, $extra_params)
        );
        
        // set template
        $this->parser->parse($this->router->class . '/index', $data);
    }
    
    /**
     * Add
     */
    public function add()
    {
        // check permission
        $this->PG_ACL('w');
        
        // set title
        $this->layout->set_title(lang('Add vote type'));
        
        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        // form validate
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('time_second_user', 'Time second user', 'required');
        $this->form_validation->set_rules('time_second_browser', 'Time second browser', 'required');
        $this->form_validation->set_rules('time_second_ip', 'Time second IP', 'required');
        
        // get post and check rule
        if ($this->input->post() && $this->form_validation->run() == TRUE)
        {
            // add vote type
            $this->Vote_type->create($this->input->post(), TRUE);
            
            // redirect to list view
            redirect('votes/admin_vote_types');
        }
        
        // set data
        $data = array(
            
        );
        
        // set template
        $this->parser->parse($this->router->class . '/add', $data);
    }
    
    /**
     * Edit
     * 
     * @param int $id
     */
    public function edit($id = 0)
    {
        // check permission
        $this->PG_ACL('e');
        
        // set title
        $this->layout->set_title(lang('Edit vote type'));
        
        // get id
        $id = ($this->input->post('id')) ? $this->input->post('id') : $id;
        
        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        // form validate
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('time_second_user', 'Time second user', 'required');
        $this->form_validation->set_rules('time_second_browser', 'Time second browser', 'required');
        $this->form_validation->set_rules('time_second_ip', 'Time second IP', 'required');
        
        // get post and check rule
        if ($this->input->post() && $this->form_validation->run() == TRUE)
        {
            // update 
            $this->Vote_type->update($this->input->post(), array('id' => $id), TRUE);
            
            // redirect
            redirect('votes/admin_vote_types');
        }
        
        // get vote types
        $vote_type = $this->Vote_type->get(array('id' => $id));
        
        // check valid vote type
        if (!$vote_type) 
        {
            show_error(lang('Error params'));
        }
        
        // set data
        $data = array(
            'edit_module' => $vote_type
        );
        
        // set template
        $this->parser->parse($this->router->class . '/edit', $data);
    }
    
    /**
     * delete
     */
    public function delete()
    {
        // check permission
        $this->PG_ACL('d');
        
        // delete from form
        $this->deleteRecordOnListView();
    }
}
                
?>