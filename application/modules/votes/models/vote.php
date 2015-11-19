<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

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
 * @property Vote_type      $Vote_type
 */
class Vote extends MY_Model {

    function __construct() {
        parent::__construct();

        $this->db_table = 'votes';
    }

    /**
     * get data from id
     * 
     * @param int $id
     * @return array
     */
    public function getOneFromId($id) {
        return $this->get(array('id' => $id));
    }

    /**
     * get data from user and resource
     * 
     * @param int $type_id
     * @param int $user_id
     * @param int $resource_id
     * @param int $record_id
     * @param string $ip
     * @return Obj 
     */
    public function getOneFromUserResource($type_id, $user_id, $resource_id, $record_id, $ip = NULL) {
        $data = array(
            'type_id' => $type_id,
            'resource_id' => $resource_id,
            'record_id' => $record_id
        );

        if ($ip) {
            $data['user_ip'] = $ip;
        } else {
            $data['user_id'] = $user_id;
        }

        return $this->get($data, 'id desc');
    }

    /**
     * get data from user
     * 
     * @param int $type_id
     * @param int $user_id     
     * @return Obj
     */
    public function getOneFromUser($type_id, $user_id) {
        return $this->get(array(
                    'type_id' => $type_id,
                    'user_id' => $user_id
                        ), 'id desc');
    }

    /**
     * create     
     */
    public function create($dataAll, $check_field = FALSE) {
        if (!isset($dataAll['username']) || !$dataAll['username']) {
            $dataAll['username'] = $this->session->userdata('user_username');
        }

        return parent::create($dataAll, $check_field);
    }

    /**
     * update
     */
    public function update($dataAll, $where, $check_field = FALSE) {
        if (isset($dataAll['username']) && !$dataAll['username']) {
            $dataAll = $this->session->userdata('user_username');
        }

        return parent::update($dataAll, $where, $check_field);
    }

    /**
     * check voted
     * 
     * @param int $type_id
     * @param int $user_id
     * @param int $resource_id
     * @param int $record_id
     * @return boolean 
     */
    public function isVoted($type_id, $user_id, $resource_id, $record_id) {
        $vote = $this->getOneFromUserResource($type_id, $user_id, $resource_id, $record_id);

        if ($vote) {
            return $vote->id;
        }

        return FALSE;
    }

    /**
     * check user can vote
     * 
     * @param int $type_id
     * @param int $user_id
     * @param int $resource_id
     * @param int $record_id
     * @param string $ip
     * @return boolean 
     */
    public function checkVote($type_id, $user_id, $resource_id, $record_id, $ip) {

        // model
        $this->load->model('Vote_type');

        // check if multi vote
        if ($this->Vote_type->isMulti($type_id) == 2) { //1 ngay vote 1 lan
            if (!$this->Vote_type->check_vote_today($type_id, $user_id, $resource_id, $record_id)) {
                return FALSE;
            }
        } else if ($this->Vote_type->isMulti($type_id) == 1) { //1 ngay nhieu lan
            if (!$this->Vote_type->checkTimeMinutes($type_id, $user_id, $resource_id, $record_id)) {
                return FALSE;
            }
        } else { //1 ngay 1 lan
            // user is voted
            if ($this->isVoted($type_id, $user_id, $resource_id, $record_id)) {
                return FALSE;
            }
        }

        // check time vote the next record
        if (!$this->Vote_type->checkTimeSecondUser($type_id, $user_id)) {
            return FALSE;
        }

        // check time vote the next record on browser
        if (!$this->Vote_type->checkTimeSecondBrowser($this->Vote_type->getCookieName($type_id, $resource_id), $record_id)) {
            return FALSE;
        }

        // check time vote the next record on ip
        if (!$this->Vote_type->checkTimeSecondIp($type_id, $resource_id, $record_id, $ip)) {
            return FALSE;
        }

        return TRUE;
    }

    /**
     * check vote @thangtpp
     * 
     * @param int $user_id
     * @param int $record_id
     * @param string $ip
     * @param int $event_id
     * @return boolean 
     */
    public function check_vote($user_id, $record_id, $event_id, $ip) {
        // check if vote larger than view
        $this->load->model('events/Event_log');
        $get_vote = $this->Event_log->find('first', array(
            'select' => 'vote_count + vote_cheat + sms_count as total, view_count + view_cheat as view',
            'where' => array(
                'record_id' => $record_id,
                'event_id' => $event_id,
            ),
                ));

        if ($get_vote && $get_vote->view <= $get_vote->total) {
            return array('success' => '0', 'msg' => 'Bình chọn không hợp lệ!');
        }

        // model
        $this->load->model('Vote_type');
        
        //check ip
        if (strpos(config_item('ip_vote_ignore'), $ip) !== false) {

            $Vote_ip = new Vote();
            //check if already voted today
            $check_ip = $Vote_ip->find('first_array', array(
                'where' => array(
                    'record_id' => $record_id,
                    'user_ip' => $ip,
                ),
                'order' => array('id' => 'desc')
                    ));

            $span_time1 = strtotime(date('Y-m-d H:i:s'));
            $span_time2 = strtotime($check_ip['created']);
            if ($span_time1 - $span_time2 < config_item('vote_time_span') * 60) {
                return array('success' => '0', 'msg' => 'Bình chọn không hợp lệ!!');
            }
        }

        $Vote = new Vote();
        //check if already voted today
        $today = $Vote->find('first_array', array(
            'where' => array(
                'record_id' => $record_id,
                'user_id' => $user_id,
                'DATE(created)' => date('Y-m-d')
            ),
                ));

        if ($today) {
            return array('success' => '0', 'msg' => 'Hôm nay bạn đã bình chọn rồi. Quay lại vào ngày mai nhé!');
        }


        return array('success' => '1', 'msg' => 'Cảm ơn bạn đã bình chọn! Quay lại vào ngày mai để bình chọn tiếp nhé!');
    }

