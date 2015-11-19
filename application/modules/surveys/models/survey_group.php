<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author tungcn <cntung2187@gmail.com> 0909898592
 * @copyright Chung Nhut Tung 2011
 * 
 * Model
 * Function on Survey
 * 
 * @package PenguinFW
 * @subpackage Survey
 * @version 1.0.0
 */

class Survey_group extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        
        $this->db_table = 'survey_groups';
    }
}

?>