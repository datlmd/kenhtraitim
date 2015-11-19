<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author tungcn <cntung2187@gmail.com> 0909898592
 * @copyright Chung Nhut Tung 2011
 * 
 * Model
 * Function on Photo
 * 
 * @package PenguinFW
 * @subpackage Photo
 * @version 1.0.0
 */

class Photo_album extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        
        $this->db_table = 'photo_albums';
    }
}

?>