<?php

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Model
 * Penguin custom
 * 
 * @package PenguinFW
 * @subpackage Core
 * @version 1.0.0
 * 
 * @property CI_Loader $load
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property CI_Email $email
 * @property CI_DB_active_record $db
 * @property CI_DB_forge $dbforge
 * @property CI_Table $table
 * @property CI_Session $session
 */
class MY_Model extends CI_Model {
    // main table on database
    protected $db_table = '';
    // require field
    protected $required_fields = array();
    // config cache
    protected $db_cache = FALSE;
    // config query pagination
    protected $paginator = array('limit' => 20);
    // count all query
    protected $count_record;

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Setter/Getters for the table prop
     * @param String $table
     */
    public function setTable($table)
    {
        $this->db_table = $table;
    }

    public function getTable()
    {
        return $this->db_table;
    }

    public function setCache($is_cache)
    {
        $this->db_cache = $is_cache;
    }

    /**
     * _required method returns false if the $data array does not contain all of the keys assigned by the $required array.
     *
     * @param array $required
     * @param array $data
     * @return bool
     */
    private function _required($required, $data)
    {
        foreach($required as $field)
        {
            if(!isset($data[$field]))
            {
                return FALSE;
            }
        }
        return TRUE;
    }
    
    /**
     * Pagination
     * 
     * @param int $segment
     * @return array
     */
    public function pagination($segment = 5, $force_offset = FALSE)
    {
        if(is_router($this->router->class, FALSE))
        {
            $segment++;
        }

        if($this->config->item('enable_named_strings') === TRUE)
        {
            $offset = $this->input->named('page');
        }
        else
        {
            $offset = $this->uri->segment($segment);
        }

        //edit by danhdvd
        if($force_offset !== FALSE)
        {

            $offset = (int) $force_offset;
        }

        // get option query
        $options = $this->paginator;

        // check offset
        if(!is_numeric($offset))
        {
            $offset = '';
        }

        // set limit
        if(!(isset($options['limit']) && $options['limit']))
        {
            $options['limit'] = 20;
        }

        // set offset
        $options['offset'] = $offset;

        // get result
        $result = $this->find('all', $options);

        // get total count            
        $this->count_record = $this->find('count', $options);

        return $result;
    }
    
    /**
     * Get link pagination 
     * 
     * @param string $uri
     * @return string 
     */
    public function getPaginationLink($uri, $segment = 5, $extra_params = '')
    {
        $check_uri = is_router($uri);
        if(!empty($check_uri))
        {
            $uri = $check_uri;
            $segment++;
        }

        if(isset($this->paginator['limit']) && $this->paginator['limit'])
        {
            $limit = $this->paginator['limit'];
        }
        else
        {
            $limit = 20;
        }

        return pagination_config($uri, $this->count_record, $limit, $segment, $open_tag = '', $close_tag = '', $extra_params);
    }
    

    /**
     * get list table
     *      
     * @param array $where
     * @param string $order_by
     * @param boolean $is_one
     * @param integer $limit
     * @param integer $offset
     * @return Object / array
     */
    public function get($where = NULL, $order_by = NULL, $is_one = TRUE, $limit = 20, $offset = '')
    {
        $this->db->select('*');
        $this->db->from($this->db_table);

        // set where in query
        if(is_array($where))
        {
            $this->db->where($where);
        }

        // set order
        if($order_by)
        {
            $this->db->order_by($order_by);
        }

        // set limit if query multi array
        if($is_one == FALSE && is_numeric($limit) && $limit > 0)
        {
            if($offset)
            {
                $this->db->limit($limit, $offset);
            }
            else
            {
                $this->db->limit($limit);
            }
        }

        // query in cache or no cache
        $query = $this->db_get_cache();

        // not record
        if($query->num_rows() == 0)
        {
            return FALSE;
        }

        // get one record
        if($is_one == TRUE)
        {
            return $query->row();
        }

        // all record
        return $query->result_array();
    }

