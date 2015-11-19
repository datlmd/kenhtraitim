<?php
//getrealIP
function getRealIp() {
	if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { 
		// case 1.A: proxy && HTTP_X_FORWARDED_FOR is defined
		$array = extractIP($_SERVER['HTTP_X_FORWARDED_FOR']);
		if ($array && count($array) >= 1) {
			return $array[0]; // first IP in the list
		}
	}
	if(isset($_SERVER['HTTP_X_FORWARDED'])) { 
		// case 1.B: proxy && HTTP_X_FORWARDED is defined
		$array = extractIP($_SERVER['HTTP_X_FORWARDED']);
		if ($array && count($array) >= 1) {
			return $array[0]; // first IP in the list
		}
	}
	if(isset($_SERVER['HTTP_FORWARDED_FOR'])) { 
		// case 1.C: proxy && HTTP_FORWARDED_FOR is defined
		$array = extractIP($_SERVER['HTTP_FORWARDED_FOR']);
		if ($array && count($array) >= 1) {
			return $array[0]; // first IP in the list
		}
	}
	if(isset($_SERVER['HTTP_FORWARDED'])) { 
		// case 1.D: proxy && HTTP_FORWARDED is defined
		$array = extractIP($_SERVER['HTTP_FORWARDED']);
		if ($array && count($array) >= 1) {
			return $array[0]; // first IP in the list
		}
	}
	if(isset($_SERVER['HTTP_CLIENT_IP'])) { 
		// case 1.E: proxy && HTTP_CLIENT_IP is defined
		$array = extractIP($_SERVER['HTTP_CLIENT_IP']);
		if ($array && count($array) >= 1) {
			return $array[0]; // first IP in the list
		}
	}
	
	if(isset($_SERVER['HTTP_VIA'])) {
		// case 2: 
		// proxy && HTTP_(X_) FORWARDED (_FOR) not defined && HTTP_VIA defined
		// other exotic variables may be defined 
		return ( $_SERVER['HTTP_VIA']. 
			'_' . $_SERVER['HTTP_X_COMING_FROM'].
			'_' . $_SERVER['HTTP_COMING_FROM']
			);
	}
	if(isset($_SERVER['HTTP_X_COMING_FROM']) || isset($_SERVER['HTTP_COMING_FROM']) ) {
		// case 3: proxy && only exotic variables defined
		// the exotic variables are not enough, we add the REMOTE_ADDR of the proxy
		return ( $_SERVER['REMOTE_ADDR'] . 
			'_' . $_SERVER['HTTP_X_COMING_FROM'] .
			'_' . $_SERVER['HTTP_COMING_FROM']
		  );
	}
	// case 4: no proxy (or tricky case: proxy+refresh)
	if(isset($_SERVER['REMOTE_HOST'])) {
		$array = extractIP($_SERVER['REMOTE_HOST']);
		if ($array && count($array) >= 1) {
			return $array[0]; // first IP in the list
		}
	}
	return $_SERVER['REMOTE_ADDR'];
}	
function extractIP($ip) {
	if (ereg ("^([0-9]{1,3}\.){3,3}[0-9]{1,3}", $ip, $array))
			return $array;
	else
			return false;
}
?>
