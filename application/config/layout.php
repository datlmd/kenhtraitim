<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| LAYOUT CONFIG
| -------------------------------------------------------------------
| This file will contain the settings needed to parse a layout.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['active'] 			TRUE/FALSE - Enables/disables layout templates
|	['clean_output'] 	In layout parsing, should all whitespace be removed
|	['layout_dir'] 		The path relative to the aplication for the layout folder
|	['layout'] 			The default layout file
|	['layout_var'] 		The variable name in the layout file to replace
|
*/

$config['active']               = TRUE;
$config['clean_output']         = FALSE;
$config['layout_dir']           = 'views/' . theme_web() . '/layouts/';
$config['layout']               = 'default';
$config['layout_var']           = 'MainContent';
$config['layout_title']         = 'MainTitle';
$config['layout_keyword']       = 'MainKeyword';
$config['layout_description']   = 'MainDescription';

/* End of file layout.php */
/* Location: ./application/config/layout.php */