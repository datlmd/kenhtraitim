<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Model
 * Function on Page
 * 
 * @package PenguinFW
 * @subpackage Page
 * @version 1.0.0
 */

class Page extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        
        $this->db_table = 'pages';
    }
    
    /**
     * Create
     */
    public function create($dataAll, $check_field = FALSE)
    {
        if (!empty ($dataAll['slug']))
            $dataAll['slug']        = make_slug($dataAll['slug']);
        else         
            $dataAll['slug']        = make_slug($dataAll['title']);        
        
        if (empty ($dataAll['mapto_id']))
            $dataAll['mapto_id']    = make_slug ($dataAll['title']);
        
        return parent::create($dataAll, $check_field);
    }
    
    /**
     * Update
     */
    public function update($dataAll, $where, $check_field = FALSE)
    {
        if (!empty ($dataAll['slug']))        
            $dataAll['slug'] = make_slug($dataAll['slug']);
        else         
            $dataAll['slug'] = make_slug($dataAll['title']);
        
        if (empty ($dataAll['mapto_id']))
            $dataAll['mapto_id']    = make_slug ($dataAll['title']);
        
        return parent::update($dataAll, $where, $check_field);
    }
}

?>