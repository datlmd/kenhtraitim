<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Model
 * Function on Module
 * 
 * @package PenguinFW
 * @subpackage Module
 * @version 1.0.0
 */

class Module extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        
        $this->db_table = 'modules';
    }
}

?>