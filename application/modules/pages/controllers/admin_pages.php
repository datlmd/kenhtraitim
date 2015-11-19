<?php

if(!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_pages
 * ...
 * 
 * @package PenguinFW
 * @subpackage Page
 * @version 1.0.0
 * 
 * @property Page           $Page
 * @property Language       $Language
 */
class Admin_pages extends MY_Controller {

    function __construct()
    {
        parent::__construct();

        $this->model_name = 'Page';

        // set layout admin
        $this->layout->set_layout('admin');

        $this->lang->load('generate', lang_web());
        $this->lang->load('pages', lang_web());

        $this->load->model('Page');
    }

    /**
     * List
     * 
     * @params int $id
     */
    public function index($cfn_id = 0)
    {
        // check permission 
        $this->PG_ACL('r');

        // set title
        $this->layout->set_title(lang('Page manager'));

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
        // filter status
        $filter_status = $this->input->get('status');
        if($filter_status)
        {
            if($filter_status == -1)
            {
                $filter_status = 0;
            }

            $this->paginator['where']['is_active'] = $filter_status;
        }

        // filter title
        $filter_title = $this->input->get('title');
        if($filter_title)
        {
            $this->paginator['where']['title like'] = '%' . $filter_title . '%';
        }

        // get pages
        $pages = $this->pagination(5);

        // set data to template
        $data = array(
            'list_views' => $pages,
            'cfn_id' => $cfn_id,
            'this_resource' => $this->router->class,
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'link_edit' => array(
                'Edit' => 'pages/admin_pages/edit/',
                'View' => 'pages/admin_pages/view/',
                'Preview' => array(
                    'uri' => 'pages/admin_pages/preview/',
                    'rel' => 'shadowbox'
                )
            ),
            'pagination_link' => $this->getPaginationLink('/pages/admin_pages/index/' . $cfn_id, 5)
        );

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
        $this->layout->set_title(lang('View page'));

        // set script
        $this->layout->set_javascript(array(
            'shadowbox/shadowbox.js',
            'shadowbox/init.js'
        ));

        // set style
        $this->layout->set_rel(array(
            'js' => 'shadowbox/shadowbox.css'
        ));

        $data = array(
            'data_view' => $this->Page->get(array('id' => $id))
        );

        $this->parser->parse($this->router->class . '/view', $data);
    }

    /**
     * Preview
     * 
     * @param int $id
     */
    public function preview($id = 0)
    {
        // check permission 
        $this->PG_ACL('r');

        // set title
        $this->layout->set_title(lang('Preview page'));

        // page
        $page = $this->Page->get(array('id' => $id));

        if($page->layout)
        {
            $this->layout->set_layout($page->layout);
        }
        else
        {
            $this->layout->set_layout('default');
        }

        // data to template
        $data = array(
            'data_view' => $page
        );

        // template
        $this->parser->parse($this->router->class . '/preview', $data);
    }

    /**
     * Add
     */
    public function add()
    {
        // set permission
        $this->PG_ACL('w');

        // set title
        $this->layout->set_title(lang('Add page'));

        // get parent page
        $parents = $this->Page->get(array('parent_id' => 0), NULL, FALSE, 0);

        $this->load->helper('form');
        $this->load->library('form_validation');

        // check form
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('content', 'Content', 'required');
        $this->form_validation->set_rules('slug', 'Slug', 'trim');
        $this->form_validation->set_rules('page_link', 'Page Link', 'trim');
        $this->form_validation->set_rules('mapto_id', 'Mapto ID', 'trim');
        $this->form_validation->set_rules('layout', 'Layout', 'trim');
        $this->form_validation->set_rules('is_active', 'Is Active', 'trim');
        $this->form_validation->set_rules('meta_keyword', 'Meta keyword', 'trim');
        $this->form_validation->set_rules('meta_description', 'Meta description', 'trim');

        // process post form
        if($this->input->post() && $this->form_validation->run() == TRUE)
        {
            $this->Page->create($this->input->post(), TRUE);

            $this->session->set_flashdata('success_message', lang('Add page success'));
            redirect('pages/admin_pages');
        }

        // set data to view
        $data = array(
            'parent_ids' => $parents,
            'languages' => $this->_getLanguage()
        );

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
        $this->layout->set_title(lang('Edit page'));

        // set javascript
        $this->layout->set_javascript(array(
            'ckeditor/ckeditor.js'
        ));

        $this->load->helper('form');
        $this->load->library('form_validation');

        // get id
        $id = ($this->input->post('id')) ? $this->input->post('id') : $id;

        // get page
        $page = $this->Page->get(array('id' => $id));

        if(!$page)
        {
            show_error(lang('Error params'));
        }

        // check form        
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('content', 'Content', 'required');
        $this->form_validation->set_rules('slug', 'Slug', 'trim');
        $this->form_validation->set_rules('page_link', 'Page Link', 'trim');
        $this->form_validation->set_rules('mapto_id', 'Mapto ID', 'trim');
        $this->form_validation->set_rules('layout', 'Layout', 'trim');
        $this->form_validation->set_rules('is_active', 'Is Active', 'trim');
        $this->form_validation->set_rules('meta_keyword', 'Meta keyword', 'trim');
        $this->form_validation->set_rules('meta_description', 'Meta description', 'trim');

        // get data from form end edit data
        if($this->input->post() && $this->form_validation->run() == TRUE)
        {
            $this->Page->update($this->input->post(), array('id' => $id));

            $this->session->set_flashdata('success_message', lang('Edit page success'));
            redirect('pages/admin_pages');
        }

        // get parent page
        $parents = $this->Page->get(array('parent_id' => 0), NULL, FALSE, 0);

        // set data to view
        $data = array(
            'parent_ids' => $parents,
            'data_edit' => $page,
            'languages' => $this->_getLanguage()
        );

        $this->parser->parse($this->router->class . '/edit', $data);
    }

    /**
     * Delete
     */
    public function delete()
    {
        // check permission
        $this->PG_ACL('e');

        // delete
        $this->deleteRecordOnListView();
    }

    /**
     * get all language
     * 
     * @return array
     */
    private function _getLanguage()
    {
        $this->load->model('languages/Language');
        return $this->Language->get(array(), 'is_active', FALSE);
    }

}

?>