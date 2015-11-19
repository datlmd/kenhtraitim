<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function purify($dirty_html)
{

     if (is_array($dirty_html))
    {
        foreach ($dirty_html as $key => $val)
        {
            $dirty_html[$key] = purify($val);
        }

        return $dirty_html;
    }

    if (trim($dirty_html) === '')
    {
        return $dirty_html;
    }

    require_once(APPPATH."third_party/htmlpurifier/library/HTMLPurifier.auto.php"); 
    require_once(APPPATH."third_party/htmlpurifier/library/HTMLPurifier.func.php");

    $config = HTMLPurifier_Config::createDefault();
	
    $CI = & get_instance();
    // load config in config folder
    $CI->config->load('htmlpurifier', TRUE, TRUE);
    $configs = $CI->config->item('htmlpurifier');
    if ($configs) {
    	foreach ($configs as $key => $conf) {
    		$config->set($key, $conf);
    	}
    }

    return HTMLPurifier($dirty_html, $config);

}
?>