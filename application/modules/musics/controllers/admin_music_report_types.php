<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_music_report_types
 * ...
 * 
 * @package PenguinFW
 * @subpackage Music
 * @version 1.0.0
 * 
 * @property Music_report_type      $Music_report_type
 * @property Music_report           $Music_report
 */
 
class Admin_music_report_types extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Music_report_type';
        
        // layout
        $this->layout->set_layout('admin');
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('musics', lang_web());
            
        $this->load->model('Music_report_type');
    }
    
    /**
     * list
     * 
     * @param int $cfn_id
     */
    public function index($cfn_id = 0)
    {
        // check permission
        $this->PG_ACL('r');       

        // set title
        $this->layout->set_title(lang('Music report type manager'));
        
        // set script
        $this->layout->set_javascript(array(            
            'shadowbox/shadowbox.js',
            'shadowbox/init.js'
        ));
        
        // set style
        $this->layout->set_rel(array(
            'js' => 'shadowbox/shadowbox.css'
        ));
        
        // filter
        $where = array();
        
        // filter name
        $filter_name = $this->input->get('name');
        if ($filter_name)
        {
            $where['name like'] = '%' . $filter_name . '%';
        }
        
        $report_types = $this->Music_report_type->getTreeItems($where);
        
        // set data
        $data = array(
            'list_views' => $report_types,            
            
            'cfn_id' => $cfn_id,            
            'this_resource' => $this->router->class,
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'link_edit' => array(                
                'Edit' => 'musics/admin_music_report_types/edit/',
                'Add music' => 'musics/admin_music_reports/add/',
                'View' => array(
                    'uri' => 'musics/admin_music_report_types/view/',
                    'rel' => 'shadowbox'
                ),
                'View music' => array(
                    'uri' => 'musics/admin_music_reports/index/'                    
                ),                
            ),
            'field_show' => 'name'
        );

        // set template
        $this->parser->parse($this->router->class . '/index', $data);
    }
    
    /**
     * add
     */
    public function add()
    {
        // check permission
        $this->PG_ACL('w');
        
        // title
        $this->layout->set_title(lang('Add report type'));
        
        // lib        
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        // check form
        $this->form_validation->set_rules('name', 'Name', 'required');
        
        // add
        if ($this->input->post() && $this->form_validation->run())
        {
            $this->Music_report_type->create($this->input->post(), TRUE);
            
            $this->session->set_flashdata('success_message', lang('Add report music type success'));
            redirect('musics/admin_music_report_types');
        }                
        
        $data = array(
            'parent_ids' => $this->Music_report_type->getTreeItems()
        );
        
        $this->parser->parse($this->router->class . '/add', $data);
    }
    
    /**
     * View
     * 
     * @param int $id report type id
     */
    public function view($id = 0)
    {
        // check permission
        $this->PG_ACL('r');
        
        // layout
        $this->layout->set_layout('popup');
        
        // title
        $this->layout->set_title(lang('View report type'));
        
        // get report_type
        $report_type = $this->Music_report_type->get(array('id' => $id));
        
        if (!$report_type)
        {
            show_error(lang('Error params'));
        }
        
        $data = array(
            'data_view' => $report_type
        );
        
        $this->parser->parse($this->router->class . '/view', $data);
    }
    
    /**
     * List
     * @param string $uri link from name
     */
    public function ajax_list($uri = '', $music_id = 0)
    {
        // check permission
        $this->PG_ACL('r');
        
        // layout
        $this->layout->set_layout('empty');                
        
        // get report type
        $report_types = $this->Music_report_type->getTreeItems(array(), 'weight asc');
        
        $uri = str_replace('__', '/', $uri . '/' . $music_id);
        
        $data = array(
            'report_types' => $report_types,
            'href_link' => base_url($uri)            
        );
        
        $this->parser->parse($this->router->class . '/ajax_list', $data);
    }
    
    /**
     * edit
     * 
     * @param int $id type_id
     */
    public function edit($id = 0)
    {
        // check permission
        $this->PG_ACL('e');
        
        // title
        $this->layout->set_title(lang('Edit report type'));
        
        // lib        
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        // get id
        $id = ($this->input->post('id')) ? $this->input->post('id') : $id;
        
        // get report_type
        $report_type = $this->Music_report_type->get(array('id' => $id));
        
        if (!$report_type)
        {
            show_error(lang('Error params'));
        }
        
        // check form
        $this->form_validation->set_rules('name', 'Name', 'required');
        
        // add
        if ($this->input->post() && $this->form_validation->run())
        {
            $this->Music_report_type->update($this->input->post(), array('id' => $id), TRUE);
            
            $this->session->set_flashdata('success_message', lang('Edit report music type success'));
            redirect('musics/admin_music_report_types');
        }
        
        $data = array(
            'data_edit' => $report_type,
            'parent_ids' => $this->Music_report_type->getTreeItems()
        );
        
        $this->parser->parse($this->router->class . '/edit', $data);
    }
    
    /**
     * delete
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