<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Model
 * Function on Module_field
 * 
 * @package PenguinFW
 * @subpackage Module_field
 * @version 1.0.0
 */

class Module_field extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        
        $this->db_table = 'module_fields';
    }
    
    /**
     * Create
     */
    public function create($dataAll, $check_field = FALSE)
    {
        $dataAll['name'] = 'pg_' . $dataAll['name'];
        
        return parent::create($dataAll, $check_field);
    }
}

?>