<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Model
 * Function on Music_album
 * 
 * @package PenguinFW
 * @subpackage Music
 * @version 1.0.0
 */

class Music_album extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        
        $this->db_table = 'music_albums';
    }
    
    /**
     * Create 
     */
    public function create($dataAll, $check_field = FALSE)
    {
        // get slug
        if (isset($dataAll['slug']) && $dataAll['slug'])
        {
            $dataAll['slug'] = make_slug($dataAll['slug']);
        } else 
        {
            $dataAll['slug'] = make_slug($dataAll['name']);
        }
        
        // get avatar default
        if (!isset($dataAll['avatar']) || !$dataAll['avatar'])
        {
            $dataAll['avatar'] = 'avatar_default_album.jpg';
        }
        
        // get category
        if (is_array($dataAll['category']))
        {
            $dataAll['category'] = implode(',', $dataAll['category']);
        }
        
        // get username
        if (!isset($dataAll['username']) || !$dataAll['username'])
        {
            $dataAll['username'] = $this->session->userdata('user_username');
        }
        
        parent::create($dataAll, $check_field);
    }
    
    /**
     * Update 
     */
    public function update($dataAll, $where, $check_field = FALSE)
    {
        // get slug
        if (isset($dataAll['slug']) && $dataAll['slug'])
        {
            $dataAll['slug'] = make_slug($dataAll['slug']);
        } else 
        {
            $dataAll['slug'] = make_slug($dataAll['name']);
        }
        
        // get avatar default
        if (isset($dataAll['avatar']) && !$dataAll['avatar'])
        {
            $dataAll['avatar'] = 'avatar_default_album.jpg';
        }
        
        // get category
        if (is_array($dataAll['category']))
        {
            $dataAll['category'] = implode(',', $dataAll['category']);
        }
        
        // get username
        if (isset($dataAll['username']) && !$dataAll['username'])
        {
            $dataAll['username'] = $this->session->userdata('user_username');
        }
        
        parent::update($dataAll, $where, $check_field);
    }
    
    /**
     * count music
     * 
     * @param int $id album id
     * @param string $type audio|video
     */
    public function countMusic($id, $type)
    {
        if ($type == ConstMusicType::MP3)
        {
            $this->incrementField(array('id' => $id), 'music_count');
        } else 
        {
            $this->incrementField(array('id' => $id), 'video_count');            
        }                
    }
}

?>