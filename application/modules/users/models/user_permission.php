<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Model
 * Function on User_permission
 * 
 * @package PenguinFW
 * @subpackage User
 * @version 1.0.0
 */

class User_permission extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        
        $this->db_table = 'user_permissions';
    }
    
    /**
     * List all Module and Module_resource
     * 
     * @return array
     */
    public function getModuleAndResource()
    {
        // get all Module
        $modules = $this->find('all', array(
            'select' => 'id, name',
            'from' => 'modules',
            'order' => array('name' => 'asc'),
            'limit' => 0
        ));
        
        // get all Module_resource
        // list Module_resource group by Module
        $resource_permissions = array();        
        $i = 0;
        foreach ($modules as $module)
        {
            // get Module_resource of Module
            $resources = $this->find('all', array(
                'select' => 'id, name',
                'from' => 'module_resources',
                'where' => array(
                    'module_id' => $module['id']
                ),
                'order' => array('name' => 'asc'),
                'limit' => 0
            ));
            
            // add array result
            $resource_permissions[$i]['module'] = $module['name'];
            $resource_permissions[$i]['resources'] = $resources;
            
            // add key array
            $i++;
        }                
        
        return $resource_permissions;
    }
    
    /**
     * Get current permission group by resource id
     * @param int $role_id
     * @return array(resource_id => array(read, write, modify, publish, delete))
     */
    public function getRolePermission($role_id)
    {
        // get role permission
        $role_permissions = $this->get(array('role_id' => $role_id), NULL, FALSE, 0);
        
        // check role permission exit
        if (!$role_permissions)
        {
            return FALSE;
        }
        
        /**
         * add role permission to array
         * 
         * array(resource_id => array(read, write, modify, publish, delete))
         */
        $result_permissions = array();
        
        foreach ($role_permissions as $role_permission)
        {
            $result_permissions[$role_permission['resource_id']] = array(
                'read' => $role_permission['read'],
                'write' => $role_permission['write'],
                'modify' => $role_permission['modify'],
                'publish' => $role_permission['publish'],
                'delete' => $role_permission['delete'],
                'trash' => $role_permission['trash']
            );
        }
        
        // return data
        return $result_permissions;
    }
    
    /**
     * Delete all current permission <=> role_id
     * 
     * @param int $role_id 
     * @return boolean 
     */
    public function deletePermission($role_id)
    {
        if ($role_id > 0)
        {
            $this->deleteRecord(array('role_id' => $role_id));            
            return TRUE;
        }
        
        return FALSE;
    }
    
    /**
     *
     * @param int $role_id
     * @param array $data
     *  $data = array(
     *      'role_id' => 
     *      'read' => array(
     *          resource_id =>1|0
     *      ),
     *      'write' => array(
     *          resource_id =>1|0
     *      ),
     *      'modify' => array(
     *          resource_id =>1|0
     *      ),
     *      'publish' => array(
     *          resource_id =>1|0
     *      ),
     *      'delete' => array(
     *          resource_id =>1|0
     *      ),
     *      'trash' => array(
     *          resource_id =>1|0
     *      ),
     *  )
     * @return boolean 
     */
    public function updatePermission($role_id, $data)
    {
        // delete all current permission
        if ($this->deletePermission($role_id))
        {
            // insert new permission
            $main_data = $data['read'];
            
            // get data read/write/modify/publish/delete
            foreach ($main_data as $resource_id => $value)
            {
                $data_insert = array(
                    'role_id' => $role_id,
                    'resource_id' => $resource_id,
                    'read'      => $data['read'][$resource_id],
                    'write'     => $data['write'][$resource_id],
                    'modify'    => $data['modify'][$resource_id],
                    'publish'   => $data['publish'][$resource_id],
                    'delete'    => $data['delete'][$resource_id],
                    'trash'     => $data['trash'][$resource_id]
                );
                
                $this->create($data_insert);
            }
            
            return TRUE;
        }
        
        return FALSE;
    }
}

?>
