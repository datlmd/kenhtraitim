<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author tungcn <cntung2187@gmail.com> 0909898592
 * @copyright Chung Nhut Tung 2011
 * 
 * Controller Sms_logs
 * ...
 * 
 * @package PenguinFW
 * @subpackage sms_logs
 * @version 1.0.0
 * 
 * @property Sms_log $Sms_log
 */
class Sms_logs extends MY_Controller {

    function __construct() {
        parent::__construct();

        $this->layout->disable_layout();

        $this->model_name = 'Sms_log';

        $this->lang->load('generate', lang_web());
        $this->lang->load('sms_logs', lang_web());

        $this->load->model('Sms_log');
    }

    /**
     * List
     *
     * @params int $cfn_id
     */
    public function index($cfn_id = 0) {
        // check permission
        $this->PG_ACL('r');

        // set title
        $this->layout->set_title(lang('Sms_log manager'));

        // get sms_logs
        $sms_logs = $this->pagination(5);

        // get $_GET
        $extra_params = get_extra_params_from_url();

        $data = array(
            'list_views' => $sms_logs,
            'this_resource' => $this->router->class,
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'link_edit' => array(
                'Edit' => 'sms_logs/sms_logs/edit/'
            ),
            'pagination_link' => $this->getPaginationLink('/sms_logs/sms_logs/index/' . $cfn_id, 5, $extra_params)
        );

        $this->parser->parse($this->router->class . '/index', $data);
    }

    //show log 
    //http://f-idol.g3/sms_logs/show_log
    function show_log($filename = '') {
        // check permission
        //$this->PG_ACL('r');
        if ($this->session->userdata('user_user_role_id') != 3){
            die('Not authorize!');
        }
        if (empty($filename)) {
            $this->show_list();
        } else {
            $file = FPENGUIN . 'application/logs/' . $filename;
            if (file_exists($file)) {
                echo '<pre>'.read_file(nl2br($file, true)).'</pre>';
            } else {
                echo 'File is not exists!';
            }
        }
    }

    //show logs list from logs directory
    private function show_list() {
        //write_log_file('test_' . date('Y_m_d'), date('Y_m_d'));
        //echo date('Y_m_d');
        if ($handle = opendir(FPENGUIN . 'application/logs/')) {
            echo "Directory handle: $handle<br />";
            echo "Entries:<br />";

            /* This is the correct way to loop over the directory. */
            while (false !== ($entry = readdir($handle))) {
                $pos = strpos($entry, 'logs');

                if ($pos !== false) {
                    echo "$entry<br />";
                }
                
            }

            closedir($handle);
        }
    }

