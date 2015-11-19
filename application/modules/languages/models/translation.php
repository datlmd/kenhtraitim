<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Model
 * Function on Translation
 * 
 * @package PenguinFW
 * @subpackage Language
 * @version 1.0.0
 */

class Translation extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        
        $this->db_table = 'translations';
    }
    
    /**
     * get all module
     * file translation
     */
    public function getModule()
    {
        return $this->find('all', array(
            'from' => 'modules',
            'select' => 'id,name',
            'limit' => 0
        ));
    }
    
    /**
     * check valid language
     * 
     * @param int $lang_id
     */
    public function getLanguage($lang_id)
    {
        $language = $this->find('first', array(
            'from' => 'languages',
            'where' => array('id' => $lang_id)
        ));
        
        if (!$language) return FALSE;
        
        return $language;
    }
}

?>