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

class Survey extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        
        $this->db_table = 'surveys';
    }
    
    public function get_survey()
    {
        
        $CI =& get_instance();
        
        $CI->load->model('Surveys/Survey_question');
        $CI->load->model('Surveys/Survey_answer');
        
        //$COLGATE_SURVEY_ID = 4;
        
        $survey = $CI->Survey_question->find('all', array( 
            'select' => 'id, name, is_other_answer',
            'order' => array('weight' => 'ASC'),
            ));
        
        for($i = 0; $i < count($survey); $i++)
        {
            $survey[$i]['answers'] = $CI->Survey_answer->find('all', array(
                'select' => 'id, name',
                'order_by' => array('weight' => 'ASC'),
                'where' => array('survey_question_id' => $survey[$i]['id'])));
        }
        
        return $survey;
    }
    
    public function insert($inputs, $check_right = FALSE, $check_field = FALSE, $check_sso = TRUE) {
        
        if($check_sso)
        {
            //check login
            if(!isset($_SESSION['user']) && empty($_SESSION['user']))
            {
                echo  0;die;
            }
                else
                {
                    $username = $_SESSION['user']['username'];
                    $user_id = user_id($username);
                }
       
        }
        else
        {
            $username = "anomynus";
            $user_id = 1;
        }
       
            
        //check user submited
       $options = array(
           'where' => array("user_id" => $user_id), 
       );
       $result = $this->Survey->find("first", $options);
  
       $is_submited = $result ? TRUE : FALSE;
           
            
        if(isset($inputs[0]["survey_answer_id"]))
        {     
            foreach ($inputs as $input)
            {
                
                $input['user_ip'] = $this->input->ip_address();
                $input['username'] = $username;
                $input['user_id'] = $user_id;
                
                //check right
                if($check_right && isset($input['survey_answer_id']))
                {
                    $options['select'] = "is_right";
                    $options["where"] = array("id" => $input['survey_answer_id']);
                    $result = $this->Survey_answer->find("first_array", $options);
                    
                    $input['is_right'] = $result['is_right'];
                    
                }
                else
                {
                    $input['is_right'] = 1;
                }
                
                if($is_submited)
                {
                    
                    $this->Survey->update($input, array("user_id" => $user_id ,"survey_question_id" => $input['survey_question_id']), $check_field);
                }
                else
                {
                     $this->Survey->create($input, $check_field);
                }              
                
            }
                                
        }
        

 
    }
}

?>