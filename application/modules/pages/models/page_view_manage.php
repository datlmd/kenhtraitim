<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Model
 * Function on Page_view_manage
 * 
 * @package PenguinFW
 * @subpackage pages 
 * @version 1.0.0
 */

class Page_view_manage extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        
        $this->db_table = 'page_view_manages';
    }
}

?>