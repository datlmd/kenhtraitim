<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Model
 * Function on Music_report_type
 * 
 * @package PenguinFW
 * @subpackage Module
 * @version 1.0.0
 */

class Music_report_type extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        
        $this->db_table = 'music_report_types';
    }
    
    /**
     * Create
     */
    public function create($dataAll, $check_field = FALSE)
    {
        if (isset($dataAll['slug']) && $dataAll['slug'])
        {
            $dataAll['slug'] = make_slug($dataAll['slug']);
        } else 
        {
            $dataAll['slug'] = make_slug($dataAll['name']);
        }
        
        parent::create($dataAll, $check_field);
    }
    
    /**
     * update
     */
    public function update($dataAll, $where, $check_field = FALSE)
    {
        if (isset($dataAll['slug']) && $dataAll['slug'])
        {
            $dataAll['slug'] = make_slug($dataAll['slug']);
        } else 
        {
            $dataAll['slug'] = make_slug($dataAll['name']);
        }
        
        parent::update($dataAll, $where, $check_field);
    }            
}

?>