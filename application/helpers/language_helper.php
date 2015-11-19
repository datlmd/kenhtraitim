<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
// ------------------------------------------------------------------------

/**
 * CodeIgniter Language Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/language_helper.html
 */
// ------------------------------------------------------------------------

/**
 * Lang
 * @author dungdv3
 * Fetches a language variable and optionally outputs a form label
 *
 * @access	public
 * @param	string	the language line
 * @param	string	the id of the form element
 * @return	string
 */
if (!function_exists('lang')) {

    function lang($line, $id = '') {
        // @hungtd        
        $default = $line;
        $line = make_slug($line, TRUE);
        $line = strtolower($line);

        /* @var $CI MY_Model */
        $CI = & get_instance();
        $line = $CI->lang->line($line);

        // @hungtd
        if (!$line) {
            if (config_item('system_auto_insert_lang') == 1) {

                $language = get_cookie('pg_lang_web_value');
                $query_lang = $CI->db->query(sprintf("SELECT * FROM languages WHERE code = '%s'", (lang_web())));

                if ($query_lang->num_rows() == 0) {
                    return $default;
                }
                $lang = $query_lang->row();

                $sql = sprintf("SELECT * FROM translations WHERE `key` = '%s' AND lang_id = %d", addslashes($default), $lang->id);
                $query = $CI->db->query($sql);

                if ($query->num_rows() == 0) {
                    $sql_ins = "
                                INSERT INTO translations (`created`, `modified`, `key`, `value`, `lang_id`, `module_id`)
                                VALUES (NOW(), NOW(), '%s', '%s', %d, -1)
                            ";
                    $CI->db->query(sprintf($sql_ins, addslashes($default), addslashes($default), $lang->id));
                }
            }

            return $default;
        }

        if ($id != '') {
            $line = '<label for="' . $id . '">' . $line . "</label>";
        }

        return $line;
    }

}

// ------------------------------------------------------------------------
/* End of file language_helper.php */
/* Location: ./system/helpers/language_helper.php */