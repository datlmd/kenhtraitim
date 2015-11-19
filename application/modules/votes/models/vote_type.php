<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Model
 * Function on Vote_type
 * 
 * @package PenguinFW
 * @subpackage Vote_type
 * @version 1.0.0
 * 
 * @property Vote       $Vote
 */

class Vote_type extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        
        $this->db_table = 'vote_types';
    }        
    
    /**
     * get Type
     * 
     * @param int $id vote_type_id
     * @return Obj
     */
    public function getOne($id)
    {
        return $this->get(array('id' => $id));
    }
    
    /**
     * update
     */
    public function update($dataAll, $where, $check_field = FALSE)
    {
        if (empty ($dataAll['is_subtract']))
        {
            $dataAll['is_subtract'] = 0;
        }
        
        if (empty ($dataAll['is_dislike']))
        {
            $dataAll['is_dislike'] = 0;
        }
        
        if (empty ($dataAll['is_multi']))
        {
            $dataAll['is_multi'] = 0;
        }
        
        return parent::update($dataAll, $where, $check_field);
    }

    /**
     * get point
     * 
     * @param int $id
     * @return int
     */
    public function getPoint($id)
    {
        $vote_type = $this->getOne($id);
        return $vote_type->point;
    }
    
    /**
     * check is subtract
     * 
     * @param int $id vote_type_id
     * @return boolean
     */
    public function isSubtract($id)
    {
        $type = $this->get_select('is_subtract', array('id' => $id));
        
        if (!$type)
        {
            return FALSE;
        }
        
        if ($type->is_subtract == 1)
        {
            return TRUE;
        }
        
        return FALSE;
    }
    
    /**
     * check is multi vote
     * 
     * @param int $id vote_type_id
     * @return boolean 
     */
    public function isMulti($id)
    {
        $type = $this->get_select('is_multi', array('id' => $id));
        
        if (!$type)
        {
            return FALSE;
        }
        
        if ($type->is_multi == 0)
        {
            return FALSE;
        }
        
        return TRUE;
    }        
    
    /**
     * Check next time vote for record
     * 
     * @param int $id vote_type_id
     * @param int $user_id
     * @param int $resource_id
     * @param int $record_id
     * @return boolean
     */
    public function checkTimeMinutes($id, $user_id, $resource_id, $record_id)
    {
        // get type
        $type = $this->getOne($id);
        
        if (!$type)
        {
            return FALSE;
        }                
        
        // get vote
        $this->load->model('Vote');
        $vote = $this->Vote->getOneFromUserResource($id, $user_id, $resource_id, $record_id);
        
        // user not yet vote
        if (!$vote)
        {
            return TRUE;
        }
        
        if (date('Y-m-d H:i:s') > add_time($vote->created, ($type->time_minutes*60)))
        {
            return TRUE;
        }
        
        return FALSE;
    }
    
    /**
     * Check next time vote for day
     * 
     * @param int $id vote_type_id
     * @param int $user_id
     * @param int $resource_id
     * @param int $record_id
     * @return boolean
     */
    public function check_vote_today($id, $user_id, $resource_id, $record_id)
    {
        // get type
        $type = $this->getOne($id);
        
        if (!$type)
        {
            return FALSE;
        }                
        
        // get vote
        $this->load->model('Vote');
        $vote = $this->Vote->getOneFromUserResource($id, $user_id, $resource_id, $record_id);
        
        // user not yet vote
        if (!$vote)
        {
            return TRUE;
        }
        
        if (date('Y-m-d') == date('Y-m-d', $vote->created))
        {
            return TRUE;
        }
        
        return FALSE;
    }
    
    /**
     * Check next time vote
     * 
     * @param int $id vote_type_id
     * @param int $user_id
     * @return boolean
     */
    public function checkTimeSecondUser($id, $user_id)
    {
        // get type
        $type = $this->getOne($id);
        
        if (!$type)
        {
            return FALSE;
        }                
        
        // get vote
        $this->load->model('Vote');
        $vote = $this->Vote->getOneFromUser($id, $user_id);
        
        // user not yet vote
        if (!$vote)
        {
            return TRUE;
        }
        
        if (date('Y-m-d H:i:s') > add_time($vote->created, $type->time_second_user))
        {
            return TRUE;
        }
        
        return FALSE;
    }
    
    /**
     * get and check cookie brower
     * 
     * @param string $cookie_name
     * @param int $record_id
     * @return boolean 
     */
    public function checkTimeSecondBrowser($cookie_name, $record_id)
    {
        if (get_cookie($cookie_name) == $record_id)
        {
            return FALSE;
        }
        
        return TRUE;
    }
    
    /**
     * set cookie when user vote
     * 
     * @param int $id vote_type_id
     * @param int $resource_id
     * @param int $record_id
     * @return boolean 
     */
    public function setCookieTimeSecondBrower($id, $resource_id, $record_id)
    {
        // get type
        $type = $this->getOne($id);
        
        if (!$type)
        {
            return FALSE;
        }
        
        // get cookie name
        $cookie_name = $this->getCookieName($id, $resource_id);
        
        // set cookie
        set_cookie(array(
            'name' => $cookie_name,
            'value' => $record_id,
            'expire' => $type->time_second_browser,
            'path' => '/'
        ));
        
        return TRUE;
    }
    
    /**
     * generate cookie name
     * 
     * @param int $id vote_type_id     
     * @param int $resource_id
     * @return string
     */
    public function getCookieName($id, $resource_id)
    {
        $data = $id.$resource_id;
        return 'SYSTEM' . $data;
    }
    
    /**
     * Check time post for ip
     * 
     * @param int $id vote type id
     * @param int $resource_id
     * @param int $record_id
     * @param string $ip
     * @return boolean 
     */
    public function checkTimeSecondIp($id, $resource_id, $record_id, $ip)
    {
        // get type
        $type = $this->getOne($id);
        
        if (!$type)
        {
            return FALSE;
        }
        
        // get vote
        $this->load->model('Vote');
        $vote = $this->Vote->getOneFromUserResource($id, NULL, $resource_id, $record_id, $ip);
        
        if (!$vote)
        {
            return TRUE;
        }
        
        if (date('Y-m-d H:i:s') > add_time($vote->created, $type->time_second_ip))
        {
            return TRUE;
        }
        
        return FALSE;
    }
    
    /**
     * check is dislike
     * 
     * @param int $id
     * @return boolean
     */
    public function isDislike($id)
    {
        // get type
        $type = $this->getOne($id);
        
        if (!$type)
        {
            return FALSE;
        }
        
        if ($type->is_dislike == 1)
        {
            return TRUE;
        }
        
        return FALSE;
    }
}

?>