<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author tungcn <cntung2187@gmail.com> 0909898592
 * @copyright Chung Nhut Tung 2011
 * 
 * Model
 * Function on SMS log Service
 * 
 * @package PenguinFW
 * @subpackage SMS logs
 * @version 1.0.0
 * 
 * 
 * @property Music $Music
 */
class Api_soap extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        
        $this->db_table = 'sms_logs';
    }
    
    /**
     * 
     * 
     * @return string
     */
    public function HelloWorld() {
    	return 'Hello';
    }
    
    // recieve SMS from user
    // insert into DB
    public function receive_mo($params) {
    	
    	$data = array(
    		'customer_id' => time(),
    		'content' => $params,
    		'type_id' => ConstConDuongAmNhac::SmsMo,
    		'status_id' => ConstConDuongAmNhac::JustReceived,
    	);
    	
    	// insert SUCCESSFULLY
    	if (parent::create($data, TRUE)) {
    		return array('success' => TRUE);
    	}
    	// FAILURE
    	else {
    		// cannot insert into DB
    		// TODO define error code
    		return array('error' => '1000');
    	}
    }
    
    // reponse SMS to user
    public function send_mt() {
    	try {
    		
    		$cutomer_id = 0;
    		$username = '';
    		$password = '';
    		
    		$data = array(
    			'Customerid' => $cutomer_id,
    			'Usernam' => $username,
    			'Password' => $password,
    		);
    		
    		$info = new SoapClient('http://ws.neo.com.vn:7001/smsservice-ws/SMSServiceMTSecure?wsdl', $data);
    		
    	} catch (SoapFault $fault) {
    		die('error');
    	}
    }
    
    /**
     * step1: get count all sms that have status = ConstConDuongAmNhac::JustReceived = 1
     * step2: count & get Music ID from content
     * step3: update counter in music table
     * step4: change status to ConstConDuongAmNhac::ReadySendSMS = 2
     * 
     */ 
    public function process_sms_mo() {
    	// load model
    	$this->load->model('musics/Music');
    	
    	// get all sms that have status = ConstConDuongAmNhac::JustReceived = 1
    	$list_sms = $this->find('all', array(
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
    		$music_id = 0;
    		list(, $music_id) = explode(' ', $sms['content']);
    		
    		// invalid music ID
    		if ( ! $music_id || (bool)preg_match( '/^[0-9]*$/', $music_id) == FALSE) {
    			$this->update(
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
    		
    		$music = $this->Music->get_array('*', array('id' => $music_id));
    		
    		// invalid music ID
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
    				array('id' => $music_id), 
    				'sms_vote_count;sms_vote_point',
    				$sms['count_sms']
    			);
    		
    		// change status to ConstConDuongAmNhac::ReadySendSMS = 2
    		$this->update(
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
    }
    
    /**
     * 
     * step1: get all sms that have status = ConstConDuongAmNhac::SentMtSuccessfully = 1
     * step2: 
     */
    public function process_sms_mt() {
    	$this->_process_send_sms_mt_1();
    	$this->_process_send_sms_mt_2();
    }
    
    /**
     * 
     * get sms that have status ReadySendSMS,
     * and send SMS MT,
     * then change to status 
     */
    private function _process_send_sms_mt_1() {
    	// get all sms that have status = ConstConDuongAmNhac::JustReceived = 1
    	$list_sms = $this->find('all', array(
    			'select' => '*',
    	    	'where' => array(
    	    		'type_id' => ConstConDuongAmNhac::SmsMo,
    	    		'status_id' => ConstConDuongAmNhac::ReadySendSMS,
    	    	),
    		));
    	
    	if ( ! $list_sms) {
    		return NULL;
    	}
    	
    	foreach ($list_sms as $sms) {
    		// send MT
    		// TODO
    	
    		// create new SMS MT
    		$data_insert = array(
    				'status_id' => ( ! $error_code) ? ConstConDuongAmNhac::SentMtSuccessfully : ConstConDuongAmNhac::SentMtError,
    		    	'type_id' => ConstConDuongAmNhac::SmsMt,
    		    	'error_code' => ( ! $error_code) ? 0 : $error_code,
    			);
    		$this->create($data_insert, TRUE);
    		
    		// change status to ConstConDuongAmNhac::SentMT = 3
    		$this->update(
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
    	$list_sms = $this->find('all', array(
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
    		// send MT
    		// TODO
    		 
    		$this->update(
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
}

?>
