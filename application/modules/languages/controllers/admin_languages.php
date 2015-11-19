<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_languages
 * ...
 * 
 * @package PenguinFW
 * @subpackage Language
 * @version 1.0.0
 * 
 * @property Language       $Language
 */
 
class Admin_languages extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Language';
        
        // set layout
        $this->layout->set_layout('admin');
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('languages', lang_web());
            
        $this->load->model('Language');
    }
    
    /**
     * LIST
     * 
     * @param int $cfn_id custom name id
     */
    public function index($cfn_id = 0)
    {
        // check permission
        $this->PG_ACL('r');
        
        // set title
        $this->layout->set_title(lang('Language manager'));
        
        // filter
        // filter name
        $filter_name = $this->input->get('name');
        if ($filter_name)
        {
            $this->paginator['where']['name like'] = '%' . $filter_name . '%';
        }
        
        // get all language
        $languages = $this->pagination(5);
        
        // get $_GET
        $extra_params = get_extra_params_from_url();
        
        // set data
        $data = array(
            'list_views'    => $languages,
            'cfn_id'        => $cfn_id,            
            
            'this_resource' => $this->router->class,
            'cf_names'      => $this->getCustomFieldName(NULL, FALSE),
            'fields'        => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'link_edit'     => array(                
                'Edit'      => 'languages/admin_languages/edit/',
                'Active'    => 'languages/admin_languages/active/',
                'Manager'   => 'languages/admin_translations/index/',
                'Refresh'   => 'languages/admin_translations/refresh/',
            ),
            'pagination_link' => $this->getPaginationLink('/languages/admin_languages/index/' . $cfn_id, 5, $extra_params)
        );
        
        // set template
        $this->parser->parse($this->router->class . '/index', $data);
    }
    
    /**
     * ADD
     */
    public function add()
    {
        // set permission
        $this->PG_ACL('w');
        
        // set title
        $this->layout->set_title(lang('Add language'));
        
        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        // form validate
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('code', 'Code', 'required');
        
        // get post and check rule
        if ($this->input->post() && $this->form_validation->run() == TRUE)
        {
            // insert 
            $this->Language->create($this->input->post(), TRUE);
            
            // redirect
            redirect('languages/admin_languages/');
        }
        
        // set data
        $data = array(
            
        );
        
        // set template
        $this->parser->parse($this->router->class . '/add', $data);
    }
    
    /**
     * EDIT
     * 
     * @param int $id
     */
    public function edit($id = 0)
    {
        // set permission
        $this->PG_ACL('e');
        
        // set title
        $this->layout->set_title(lang('Edit language'));                
        
        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        // form validate
        $this->form_validation->set_rules('name', 'Name', 'required');
        
        // get id
        $id = ($this->input->post('id')) ? $this->input->post('id') : $id;
        
        // get post and check rule
        if ($this->input->post() && $this->form_validation->run() == TRUE)
        {
            // update
            $this->Language->update($this->input->post(), array('id' => $id), TRUE);
            
            // redirect
            redirect('languages/admin_languages/');
        }
        
        // get language
        $language = $this->Language->get(array('id' => $id));
        
        // check valid
        if (!$language)
        {
            show_error(lang('Error params'));
        }
        
        // set data
        $data = array(
            'data_edit' => $language
        );
        
        // set template
        $this->parser->parse($this->router->class . '/edit', $data);
    }
    
    /**
     * delete
     */
    public function delete()
    {
        // set permission
        $this->PG_ACL('d');
        
        // check $id
        if ($this->input->post())
        {
            // get data post
            $list_delete_ids = $this->input->post('listViewId');
            
            if (in_array(1, $list_delete_ids))
            {
                show_error(lang('Can not delete language system default'));
            }
        }
        
        // delete
        $this->deleteRecordOnListView();
    }
}
                
?>