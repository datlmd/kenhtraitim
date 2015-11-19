<?php

if(!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author tungcn <cntung2187@gmail.com> 0909898592
 * @copyright Chung Nhut Tung 2011
 * 
 * Controller Admin_photo_albums
 * ...
 * 
 * @package PenguinFW
 * @subpackage Photo
 * @version 1.0.0
 * 
 * @property Photo_album $Photo_album
 * @property Photo_category $Photo_category
 */
class Admin_photo_albums extends MY_Controller {

    function __construct()
    {
        parent::__construct();

        $this->layout->set_layout('admin');

        $this->model_name = 'Photo_album';

        $this->lang->load('generate', lang_web());
        $this->lang->load('photos', lang_web());

        $this->load->model('Photo_album');
        $this->load->model('Photo_category');
    }

    function index($cfn_id = 0)
    {
        // check permission
        $this->PG_ACL('r');

        // set title
        $this->layout->set_title(lang('Photo Album manager'));

        // get data
        $data = $this->_listView('index', $cfn_id);

        $this->parser->parse($this->router->class . '/index', $data);
    }

    private function _listView($action = 'index', $cfn_id = 0)
    {
        // set javascript to view
        $this->layout->set_javascript(array(
            'jquery.ui.core.min.js',
            'jquery.ui.datepicker.min.js'
        ));

        // set css to view
        $this->layout->set_rel(array(
            'jquery.ui.base.css',
            'jquery.ui.datepicker.css'
        ));

        // filter photos
        // filter album status id
        $filter_album_status_id = $this->input->get('album_status_id');
        if($filter_album_status_id != '')
        {
            $this->paginator['where']['album_status_id'] = $filter_album_status_id;
        }

        // filter created from date
        $filter_from_date = $this->input->get('from_date');
        if($filter_from_date)
        {
            $this->paginator['where']['DATE(created) >='] = standar_date($filter_from_date, '-', '-');
        }

        // filter created end date
        $filter_to_date = $this->input->get('to_date');
        if($filter_to_date)
        {
            $this->paginator['where']['DATE(created) <='] = standar_date($filter_to_date, '-', '-');
        }

        // filter photo category id
        $filter_photo_category_id = $this->input->get('photo_category_id');
        if($filter_photo_category_id)
        {
            $this->paginator['where']['photo_category_id'] = $filter_photo_category_id;
        }

        // filter name
        $filter_name = $this->input->get('name');
        if($filter_name)
        {
            $this->paginator['where']['name'] = $filter_name;
        }


        //filter singers
        $filter_singer = $this->input->get('singer_id');
        if($filter_singer)
        {
            $this->paginator['where']['singer_id'] = $filter_singer;
        }

        // only show user not in recycle bin
        // check action is recyclebin
        if($action == 'recyclebin')
        {
            $this->paginator['where']['is_delete'] = 1;
        }
        else
        { // action is index
            $this->paginator['where']['is_delete'] = 0;
        }

        // get Photo Album
        $albums = $this->pagination(5);

        // set data view
        return array(
            'list_views' => $albums,
            'total_records' => $this->count_record,
            'cfn_id' => $cfn_id,
            'album_status_ids' => $this->_getPhotoAlbumStatus(),
            'categories' => $this->Photo_category->getTreeCategories(),
            'this_resource' => $this->router->class,
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'link_edit' => array(
                'View' => 'photos/admin_photo_albums/view/',
                'Edit' => 'photos/admin_photo_albums/edit/',
                'Photos' => array('no_slash' => 'photos/admin_photos?photo_album_id='),
            ),
            'pagination_link' => $this->getPaginationLink('/photos/admin_photo_albums/' . $action . '/' . $cfn_id, 5)
        );
    }

    /**
     *
     * Add Photo Album
     */
    public function add($photo_category_id = 0)
    {
        // check permission
        $this->PG_ACL('w');

        // set javascript to view
        $this->layout->set_javascript(array(
            'jquery.ui.core.min.js',
            'ckeditor/ckeditor.js',
        ));

        // set css to view
        $this->layout->set_rel(array(
            'jquery.ui.base.css',
        ));
        
        // set title
        $this->layout->set_title(lang('Add Photo Album'));

        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');

        // form validate
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('photo_category_id', 'Photo Album', 'required|greater_than[0]');
        $this->form_validation->set_rules('description', 'Description', 'trim');
        $this->form_validation->set_rules('slug', 'Slug', 'trim');
        $this->form_validation->set_rules('album_status_id', 'Album status Id', 'trim|required');

        // get post and check rule
        if($this->input->post() && $this->form_validation->run() == TRUE)
        {


            if(!$slug = $this->input->post('slug'))
            {
                $_POST['slug'] = $this->input->post('name');
            }

            $_POST['slug'] = make_slug($_POST['slug']);
            $_POST['username'] = $this->session->userdata('user_username');

            // save data
            if($this->Photo_album->create($this->input->post(), TRUE))
            {
                if($this->input->post('album_status_id'))
                {
                    // increase album counter in category
                    $this->Photo_category->incrementField(array('id' => $this->input->post('photo_category_id')), 'counter_album');
                }
                $this->session->set_flashdata('success_message', lang('Success'));
            }
            else
            {
                $this->session->set_flashdata('error_message', lang('Error'));
            }

            // redirect
            redirect('photos/admin_photo_albums');
        }

        //get singers
        $singers = $this->Photo_album->find('all', array(
            'from' => 'music_singers',
            'select' => 'id, name',
                ));


        // data to view
        $data = array(
            'singers' => $singers,
            'album_status_ids' => $this->_getPhotoAlbumStatus(),
            'categories' => $this->Photo_category->getTreeCategories(array('category_status_id' => 1)),
            'selected_category_id' => array($photo_category_id),
        );

        // parser
        $this->parser->parse($this->router->class . '/add', $data);
    }

    /**
     * EDIT Photo Album
     *
     * @param int $photo_album_id
     */
    public function edit($photo_album_id = 0)
    {
        // check permission
        $this->PG_ACL('e');

        // set title
        $this->layout->set_title(lang('Edit Photo Album'));

        // set javascript to view
        $this->layout->set_javascript(array(
            'jquery.ui.core.min.js',
            'jquery.ui.datepicker.min.js',
            'ckeditor/ckeditor.js',
        ));

        // set css to view
        $this->layout->set_rel(array(
            'jquery.ui.base.css',
            'jquery.ui.datepicker.css'
        ));

        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');

                // form validate
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('photo_category_id', 'Photo Album', 'required|greater_than[0]');
        $this->form_validation->set_rules('description', 'Description', 'trim');
        $this->form_validation->set_rules('slug', 'Slug', 'trim');
        $this->form_validation->set_rules('album_status_id', 'Album status Id', 'trim|required');

        // get post and check rule
        if($this->input->post() && $this->form_validation->run() == TRUE)
        {
            if(!$slug = $this->input->post('slug'))
            {
                $_POST['slug'] = $this->input->post('name');
            }

            $_POST['slug'] = make_slug($_POST['slug']);

            $original_album = $this->Photo_album->get_array('*', array('id' => $photo_album_id));

            // save data
            if($this->Photo_album->update($this->input->post(), array('id' => $photo_album_id), TRUE))
            {
                // change status of album
                // from enable to disable
                if($original_album['album_status_id'] > $this->input->post('album_status_id'))
                {
                    // decrease counter
                    $this->_decrementCounterAlbum($original_album['photo_category_id']);
                }
                // from disable to enable
                elseif($original_album['album_status_id'] < $this->input->post('album_status_id'))
                {
                    $this->_incrementCounterAlbum($this->input->post('photo_category_id'));
                }
                else
                {
                    // move enabled album to new category
                    if($original_album['photo_category_id'] != $this->input->post('photo_category_id'))
                    {
                        // increase album counter in new category
                        $this->_incrementCounterAlbum($this->input->post('photo_category_id'));
                        // decrease album counter in old category
                        $this->_decrementCounterAlbum($original_album['photo_category_id']);
                    }
                }

                $this->session->set_flashdata('success_message', lang('Success'));
            }
            else
            {
                $this->session->set_flashdata('error_message', lang('Error'));
            }

            // redirect
            redirect_previous_url('photos/admin_photo_albums');
        }

        // get photo album
        $photo_album = $this->Photo_album->get_array('*', array('id' => $photo_album_id));

        //get singers
        $singers = $this->Photo_album->find('all', array(
            'from' => 'music_singers',
            'select' => 'id, name',
                ));

        // data to view
        $data = array(
            'singers' => $singers,
            'edit_module' => $photo_album,
            'album_status_ids' => $this->_getPhotoAlbumStatus(),
            'comment_ids' => $this->_getValueIs(),
            'categories' => $this->Photo_category->getTreeCategories(array('category_status_id' => 1)),
        );

        // parser
        $this->parser->parse($this->router->class . '/edit', $data);
    }

    /**
     *
     * View Photo Album
     * @param int $photo_album_id
     */
    public function view($photo_album_id = 0)
    {
        // check permission
        $this->PG_ACL('r');

        // set title
        $this->layout->set_title(lang('View photo album'));

        // get user data from database
        $photo_album = $this->Photo_album->find('first', array(
            'where' => array('id' => $photo_album_id)
                ));

        // Get parent category
        if(!$photo_album->photo_category_id)
        {
            $photo_album->parent_name = lang('No Parent');
        }
        else
        {
            $photo_category_parent = $this->Photo_category->find('first', array(
                'select' => 'photo_categories.*',
                'from' => 'photo_categories',
                'where' => array('photo_categories.id' => $photo_album->photo_category_id)
                    ));

            $photo_album->parent_name = $photo_category_parent->name;
        }
        // Get photo category status
        //$photo_album->category_status_name = ($photo_album->category_status_id == 1) ? lang('Enable') : lang('Disable');
        // Get delete
        //$photo_category->delete_name = ($photo_category->is_delete == 1) ? lang('Removed') : lang('No');
        // set data to view
        $data = array(
            'view_data' => $photo_album,
            'album_status_ids' => $this->_getPhotoAlbumStatus(),
            'comment_ids' => $this->_getValueIs(),
        );

        // parser
        $this->parser->parse($this->router->class . '/view', $data);
    }

    /**
     * Delete on list view
     */
    public function delete()
    {
        if($this->input->post())
        {

            $list_ids = $this->input->post('listViewId');
            $publish_type = $this->input->post('publish_type');

            if(!empty($list_ids))
            {
                if($publish_type == 1)
                {
                    // is_publish
                    // check permission
                    $this->PG_ACL('p');

                    foreach($list_ids as $id)
                    {
                        $this->_publish($id);
                    }
                }
                elseif($publish_type == -1)
                {
                    // un publish
                    // check permission
                    $this->PG_ACL('p');

                    foreach($list_ids as $id)
                    {
                        $this->_publish($id, FALSE);
                    }
                }
                else
                {
                    // is delete
                    // check permission
                    $this->PG_ACL('d');

                    foreach($list_ids as $id)
                    {
                        $this->_delete($id);
                    }
                } // end
            }
        }

        redirect('photos/admin_photo_albums');
    }

    /**
     *
     * delete photo
     * @param integer $id
     */
    private function _delete($id)
    {
        $record = $this->Photo_album->get_array('*', array('id' => $id));

        if(!$record)
        {
            return FALSE;
        }

        // decrease album counter
        if($record['album_status_id'])
        {
            $this->_decrementCounterAlbum($record['photo_category_id']);
        }

        $this->Photo_album->delete(array('id' => $id));
    }

    /**
     * chang status
     *
     * @param int $id
     * @param boolean $is_publish
     * @return boolean
     */
    private function _publish($id, $is_publish = TRUE)
    {
        $record = $this->Photo_album->get_array('*', array('id' => $id));

        if(!$record)
        {
            return FALSE;
        }

        $status = '';
        if($is_publish)
        {
            // increase album counter
            if(!$record['album_status_id'])
            {
                $this->_incrementCounterAlbum($record['photo_category_id']);
            }
            $status = ConstPhotosStatus::Approved;
        }
        else
        {
            // decrease album counter
            if($record['album_status_id'])
            {
                $this->_decrementCounterAlbum($record['photo_category_id']);
            }
            $status = ConstPhotosStatus::NoApproved;
        }

        $this->Photo_album->update(array('album_status_id' => $status), array('id' => $id));
    }

    private function _incrementCounterAlbum($category_id)
    {
        if(!empty($category_id))
        {
            // increase photo counter in category
            $this->Photo_category->incrementField(array('id' => $category_id), 'counter_album');
        }
    }

    private function _decrementCounterAlbum($category_id)
    {
        if(!empty($category_id))
        {
            // decrease photo counter in category
            $this->Photo_category->decrementField(array('id' => $category_id), 'counter_album');
        }
    }

    /**
     *
     * List value of IS
     * array 0 => No
     * 		1 => Yes
     */
    private function _getValueIs()
    {
        return array(0 => lang('No'), 1 => lang('Yes'));
    }

    /**
     *
     * Get photo album status
     * @return array
     */
    private function _getPhotoAlbumStatus()
    {
        return array(
            array('id' => 0, 'name' => 'Disable'),
            array('id' => 1, 'name' => 'Enable'),
        );
    }

}

?>