    /**
     * Get list data width select
     * 
     * @param string $select
     * @param array $where
     * @param string $order_by
     * @param boolean $is_one
     * @param integer $limit
     * @return Object / array
     */
    public function get_select($select, $where = NULL, $order_by = NULL, $is_one = TRUE, $limit = 20)
    {
        $this->db->select($select);
        $this->db->from($this->db_table);

        // get where in query
        if($where)
        {
            $this->db->where($where);
        }

        // get order by
        if($order_by)
        {
            $this->db->order_by($order_by);
        }

        // get limit
        if($is_one == FALSE && is_numeric($limit) && $limit > 0)
        {
            if(!empty($offset))
            {
                $this->db->limit($limit, $offset);
            }
            else
            {
                $this->db->limit($limit);
            }
        }

        // query in cache or no cache
        $query = $this->db_get_cache();

        if($query->num_rows() == 0)
        {
            return FALSE;
        }

        // get one record
        if($is_one == TRUE)
        {
            return $query->row();
        }

        // get all record
        return $query->result_array();
    }

    /**
     * create record
     *      
     * @param array $data
     * @param boolean $check_field
     * @return int
     */
    public function create($dataAll, $check_field = FALSE)
    {
        // Kiem tra xem cho can check field hay khong
        if($check_field == TRUE)
        {
            $data = $this->getFormDataField($dataAll);
        }
        else
        {
            $data = $dataAll;
        }

        // check empty data
        if(empty($data))
        {
            return FALSE;
        }

        // check field require
        if(!$this->_required($this->required_fields, $data))
        {
            return FALSE;
        }

        $this->load->helper('date');

        // field default: created / modified / user_id
        $data['created'] = mdate('%Y-%m-%d %H:%i:%s', now());
        $data['modified'] = mdate('%Y-%m-%d %H:%i:%s', now());

        if(empty($data['user_id']) || $data['user_id'] < 0)
        {
            $data['user_id'] = $this->session->userdata('user_id');
        }

        // log user insert db
        if(config_item('system_log_database') >= ConstGlobal::log_insert)
        {
            write_log_file(
                    "insert_database__{$this->session->userdata('user_username')}", "User: {$this->session->userdata('user_username')}, ip: {$this->input->ip_address()}, Table: {$this->db_table}, Data: " . json_encode($data)
            );
        }

        // insert record
        if($this->db->insert($this->db_table, $data))
        {
            // get id
            $id = $this->db->insert_id();
            $name = isset($data['name']) ? ',' . $data['name'] : '';

            //log db
            if(ConstUser::flag_write_db_log_insert === 1)
            {
                $this->load->model('Users/User_log');

                $data_log = array(
                    'user_action' => "insert table '$this->db_table' record '$id $name'",
                );

                $this->User_log->create($data_log, FALSE);
            }
            
            // get id
            return $id;
        }

        return FALSE;
    }

    /**
     * Update record
     *      
     * @param array $data
     * @param array $where 
     * @param boolean $check_field
     */
    public function update($dataAll, $where, $check_field = FALSE)
    {
        // Kiem tra xem cho can check field hay khong
        if($check_field == TRUE)
        {
            $data = $this->getFormDataField($dataAll);
        }
        else
        {
            $data = $dataAll;
        }

        // check empty data
        if(empty($data))
        {
            return FALSE;
        }

        // check update record
        if(!$this->_required($this->required_fields, $data))
        {
            return FALSE;
        }

        $this->load->helper('date');

        // update date modified
        $data['modified'] = mdate('%Y-%m-%d %H:%i:%s', now());

        // update data
        $this->db->where($where);
        $this->db->update($this->db_table, $data);

        // log user update db
        if(config_item('system_log_database') >= ConstGlobal::log_update)
        {
            write_log_file(
                    "update_database__{$this->session->userdata('user_username')}", "User: {$this->session->userdata('user_username')}, ip: {$this->input->ip_address()}, Table: {$this->db_table}, Where: " . json_encode($where) . ", Data: " . json_encode($data)
            );
        }
        
        // get id
        $id = $where;
        $name = isset($data['name']) ? ',' . $data['name'] : '';

        //log db
        if(ConstUser::flag_write_db_log_update === 1)
        {
            $this->load->model('Users/User_log');

            $data_log = array(
                'user_action' => "update table '$this->db_table' record '$id $name'",
            );

            $this->User_log->create($data_log, FALSE);
        }

        return TRUE;
    }

