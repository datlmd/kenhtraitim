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
include 'thriftlib/packages/sms/SessionServiceWrite.php';
class CSSO{
	function CSSO(){}
	/**
	 * get cookie from client
	 *
	 */
	public static function getCookies(){
		return array(
			'vngauth' => Cookies::getCookie('vngauth'),
			'uin' => Cookies::getCookie('uin'),
			'skey' => Cookies::getCookie('skey'),
			'acn' => Cookies::getCookie('acn'),
		);
	}	
	/**
	 * check logged-in status from VNG SSO server
	 *
	 * @param array $cookies
	 * @param string $host
	 * @param string $port
	 */
	public static function checkVNGSession($cookies="",$host=VNG_SESSION_HOST,$port=VNG_SESSION_PORT){
		if($cookies['vngauth'] && $cookies['uin']){
			$obj = new Session(array('host'=>$host, "port"=>$port));
			$useragent = strtoupper(md5($_SERVER['HTTP_USER_AGENT']));
			$ipAddress = getRealIp();
			$result = $obj->read($cookies['vngauth']);	
			if($result->resultCode == 0){
				// TungCN modified
				/* if($result->session->hostname != $ipAddress){
					return false;
				} */
				if($result->session->useragent != $useragent){
					return false;
				}
			}						
			return $result->session;
		}
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