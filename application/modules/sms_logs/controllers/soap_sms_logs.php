<?php

/**
 * PENGUIN FrameWork
 * @author tungcn <cntung2187@gmail.com> 0909898592
 * @copyright Chung Nhut Tung 2011
 * 
 * Controller Soap_sms_logs
 * ...
 * 
 * @package PenguinFW
 * @subpackage sms_logs
 * @version 1.0.0
 * @property Music $Music
 */
class Soap_sms_logs {

    /**
     * SMS
     * @param string $requestId
     * @param string $userId
     * @param string $serviceId
     * @param string $commandCode
     * @param string $Message
     * @param string $MobileOperator
     * @param string $partnerUsername
     * @param string $partnerPassword
     * @param string $requestTime 
     * @return int
     */
    public function receiveMO($RequestID, $UserID, $ServiceID, $CommandCode, $Message, $MobileOperator, $Username, $Password, $RequestTime) {
        // write log
        write_log_file('receive_mo_logs_' . DATE('Y_m_d'), "$RequestID | $UserID | $CommandCode | $Message | $MobileOperator | $RequestTime");
        return $this->receive_mo($RequestID, $UserID, $ServiceID, $CommandCode, $Message, $MobileOperator, $Username, $Password, $RequestTime);
    }

    private function receive_mo($RequestID, $UserID, $ServiceID, $CommandCode, $Message, $MobileOperator, $Username, $Password, $RequestTime) {
        $user = 'fidol_sms_service';
        $pass = 's6M^$t64V%';
        try {
            if ($Username == $user && $Password == $pass) {

                $Message = base64_decode($Message);
                $commandCode = trim($commandCode);
                //insert to sms_log
                $data_insert = array(
                    'request_id' => $RequestID,
                    'service_id' => $ServiceID,
                    'command_code' => $CommandCode,
                    'message' => $Message,
                    'operator' => $MobileOperator,
                    'request_time' => $RequestTime,
                    'status_id' => 0,
                );

                require_once APPPATH . 'modules/sms_logs/models/sms_log.php';

                $Sms_log = new Sms_log();
                $Sms_log->create($data_insert, TRUE);

                $result = $this->send_mt($RequestID, $UserID, $ServiceID, $Message, $MobileOperator, $CommandCode);
                if ($result != 1) {
                    $result = -6;
                } else {
                    $result = 1;
                }
            } else {
                $result = -7;
            }
        } catch (Exception $e) {
            write_log_file('receive_mo_error_logs_' . date('Y_m_d'), $RequestID . '|' . $e);
            $result = -6;
        }

        return $result;
    }

    /**
     * xxx
     * @param string $RequestID
     * @param string $UserID
     * @param string $ServiceID
     * @param string $Message
     * @param string $mobile_operator
     * @param string $CommandCode
     * @return int 
     */
    private function send_mt($RequestID, $UserID, $ServiceID, $Message, $mobile_operator, $CommandCode) {

        try {
            require_once(APPPATH . 'libraries/nusoap/nusoap' . EXT); //includes nusoap
            $validate = $this->check_validate(trim($Message), $UserID);
            //$sig = md5($RequestID . $UserID . $ServiceID . $CommandCode . $validate['announce_message'] . 'mvas@#123'); //local key
            $sig = md5($RequestID . $UserID . $ServiceID . $CommandCode . $validate['announce_message'] . 'sdsfgf221212ZZZJJJ'); //real key
            //$oClient = new nusoap_client('http://10.199.38.101/axis/services/CPRMTNEW?wsdl'); //local
            $oClient = new nusoap_client('http://smsgw.zing.vn/axis/services/CPRMTNEW?wsdl'); //real
            // Init: request timeout

            $result = $oClient->call('mtReceiver', array(
                $RequestID,
                $UserID,
                $ServiceID,
                $CommandCode,
                base64_encode($validate['announce_message']), //message tra cho user
                $validate['status'], //trang thai hoan tien
                $mobile_operator,
                1,
                $sig,
                    ));
        } catch (Exception $e) {
            write_log_file('send_mt_error_logs_' . date('Y_m_d'), $RequestID . '|' . $e);
        }
        // write log
        write_log_file('send_mt_logs_' . date('Y_m_d'), "$RequestID| $UserID| $ServiceID| $Message| " . $validate['announce_message'] . "| " . $validate['status'] . "| $mobile_operator| 1| $sig |$result");

        return $result;
    }

