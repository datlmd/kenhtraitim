<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Model
 * Function on Music
 * 
 * @package PenguinFW
 * @subpackage Music
 * @version 1.0.0
 */

class Music extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        
        $this->db_table = 'musics';
    }
    
    /**
     * create MP3 
     */
    public function createMp3($dataAll, $check_field = FALSE)
    {
        $dataAll['type_id'] = ConstMusicType::MP3;
        
        return $this->create($dataAll, $check_field);
    }
    
    /**
     * Create Video 
     */
    public function createVideo($dataAll, $check_field = FALSE)
    {
        $dataAll['type_id'] = ConstMusicType::Video;
        
        return $this->create($dataAll, $check_field);
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
            $dataAll['avatar'] = 'avatar_default_music.jpg';
        }
        
        // get category
        if (is_array($dataAll['category']))
        {
            $dataAll['category'] = implode(',', $dataAll['category']);
        }
        
        // username 
        if (!isset($dataAll['username']) || !$dataAll['username'])
        {
            $dataAll['username'] = $this->session->userdata('user_username');
        }
        
        return parent::create($dataAll, $check_field);
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
            $dataAll['avatar'] = 'avatar_default_music.jpg';
        }
        
        // get category
        if (is_array($dataAll['category']))
        {
            $dataAll['category'] = implode(',', $dataAll['category']);
        }
        
        // username 
        if (isset($dataAll['username']) && !$dataAll['username'])
        {
            $dataAll['username'] = $this->session->userdata('user_username');
        }
        
        return parent::update($dataAll, $where, $check_field);
    }
    
    /**
     * update status id
     * 
     * @param int $id
     * @param int $status_id 
     */
    public function updateStatus($id, $status_id)
    {
        $dataAll['status_id'] = $status_id;
        
        parent::update($dataAll, array('id' => $id));
    }
    
    /**
     * get music in album
     * 
     * @param int $album_id
     * @return array 
     */
    public function getAlbumMusic($album_id)
    {
        return $this->get(array('album_id' => $album_id), NULL, FALSE, 0);                
    }
    
    /**
     * get total point
     * 
     * @param int $listen_count
     * @param int $vote_count
     * @param int $sms_vote_cout 
     */
    public function getTotalPoint($listen_count, $vote_count, $sms_vote_cout)
    {
        $listen = (int) $listen_count;
        $listen_percent = ConstMusicGlobal::ListenPercent;
        
        $vote = (int) $vote_count;
        $vote_percent = ConstMusicGlobal::VotePercent;
        
        $sms = (int) $sms_vote_cout;
        $sms_pervent = ConstMusicGlobal::SmsPercent;
        
        return (($listen*$listen_percent)/100) + (($vote*$vote_percent)/100) + (($sms*$sms_pervent)/100);
    }
}

?>