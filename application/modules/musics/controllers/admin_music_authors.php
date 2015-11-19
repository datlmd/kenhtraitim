<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_music_authors
 * ...
 * 
 * @package PenguinFW
 * @subpackage Music
 * @version 1.0.0
 * 
 * @property Music_author   $Music_author
 */
 
class Admin_music_authors extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Music_author';
		
		// set lay out 
		$this->layout->set_layout('admin');
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('musics', lang_web());
            
        $this->load->model('Music_author');
    }
	
    /**
     * List View
     * 
     * @param int $cfn_id
     */
    public function index($cfn_id = 0)
    {
        // check permission
        $this->PG_ACL('r');

        // set title
        $this->layout->set_title(lang('Music author manager'));                        
        
        // filter
        // filter name
        $filter_name = $this->input->get('name');
        if ($filter_name)
        {
            $this->paginator['where']['name like'] = '%' . $filter_name . '%';
        }
        
        // order
        $this->paginator['order'] = array('weight' => 'asc');
        
        // get list author
        $authors = $this->pagination(5);
        
        // set data
        $data = array(
            'list_views' => $authors,
            'cfn_id' => $cfn_id,            
            
            'this_resource' => $this->router->class,
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'link_edit' => array(                
                'Edit' => 'musics/admin_music_authors/edit/'
            ),
            'pagination_link' => $this->getPaginationLink('/musics/admin_music_authors/index/' . $cfn_id, 5)
        );

        // set template
        $this->parser->parse($this->router->class . '/index', $data);
    }
    
    /**
     * List View popup          
     */
    public function popup()
    {
        // check permission
        $this->PG_ACL('r');

        // set layout
        $this->layout->set_layout('popup');
        
        // set title
        $this->layout->set_title(lang('Music author manager'));                        
        
        // filter
        // filter name
        $filter_name = $this->input->get('name');
        if ($filter_name)
        {
            $this->paginator['where']['name like'] = '%' . $filter_name . '%';
        }
        
        // get list comment
        $authors = $this->pagination(4);
        
        // set data
        $data = array(
            'list_views' => $authors,                                    
            'pagination_link' => $this->getPaginationLink('/musics/admin_music_authors/popup', 4)
        );

        // set template
        $this->parser->parse($this->router->class . '/popup', $data);
    }
	 
    /**
     * ADD
     * 
     * @param boolean $is_popup
     */
    public function add($is_popup = 0)
    {
        // check permission
        $this->PG_ACL('w');
        
        // set layout if is popup
        if ($is_popup == 1)
        {
            $this->layout->set_layout('popup');
        }

        // set title
        $this->layout->set_title(lang('Add music author'));
        
        // set javascript to view
        $this->layout->set_javascript(array(
            'jquery-ui.min.js',
            'ajaxupload.js',
            'musics/upload.js',
            'ckeditor/ckeditor.js'
        ));                
        
        // get lib        
        $this->load->helper('form');
        $this->load->library('form_validation');

        // check form
        $this->form_validation->set_rules('name', 'Name', 'required');       
        
        if ($this->input->post() && $this->form_validation->run() == TRUE)
        {
            $this->Music_author->create($this->input->post(), TRUE);
            
            if ($this->input->post('is_popup'))
            {                
                redirect('musics/admin_music_authors/popup?insert_id=' . $this->input->post('insert_id') . '&insert_name=' . $this->input->post('insert_name'));
            }
            
            redirect('musics/admin_music_authors');
        }

        // set data to template
        $data = array(
            'is_popup' => $is_popup
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
        $this->layout->set_title(lang('Edit music author'));
        
        // set javascript to view
        $this->layout->set_javascript(array(
            'jquery-ui.min.js',
            'ajaxupload.js',
            'musics/upload.js',
            'ckeditor/ckeditor.js'
        ));                
        
        // get lib        
        $this->load->helper('form');
        $this->load->library('form_validation');

        // check form
        $this->form_validation->set_rules('name', 'Name', 'required');
        
        // get id
        $id = ($this->input->post('id')) ? $this->input->post('id') : $id;
        
        // get author
        $author = $this->Music_author->get(array('id' => $id));
        
        // edit
        if ($this->input->post() && $this->form_validation->run() == TRUE)
        {
            $this->Music_author->update($this->input->post(), array('id' => $id), TRUE);
            
            redirect('musics/admin_music_authors');
        }
        
        // set data to template
        $data = array(
            'data_edit' => $author
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