    public function general_process_sms() {

        $this->load->model('musics/Music');

        for ($i = 0; $i < 300; $i++) {
            $is_allow_add_point = FALSE;
            $is_wrong_format = TRUE;
            $is_exceed_sms = TRUE;

            // get all sms that have status = ConstConDuongAmNhac::JustReceived = 1
            $list_sms = $this->Sms_log->find('all', array(
                'select' => '*',
                'where' => array(
                    'type_id' => ConstConDuongAmNhac::SmsMo,
                    'status_id' => ConstConDuongAmNhac::JustReceived,
                ),
                'order' => array('id' => 'asc'),
                'limit' => 1,
                    ));



            // empty sms just receive
            if (!$list_sms) {
                return NULL;
            }

            $sms = $list_sms[0];

            $this->Sms_log->update(
                    array(
                'status_id' => 123,
                    ), array(
                'id' => $sms['id'],
                    ), TRUE
            );

            // count & get Music ID from content
            $codeid = 0;
            //list($tmp, $codeid, $tmp1) = explode(' ', $sms['content']);
            $parse_content = explode(' ', $sms['content']);

            $codeid = $parse_content[1];

            // invalid code ID
            if (!$codeid || count($parse_content) != 2
                    || (bool) preg_match('/^[0-9]*$/', $codeid) == FALSE
                    || !($music = $this->Music->get_array('*', array('codeid' => $codeid)))) {

                $is_wrong_format = TRUE;
            }
            // Correct format
            else {
                $is_wrong_format = FALSE;
            }

            if ($is_wrong_format == FALSE) {
                $begin_today_datetime = date('Y-m-d', time());
                $begin_today_datetime .= ' 00:00:00';

                $counter_sms = $this->Sms_log->find('count', array(
                    'where' => array(
                        'message_id' => $codeid,
                        'sender' => $sms['sender'],
                        'created >=' => $begin_today_datetime
                    ),
                        ));

                // one phone have maximum 10 vote per music    		
                if ($counter_sms >= config_item('fe_sms_max_per_phone_day_music')) {
                    $is_exceed_sms = TRUE;
                } else {
                    $is_exceed_sms = FALSE;
                }
            }

            // no error
            // allow adding point
            if (!$is_wrong_format && !$is_exceed_sms) {
                $is_allow_add_point = TRUE;
            }

            // ERR: format
            if ($is_wrong_format) {
                $this->Sms_log->update(
                        array(
                    'status_id' => ConstConDuongAmNhac::ErrorMoInvalidFormatSentMT,
                        ), array(
                    'id' => $sms['id'],
                        ), TRUE
                );

                // make content for sms mt
                $sms['content'] = lang('Sorry, your voting music is invalid');

                // send MT
                $error_code = $this->send_mt($sms['receiver'], $sms['sender'], $sms['content'], $sms['moid']);

                /* if ( ! $error_code) {
                  $this->Sms_log->update(
                  array(
                  'status_id' => ConstConDuongAmNhac::ErrorMoInvalidFormatSentMT,
                  ),
                  array(
                  'id' => $sms['id'],
                  ),
                  TRUE
                  );
                  } */
            }
            // ERR: exceed
            elseif ($is_exceed_sms) {
                $this->Sms_log->update(
                        array(
                    'status_id' => ConstConDuongAmNhac::ErrorExceedMoSentMT,
                        ), array(
                    'id' => $sms['id'],
                        ), TRUE
                );

                // make content for sms mt
                $sms['content'] = lang('Sorry, your number of voting music is exceed');

                // send MT
                $error_code = $this->send_mt($sms['receiver'], $sms['sender'], $sms['content'], $sms['moid']);

                /* if ( ! $error_code) {
                  $this->Sms_log->update(
                  array(
                  'status_id' => ConstConDuongAmNhac::ErrorExceedMoSentMT,
                  ),
                  array(
                  'id' => $sms['id'],
                  ),
                  TRUE
                  );
                  } */
            }
            // allow adding point
            elseif ($is_allow_add_point) {
                $sms_1 = $this->Sms_log->get_array('*', array(
                    'id' => $sms['id'],
                    //'status_id' => ConstConDuongAmNhac::JustReceived,
                    'status_id' => 123,
                        ));

                if ($sms_1) {
                    write_log_file('soap_sms_logs_mt_tung', "readyForSend | " . $sms['moid']);
                    // update counter sms in musics table
                    $this->Music->incrementField(
                            array('codeid' => $codeid), 'sms_vote_count;sms_vote_point', 1
                    );

                    // change status to ConstConDuongAmNhac::SentMT = 3
                    $this->Sms_log->update(
                            array(
                        'status_id' => ConstConDuongAmNhac::SentMT,
                        'message_id' => $codeid,
                            ), array(
                        'id' => $sms['id'],
                        //'status_id' => ConstConDuongAmNhac::JustReceived,
                        'status_id' => 123,
                            ), TRUE
                    );

                    $music = $this->Music->get_array('*', array('codeid' => $codeid));

                    $this->load->helper('text');
                    // make content for sms mt
                    $sms['content'] = sprintf(lang('Congratulation, you voted successfully for music named %s with code %s'), convert_accented_characters($music['name']), $codeid);

                    // send MT
                    $error_code = $this->send_mt($sms['receiver'], $sms['sender'], $sms['content'], $sms['moid'], $codeid);

                    /* if ($error_code) {
                      // change status to ConstConDuongAmNhac::ErrorMoSentMT = 3
                      $this->Sms_log->update(
                      array(
                      'status_id' => ConstConDuongAmNhac::ErrorMoSentMT,
                      'error_code' => $error_code,
                      'message_id' => $codeid,
                      ),
                      array(
                      'id' => $sms['id'],
                      'status_id' => ConstConDuongAmNhac::JustReceived,
                      ),
                      TRUE
                      );
                      } */
                }
            }

            //sleep(1);
        } // for

        exit(0);
    }