    /**
     * Update record is delete
     *      
     * @param array $where 
     * @param boolean $is_restore
     */
    public function delete($where, $is_restore = FALSE)
    {
        $this->load->helper('date');

        // error params
        if(empty($where))
        {
            return FALSE;
        }

        // update date delete and hidden record
        // is restore
        if($is_restore == TRUE)
        {
            $data = array(
                'modified' => mdate('%Y-%m-%d %H:%i:%s', now()),
                'is_delete' => 0
            );
        }
        else // is delete 
        {
            $data = array(
                'modified' => mdate('%Y-%m-%d %H:%i:%s', now()),
                'is_delete' => 1
            );
        }

        $this->db->where($where);
        $this->db->update($this->db_table, $data);

        // log user delete db
        if(config_item('system_log_database') >= ConstGlobal::log_delete)
        {
            write_log_file(
                    "update_delete_database__{$this->session->userdata('user_username')}", "User: {$this->session->userdata('user_username')}, ip: {$this->input->ip_address()}, Table: {$this->db_table}, Data: " . json_encode($data)
            );
        }
        
        // get id
        $id = $where;
        $name = isset($data['name']) ? ',' . $data['name'] : '';

        //log db
        if(ConstUser::flag_write_db_log_delete === 1)
        {
            $this->load->model('Users/User_log');

            $data_log = array(
                'user_action' => "delete table '$this->db_table' record '$id $name'",
            );

            $this->User_log->create($data_log, FALSE);
        }

        return TRUE;
    }

    /**
     * Delete record on database
     *      
     * @param array $where 
     */
    public function deleteRecord($where)
    {
        // error params
        if(empty($where))
        {
            return FALSE;
        }

        $this->db->where($where);
        $this->db->delete($this->db_table, $where);

        // log user delete db
        if(config_item('system_log_database') >= ConstGlobal::log_delete)
        {
            write_log_file(
                    "delete_database__{$this->session->userdata('user_username')}", "User: {$this->session->userdata('user_username')}, ip: {$this->input->ip_address()}, Table: {$this->db_table}, Data: " . json_encode($where)
            );
        }
        
        // get id
        $id = $where;
        $name = isset($data['name']) ? ',' . $data['name'] : '';

        //log db
        if(ConstUser::flag_write_db_log_delete === 1)
        {
            $this->load->model('Users/User_log');

            $data_log = array(
                'user_action' => "delete table '$this->db_table' record '$id $name'",
            );

            $this->User_log->create($data_log, FALSE);
        }

        return TRUE;
    }

    /**
     * query cache on PG
     * 
     * @return object query_obj
     */
    public function db_get_cache()
    {
        if($this->db_cache == FALSE)
        {
            $data = $this->db->get();
        }
        else
        {
            $this->db->cache_on();
            $data = $this->db->get();
            $this->db->cache_off();
        }

        return $data;
    }

    /**
     * Logs an error
     * 
     * @param String $level
     * @param String $msg
     */
    protected function log($level, $msg)
    {
        log_message($level, __CLASS__ . '->' . __METHOD__ . ' :: ' . $msg . ' | In: ' . __FILE__ . ' Line: ' . __LINE__);
    }

    /**
     * Checks if certain field in any row has a certain value.
     * Its used to have a unique data like username, email etc.
     * 
     * @param String $field Name of the field in the table to check the data in
     * @param String $value The value to check if exists in that field
     * @return Bool TRUE if this data exists, FALSE if unique
     */
    public function is_duplicate($fieldName, $value)
    {
        if(empty($fieldName) OR empty($value))
        {
            return FALSE;
        }
        else
        {
            $this->db->select($fieldName);
            $query = $this->db->get_where($this->db_table, array($fieldName => $value));
            if($query->num_rows > 0)
            {
                return TRUE;
            }
            else
            {
                return FALSE;
            }
        }
        return FALSE;
    }

