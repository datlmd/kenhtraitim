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

class User_role extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        
        $this->db_table = 'user_roles';
    }
    
    /**
     * Cp role permission
     * 
     * @param int $role_id
     * @param int $role_cp_id 
     * @return boolean
     */
    public function copyRole($role_id, $role_cp_id)
    {
        // load model User_permission
        $this->load->model('User_permission');
        
        // load cp User_permission
        $user_permission_cps = $this->User_permission->get(array('role_id' => $role_cp_id), NULL, FALSE, 0);
        
        // check exit User_permission
        if (empty ($user_permission_cps))
        {
            return FALSE;
        }
        
        // cp User_permission
        foreach ($user_permission_cps as $user_permission_cp)
        {
            $data_cp = array(
                'role_id' => $role_id,
                'resource_id' => $user_permission_cp['resource_id'],
                'read' => $user_permission_cp['read'],
                'write' => $user_permission_cp['write'],
                'modify' => $user_permission_cp['modify'],
                'delete' => $user_permission_cp['delete'],
                'publish' => $user_permission_cp['publish']
            );
            
            $this->User_permission->create($data_cp);
        }
        
        return TRUE;
    }        
}