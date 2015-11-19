<?php
include 'SSO_Config.php';
include 'SSO_Cookies.php';
include 'SSO_GetIP.php';
include 'SSO_Session.php';
include 'thriftlib/Thrift.php';
include 'thriftlib/protocol/TBinaryProtocol.php';
include 'thriftlib/transport/TSocket.php';
include 'thriftlib/transport/THttpClient.php';
include 'thriftlib/transport/TFramedTransport.php';
include 'thriftlib/packages/sms/sms_types.php';
include 'thriftlib/packages/sms/SessionServiceRead.php';
class CXSSO{
	function CXSSO(){}
	/**
	 * check logged-in status from VNG SSO server
	 *
	 * @param array $cookies
	 * @param string $host
	 * @param string $port
	 */
	public static function checkVNGSession($sid, $host=VNG_SESSION_HOST, $port=VNG_SESSION_PORT){
		if($sid){
			$obj = new Session(array('host'=>$host, "port"=>$port));
			$result = $obj->read($sid);		
			if($result->resultCode == 0){
				return $result->session;
			}						
			return false;
		}
		return false;
	}		
	/**
	 * logout
	 *
	 * @param string $return_url
	 */
	public static function logout($return_url=URL_RETURN_LOGOUT){
		header("Location: ".URL_LOGOUT.$return_url);
		exit;
	}
}
?>