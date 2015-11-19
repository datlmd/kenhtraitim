<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of zalo_sms_service
 *
 * @author Dung Doan
 */
class zalo_sms_service extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->layout->disable_layout();
    }

    public function receive_notify() {
        $this->layout->disable_layout();
        $this->load->library("zalo");
        $event = $this->input->get('event', TRUE);

        $sms_data = array();
        $flag_status = 'not_true';

        //User send text message to fanpage
        if ($event == "sendmsg") {
            $sms_data = array(
                'event' => $event,
                'pageid' => $this->input->get('pageid', TRUE),
                'mac' => $this->input->get('mac', TRUE),
                'fromuid' => $this->input->get('fromuid', TRUE),
                'msgid' => $this->input->get('msgid', TRUE),
                'message' => $this->input->get('message', TRUE),
                'timestamp' => $this->input->get('timestamp', TRUE)
            );

            if ($sms_data['mac'] == hash('sha256', $sms_data['pageid'] . $sms_data['fromuid'] . $sms_data['msgid'] . $sms_data['message'] . $sms_data['timestamp'] . $this->zalo->getSecretKey())) {
                //Put your code here
                //Set status of notify
                $flag_status = 'true';
            }

            //User send image message to fanpage
        } elseif ($event == "sendimagemsg") {
            $sms_data = array(
                'event' => $event,
                'pageid' => $this->input->get('pageid', TRUE),
                'mac' => $this->input->get('mac', TRUE),
                'fromuid' => $this->input->get('fromuid', TRUE),
                'msgid' => $this->input->get('msgid', TRUE),
                'message' => $this->input->get('message', TRUE),
                'message' => $this->input->get('href', TRUE),
                'message' => $this->input->get('thumb', TRUE),
                'timestamp' => $this->input->get('timestamp', TRUE)
            );

            if ($sms_data['mac'] == hash('sha256', $sms_data['pageid'] . $sms_data['fromuid'] . $sms_data['msgid'] . $sms_data['message'] . $sms_data['href'] . $sms_data['thumb'] . $sms_data['timestamp'] . $this->zalo->getSecretKey())) {
                //Put your code here
                //Set status of notify
                $flag_status = 'true';
            }

            //User follow fanpage
        } elseif ($event == "follow") {
            $sms_data = array(
                'event' => $event,
                'pageid' => $this->input->get('pageid', TRUE),
                'mac' => $this->input->get('mac', TRUE),
                'fromuid' => $this->input->get('fromuid', TRUE),
                'timestamp' => $this->input->get('timestamp', TRUE)
            );

            if ($sms_data['mac'] == hash('sha256', $sms_data['pageid'] . $sms_data['fromuid'] . $sms_data['timestamp'] . $this->zalo->getSecretKey())) {
                //Put your code here
                //Set status of notify
                $flag_status = 'true';
            }

            //User follow fanpage
        } elseif ($event == "unfollow") {
            $sms_data = array(
                'event' => $event,
                'pageid' => $this->input->get('pageid', TRUE),
                'mac' => $this->input->get('mac', TRUE),
                'fromuid' => $this->input->get('fromuid', TRUE),
                'timestamp' => $this->input->get('timestamp', TRUE)
            );

            if ($sms_data['mac'] == hash('sha256', $sms_data['pageid'] . $sms_data['fromuid'] . $sms_data['timestamp'] . $this->zalo->getSecretKey())) {
                //Put your code here
                //Set status of notify
                $flag_status = 'true';
            }

            //User subscribe fanpage events
        } elseif ($event == "subscribe") {
            $sms_data = array(
                'event' => $event,
                'pageid' => $this->input->get('pageid', TRUE),
                'mac' => $this->input->get('mac', TRUE),
                'fromuid' => $this->input->get('fromuid', TRUE),
                'timestamp' => $this->input->get('timestamp', TRUE)
            );

            if ($sms_data['mac'] == hash('sha256', $sms_data['pageid'] . $sms_data['fromuid'] . $sms_data['timestamp'] . $this->zalo->getSecretKey())) {
                //Put your code here
                //Set status of notify
                $flag_status = 'true';
            }

            //User unsubscribe fanpage events
        } elseif ($event == "unsubscribe") {
            $sms_data = array(
                'event' => $event,
                'pageid' => $this->input->get('pageid', TRUE),
                'mac' => $this->input->get('mac', TRUE),
                'fromuid' => $this->input->get('fromuid', TRUE),
                'timestamp' => $this->input->get('timestamp', TRUE)
            );

            if ($sms_data['mac'] == hash('sha256', $sms_data['pageid'] . $sms_data['fromuid'] . $sms_data['timestamp'] . $this->zalo->getSecretKey())) {
                //Put your code here
                //Set status of notify
                $flag_status = 'true';
            }
        }

        if ($event) {
            $this->write_file_log($event, $sms_data, $flag_status);
        }
        echo $flag_status;
    }

    private function write_file_log($event, $write_data, $status) {
        $directory = FPENGUIN . "media/logs/ZaloNotify/" . date('Y') . '/' . date('m') . '/' . date('d') . '/';
        if (!is_dir($directory)) {
            mkdir($directory, 0777, TRUE);
        }

        if (is_array($write_data)) {
            $string_data = json_encode($write_data);
            $string_data = $event . "|++|" . date('d/m/Y H:i:s') . "|" . $status . "|$string_data|" . "\n";
            write_file($directory . $event . ".txt", $string_data, 'a');
        }
    }

}
