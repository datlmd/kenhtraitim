<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Model
 * Function on Event_log
 * 
 * @package PenguinFW
 * @subpackage events
 * @version 1.0.0
 */
class Event_log extends MY_Model {

    function __construct() {
        parent::__construct();

        $this->db_table = 'event_logs';
    }

    function insert_event_logs($record_id, $event_ids) {
        //reset event id to 0
        $data_reset = array(
            'record_id' => $record_id,
            'resource_id' => 31,
        );
        $update = array('status_id' => '0');
        $this->update($update, $data_reset);



        foreach ($event_ids as $event_id) {
            //get real event_id from events
            $this->load->model('Musics/Music_singer_category');

            $real_event_id = array();
            $real_event_id = $this->Music_singer_category->find('first_array', array(
                'select' => 'event_id',
                'where' => array(
                    'id' => $event_id,
                ),
                    ));
            $real_id = $real_event_id['event_id'];

            $data = array(
                'record_id' => $record_id,
                'event_id' => $real_id,
                'resource_id' => 31,
            );

            //debug($real_id);
            $is_exists = array();
            $is_exists = $this->find('first_array', array(
                'select' => '*',
                'join' => array(
                    'music_singer_categories msc' => 'msc.event_id = event_logs.event_id'
                ),
                'where' => array(
                    'record_id' => $record_id,
                    'msc.event_id' => $real_id,
                ),
                    ));

            //debug($is_exists);
            if (!$is_exists) {
                $this->create($data);
            } else {
                $update = array('status_id' => '1');
                $this->update($update, $data);
            }
        }
    }

}

?>