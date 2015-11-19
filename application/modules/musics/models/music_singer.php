<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Model
 * Function on Music_singer
 * 
 * @package PenguinFW
 * @subpackage Music
 * @version 1.0.0
 */

class Music_singer extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        
        $this->db_table = 'music_singers';
    }
    
    /**
     * Get singer_name
     * 
     * @param int $singer_id
     * @return string
     */
    public function getSingerName($singer_id)
    {
        $singer = $this->get_select('name', array('id' => $singer_id));
        
        if ($singer)
        {
            return $singer->name;
        }
        
        return FALSE;
    }
    
    /**
     * Create 
     */
    public function create($dataAll, $check_field = FALSE)
    {
        if (!isset($dataAll['username']) || !$dataAll['username'])
        {
            $dataAll['username'] = $this->session->userdata('user_username');
        }
        
        if (!isset($dataAll['nickname']) || !$dataAll['nickname'])
        {
            $dataAll['nickname'] = $dataAll['name'];
        }
        
        // get avatar default
        if (!isset($dataAll['avatar']) || !$dataAll['avatar'])
        {
            $dataAll['avatar'] = 'avatar_default_singer.jpg';
        }
        
        return parent::create($dataAll, $check_field);
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
        
        if (isset($dataAll['nickname']) && !$dataAll['nickname'])
        {
            $dataAll['nickname'] = $dataAll['name'];
        }
        
        // get avatar default
        if (isset($dataAll['avatar']) && !$dataAll['avatar'])
        {
            $dataAll['avatar'] = 'avatar_default_singer.jpg';
        }
        
        return parent::update($dataAll, $where, $check_field);
    }
}

?>