<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_music_singer_categories
 * ...
 * 
 * @package PenguinFW
 * @subpackage musics
 * @version 1.0.0
 */
 
class Admin_music_singer_categories extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->layout->set_layout('admin');
            
        $this->model_name = 'Music_singer_category';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('musics', lang_web());
            
        $this->load->model('Music_singer_category');
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
        $this->layout->set_title(lang('Music_singer_category manager'));
        
        // get admin_music_singer_categories
        $this->paginator['from'] = 'music_singer_categories m';
        $this->paginator['leftjoin'] = array('events e' => 'm.event_id = e.id');
        $this->paginator['select'] = 'm.*, e.name as event_id';
        
        // filter
        // filter name
        $filter_name = $this->input->get('name');
        if($filter_name)
        {
            $this->paginator['where']['name like'] = '%' . $filter_name . '%';
        }
        
        //filter category
        $filter_cate = $this->input->get('event_id');
        if($filter_cate)
        {
            $this->paginator['where']['m.event_id'] = $filter_cate;
        }
        
        $admin_music_singer_categories = $this->pagination(5);
                
        $data = array(
            'list_views' => $admin_music_singer_categories,
            'total_records' => $this->count_record,
            'events' => $this->Music_singer_category->find('all', array('from' => 'events', 'select' => 'id, name')),
            'this_resource' => $this->router->class,            
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'link_edit' => array(
                'Edit' => 'musics/admin_music_singer_categories/edit/'                
            ),
            'pagination_link' => $this->getPaginationLink('/musics/admin_music_singer_categories/index/' . $cfn_id, 5)
        );
        
        $this->parser->parse($this->router->class . '/index', $data);
    }
    
    public function export()
    {
        $this->paginator['from'] = 'music_singer_categories m';
        $this->paginator['leftjoin'] = array('events e' => 'm.event_id = e.id');
        $this->paginator['select'] = 'm.*, e.name as event_id';
        
        // filter
        // filter name
        $filter_name = $this->input->get('name');
        if($filter_name)
        {
            $this->paginator['where']['name like'] = '%' . $filter_name . '%';
        }
        
        //filter category
        $filter_cate = $this->input->get('event_id');
        if($filter_cate)
        {
            $this->paginator['where']['m.event_id'] = $filter_cate;
        }

        // order

        $this->paginator['limit'] = 0;
        
        $contents = array();

        $contents = $this->pagination(5);

        if(empty($contents))
        {

            $contents[0] = array('Data' => 'No record');
        }

        $this->load->library('Write_exel');
        $this->write_exel->write($contents, SITE_NAME . '_' . date('Y_m_d_H'));
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
        $this->layout->set_title(lang('View Music_singer_category'));
                
        $admin_music_singer_categories = $this->Music_singer_category->get(array('id' => $id));
                
        // set data to view
        $data = array(
            'data_view' => $admin_music_singer_categories
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
        $this->layout->set_title(lang('Add Music_singer_category'));
                
        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        // form validate
        $this->form_validation->set_rules('name', 'Name', 'required');
                
        // get post and check rule
        if ($this->input->post() && $this->form_validation->run() == TRUE)
        {
            // save data
            if ($this->Music_singer_category->create($this->input->post(), TRUE))
            {
                $this->session->set_flashdata('success_message', lang('Success'));
            } else 
            {
                $this->session->set_flashdata('error_message', lang('Error'));
            }
            
            // redirect
            redirect('musics/admin_music_singer_categories');
        }
                
        //events
        $events = $this->Music_singer_category->find('all', array(
           'from' => 'events',
        ));

        
        $data = array(
            'events' => $events,
        );
                
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
        $this->layout->set_title(lang('Edit Music_singer_category'));
                
        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        // form validate
        $this->form_validation->set_rules('name', 'Name', 'required');
        
        // get id
        $id = ($this->input->post('id')) ? $this->input->post('id') : $id;
                
        // get admin_music_singer_categories
        $admin_music_singer_categories = $this->Music_singer_category->get(array('id' => $id));
            
        if (!$admin_music_singer_categories)
        {
            show_error(lang('Error params'));
        }
        
        // get post and check rule
        if ($this->input->post() && $this->form_validation->run() == TRUE)
        {
            // save data
            if ($this->Music_singer_category->update($this->input->post(), array('id' => $id), TRUE))
            {
                $this->session->set_flashdata('success_message', lang('Success'));
            } else 
            {
                $this->session->set_flashdata('error_message', lang('Error'));
            }
            
            // redirect
            redirect('musics/admin_music_singer_categories');
        }
                
        //events
        $events = $this->Music_singer_category->find('all', array(
           'from' => 'events',
        ));

        // data to view
        $data = array(
            'data_edit' => $admin_music_singer_categories,
            'events' => $events,
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