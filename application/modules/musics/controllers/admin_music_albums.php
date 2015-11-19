<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_music_albums
 * ...
 * 
 * @package PenguinFW
 * @subpackage Music
 * @version 1.0.0
 * 
 * @property Music_album        $Music_album
 * @property Music_category     $Music_category
 */
 
class Admin_music_albums extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Music_album';
        
        // set layout
        $this->layout->set_layout('admin');
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('musics', lang_web());
            
        $this->load->model('Music_album');
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
        $this->layout->set_title(lang('Music album manager'));                  
        
        // filter
        // filter name
        $filter_name = $this->input->get('name');
        if ($filter_name)
        {
            $this->paginator['where']['name like'] = '%' . $filter_name . '%';
        }
        
        // filter category
        $filter_category = $this->input->get('category');
        if ($filter_category)
        {
            $this->paginator['where']['category like'] = '%' . $filter_category . '%';
        }
        
        // filter release year
        $filter_year = $this->input->get('release_year');
        if ($filter_year)
        {
            $this->paginator['where']['release_year'] = $filter_year;
        }
        
        // filter username
        $filter_username = $this->input->get('username');
        if ($filter_username)
        {
            $this->paginator['where']['username'] = $filter_username;
        }
        
        // order
        $this->paginator['order'] = array('weight' => 'asc');
        
        // get list albums
        $albums = $this->pagination(5);
        
        // set data
        $data = array(
            'list_views' => $albums,
            'categories' => $this->Music_album->find('all', array(
                'from' => 'music_categories',
                'select' => 'id,name',
                'order' => array(
                    'weight' => 'asc'
                )
            )),
            
            'cfn_id' => $cfn_id,            
            'this_resource' => $this->router->class,
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'link_edit' => array(                
                'Edit' => 'musics/admin_music_albums/edit/',
                'View' => 'musics/admin_music_albums/view/',
                'List' => 'musics/admin_musics/index/'
            ),
            'pagination_link' => $this->getPaginationLink('/musics/admin_music_albums/index/' . $cfn_id, 5)
        );

        // set template
        $this->parser->parse($this->router->class . '/index', $data);
    }
    
    /**
     * View 
     * 
     * @param int $id
     */
    public function view($id = 0)
    {
        // check permission
        $this->PG_ACL('r');

        // set title
        $this->layout->set_title(lang('View music album'));
        
        // check id
        if ($id == 0)
        {
            show_error(lang('Error params'));
        }
        
        // get album
        $album = $this->Music_album->get(array('id' => $id));
        
        // get singer
        $singer_name = '';
        // query singer
        if ($album->singer_id > 0)
        {
            $singer = $this->Music_album->find('first', array(
                'select' => 'id,name,nickname',
                'from' => 'music_singers',
                'where' => array('id' => $album->singer_id)
            ));
            
            $singer_name = $singer->name;
        }
        
        // load model category
        $this->load->model('Music_category');
        
        // set data to template
        $data = array(
            'data_view' => $album,
            'singer_name' => $singer_name,
            'category' => $this->Music_category->getStringCategory($album->category)
        );
        // set template
        $this->parser->parse($this->router->class . '/view', $data);
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
        $this->layout->set_title(lang('Add music album'));
        
        // set javascript to view
        $this->layout->set_javascript(array(
            'jquery-ui.min.js',
            'ajaxupload.js',
            'musics/upload.js',
            'ckeditor/ckeditor.js'
        ));
        
        // lib
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('Music_category');

        // check form
        $this->form_validation->set_rules('name', 'Name', 'required');       
        
        // created data
        if ($this->input->post() && $this->form_validation->run() == TRUE)
        {            
            $this->Music_album->create($this->input->post(), TRUE);
            
            $this->session->set_flashdata('success_message', lang('Add music album success'));
            
            redirect('musics/admin_music_albums');
        }
        
        // set data to template
        $data = array(
            'categories' => $this->Music_category->getTreeItems()
        );
        // set template
        $this->parser->parse($this->router->class . '/add', $data);
    }
    
    /**
     * Edit 
     */
    public function edit($id = 0)
    {
        // check permission
        $this->PG_ACL('e');
        
        // config layout
        // set title
        $this->layout->set_title(lang('Edit music album'));
        
        // set javascript to view
        $this->layout->set_javascript(array(
            'jquery-ui.min.js',
            'ajaxupload.js',
            'musics/upload.js',
            'ckeditor/ckeditor.js'
        ));                           
        
        // lib
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('Music_category');
        
        // model
        $this->load->model('Music_category');

        // check form
        $this->form_validation->set_rules('name', 'Name', 'required');       
        
        // get id
        $id = ($this->input->post('id')) ? $this->input->post('id') : $id;
        
        // created data
        if ($this->input->post() && $this->form_validation->run() == TRUE)
        {
            $this->Music_album->update($this->input->post(), array('id' => $id), TRUE);
            
            $this->session->set_flashdata('success_message', lang('Edit music lyrics success'));
            
            redirect('musics/admin_music_albums');
        }
        
        // get album
        $album = $this->Music_album->get(array('id' => $id));
        
        // get singer
        $singer_name = '';
        // query singer
        if ($album->singer_id > 0)
        {
            $singer = $this->Music_album->find('first', array(
                'select' => 'id,name,nickname',
                'from' => 'music_singers s',
                'where' => array('id' => $album->singer_id)
            ));
            
            $singer_name = $singer->name;
        }
        
        // set data to template
        $data = array(
            'data_edit' => $album,
            'singer_name' => $singer_name,
            'categories' => $this->Music_category->getTreeItems(),
            'category_ids' => explode(',', $album->category)
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
        
        $this->deleteRecordOnListView();
    }
}
                
?>