    /**
     * Query about conditions
     * 
     * @param string $type 'first', 'all', 'count'
     * @param array $options
     *  'select' => string,
     *  'join' => array(),
     *  'leftjoin' => array(),
     *  'rightjoin' => array(),
     *  'from' => string,
     *  'where' => array(),
     *  'wherefalse' => string,
     *  'or' => array(),
     *  'where_in' => array(),
     *  'where_not_in' => array(),
     *  'like' => array(),
     *  'groupby' => array(),
     *  'having' => array(),
     *  'order' => array(),
     *  'limit' => int,
     *  'offset' => int
     * @return array
     */
    public function find($type = 'all', $options = array())
    {
        // get select -> query
        if(isset($options['select']) && $options['select'])
        {
            $this->db->select($options['select']);
        }
        else
        {
            $this->db->select('*');
        }

        // get table join
        // inner join
        if(isset($options['join']) && !empty($options['join']))
        {
            foreach($options['join'] as $table => $cond)
            {
                $this->db->join($table, $cond);
            }
        }

        // left join
        if(isset($options['leftjoin']) && !empty($options['leftjoin']))
        {
            foreach($options['leftjoin'] as $table => $cond)
            {
                $this->db->join($table, $cond, 'left');
            }
        }

        // right join
        if(isset($options['rightjoin']) && !empty($options['rightjoin']))
        {
            foreach($options['rightjoin'] as $table => $cond)
            {
                $this->db->join($table, $cond, 'right');
            }
        }

        // from table
        if(isset($options['from']) && $options['from'])
        {
            $this->db->from($options['from']);
        }
        else
        {
            $this->db->from($this->db_table);
        }

        // where
        if(isset($options['where']) && !empty($options['where']))
        {
            $this->db->where($options['where']);
        }

        //where wild
        if(isset($options['where_wild']) && !empty($options['where_wild']))
        {
            foreach($options['where_wild'] as $key => $opt)
            {
                $this->db->where($key, $opt, FALSE);
            }
        }

        // wherefalse
        if(!empty($options['wherefalse']))
        {
            $wherefalses = $options['wherefalse'];
            foreach($wherefalses as $key_wherefalse => $value_wherefalse)
            {
                $this->db->where($key_wherefalse, $value_wherefalse, FALSE);
            }
        }

        // or
        if(!empty($options['or']))
        {
            $this->db->or_where($options['or']);
        }

        // where in
        if(isset($options['where_in']) && !empty($options['where_in']))
        {
            foreach($options['where_in'] as $key => $key_value)
            {
                $this->db->where_in($key, $key_value);
            }
        }

        // where not in
        if(isset($options['where_not_in']) && !empty($options['where_not_in']))
        {
            foreach($options['where_not_in'] as $key => $key_value)
            {
                $this->db->where_not_in($key, $key_value);
            }
        }

        // where like
        if(isset($options['like']) && !empty($options['like']))
        {
            foreach($options['like'] as $key => $key_value)
            {
                // where put wildcard
                if(is_array($key_value))
                {
                    $this->db->like($key, $key_value[0], $key_value[1]);
                }
                else
                {
                    $this->db->like($key, $key_value);
                }
            }
        }

        // count all result query
        if($type == 'count')
        {
            if(!empty($options['count_all']))
            {
                $this->db->select($options['count_all'] . ' AS count_all');
                $query = $this->db->get();
                if(isset($query->row()->count_all))
                    return $query->row()->count_all;
                else
                    return 0;
            } else
            {

                return $this->db->count_all_results();
                // return $this->db->
            }
        }

        // group by
        if(isset($options['groupby']) && !empty($options['groupby']))
        {
            $this->db->group_by($options['groupby']);
        }

        // having
        if(isset($options['having']) && !empty($options['having']))
        {
            $this->db->having($options['having']);
        }

        // order
        if(isset($options['order']) && !empty($options['order']))
        {
            foreach($options['order'] as $field_order => $type_order)
            {
                $this->db->order_by($field_order, $type_order);
            }
        }

//        else
//        {
//            //default order by created
//            $this->db->order_by('id', 'DESC');
//        }
        // limit
        if(isset($options['limit']) && $options['limit'])
        {
            if(isset($options['offset']) && $options['offset'])
            {
                $this->db->limit($options['limit'], $options['offset']);
            }
            else
            {
                $this->db->limit($options['limit']);
            }
        }

        // query
        $query = $this->db->get();

        // get result
        if($query->num_rows() == 0)
        {
            return array();
        }

        switch($type)
        {
            case 'first':
                return $query->row();
                break;

            case 'first_array':
                return $query->row_array();
                break;

            case 'list':
                return $this->changAllToList($query->result_array());
                break;

            case 'all':
                return $query->result_array();
                break;

            default:
                return array();
                break;
        }
    }

