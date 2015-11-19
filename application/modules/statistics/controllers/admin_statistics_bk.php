<?php

if(!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_comments
 * ...
 * 
 * @package PenguinFW
 * @subpackage Comment
 * @version 1.0.0
 * 
 * @property Comment $Comment
 */
class Admin_statistics extends MY_Controller {

    function __construct()
    {
        parent::__construct();

        $this->model_name = 'Statistic';

        $this->layout->set_layout('admin');

        $this->lang->load('generate', lang_web());

        $this->load->model('Statistic');
    }

    /**
     * LIST View
     * 
     * @param string $action index, restore
     * @param string $resource_name
     * @param int $cfn_id
     */
    private function _listView($action = 'index', $resource_name = 0, $cfn_id = 0)
    {
        // set javascript to view
        $this->layout->set_javascript(array(
            'jquery.ui.core.min.js',
            'jquery.ui.datepicker.min.js'
        ));

        // set css to view
        $this->layout->set_rel(array(
            'jquery.ui.base.css',
            'jquery.ui.datepicker.css'
        ));


        // get total view
//        $total_view = 

        switch($resource_name)
        {
            case 'articles':
                break;
            case 'musics':
                $sql_view = 'SELECT sum(counter_view) as view FROM musics';
                $sql_vote = 'SELECT sum(counter_vote) as vote FROM musics';
                $sql_comment = 'SELECT sum(counter_comment) as comment FROM musics';
                break;
        }
    
        $query = $this->db->query($sql_view);
        $total_view = $query->row_array();
        $total_view = $total_view['view'] ? $total_view['view'] : 0;
        
        $query = $this->db->query($sql_vote);
        $total_vote = $query->row_array();
        $total_vote = $total_vote['vote'] ? $total_view['vote'] : 0;
 
        $query = $this->db->query($sql_comment);
        $total_comment = $query->row_array();
        $total_comment = $total_comment['comment'] ? $total_view['comment'] : 0;
        
        $statistics = array(
            0 => array(
                'id' => 1,
                'name' => 'Total view',
                'value' => $total_view,
            ),
            1 => array(
                'id' => 2,
                'name' => 'Total comment',
                'value' => $total_comment,
            ),
            2 => array(
                'id' => 3,
                'name' => 'Total vote',
                'value' => $total_vote,
            ),
        );
        
        $fields = array(
            'id' => 'INT',
            'name' => 'TEXT',
            'value' => 'INT', 
        );

        // set data
        return array(
            'list_views' => $statistics,
            'cfn_id' => $cfn_id,
            'p_resource_name' => $resource_name,
            'this_resource' => $this->router->class,
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $fields,
           );
    }

    /**
     * LIST View
     * 
     * @param string $resource_name
     * @param int $cfn_id 
     */
    public function index($resource_name = '', $cfn_id = 0)
    {
        // check permission
        //$this->PG_ACL('r');

        // set title
        $this->layout->set_title(lang('Statistics manager'));

        // get list view
        $data = $this->_listView('index', $resource_name, $cfn_id);

        //total record
        $data['total_records'] = 3;

        // set template
        $this->parser->parse($this->router->class . '/index', $data);

        //set last url
        $_SESSION[URL_LAST_SESS_NAME] = full_url();
    }
    
 
}

?>