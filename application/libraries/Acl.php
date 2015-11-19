<?php

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Zend ACL and Codeigniter
 * 
 * @package PenguinFW
 * @subpackage ACL
 * @version 1.0.0
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Acl
{
    function __construct()
    {         
        $CI = &get_instance();
        
        $CI->load->library('zend', 'Zend/Acl');
        $this->acl = new Zend_Acl();

        $CI->db->order_by('parent_id', 'ASC'); //Get the roles
        $query = $CI->db->get('user_roles');
        $roles = $query->result();

        $CI->db->order_by('parent_id', 'ASC'); //Get the resources
        $query = $CI->db->get('module_resources');
        $resources = $query->result();

        $query = $CI->db->get('user_permissions'); //Get the permissions
        $permissions = $query->result();

        foreach ($roles as $roles) { //Add the roles to the ACL
            $role = new Zend_Acl_Role($roles->id);
            $roles->parent_id != null ?
                    $this->acl->addRole($role, $roles->parent_id) :
                    $this->acl->addRole($role);
        }

        foreach ($resources as $resources) { //Add the resources to the ACL
            $resource = new Zend_Acl_Resource($resources->id);
            $resources->parent_id != null ?
                    $this->acl->add($resource, $resources->parent_id) :
                    $this->acl->add($resource);
        }

        foreach ($permissions as $perms) { //Add the permissions to the ACL
            $perms->read == '1' ?
                    $this->acl->allow($perms->role_id, $perms->resource_id, 'read') :
                    $this->acl->deny($perms->role_id, $perms->resource_id, 'read');
            $perms->write == '1' ?
                    $this->acl->allow($perms->role_id, $perms->resource_id, 'write') :
                    $this->acl->deny($perms->role_id, $perms->resource_id, 'write');
            $perms->modify == '1' ?
                    $this->acl->allow($perms->role_id, $perms->resource_id, 'modify') :
                    $this->acl->deny($perms->role_id, $perms->resource_id, 'modify');
            $perms->publish == '1' ?
                    $this->acl->allow($perms->role_id, $perms->resource_id, 'publish') :
                    $this->acl->deny($perms->role_id, $perms->resource_id, 'publish');            
            $perms->delete == '1' ?
                    $this->acl->allow($perms->role_id, $perms->resource_id, 'delete') :
                    $this->acl->deny($perms->role_id, $perms->resource_id, 'delete');
            $perms->trash == '1' ?
                    $this->acl->allow($perms->role_id, $perms->resource_id, 'trash') :
                    $this->acl->deny($perms->role_id, $perms->resource_id, 'trash');
        }
        $this->acl->allow(ConstUserRole::administrator); //Change this to whatever id your adminstrators group is
    }

    /*
     * Methods to query the ACL.
     */

    function is_read($role, $resource)
    {
        return $this->acl->isAllowed($role, $resource, 'read') ? TRUE : FALSE;
    }

    function is_write($role, $resource)
    {
        return $this->acl->isAllowed($role, $resource, 'write') ? TRUE : FALSE;
    }

    function is_modify($role, $resource)
    {
        return $this->acl->isAllowed($role, $resource, 'modify') ? TRUE : FALSE;
    }
    
    function is_publish($role, $resource)
    {
        return $this->acl->isAllowed($role, $resource, 'publish') ? TRUE : FALSE;
    }

    function is_delete($role, $resource)
    {
        return $this->acl->isAllowed($role, $resource, 'delete') ? TRUE : FALSE;
    }
    
    function is_trash($role, $resource)
    {
        return $this->acl->isAllowed($role, $resource, 'delete') ? TRUE : FALSE;
    }
}

?>
