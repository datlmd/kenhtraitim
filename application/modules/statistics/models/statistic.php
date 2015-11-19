<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Model
 * Function on User
 * 
 * @package PenguinFW
 * @subpackage User
 * @version 1.0.0
 * 
 * @property User_permission $User_permission
 */

class Statistic extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        
        //$this->db_table = 'user_roles';
    }
    
}