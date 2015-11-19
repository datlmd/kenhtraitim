<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
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
 
class Sms_logs extends MY_Controller
{
    function __construct()
    {
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
    public function index($cfn_id = 0)
    {
        // check permission
        $this->PG_ACL('r');
        
        // set title
        $this->layout->set_title(lang('Sms_log manager'));
        
        // get sms_logs
        $sms_logs = $this->pagination(5);
                
        $data = array(
            'list_views' => $sms_logs,
            
            'this_resource' => $this->router->class,            
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'link_edit' => array(
                'Edit' => 'sms_logs/sms_logs/edit/'                
            ),
            'pagination_link' => $this->getPaginationLink('/sms_logs/sms_logs/index/' . $cfn_id, 5)
        );
        
        $this->parser->parse($this->router->class . '/index', $data);
    }
    
    /**
    * step1: get count all sms that have status = ConstConDuongAmNhac::JustReceived = 1
    * step2: count & get Code ID from content
    * step3: update counter in music table
    * step4: change status to ConstConDuongAmNhac::ReadySendSMS = 2
    *
    */
    public function process_sms_mo() {
    	
    	// load model
    	$this->load->model('musics/Music');
    	 
    	// get all sms that have status = ConstConDuongAmNhac::JustReceived = 1
    	$list_sms = $this->Sms_log->find('all', array(
        			'select' => 'count(id) as count_sms, status_id, type_id, content',
        			'where' => array(
        				'type_id' => ConstConDuongAmNhac::SmsMo,
        	    		'status_id' => ConstConDuongAmNhac::JustReceived,
    	),
        			'groupby' => array('content'),
    	));
    	 
    	// empty sms just receive
    	if ( ! $list_sms) {
    		return NULL;
    	}
    	
    	// count & get Music ID from content
    	foreach ($list_sms as $sms) {
    		$codeid = 0;
    		list($tmp, $codeid) = explode(' ', $sms['content']);
    		
    		// invalid code ID
    		if ( ! $codeid || (bool)preg_match( '/^[0-9]*$/', $codeid) == FALSE) {
    			$this->Sms_log->update(
    					array(
        					'status_id' => ConstConDuongAmNhac::ErrorMoInvalidFormat,
    					),
    					array(
        					'type_id' => ConstConDuongAmNhac::SmsMo,
        			        'status_id' => ConstConDuongAmNhac::JustReceived,
        			        'content' => $sms['content'],
    					),
    					TRUE
    				);
    			 
    			continue;
    		}
    
    		$music = $this->Music->get_array('*', array('codeid' => $codeid));
    		
    		// invalid code ID
    		if ( ! $music) {
    			$this->Sms_log->update(
    					array(
    			        	'status_id' => ConstConDuongAmNhac::ErrorMoInvalidFormat,
    					),
    					array(
    			        	'type_id' => ConstConDuongAmNhac::SmsMo,
    			            'status_id' => ConstConDuongAmNhac::JustReceived,
    			        	'content' => $sms['content'],
    					),
    					TRUE
    				);
    			
    			continue;
    		}
    		
    		// update counter sms in musics table
    		$this->Music->incrementField(
    				array('codeid' => $codeid),
        			'sms_vote_count;sms_vote_point',
    				$sms['count_sms']
    			);
    
    		// change status to ConstConDuongAmNhac::ReadySendSMS = 2
    		$this->Sms_log->update(
    				array(
        		    	'status_id' => ConstConDuongAmNhac::ReadySendSMS,
    				),
    				array(
        		    	'type_id' => ConstConDuongAmNhac::SmsMo,
        		        'status_id' => ConstConDuongAmNhac::JustReceived,
        		        'content' => $sms['content'],
    				),
    				TRUE
    			);
    	}
    	
    	exit();
    }
    
    /**
    *
    *	sent sms MT
    *	Update status
    * 
    */
    public function process_sms_mt() {
    	
    	$this->_process_send_sms_mt_1();
    	$this->_process_send_sms_mt_2();
    	$this->_process_send_sms_mt_3();
    	
    	exit();
    }
    
    /**
    *
    * get sms that have status ReadySendSMS,
    * and send SMS MT,
    * then change to status
    */
    private function _process_send_sms_mt_1() {
    	// get all sms that have status = ConstConDuongAmNhac::ReadySendSMS = 2
    	$list_sms = $this->Sms_log->find('all', array(
        		'select' => '*',
        	    'where' => array(
        	    	'type_id' => ConstConDuongAmNhac::SmsMo,
        	    	'status_id' => ConstConDuongAmNhac::ReadySendSMS,
        	    ),
    		));
    	 
    	if ( ! $list_sms) {
    		return NULL;
    	}
    	
    	// load model
    	$this->load->model('musics/Music');
    	
    	foreach ($list_sms as $sms) {
    		$codeid = 0;
    		// get music ID
    		list($tmp, $codeid) = explode(' ', $sms['content']);
    		
    		// load music
    		$music = $this->Music->get_array('*', array('codeid' => $codeid));
    		
    		// make content for sms mt
    		$sms['content'] = sprintf(lang('Congratulation, you voted successfully for music: %s'), music_code($codeid));
    		
    		// send MT
    		$error_code = $this->send_mt($sms['receiver'], $sms['sender'], $sms['content'], $sms['moid']);
    		
    		// create new SMS MT
    		$data_insert = array(
        			'status_id' => ( ! $error_code) ? ConstConDuongAmNhac::SentMtSuccessfully : ConstConDuongAmNhac::SentMtError,
        		    'type_id' => ConstConDuongAmNhac::SmsMt,
        		    'error_code' => ( ! $error_code) ? 0 : $error_code,
        		    'sender' => $sms['receiver'],
        		    'receiver' => $sms['sender'],
        		    'content' => $sms['content'],
        		    'moid' => $sms['moid'],
    			);
    		$this->Sms_log->create($data_insert, TRUE);
    
    		// change status to ConstConDuongAmNhac::SentMT = 3
    		$this->Sms_log->update(
    				array(
        				'status_id' => ConstConDuongAmNhac::SentMT,
    				),
    				array(
        		   	    'id' => $sms['id'],
    				),
    				TRUE
    			);
    	}
    }
    
    /**
     *
     * send failure sms mt again.
     */
    private function _process_send_sms_mt_2() {
    	// get all sms that have status = ConstConDuongAmNhac::JustReceived = 1
    	$list_sms = $this->Sms_log->find('all', array(
            	'select' => '*',
            	'where' => array(
            		'type_id' => ConstConDuongAmNhac::SmsMt,
            		'status_id' => ConstConDuongAmNhac::SentMtError,
            	),
    		));
    
    	if ( ! $list_sms) {
    		return NULL;
    	}
    
    	foreach ($list_sms as $sms) {
    		// send MT again
    		$error_code = $this->send_mt($sms['sender'], $sms['receiver'], $sms['content'], $sms['moid']);
    		
    		// update status
    		$this->Sms_log->update(
    				array(
        	    		'status_id' => ( ! $error_code) ? ConstConDuongAmNhac::SentMtSuccessfully : ConstConDuongAmNhac::SentMtError,
        			   	'error_code' => ( ! $error_code) ? 0 : $error_code,
    				),
    				array(
        				'id' => $sms['id'],
    				),
    				TRUE
    			);
    	}
    }
    
    /**
     * 
     * get sms that have status ErrorMoInvalidFormat,
     * and send SMS MT,
     * then change to status
     */
    private function _process_send_sms_mt_3() {
    	// get all sms that have status = ConstConDuongAmNhac::ErrorMoInvalidFormat = -1
    	$list_sms = $this->Sms_log->find('all', array(
            		'select' => '*',
            	    'where' => array(
            	    	'type_id' => ConstConDuongAmNhac::SmsMo,
            	    	'status_id' => ConstConDuongAmNhac::ErrorMoInvalidFormat,
    	),
    	));
    
    	if ( ! $list_sms) {
    		return NULL;
    	}
    	 
    	foreach ($list_sms as $sms) {
    		
    		// make content for sms mt
    		$sms['content'] = lang('Sorry, your voting music is invalid');
    
    		// send MT
    		$error_code = $this->send_mt($sms['receiver'], $sms['sender'], $sms['content'], $sms['moid']);
    
    		// create new SMS MT
    		$data_insert = array(
            			'status_id' => ( ! $error_code) ? ConstConDuongAmNhac::SentMtSuccessfully : ConstConDuongAmNhac::SentMtError,
            		    'type_id' => ConstConDuongAmNhac::SmsMt,
            		    'error_code' => ( ! $error_code) ? 0 : $error_code,
            		    'sender' => $sms['receiver'],
            		    'receiver' => $sms['sender'],
            		    'content' => $sms['content'],
            		    'moid' => $sms['moid'],
    		);
    		$this->Sms_log->create($data_insert, TRUE);
    
    		// change status to ConstConDuongAmNhac::ErrorMoInvalidFormatSentMT = -2
    		$this->Sms_log->update(
    				array(
            			'status_id' => ConstConDuongAmNhac::ErrorMoInvalidFormatSentMT,
    				),
    				array(
            		    'id' => $sms['id'],
    				),
    				TRUE
    			);
    	}
    }
    
    private function send_mt($sender, $receiver, $content, $moid, $service_code = 1, $charged_flag = 1) {
    	// write log
    	write_log_file('soap_sms_logs_mt', "$sender | $receiver | $content | $service_code | $charged_flag");
    	
    	$username 		= 'BDHN'; /* Username: case sensitive*/
    	$password 		= 'BDHN@!@#NE0'; /* Password: case sensitive*/
    	$customer_id 	= 'BDHN'; /* Customerid: MRLIM*/
    	$service_code 	= $service_code; /* ServiceCode: Text=1, Wappush=7, ...*/
    	$sender1 		= "$sender";  /* Sender: is shortcode*/
    	$receiver1 		= "$receiver"; /* Receiver: is subscriber's mobile */
    	$content 		= "$content"; /* Content: in text message value="content_of_message" and binary message value="title_of_url" */
    	$hex_content 	= ""; /*HexContent: in text message value="" and binary message value="URL" */
    	$charged_number = "$receiver"; /* ChargeNumber: is */
    	$charged_flag 	= $charged_flag; /* ChargeFlag: 0 is nocharge, 1 is charge*/
    	$service_number = "$sender"; /* ServiceNumber: is shortcode*/
    	$service_name 	= ""; /* ServiceName: any thing*/
    	$message_id		= "$moid"; /*MO id*/
    	
    	$oClient = new SoapClient('http://ws.neo.com.vn:7001/smsservice-ws/SMSServiceMTSecure?wsdl');
    	
    	$result = $oClient->sendMessage($customer_id,
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
								    	$password);
    	
    	return $result;
    }
}
                
?>