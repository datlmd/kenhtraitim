<?php

if(!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Model
 * Function on Statistic_permission
 * 
 * @package PenguinFW
 * @subpackage statistics
 * @version 1.0.0
 */
class Statistic_permission extends MY_Model {

    function __construct()
    {
        parent::__construct();

        $this->db_table = 'statistic_permissions';
    }

    public function updatePermission($campaign_id, $data)
    {
        // delete all current permission
        if($this->deletePermission($campaign_id))
        {
            // insert new permission
            $main_data = $data['permission'];

            // get data read/write/modify/publish/delete
            foreach($main_data as $user_id => $value)
            {
                $data_insert = array(
                    'account_id' => $user_id,
                    'campaign_id' => $campaign_id,
                    'permission' => $value,
                );

                $this->create($data_insert);
            }

            return TRUE;
        }

        return FALSE;
    }

    public function deletePermission($campaign_id)
    {
        if($campaign_id > 0)
        {
            $this->deleteRecord(array('campaign_id' => $campaign_id));
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Get current permission group by resource id
     * @param int $role_id
     * @return array(resource_id => array(read, write, modify, publish, delete))
     */
    public function getPermissions($campaign_id)
    {
        // get role permission
        $role_permissions = $this->get(array('campaign_id' => $campaign_id), NULL, FALSE, 0);

        // check role permission exit
        if(!$role_permissions)
        {
            return FALSE;
        }

        /**
         * add role permission to array
         * 
         * array(resource_id => array(read, write, modify, publish, delete))
         */
        $result_permissions = array();

        foreach($role_permissions as $role_permission)
        {
            $result_permissions[$role_permission['account_id']] = array(
                'permission' => $role_permission['permission'],
            );
        }

        // return data
        return $result_permissions;
    }

    public function check_permission($access_campaign)
    {
//         $user_id = isset($_SESSION['user']['user_id']) ? $_SESSION['user']['user_id'] : NULL;
        $user_id = $this->session->userdata('user_id');

        if($user_id == NULL)
            return FALSE;

        $camp_ids = $this->get_permited_camp_ids($user_id);

        if($camp_ids == NULL)
            return FALSE;

        if(in_array($access_campaign, $camp_ids))
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function get_permited_camp_ids()
    {
//        $user_id = isset($_SESSION['user']['user_id']) ? $_SESSION['user']['user_id'] : NULL;
        $user_id = $this->session->userdata('user_id');

        if($user_id == NULL)
            return NULL;

        $ids = $this->find('all', array('select' => 'campaign_id', 'where' => array('account_id' => $user_id, 'permission' => 1)));


        return get_sub_array_by_keys($ids, 'campaign_id');
    }

    public function get_permission_campaign($campaign_id)
    {
        //get user
        $accounts = $this->find('all', array(
            'from' => 'users a', 
//            'where' => 'b.campaign_id ='. $campaign_id,
            'select' => 'a.id, a.username, b.permission',
            'leftjoin' => array('statistic_permissions b' => 'a.id = b.account_id')));

        return $accounts;
    }

}

?>