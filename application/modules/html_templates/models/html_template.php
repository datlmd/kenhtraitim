<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Model
 * Function on Html_template
 * 
 * @package PenguinFW
 * @subpackage Html_template
 * @version 1.0.0
 */

class Html_template extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        
        $this->db_table = 'html_templates';
    }
    
    /**
     * remove default current template
     * 
     * @param string $name
     * @param int $resource_id 
     * @param string $ext
     */
    public function removeDefault($name, $resource_id = 0, $ext = 'tpl')
    {
        $this->update(array('is_default' => 0), array('name' => $name, 'ext' => $ext, 'resource_id' => $resource_id, 'is_default' => 1));
    }
    
    /**
     * get all version template
     * 
     * @param string $name
     * @param int $resource_id
     * @param string $ext
     * @return array 
     */
    public function getOldTemplate($name, $resource_id = 0, $ext = 'tpl')
    {
        return $this->get(array('name' => $name, 'ext' => $ext, 'resource_id' => $resource_id, 'is_default' => 0), 'id DESC', FALSE);
    }
}

?>