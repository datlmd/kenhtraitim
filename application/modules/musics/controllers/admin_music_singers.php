<?php

if(!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_music_singers
 * ...
 * 
 * @package PenguinFW
 * @subpackage Music
 * @version 1.0.0
 * 
 * @property Music_singer   $Music_singer
 */
class Admin_music_singers extends MY_Controller {

    function __construct()
    {
        parent::__construct();

        //music singers
        $this->model_name = 'Music_singer';

        // set layout admin
        $this->layout->set_layout('admin');

        $this->lang->load('generate', lang_web());
        $this->lang->load('musics', lang_web());

        $this->load->model('Music_singer');
        $this->load->model('Music_singer_category_relationship');
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
        $this->layout->set_title(lang('Music singer manager'));

        // filter
        // filter name
        $filter_name = $this->input->get('name');
        if($filter_name)
        {
            $this->paginator['where']['name like'] = '%' . $filter_name . '%';
        }
        
        //filter category
        $filter_cate = $this->input->get('category_id');
        if($filter_cate)
        {
            $this->paginator['leftjoin']['music_singer_category_relationships r'] = 'music_singers.id = r.singer_id';
            $this->paginator['where']['r.singer_cate_id'] = $filter_cate;
        }

        // order
        $this->paginator['order'] = array('weight' => 'asc');

        // get list albums
        $singers = $this->pagination(5);



        // set data
        $data = array(
            'list_views' => $singers,
            'cfn_id' => $cfn_id,
            'total_records' => $this->count_record,
            'categories' => $this->Music_singer->find('all', array('from' => 'music_singer_categories', 'select' => 'id, name')),
            'this_resource' => $this->router->class,
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'link_edit' => array(
                'Edit' => 'musics/admin_music_singers/edit/',
                'View' => 'musics/admin_music_singers/view/',
                'Album' => array('no_slash' => 'photos/admin_photo_albums?singer_id='),
            ),
            'pagination_link' => $this->getPaginationLink('/musics/admin_music_singers/index/' . $cfn_id, 5)
        );

        // set template
        $this->parser->parse($this->router->class . '/index', $data);

        //set last url
        $_SESSION[URL_LAST_SESS_NAME] = full_url();
    }

    public function export()
    {
        // filter
        // filter name
        $filter_name = $this->input->get('name');
        if($filter_name)
        {
            $this->paginator['where']['name like'] = '%' . $filter_name . '%';
        }
        
        //filter category
        $filter_cate = $this->input->get('category_id');
        if($filter_cate)
        {
            $this->paginator['leftjoin']['music_singer_category_relationships r'] = 'music_singers.id = r.singer_id';
            $this->paginator['where']['r.singer_cate_id'] = $filter_cate;
        }

        // order
        $this->paginator['order'] = array('weight' => 'asc');

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
     * POPUP 
     */
    public function popup()
    {
        // check permission
        $this->PG_ACL('r');

        // set layout
        $this->layout->set_layout('popup');

        // set title
        $this->layout->set_title(lang('Music singer manager'));

        // filter
        // filter name
        $filter_name = $this->input->get('name');
        if($filter_name)
        {
            $this->paginator['where']['name like'] = '%' . $filter_name . '%';
        }

        // order
        $this->paginator['order'] = array('weight' => 'asc');

        // get list singer
        $singers = $this->pagination(4);

        // set data
        $data = array(
            'list_views' => $singers,
            'pagination_link' => $this->getPaginationLink('/musics/admin_music_singers/index/', 4)
        );

        // set template
        $this->parser->parse($this->router->class . '/popup', $data);
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
        $this->layout->set_title(lang('View music singer'));

        // set data
        $data = array(
            'data_view' => $this->Music_singer->get(array('id' => $id))
        );

        // set template
        $this->parser->parse($this->router->class . '/view', $data);
    }

    /**
     * Add 
     * 
     * @param int $is_popup
     */
    public function add($is_popup = 0)
    {
        // check permission
        $this->PG_ACL('w');

        // set layout if is popup
        if($is_popup == 1)
        {
            $this->layout->set_layout('popup');
        }

        // config layout
        // set title
        $this->layout->set_title(lang('Add music singer'));

        // set title
        $this->layout->set_title(lang('Add music author'));

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
        $this->load->model('Music_singer_category');

        // check form
        $this->form_validation->set_rules('name', 'Name', 'required');

        // created data
        if($this->input->post() && $this->form_validation->run() == TRUE)
        {

            $id = $this->Music_singer->create($this->input->post(), TRUE);
            try
            {
               //update to relationships
                $this->_save_music_singer_category_relationship($id, $this->input->post('category_id'));
            }
            catch(Exception $ex)
            {}
          

            $this->session->set_flashdata('success_message', lang('Add music singer success'));

            if($this->input->post('is_popup'))
            {
                redirect('musics/admin_music_singers/popup?insert_id=' . $this->input->post('insert_id') . '&insert_name=' . $this->input->post('insert_name'));
            }

            redirect('musics/admin_music_singers');
        }

        // set data to template
        $data = array(
            'is_popup' => $is_popup,
            'categories' => $this->Music_singer_category->find('all'),
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
        $this->layout->set_title(lang('Edit music singer'));

        // set title
        $this->layout->set_title(lang('Add music author'));

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

        // check form
        $this->form_validation->set_rules('name', 'Name', 'required');

        // get id
        $id = ($this->input->post('id')) ? $this->input->post('id') : $id;

        // created data
        if($this->input->post() && $this->form_validation->run() == TRUE)
        {
            //update to relationships
            $this->_save_music_singer_category_relationship($id, $this->input->post('category_id'));

            $this->Music_singer->update($this->input->post(), array('id' => $id), TRUE);

            $this->session->set_flashdata('success_message', lang('Edit music singer success'));

            redirect('musics/admin_music_singers');
        }
        $this->load->model('Music_singer_category');

        //get selected categories
        $selected_category_ids = $this->Music_singer_category_relationship->find('all', array(
            'where' => array('singer_id' => $id),
            'select' => 'singer_cate_id',
                ));
        $selected_cate_ids = array();
        
        foreach($selected_category_ids as $selected_category_id)
        {
            $selected_cate_ids[] = $selected_category_id['singer_cate_id'];
        }

        // set data to template
        $data = array(
            'selected_cate_ids' => $selected_cate_ids,
            'data_edit' => $this->Music_singer->get(array('id' => $id)),
            'categories' => $this->Music_singer_category->find('all'),
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

    /**
     * 
     * Save article category relation ship
     * @param integer $article_id
     * @param array $category_ids
     */
    private function _save_music_singer_category_relationship($article_id, $category_ids)
    {
        // Remove article_category_relationship
        $this->Music_singer_category_relationship->deleteRecord(array('singer_id' => $article_id));

        // insert Article_category_relationship
        $this->Music_singer_category_relationship->insert_music_singer_category_relationship($article_id, $category_ids);
    }

}

?>