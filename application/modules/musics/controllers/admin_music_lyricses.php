<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_music_lyricses
 * ...
 * 
 * @package PenguinFW
 * @subpackage Music
 * @version 1.0.0
 * 
 * @property Music_lyrics   $Music_lyrics
 */
 
class Admin_music_lyricses extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Music_lyrics';
        
        // set layout admin
        $this->layout->set_layout('admin');
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('musics', lang_web());
            
        $this->load->model('Music_lyrics');
    }
    
    /**
     * List
     * 
     * @param int $music_id
     * @param int $cfn_id 
     */
    public function index($music_id = 0, $cfn_id = 0)
    {
        // check permission
        $this->PG_ACL('r');
        
        // set title
        $this->layout->set_title(lang('Music lyrics manager'));
        
        // check music id
        if ($music_id == 0)
        {
            show_error(lang('Error params'));
        }
        
        // order
        $this->paginator['order'] = array('weight' => 'asc');
        
        // get conditions
        $this->paginator['where']['music_id'] = $music_id;
        
        // get list lyrics
        $lyricses = $this->pagination(6);
        
        // set data
        $data = array(
            'list_views' => $lyricses,
            'music_id' => $music_id,
            
            'cfn_id' => $cfn_id,            
            'this_resource' => $this->router->class,
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'link_edit' => array(                
                'Edit' => 'musics/admin_music_lyricses/edit/'
            ),
            'pagination_link' => $this->getPaginationLink('/musics/admin_music_lyricses/index/' . $music_id . '/' . $cfn_id, 6)
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
        $this->layout->set_title(lang('View music lyrics'));
        
        // check params
        if ($id == 0)
        {
            show_error(lang('Error params'));
        }
        
        // get lirics
        $lyrics = $this->Music_lyrics->find('first', array(
            'select' => 'l.*, m.name as music_id',
            'from' => 'music_lyricses l',
            'join' => array(
                'musics m' => 'm.id = l.music_ic'
            ),
            'where' => array(
                'l.id' => $id
            )
        ));
        
        // check lyrics
        if (!$lyrics)
        {
            show_error(lang('Error params'));
        }
        
        // set data template
        $data = array(
            'data_view' => $lyrics
        );
        
        // set template
        $this->parser->parse($this->router->class . '/view', $data);
    }
    
    /**
     * Add 
     * 
     * @param int $music_id
     */
    public function add($music_id = 0)
    {
        // check permission
        $this->PG_ACL('w');
        
        // set title
        $this->layout->set_title(lang('Add music lyrics'));
        
        // set javascript
        $this->layout->set_javascript(array(
            'ckeditor/ckeditor.js'
        ));
        
        // get music id
        $music_id = ($this->input->post('music_id')) ? $this->input->post('music_id') : $music_id;
        
        // check params
        if ($music_id == 0)
        {
            show_error(lang('Error params'));
        }
        
        // lib
        $this->load->helper('form');
        $this->load->library('form_validation');

        // check form
        $this->form_validation->set_rules('content', 'Content', 'required');       
        
        // created data
        if ($this->input->post() && $this->form_validation->run() == TRUE)
        {            
            $this->Music_lyrics->create($this->input->post(), TRUE);
            
            $this->session->set_flashdata('success_message', lang('Add music lyrics success'));
            
            redirect('musics/admin_music_lyricses/index/' . $music_id);
        }
        
        // set data template
        $data = array(
            'music_id' => $music_id
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
        $this->layout->set_title(lang('Edit music lyrics'));
        
        // set javascript
        $this->layout->set_javascript(array(
            'ckeditor/ckeditor.js'
        ));
        
        // get params
        $id = ($this->input->post('id')) ? $this->input->post('id') : $id;        
        
        // check params
        if ($id == 0)
        {
            show_error(lang('Error params'));
        }
        
        // get lirics
        $lyrics = $this->Music_lyrics->get(array('id' => $id));
        
        // check lyrics
        if (!$lyrics)
        {
            show_error(lang('Error params'));
        }
        
        // lib
        $this->load->helper('form');
        $this->load->library('form_validation');

        // check form
        $this->form_validation->set_rules('content', 'Content', 'required');       
        
        // created data
        if ($this->input->post() && $this->form_validation->run() == TRUE)
        {            
            $this->Music_lyrics->update($this->input->post(), array('id' => $id), TRUE);
            
            $this->session->set_flashdata('success_message', lang('Edit music lyrics success'));
            
            redirect('musics/admin_music_lyricses/index/' . $lyrics->music_id);
        }
        
        // set data template
        $data = array(
            'data_edit' => $lyrics
        );
        
        // set template
        $this->parser->parse($this->router->class . '/edit', $data);
    }
    
    /**
     * Detele 
     * 
     * @param $music_lyrics_type 0 delete, 1 publish, -1 unpublish
     */
    public function delete()
    {
        $type = $this->input->post('publish_type');
        
        if ($type == 0)
        {
            // check permission
            $this->PG_ACL('d');

            // delete
            $this->deleteRecordOnListView();
        } else if ($type == 1)
        {
            // check permission
            $this->PG_ACL('p');
            
            // publish
            $this->Music_lyrics->publish($this->input->post('listViewId'));
            
            $this->session->set_flashdata('success_message', lang('Publish music lyrics success'));
            
            // redirect
            redirect('musics/admin_music_lyricses/' . $this->input->post('music_id'));
        } else 
        {
            // check permission
            $this->PG_ACL('p');
            
            // publish
            $this->Music_lyrics->publish($this->input->post('listViewId'), FALSE);
            
            $this->session->set_flashdata('success_message', lang('Unpublish music lyrics success'));
            
            // redirect
            redirect('musics/admin_music_lyricses/' . $this->input->post('music_id'));
        }
    }
}
                
?>