    /**
     * Query db
     * 
     * @param string $query
     * @param boolean $no_result
     * @return array 
     */
    public function query($query, $no_result = FALSE)
    {
        $result = $this->db->query($query);

        if($no_result == TRUE)
        {
            return TRUE;
        }

        if($result->num_rows() == 0)
        {
            return FALSE;
        }

        // log user query db
        if(config_item('system_log_database') >= ConstGlobal::log_query)
        {
            write_log_file(
                    "query_database__{$this->session->userdata('user_username')}", "User: {$this->session->userdata('user_username')}, ip: {$this->input->ip_address()}, Table: {$this->db_table}, Data: " . json_encode($query)
            );
        }

        return $result->result_array();
    }

    /**
     * Get list data
     * 
     * @param array $result_array
     * @param string $key
     * @param string $value
     * @return array [$key] => [$value] 
     */
    public function changAllToList($result_array, $key = 'id', $value = 'name')
    {
        // check result array
        if(empty($result_array))
        {
            return FALSE;
        }

        // check key and value in result array
        if(!$result_array[0][$key] && !$result_array[0][$value])
        {
            return FALSE;
        }

        // list return
        $list = array();

        // get list
        foreach($result_array as $result)
        {
            $list[$result[$key]] = $result[$value];
        }

        return $list;
    }

    /**
     *
     * @param array $data Data from foem
     * @param array $resource_name resource insert
     * @param boolean $is_main
     * @return boolean | Array data in DB 
     */
    public function getFormDataField($data, $resource_name = '', $is_main = FALSE)
    {
        // get resource name
        $resource_name = ($resource_name) ? $resource_name : $this->db_table;

        // get resource
        $resource = $this->find('first', array(
            'select' => 'id, main_id',
            'from' => 'module_resources',
            'where' => array('name' => $resource_name)
                ));

        // check valid resource
        if(!$resource)
        {
            return FALSE;
        }

        // get resource id
        if($is_main == TRUE)
        {
            $resource_id = $resource->main_id;
        }
        else
        {
            $resource_id = $resource->id;
        }

        // get module field resource
        $module_fields = $this->find('list', array(
            'select' => 'id, name',
            'from' => 'module_fields',
            'where' => array('resource_id' => $resource_id)
                ));

        // check valid module field
        if(!$module_fields)
        {
            return FALSE;
        }

        $result = array();

        // check field in db
        if(is_array($data))
        {
            foreach($data as $field => $value)
            {
                // form value in module fields
                if(in_array($field, $module_fields))
                {
                    $result[$field] = $value;
                }
            }
        }

        // not value
        if(empty($result))
        {
            return FALSE;
        }

        // array value
        return $result;
    }

    /**
     * @author TungCN <cntung2187@gmail.com> 0909898592
     * @copyright Chung Nhut Tung 2011
     * 
     * get records with array type
     * @param string $select
     * @param array $where
     * @param string $order_by
     * @param boolean $is_one
     * @param integer $limit
     * @param integer $offset
     * @return array
     */
    public function get_array($select, $where = NULL, $order_by = NULL, $is_one = TRUE, $limit = 20, $offset = 0)
    {

        $this->db->select($select);
        $this->db->from($this->db_table);

        // get where in query
        if($where)
        {
            $this->db->where($where);
        }

        // get order by
        if($order_by)
        {
            $this->db->order_by($order_by);
        }

        // get limit
        if($is_one == FALSE && is_numeric($limit) && $limit > 0)
        {
            if($offset)
            {
                $this->db->limit($limit, $offset);
            }
            else
            {
                $this->db->limit($limit);
            }
        }

        // query in cache or no cache
        $query = $this->db_get_cache();

        if($query->num_rows() == 0)
        {
            return FALSE;
        }

        // get one record
        if($is_one == TRUE)
        {
            return $query->row_array();
        }

        // get all record
        return $query->result_array();
    }

