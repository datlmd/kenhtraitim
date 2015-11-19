<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Model
 * Function on Music_author
 * 
 * @package PenguinFW
 * @subpackage Music
 * @version 1.0.0
 */

class Music_author extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        
        $this->db_table = 'music_authors';
    }
    
    /**
     * Get author name
     * 
     * @param int $author_id
     * @return string
     */
    public function getAuthorName($author_id)
    {
        $author = $this->get_select('name', array('id' => $author_id));
        
        if ($author)
        {
            return $author->name;
        }
        
        return FALSE;
    }
    
    /**
     * Created 
     */
    public function create($dataAll, $check_field = FALSE)
    {
        // get avatar default
        if (!isset($dataAll['avatar']) || !$dataAll['avatar'])
        {
            $dataAll['avatar'] = 'avatar_default_author.jpg';
        }
        
        parent::create($dataAll, $check_field);
    }
    
    /**
     * Update 
     */
    public function update($dataAll, $where, $check_field = FALSE)
    {
        // get avatar default
        if (isset($dataAll['avatar']) && !$dataAll['avatar'])
        {
            $dataAll['avatar'] = 'avatar_default_author.jpg';
        }
        
        parent::update($dataAll, $where, $check_field);
    }
}

?>