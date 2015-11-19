<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Musics
 * ...
 * 
 * @package PenguinFW
 * @subpackage Music
 * @version 1.0.0
 * 
 * @property Music          $Music
 * @property Music_album    $Music_album
 */
 
class Musics extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Music';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('musics', lang_web());
            
        $this->load->model('Music');
    }
    
    /**
     * View / Listen
     * 
     * @param int $id
     * @param string slug
     */
    public function view($id = 0, $slug = NULL)
    {
        // check permission
        $this->PG_ACL('r');
        
        // check params
        if ($id == 0)
        {
            show_404();
        }
        
        // get music
        $music = $this->Music->get(array('id' => $id));
        
        // check valid
        if (!$music)
        {
            show_404();
        }
        
        // track
        $this->Music->incrementField(array('id' => $id), MUSIC_VIEW_COUNT);
        
        // invalid slug
        if ($music->slug != $slug)
        {            
            redirect_to('musics', 'musics', 'view', $id . '/' . $music->slug);
        }
        
        if ($music->type_id == ConstMusicType::MP3)
        {
            $music_type = 'musics';
        } else 
        {
            $music_type = 'videos';
        }
        
        // set title
        $this->layout->set_title($music->name);
        
        // set javascript
        $this->layout->set_javascript(array(
            'flowplayer/flowplayer-3.2.6.min.js',
            'flowplayer/flowplayer.playlist-3.0.8.js',
            'flowplayer/flowplayer.controls-3.0.2.js'
        ));                
        
        // set css
        $this->layout->set_rel(array(
            'js' => 'flowplayer/playlist.css'
        ));
        
        // lib
        $this->load->helper('strhash');
        
        // process listen music
        // time on view        
        $time_on_view = $this->_timeOnView($music->length);
        
        // get token
        $token = get_token();
        
        // param post view        
        $params_post = string_hash($id.'|'.$token);                
        
        // process vote music
        // get token
        $vote_token = get_token('sys_vtoken');
        
        // param vote record_id|resource_name|type_id|token|field_update_count
        $params_vote = string_hash($id.'|'.'musics'.'|'.ConstMusicGlobal::VoteTypeID.'|'.$vote_token.'|'.MUSIC_VOTE_COUNT.';'.MUSIC_VOTE_POINT);
        
        // process comment
        // get params
        $params_comment = string_hash($id . '|' . 'musics' . '|' . 0 . '|' . MUSIC_COMMENT_COUNT);
        
        // data to template
        $data = array(
            'music' => $music,
            'music_type' => $music_type,
            'time_on_view' => $time_on_view,
            'idd_post' => md5(time()),
            'params_post' => $params_post,
            'params_vote' => $params_vote,
            'params_comment' => $params_comment
        );                
        
        // template        
        $this->parser->parse('view', $data);
    }
    
    /**
     * Listen album
     * 
     * @param int $album_id
     * @param string $album_slug 
     */
    public function album($album_id = 0, $album_slug = '')
    {
        // set permission
        $this->PG_ACL('r');
        
        // lib
        $this->load->model('Music_album');
        
        // get album
        $album = $this->Music_album->get(array('id' => $album_id));
        
        if (!$album)
        {
            show_404();
        }
        
        // check link
        if ($album_slug != $album->slug)
        {
            redirect_to('musics', 'musics', 'album', $album_id . '/' . $album->slug);
        }
        
        // track
        $this->Music_album->incrementField(array('id' => $album_id), MUSIC_ALBUM_VIEW_COUNT);
        
        // set title
        $this->layout->set_title($album->name);
        
        // set javascript
        $this->layout->set_javascript(array(
            'flowplayer/flowplayer-3.2.6.min.js',
            'flowplayer/flowplayer.playlist-3.0.8.js'
        ));                
        
        // set css
        $this->layout->set_rel(array(
            'js' => 'flowplayer/playlist.css'
        ));
        
        // lib
        $this->load->helper('strhash');
        
        // get music
        $musics = $this->Music->getAlbumMusic($album_id);                
        
        // data to template
        $data = array(
            'album' => $album,
            'musics' => $musics,
            'mp3_id' => ConstMusicType::MP3,
            'video_id' => ConstMusicType::Video,
            'idd_post' => md5(time()),
            'token_post' => get_token()
        );
        
        // set tempalte
        $this->parser->parse('album', $data);
    }
    
    /**
     * add Listen time
     */
    public function add_listen()
    {
        // set layout
        $this->layout->set_layout('empty');
        
        // check permission
        if (!$this->isACL('r'))
        {            
            exit();
        }
        
        // lib
        $this->load->helper('strhash');
        
        // process post data
        if ($this->input->post())
        {
            // get params
            $params_hash = $this->input->post('params');
            $params = string_hash($params_hash, FALSE);
            
            // process params
            if (strpos($params, '|') !== FALSE)
            {
                $param_array = explode('|', $params);
                
                $id = $param_array[0];
                $token = $param_array[1];
                
                if ($token == $this->session->userdata('sys_token'))
                {
                    $this->Music->incrementField(array('id' => $id), MUSIC_LISTEN_COUNT.';'.MUSIC_LISTEN_POINT);
                    get_token();
                }
            }
        }
    }
    
    /**
     * add listen when user view on album
     */
    public function add_album_listen()
    {
        // set layout
        $this->layout->set_layout('empty');
        
        // check permission
        if (!$this->isACL('r'))
        {            
            exit();
        }                
        
        // process post data
        if ($this->input->post())
        {
            // get params
            $id = $this->input->post('id');
            $token = str_replace(' ', '', $this->input->post('token'));
            
            if ($id && $token && $token == $this->session->userdata('sys_token'))
            {        
                // lib
                $this->load->helper('strhash');
        
                $this->Music->incrementField(array('id' => $id), MUSIC_LISTEN_COUNT);
                echo get_token();
                exit();
            }
        }
    }
    
    /**
     * get time on view
     * 
     * @param string $time
     * @return string
     */
    private function _timeOnView($time)
    {
        $time_length = (int) $time;
        $time_on_view = ($time_length*70)/100;
        return $time_on_view*1000;
    }        
}
                
?>