    /**
     * incrementField
     * 
     * @param array $where
     * @param string $field
     * @param int $num 
     */
    public function incrementField($where, $field, $num = 1)
    {
        if(strpos($field, ';') === FALSE)
        {
            $this->db->set($field, $field . '+' . $num, FALSE);
        }
        else
        {
            $field_array = explode(';', $field);
            foreach($field_array as $field_incre)
            {
                $this->db->set($field_incre, $field_incre . '+' . $num, FALSE);
            }
        }
        $this->db->set('modified', date('Y-m-d H:i:s'));
        $this->db->where($where);
        $this->db->update($this->db_table);
    }

    /**
     * 
     * decrease value of any field
     * @param array $where
     * @param string $field
     * @param int $num
     */
    public function decrementField($where, $field, $num = 1)
    {
        $this->db->set($field, $field . '-' . $num, FALSE);
        $this->db->set('modified', date('Y-m-d H:i:s'));
        $this->db->where($where);
        $this->db->update($this->db_table);
    }

    /**
     * Returns the last query that was executed
     *
     * @access	public
     * @return	void
     */
    public function last_query()
    {
        return $this->db->last_query();
    }

    /**
     * get item and children item
     * 
     * @param array $where
     * @param int $parent_id
     * @param string $field_parent
     * @return array
     */
    private function _getTree($where = array(), $order = NULL, $parent_id = 0, $field_parent = 'parent_id')
    {
        // result
        $result = FALSE;

        // get where 
        $where[$field_parent] = $parent_id;

        // get root
        $parents = $this->get($where, $order, FALSE, 20);

        if($parents)
        {
            // get childrent
            $i = 0;

            foreach($parents as $parent)
            {
                $result[$i] = $parent;
                $childrens = $this->_getTree($where, $order, $parent['id'], $field_parent);
                if($childrens)
                {
                    $result[$i]['items'] = $childrens;
                }
                $i++;
            }
        }

        return $result;
    }

    /**
     * get item and children item
     * 
     * @param array $where
     * @param int $parent_id
     * @param string $field_parent
     * @return array
     */
    public function getTreeItems($where = array(), $order = NULL, $parent_id = 0, $field_parent = 'parent_id')
    {
        return array('items' => $this->_getTree($where, $order, $parent_id, $field_parent));
    }


    /**
     * Get list paging using jpaging
     * @param array $options
     *  'select' => string,
     *  'join' => array(),
     *  'leftjoin' => array(),
     *  'rightjoin' => array(),
     *  'from' => string,
     *  'where' => array(),
     *  'wherefalse' => string,
     *  'or' => array(),
     *  'where_in' => array(),
     *  'where_not_in' => array(),
     *  'like' => array(),
     *  'groupby' => array(),
     *  'having' => array(),
     *  'order' => array(),
     * return array(list_view, current-page, total item paging, detail_common_link)
     */
    public function list_view_using_jpaging($page = 1, $page_size = 1, $controller='', $action='', $options = array()) {

        //Record cần lấy
        $skip = ($page - 1) * $page_size;
        $options['limit'] = $page_size;
        $options['offset'] = intval($skip);
        $list_views = $this->find('all', $options);

        //Tổng số item
        $total_item = $this->find('count', $options);
        $total_page_button =  ceil((double) $total_item / $page_size);

        //detail link
        $detail_common_link = '';
        if(!empty($controller)&& !empty($action))
            $detail_common_link = base_url().$controller.'/'.$action.'/';


        $data = array(
            'list_views' => $list_views,
            'total_page_button' => $total_page_button,
            'current_page' => $page,
            'detail_common_link' => $detail_common_link
        );

        return $data;
    }

}

?>
