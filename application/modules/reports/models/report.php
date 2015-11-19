<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Model
 * Function on Report
 * 
 * @package PenguinFW
 * @subpackage reports
 * @version 1.0.0
 */

class Report extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        
        $this->db_table = 'reports';
    }
    
    /**
     * create
     */
    public function create($dataAll, $check_field = FALSE)
    {
        if (!isset($dataAll['share']) || !$dataAll['share'])
        {
            $dataAll['share'] = ConstGlobal::share;
        }
        
        $dataAll['query'] = '';
        
        return parent::create($dataAll, $check_field);
    }
}

?>