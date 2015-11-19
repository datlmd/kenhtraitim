<?php
class Cookies
{
	const COOKIES_DOMAIN='zing.vn';
	const COOKIES_EXPIRE=7200;//2 hours
	
	static function getCookie($name, $defaultValue = '')
	{
		return isset($_COOKIE[$name]) ? $_COOKIE[$name]: $defaultValue;
	}
	
	static function setCookie($name , $value , $expire=self::COOKIES_EXPIRE , $path='/', $domain=self::COOKIES_DOMAIN)
	{
		$cookieExpire = ($expire ==0) ? 0 : time()+$expire;
		return setcookie($name, $value, $cookieExpire, $path, $domain);
	}
	
	static function createCookies($name , $value , $expire=self::COOKIES_EXPIRE , $path='/', $domain=self::COOKIES_DOMAIN)
	{		
		$cookieExpire = ($expire ==0) ? 0 : time()+$expire;
		return setcookie($name, $value, $cookieExpire, $path, $domain);
	}
	
	static function clearCookies($name , $path='/', $domain=self::COOKIES_DOMAIN)
	{		
		return setcookie($name, 'deleted', time()-365*24*3600, $path, $domain);
	}
	
	static function extendExpireTime($name ,$expire=self::COOKIES_EXPIRE, $path='/', $domain=self::COOKIES_DOMAIN)
	{
		if (isset($_COOKIE[$name]))
		{	
			$value=$_COOKIE[$name];
			self::createCookies($name,$value,$expire,$path,$domain);
			return true;
		}
		return false;
	}
	
}
?>