    /**
     * Add vote
     * 
     * @param int $user_id
     * @param int $record_id
     * @param int $point
     * @param int $type_id
     * @param int $resource_id
     * @param string $ip
     * @param string $field_update_count
     * @return type 
     * @param int $event_id
     */
    public function addVote($user_id, $record_id, $point, $type_id, $resource_id, $ip, $field_update_count = NULL, $event_id = 0) {
        $check_vote = array();
        $check_vote = $this->check_vote($user_id, $record_id, $event_id, $ip);

        if ($check_vote['success'] == '1') {
            $data_create = array(
                'record_id' => $record_id,
                'point' => $point,
                'type_id' => $type_id,
                'resource_id' => $resource_id,
                'user_ip' => $ip,
                'username' => isset($_SESSION['user']['username']) ? $_SESSION['user']['username'] : '',
                'user_id' => $user_id,
                'event_id' => $event_id,
            );

            $this->create($data_create);

            if (strpos($field_update_count, ';') === FALSE) {
                $this->addVoteCount($resource_id, $record_id, $type_id, $field_update_count);
            } else {
                $field_update_count_array = explode(';', $field_update_count);
                foreach ($field_update_count_array as $field_count) {
                    $this->addVoteCount($resource_id, $record_id, $type_id, $field_count);
                }
            }

            $this->load->model("events/Event_log");
            $data = array();
            $data['event_log'] = $this->Event_log->find('first_array', array(
                'select' => '*',
                'where' => array(
                    'record_id' => $record_id,
                    'resource_id' => 31,
                    'event_id' => $event_id
                ),
                'order' => array(
                    'created' => 'desc'
                )
                    ));


            if ($data['event_log'] && count($data['event_log']) == '0') {
                //insert if not exists
                $event_log_insert = array(
                    'event_id' => $data['event_id'],
                    'resource_id' => 31, //resource id of music_singers
                    'record_id' => $record_id,
                    'view_count' => 1,
                    'vote_count' => 1,
                    'sms_count' => 0,
                    'user_id' => $id
                );

                $this->Event_log->create($event_log_insert, TRUE);
            } else {

                $update_where = array(
                    'record_id' => $record_id,
                    'event_id' => $event_id
                );

                $this->Event_log->incrementField($update_where, 'vote_count');
            }

            return $check_vote;
        }

        $check_vote['success'] = 0;
        return $check_vote;
    }

    /**
     * add count
     *      
     * @param int $resource_id
     * @param int $record_id
     * @param int $type_id
     * @param string $field_update_count
     * @return boolean
     */
    public function addVoteCount($resource_id, $record_id, $type_id, $field_update_count = NULL) {
        if ($field_update_count) {
            $resource = $this->find('first', array(
                'select' => 'm.name',
                'from' => 'module_resources m',
                'where' => array(
                    'm.id' => $resource_id
                )
                    ));

            if (!$resource) {
                return FALSE;
            }

            $this->load->model('Vote_type');
            $point = $this->Vote_type->getPoint($type_id);

            $this->db->query(
                    sprintf("UPDATE %s SET %s = %s + %d WHERE id = %d", $resource->name, $field_update_count, $field_update_count, $point, $record_id
                    ));
        }

        return TRUE;
    }

    /**
     * upload count
     * 
     * @param int $id vote id
     * @param int $resource_id
     * @param int $record_id
     * @param int $type_id
     * @param string $field_update_count
     * @return boolean 
     */
    public function changToDislike($id, $resource_id, $record_id, $type_id, $field_update_count = NULL) {
        $this->update(array('point' => 0), array('id' => $id));

        if ($field_update_count) {
            $resource = $this->find('first', array(
                'select' => 'm.name',
                'from' => 'module_resources m',
                'where' => array(
                    'm.id' => $resource_id
                )
                    ));

            if (!$resource) {
                return FALSE;
            }

            $this->load->model('Vote_type');
            $point = $this->Vote_type->getPoint($type_id);

            if (strpos($field_update_count, ';') !== FALSE) {
                $fields = explode(';', $field_update_count);

                $this->db->query(
                        sprintf("UPDATE %s SET %s = %s + %d, %s = %s - %d WHERE id = %d"), $resource->name, $fields[0], $fields[0], $point, $fields[1], $fields[1], $point, $record_id
                );
            } else {
                $this->db->query(
                        sprintf("UPDATE %s SET %s = %s - %d WHERE id = %d"), $resource->name, $field_update_count, $field_update_count, $point, $record_id
                );
            }
        }

        return TRUE;
    }

    /**
     * delete vote
     * 
     * @param int $id
     * @param int $resource_id
     * @param int $record_id
     * @param int $type_id
     * @param string $field_update_count
     * @return boolean
     */
    public function deleteVote($id, $resource_id, $record_id, $type_id, $field_update_count = NULL) {
        $this->deleteRecord(array('id' => $id));

        if ($field_update_count) {
            $resource = $this->find('first', array(
                'select' => 'm.name',
                'from' => 'module_resources m',
                'where' => array(
                    'm.id' => $resource_id
                )
                    ));

            if (!$resource) {
                return FALSE;
            }

            $this->load->model('Vote_type');
            $point = $this->Vote_type->getPoint($type_id);

            $this->db->query(
                    sprintf("UPDATE %s SET %s = %s - %d WHERE id = %d"), $resource->name, $field_update_count, $field_update_count, $point, $record_id
            );
        }

        return TRUE;
    }

}

?>