    private function check_validate($mt_message, $UserID) {
        try {
            //split $mt_message to 2 element: [0] - FIDOL. [1] - candidate_number
            $str_tmp = explode(' ', $mt_message);
            $candidate_number = $str_tmp[1];

            require_once APPPATH . 'modules/musics/models/music_singer.php';
            $music_singer = new Music_singer();
            $data = $music_singer->find('first_array', array(
                'select' => 'start, end, music_singers.name as name, event_id, music_singers.id as id',
                'join' => array(
                    'music_singer_category_relationships mscr' => 'mscr.singer_id = music_singers.id',
                    'music_singer_categories msc' => 'msc.id = mscr.singer_cate_id',
                    'events e' => 'e.id = msc.event_id'
                ),
                'where' => array(
                    'candidate_number' => $candidate_number,
                    'music_singers.status_id' => 1
                ),
                'order' => array('msc.event_id' => 'desc')
                    ));

            if ($data) {

                $music_singer_id = $data['id'];

                if (time() < strtotime($data['start'])) {
                    //coming soon
                    return array('status' => 2, 'announce_message' => 'Chua toi han binh chon cho thi sinh nay! Vui long quay lai vao ' . date('d-m-Y H:i:s', strtotime($data['start'])));
                } elseif (time() > strtotime($data['end'])) {
                    //expire
                    return array('status' => 2, 'announce_message' => 'Han binh chon cho thi sinh nay da ket thuc vao ' . date('d-m-Y H:i:s', strtotime($data['end'])));
                } else {

                    require_once APPPATH . 'modules/votes/models/vote.php';

                    $Vote = new Vote();
                    //check if already voted today
                    $today = $Vote->find('first_array', array(
                        'where' => array(
                            'record_id' => $music_singer_id,
                            'user_id' => $UserID,
                            'DATE(created)' => date('Y-m-d')
                        ),
                            ));

                    if ($today) {
                        return array('status' => 2, 'announce_message' => 'Hom nay ban da binh chon cho thi sinh co SBD: ' . $candidate_number . ' roi. Quay lai vao ngay mai nhe!');
                    }

                    //insert votes
                    $data_insert = array(
                        'record_id' => $music_singer_id,
                        'point' => 1,
                        'type_id' => 2,
                        'resource_id' => 31, //music_singers
                        'user_ip' => '127.0.0.2',
                        'username' => 'sms_service',
                        'user_id' => $UserID,
                        'event_id' => $data['event_id'],
                    );
                    $Vote->create($data_insert, TRUE);

                    require_once APPPATH . 'modules/events/models/event_log.php';
                    $Event = new Event_log();
                    $event_log = $Event->find('first_array', array(
                        'select' => '*',
                        'where' => array(
                            'record_id' => $id,
                            'resource_id' => 31,
                            'event_id' => $data['event_id']
                        ),
                        'order' => array(
                            'created' => 'desc'
                        )
                            ));


                    if ($event_log) {
                        //insert if not exists
                        $event_log_insert = array(
                            'event_id' => $data['event_id'],
                            'resource_id' => 31, //resource id of music_singers
                            'record_id' => $music_singer_id,
                            'view_count' => 1,
                            'vote_count' => 0,
                            'sms_count' => 1,
                            'user_id' => $id
                        );

                        $Event->create($event_log_insert, TRUE);
                    } else {

                        $update_where = array(
                            'record_id' => $music_singer_id,
                        );

                        $Event->incrementField($update_where, 'sms_count');
                    }

                    return array('status' => 1, 'announce_message' => 'Ban da binh chon thanh cong cho thi sinh co SBD: ' . $candidate_number);
                }
            } else {
                //invalid cadidate number
                return array('status' => 2, 'announce_message' => 'Thi sinh co SBD: ' . $candidate_number . ' khong ton tai!');
            }
        } catch (Exception $e) {
            write_log_file('send_mt_error_logs_' . date('Y_m_d'), $e);
        }
    }

}

?>