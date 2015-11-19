<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * Cac ham ve field support view
 * 
 * @author      hungtd <tdhungit@gmail.com> 0972014011
 * @copyright   Tran Dinh Hung 2011
 * @package     PenguinFW
 * @subpackage  Helper
 * @version     1.0.0
 */

/**
 * show data to debug
 * 
 * @param string $url 
 * @return array width and heigth
 */
if (!function_exists('get_suit_image_size'))
{
    function get_suit_image_size($image_url, $max_width = "400", $max_height = "400")
    {     
        $image_url = trim($image_url);
       
        $size = getimagesize($image_url);
                
        $width = $size[0];
        $heigth = $size[1];
        
        $scale = (float)($width / $heigth);
        
        //check large than scale
        if($width > $max_width)
        {
            $width = $max_width;
            
            $heigth = (int)($width / $scale);
   
        }
        
        if($heigth > $max_height)
        {
            $heigth = $max_height;
            
            $width = (int)($heigth * $scale);
        }
        
        return array('width' => $width, 'heigth' => $heigth);
    }
}

?>