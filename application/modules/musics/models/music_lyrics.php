<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Model
 * Function on Music_lyrics
 * 
 * @package PenguinFW
 * @subpackage Music
 * @version 1.0.0
 */

class Music_lyrics extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        
        $this->db_table = 'music_lyricses';
    }
    
    /**
     * CREATED 
     */
    public function create($dataAll, $check_field = FALSE)
    {
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
        if (isset($dataAll['username']) && !$dataAll['username'])
        {
            $dataAll['username'] = $this->session->userdata('user_username');
        }
        
        parent::update($dataAll, $where, $check_field);
    }
    
    /**
     * Publish 
     * 
     * @param array $ids
     * @param boolean $is_publish
     */
    public function publish($ids, $is_publish = TRUE)
    {
        foreach ($ids as $id)
        {
            if ($is_publish)
            {
                $this->update(array('status_id' => ConstMusicsStatus::Approved), array('id' => $id));
            } else 
            {
                $this->update(array('status_id' => ConstMusicsStatus::NoApproved), array('id' => $id));
            }
        }
    }
}

?>