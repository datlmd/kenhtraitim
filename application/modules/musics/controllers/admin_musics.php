<?php

if(!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_musics
 * ...
 * 
 * @package PenguinFW
 * @subpackage Music
 * @version 1.0.0
 * 
 * @property Music              $Music
 * @property Music_category     $Music_category
 * @property Music_album        $Music_album
 */
class Admin_musics extends MY_Controller {

    function __construct()
    {
        parent::__construct();

        $this->model_name = 'Music';

        // set layout admin
        $this->layout->set_layout('admin');

        $this->lang->load('generate', lang_web());
        $this->lang->load('musics', lang_web());

        $this->load->model('Music');
    }

    /**
     * List
     * 
     * @param int $album_id
     * @param int $cfn_id 
     */
    public function index($album_id = 0, $cfn_id = 0)
    {
        // check permission
        $this->PG_ACL('r');

        // set title
        $this->layout->set_title(lang('Music manager'));

        // set script
        $this->layout->set_javascript(array(
            'shadowbox/shadowbox.js',
            'shadowbox/init.js',
            'tinybox2/tinybox.js'
        ));

        // set style
        $this->layout->set_rel(array(
            'js__1' => 'shadowbox/shadowbox.css',
            'js__2' => 'tinybox2/tinybox.css'
        ));

        // filter
        // filter status
        $filter_status_id = $this->input->get('status');
        if($filter_status_id)
        {
            if($filter_status_id == -1)
            {
                $filter_status_id = 0;
            }

            $this->paginator['where']['musics.status_id'] = $filter_status_id;
        }

        // filter name
        $filter_name = $this->input->get('name');
        if($filter_name)
        {
            $this->paginator['where']['musics.name like'] = '%' . $filter_name . '%';
        }

        // filter type
        $filter_type_id = $this->input->get('type');
        if($filter_type_id)
        {
            $this->paginator['where']['musics.type_id'] = $filter_type_id;
        }

        // filter hight_quality
        $filter_hight_quality = $this->input->get('quality');
        if($filter_hight_quality)
        {
            $this->paginator['where']['musics.hight_quality'] = $filter_hight_quality;
        }

        // filter hit
        $filter_is_hit = $this->input->get('hit');
        if($filter_is_hit)
        {
            if($filter_is_hit == -1)
            {
                $filter_is_hit = 0;
            }
            $this->paginator['where']['musics.is_hit'] = $filter_is_hit;
        }

        // filter singer
        $filter_singer = $this->input->get('singer');
        if($filter_singer)
        {
            $this->paginator['where']['s.name like'] = '%' . $filter_singer . '%';
        }

        // filter author
        $filter_author = $this->input->get('author');
        if($filter_author)
        {
            $this->paginator['where']['a.name like'] = '%' . $filter_author . '%';
        }

        // select,join
        $this->paginator['select'] = 'musics.*, s.name as singer_id, a.name as author_id';
        $this->paginator['from'] = 'musics';
        $this->paginator['join'] = array(
            'music_singers s' => 's.id = musics.singer_id',
            'music_authors a' => 'a.id = musics.author_id'
        );

        // where
        if(is_numeric($album_id) && $album_id > 0)
        {
            $this->paginator['where']['musics.album_id'] = $album_id;
        }

        // order
        $this->paginator['order'] = array('musics.id' => 'desc');

        // get list albums
        $musics = $this->pagination(6);

        //get extra params
        $extra_params = get_extra_params_from_url();
        
        // set data
        $data = array(
            'list_views' => $musics,
            'type_ids' => $this->Music->find('all', array(
                'select' => 'id,name',
                'from' => 'music_types'
            )),
            'album_id' => $album_id,
            'cfn_id' => $cfn_id,
            'this_resource' => $this->router->class,
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'link_edit' => array(
                'Edit' => 'musics/admin_musics/edit/',
                'View' => 'musics/admin_musics/view/',
                'View lyrics' => array(
                    'uri' => 'musics/admin_music_lyricses/index/',
                    'rel' => 'shadowbox'
                ),
                'Add lyrics' => 'musics/admin_music_lyricses/add/',
                'Add to report' => array(
                    'uri' => 'musics/admin_music_report_types/ajax_list/musics__admin_music_reports__add_music/',
                    'class' => 'JsPopupList'
                )
            ),
            'pagination_link' => $this->getPaginationLink('/musics/admin_musics/index/' . $album_id . '/' . $cfn_id, 6, $extra_params)
        );

        $data['total_records'] = $this->count_record;

        // set template
        $this->parser->parse($this->router->class . '/index', $data);

        //set last url
        $_SESSION[URL_LAST_SESS_NAME] = full_url();
    }

    /**
     * Add MP3 
     */
    public function addmp3($album_id = 0)
    {
        // check permission
        $this->PG_ACL('w');

        // set title
        $this->layout->set_title(lang('Add music'));

        // set javascript to view
        $this->layout->set_javascript(array(
            'jquery-ui.min.js',
            'ajaxupload.js',
            'musics/upload.js',
            'musics/upload_audio.js'
        ));

        // lib        
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('Music_category');

        // check form
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('file', 'File', 'required');

        // get album
        $album_id = ($this->input->post('album_id')) ? $this->input->post('album_id') : $album_id;

        // created data
        if($this->input->post() && $this->form_validation->run() == TRUE)
        {
            if($this->Music->createMp3($this->input->post(), TRUE))
            {
                $this->load->model('Music_album');
                $this->Music_album->countMusic($album_id, ConstMusicType::MP3);
            }

            $this->session->set_flashdata('success_message', lang('Add music success'));

            redirect('musics/admin_musics/index/' . $album_id);
        }

        // set data
        $data = array(
            'categories' => $this->Music_category->getTreeItems(),
            'album_id' => $album_id
        );

        // set template
        $this->parser->parse($this->router->class . '/addmp3', $data);
    }

    /**
     * Add Video 
     */
    public function addvideo($album_id = 0)
    {
        // check permission
        $this->PG_ACL('w');

        // set title
        $this->layout->set_title(lang('Add video'));

        // set javascript to view
        $this->layout->set_javascript(array(
            'jquery-ui.min.js',
            'ajaxupload.js',
            'musics/upload_video.js'
        ));

        // lib        
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('Music_category');

        // check form
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('file', 'File', 'required');

        // get album
        $album_id = ($this->input->post('album_id')) ? $this->input->post('album_id') : $album_id;

        // created data
        if($this->input->post() && $this->form_validation->run() == TRUE)
        {
            if($this->Music->createVideo($this->input->post(), TRUE))
            {
                $this->load->model('Music_album');
                $this->Music_album->countMusic($album_id, ConstMusicType::Video);
            }

            $this->session->set_flashdata('success_message', lang('Add video success'));

            redirect('musics/admin_musics/index/' . $album_id);
        }

        // set data
        $data = array(
            'categories' => $this->Music_category->getTreeItems(),
            'album_id' => $album_id
        );

        // set template
        $this->parser->parse($this->router->class . '/addvideo', $data);
    }

    /**
     * View 
     * 
     * @param int $id 
     */
    public function view($id = 0)
    {
        // check permission
        $this->PG_ACL('w');

        // set title
        $this->layout->set_title(lang('View music'));

        // set script
        $this->layout->set_javascript(array(
            'shadowbox/shadowbox.js',
            'shadowbox/init.js',
            'tinybox2/tinybox.js'
        ));

        // set style
        $this->layout->set_rel(array(
            'js__1' => 'shadowbox/shadowbox.css',
            'js__2' => 'tinybox2/tinybox.css'
        ));

        // get music/video
        $music = $this->Music->find('first', array(
            'select' => 'm.*, s.name as singer_id, a.name as author_id, t.name as type_name',
            'from' => 'musics m',
            'join' => array(
                'music_singers s' => 's.id = m.singer_id',
                'music_authors a' => 'a.id = m.author_id',
                'music_types t' => 't.id = m.type_id'
            ),
            'where' => array(
                'm.id' => $id
            )
                ));

        // check valid
        if(!$music)
        {
            show_error(lang('Error params'));
        }

        // get category
        $this->load->model('Music_category');

        $category = $this->Music_category->getStringCategory($music->category);

        // get music type
        if($music->type_id == ConstMusicType::Video)
        {
            $music_type = 'videos';
        }
        else
        {
            $music_type = 'musics';
        }

        // data to template
        $data = array(
            'data_view' => $music,
            'category' => $category,
            'music_type' => $music_type
        );



        // set template
        $this->parser->parse($this->router->class . '/view', $data);
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
        $this->layout->set_title(lang('Edit music'));

        // lib        
        $this->load->helper('form');
        $this->load->library('form_validation');

        // model
        $this->load->model('Music_author');
        $this->load->model('Music_singer');
        $this->load->model('Music_category');

        // get id
        $id = ($this->input->post('id')) ? $this->input->post('id') : $id;

        // get music
        $music = $this->Music->get(array('id' => $id));

        // check valid
        if(!$music)
        {
            show_error(lang('Error params'));
        }

        // check form
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('file', 'File', 'required');

        // update
        if($this->input->post() && $this->form_validation->run())
        {
            $this->Music->update($this->input->post(), array('id' => $id), TRUE);

            redirect('musics/admin_musics/index/' . $music->album_id);
        }

        // data to template
        $data = array(
            'data_edit' => $music,
            'author_name' => $this->Music_author->getAuthorName($music->author_id),
            'singer_name' => $this->Music_singer->getSingerName($music->singer_id),
            'categories' => $this->Music_category->getTreeItems(),
            'category_ids' => explode(',', $music->category)
        );

        // set template
        if($music->type_id == ConstMusicType::Video)
        {
            // set javascript to view
            $js = array(
                'jquery-ui.min.js',
                'ajaxupload.js',
                'musics/upload_video.js'
            );

            $template = '/editvideo';
        }
        else
        {
            // set javascript to view
            $js = array(
                'jquery-ui.min.js',
                'ajaxupload.js',
                'musics/upload.js',
                'musics/upload_audio.js'
            );

            $template = '/editmp3';
        }

        // set static
        // set script
        $js[] = 'shadowbox/shadowbox.js';
        $js[] = 'shadowbox/init.js';
        $this->layout->set_javascript($js);

        // set style
        $this->layout->set_rel(array(
            'js' => 'shadowbox/shadowbox.css'
        ));

        // set template
        $this->parser->parse($this->router->class . $template, $data);
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
                { // is_publish
                    // check permission
                    $this->PG_ACL('p');

                    foreach($list_ids as $id)
                    {
                        $this->_publish($id);
                    }
                }
                else if($publish_type == -1)
                { // un publish
                    // check permission
                    $this->PG_ACL('p');

                    foreach($list_ids as $id)
                    {
                        $this->_publish($id, FALSE);
                    }
                }
                else
                { // is delete
                    // check permission
                    $this->PG_ACL('d');

                    foreach($list_ids as $id)
                    {
                        $this->_delete($id);
                    }
                } // end
            }
        }

        // redirect
        if(isset($_SESSION[URL_LAST_SESS_NAME]))
        {
            $last_url = $_SESSION[URL_LAST_SESS_NAME];
            unset($_SESSION[URL_LAST_SESS_NAME]);
            redirect($last_url);
        }
        else
        {
            $l_redirect = $this->input->post('p_redirect') ? $this->input->post('p_redirect') : '';

            redirect('comments/admin_comments/' . $l_redirect);
        }
    }

    /**
     * delete music
     * 
     * @param int $id
     * @return boolean
     */
    private function _delete($id)
    {
        $music = $this->Music->get_select('id,name,type_id,file,avatar', array('id' => $id));

        if(!$music)
        {
            return FALSE;
        }

        $this->Music->deleteRecord(array('id' => $id));
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
        $music = $this->Music->get_select('id,name,type_id,file,avatar', array('id' => $id));

        if(!$music)
        {
            return FALSE;
        }

        if($is_publish)
        {
            $this->Music->updateStatus($id, ConstMusicsStatus::Approved);
        }
        else
        {
            $this->Music->updateStatus($id, ConstMusicsStatus::NoApproved);
        }
    }

}

?>