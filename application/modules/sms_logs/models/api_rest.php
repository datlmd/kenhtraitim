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
 */
class Api_rest extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        
        $this->db_table = 'sms_logs';
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
    		return array('error' => '1111');
    	}
    }
    
    // reponse SMS to user
    public function send_mo() {
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
    
    public function process_sms() {
    	
    	
    }
}

?>
