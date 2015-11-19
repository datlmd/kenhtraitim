<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * Các hàm về field support video
 * 
 * @author      hungtd <tdhungit@gmail.com> 0972014011
 * @copyright   Tran Dinh Hung 2011
 * @package     PenguinFW
 * @subpackage  Helper
 * @version     1.0.0
 */

/**
 * get Thumbnail video
 * 
 * @param string $video_path 
 * @param string $fromdurasec
 */
if (!function_exists('video_thumb'))
{
    function video_thumb($video_path, $uri_img, $fromdurasec = 30)
    {
        if (config_item('penguin_system') == 'Windows')
        {
            $ffmpegpath = FPENGUIN . APPPATH . 'third_party/ffmpeg/ffmpeg.exe';
        } else 
        {
            $ffmpegpath = 'ffmpeg';
        }
                            
        if(!file_exists($video_path))
        {
            return FALSE;
        }

        $folder_path = get_folder_upload($uri_img);
  
        $img_name = '/' . md5(time()) . '.jpg';

        $img_path = $folder_path['dir'] . $img_name;

        $command = "$ffmpegpath -i $video_path -ss $fromdurasec -vcodec mjpeg -vframes 1 -an -f rawvideo $img_path";

        @exec( $command, $ret );

        if(!file_exists($img_path))
        {
            return FALSE;
        }

        if(filesize($img_path) == 0)
        {
            return FALSE;
        }

        return $folder_path['sub_dir'] . $img_name;
    }
}