    private function send_mt($sender, $receiver, $content, $moid, $codeid = -1, $service_code = 1, $charged_flag = 1) {
        // write log
        write_log_file('soap_sms_logs_mt', "readyForSend | $sender | $receiver | $content | $moid | 0");

        $username = 'BDHN'; /* Username: case sensitive */
        $password = 'BDHN@!@#NE0'; /* Password: case sensitive */
        $customer_id = 'BDHN'; /* Customerid: MRLIM */
        $service_code = $service_code; /* ServiceCode: Text=1, Wappush=7, ... */
        $sender1 = "$sender";  /* Sender: is shortcode */
        $receiver1 = "$receiver"; /* Receiver: is subscriber's mobile */
        $content = "$content"; /* Content: in text message value="content_of_message" and binary message value="title_of_url" */
        $hex_content = ""; /* HexContent: in text message value="" and binary message value="URL" */
        $charged_number = "$receiver"; /* ChargeNumber: is */
        $charged_flag = $charged_flag; /* ChargeFlag: 0 is nocharge, 1 is charge */
        $service_number = "$sender"; /* ServiceNumber: is shortcode */
        $service_name = ""; /* ServiceName: any thing */
        $message_id = "$moid"; /* MO id */

        require_once(APPPATH . 'libraries/nusoap/nusoap' . EXT); //includes nusoap

        $oClient = new nusoap_client('http://ws.neo.com.vn:7001/smsservice-ws/SMSServiceMTSecure?wsdl');

        //write_log_file('soap_sms_logs_mt_tung', "$sender | $receiver | $content | $moid");
        //$oClient = new SoapClient('http://123.30.17.103:7001/smsservice-ws/SMSServiceMTSecure?wsdl');
        // Init: request timeout
        $result = 408;

        $result = $oClient->call('sendMessage', array(
            $customer_id,
            $service_code,
            $sender1,
            $receiver1,
            $content,
            $hex_content,
            $charged_number,
            $charged_flag,
            $service_number,
            $service_name,
            $message_id,
            $username,
            $password
                ));

        /* $result = $oClient->sendMessage($customer_id,
          $service_code,
          $sender1,
          $receiver1,
          $content,
          $hex_content,
          $charged_number,
          $charged_flag,
          $service_number,
          $service_name,
          $message_id,
          $username,
          $password); */
        //write_log_file('soap_sms_logs_mt_tung', "$sender | $receiver | $result | $moid");
        write_log_file('soap_sms_logs_mt', "Sent | $sender | $receiver | $content | $moid | $result");

        // no error
        if (!$result) {
            // create new SMS MT
            $data_insert = array(
                'status_id' => ConstConDuongAmNhac::SentMtSuccessfully,
                'type_id' => ConstConDuongAmNhac::SmsMt,
                'error_code' => 0,
                'sender' => $sender,
                'receiver' => $receiver,
                'content' => $content,
                'moid' => $moid,
                'message_id' => $codeid,
            );

            if ($this->Sms_log->create($data_insert, TRUE)) {
                return 0;
            } else {
                return 404;
            }
        }

        return $result;
    }

    private function send_mt2($sender, $receiver, $content, $moid, $codeid = -1, $service_code = 1, $charged_flag = 1) {
        // write log
        write_log_file('soap_sms_logs_mt', "readyForSend | $sender | $receiver | $content | $moid | 0");

        $username = 'BDHN'; /* Username: case sensitive */
        $password = 'BDHN@!@#NE0'; /* Password: case sensitive */
        $customer_id = 'BDHN'; /* Customerid: MRLIM */
        $service_code = $service_code; /* ServiceCode: Text=1, Wappush=7, ... */
        $sender1 = "$sender";  /* Sender: is shortcode */
        $receiver1 = "$receiver"; /* Receiver: is subscriber's mobile */
        $content = "$content"; /* Content: in text message value="content_of_message" and binary message value="title_of_url" */
        $hex_content = ""; /* HexContent: in text message value="" and binary message value="URL" */
        $charged_number = "$receiver"; /* ChargeNumber: is */
        $charged_flag = $charged_flag; /* ChargeFlag: 0 is nocharge, 1 is charge */
        $service_number = "$sender"; /* ServiceNumber: is shortcode */
        $service_name = ""; /* ServiceName: any thing */
        $message_id = "$moid"; /* MO id */

        require_once(APPPATH . 'libraries/nusoap/nusoap' . EXT); //includes nusoap

        $oClient = new nusoap_client('http://ws.neo.com.vn:7001/smsservice-ws/SMSServiceMTSecure?wsdl');

        //write_log_file('soap_sms_logs_mt_tung', "$sender | $receiver | $content | $moid");
        //$oClient = new SoapClient('http://123.30.17.103:7001/smsservice-ws/SMSServiceMTSecure?wsdl');
        // Init: request timeout
        $result = 408;

        $result = $oClient->call('sendMessage', array(
            $customer_id,
            $service_code,
            $sender1,
            $receiver1,
            $content,
            $hex_content,
            $charged_number,
            $charged_flag,
            $service_number,
            $service_name,
            $message_id,
            $username,
            $password
                ));

        /* $result = $oClient->sendMessage($customer_id,
          $service_code,
          $sender1,
          $receiver1,
          $content,
          $hex_content,
          $charged_number,
          $charged_flag,
          $service_number,
          $service_name,
          $message_id,
          $username,
          $password); */
        //write_log_file('soap_sms_logs_mt_tung', "$sender | $receiver | $result | $moid");
        write_log_file('soap_sms_logs_mt', "Sent | $sender | $receiver | $content | $moid | $result");

        // no error
        if (!$result) {
            // create new SMS MT
            $data_insert = array(
                'status_id' => ConstConDuongAmNhac::SentMtSuccessfully,
                'type_id' => ConstConDuongAmNhac::SmsMt,
                'error_code' => 0,
                'sender' => $sender,
                'receiver' => $receiver,
                'content' => $content,
                'moid' => $moid,
                'message_id' => $codeid,
            );

            if ($this->Sms_log->create($data_insert, TRUE)) {
                return 0;
            } else {
                return 404;
            }
        }

        return $result;
    }

}

?>
