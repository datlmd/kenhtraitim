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

class Survey_question extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        
        $this->db_table = 'survey_questions';
    }
    
    public function deletion_update($id)
    {
        //delete in survey questions
        $sql = "DELETE FROM survey_questions
                WHERE id=$id";
        
        $this->db->query($sql);
            
        //delete in survey answers
        $sql = "DELETE FROM survey_answers
                WHERE survey_question_id=$id";
        
        $this->db->query($sql);
        
        //delete in surveys
        $sql = "DELETE FROM surveys
                WHERE survey_question_id=$id";
        
        $this->db->query($sql);
        
        
    }
    
}


?>