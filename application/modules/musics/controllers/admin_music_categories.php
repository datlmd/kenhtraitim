<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_music_categories
 * ...
 * 
 * @package PenguinFW
 * @subpackage Music
 * @version 1.0.0
 * 
 * @property Music_category     $Music_category
 */
 
class Admin_music_categories extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Music_category';
        
        // set layout
        $this->layout->set_layout('admin');
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('musics', lang_web());
            
        $this->load->model('Music_category');
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
        $this->layout->set_title(lang('Music category manager'));                        
        
        // filter
        $where = array();
        // filter name
        $filter_name = $this->input->get('name');
        if ($filter_name)
        {
            $where['name like'] = '%' . $filter_name . '%';
        }                                
        
        // get list category
        $categories = $this->Music_category->getTreeItems($where, 'weight asc');        
                
        // set data
        $data = array(
            'list_views' => $categories,            
            
            'cfn_id' => $cfn_id,            
            'this_resource' => $this->router->class,
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'link_edit' => array(                
                'Edit' => 'musics/admin_music_categories/edit/'
            ),
            'field_show' => 'name'
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
        
        // config layout
        // set title
        $this->layout->set_title(lang('Add music category'));
        
        // set javascript
        $this->layout->set_javascript(array(
            'ckeditor/ckeditor.js'
        ));
        
        // lib
        $this->load->helper('form');
        $this->load->library('form_validation');

        // check form
        $this->form_validation->set_rules('name', 'Name', 'required');       
        
        // created data
        if ($this->input->post() && $this->form_validation->run() == TRUE)
        {
            $this->Music_category->create($this->input->post(), TRUE);
            
            redirect('musics/admin_music_categories');
        }
        
        // set data to template
        $data = array(
            'parent_ids' => $this->Music_category->getTreeItems(array(), 'weight asc')        
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
        
        // config layout
        // set title
        $this->layout->set_title(lang('Edit music category'));
        
        // set javascript
        $this->layout->set_javascript(array(
            'ckeditor/ckeditor.js'
        ));
        
        // lib
        $this->load->helper('form');
        $this->load->library('form_validation');

        // check form
        $this->form_validation->set_rules('name', 'Name', 'required'); 
        
        // get id
        $id = ($this->input->post('id')) ? $this->input->post('id') : $id;
        
        // created data
        if ($this->input->post() && $this->form_validation->run() == TRUE)
        {
            $this->Music_category->update($this->input->post(), array('id' => $id), TRUE);
            
            redirect('musics/admin_music_categories');
        }
        
        // set data to template
        $data = array(
            'data_edit' => $this->Music_category->get(array('id' => $id)),
            'parent_ids' => $this->Music_category->getTreeItems(array(), 'weight asc')
        );
        // set template
        $this->parser->parse($this->router->class . '/edit', $data);
    }
    
    /**
     * Delete 
     */
    public function delete()
    {
        // check permission
        $this->PG_ACL('d');
        
        // delete
        $this->deleteRecordOnListView();
    }
}
                
?>