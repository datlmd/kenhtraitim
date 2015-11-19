<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_upload
 * ...
 * 
 * @package PenguinFW
 * @subpackage Music
 * @version 1.0.0
 */
 
class Admin_upload extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Music';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('musics', lang_web());
            
        $this->load->model('Music');
    }
    
    /**
     * Add Avatar 
     */
    public function avatar()
    {
        // set permission
        if (!$this->isACL('w'))
        {
            echo lang('You can not access allow');
            exit();
        }
        
        // set layout
        $this->layout->set_layout('empty');
        
        // upload
        $upload = upload_file('file_name_avatar', 'images', config_item('musics_image_type'), config_item('musics_image_size'));
        
        if ($upload['error'] == 1)
        {            
            echo $upload['message'];
            exit();
        } else
        {            
            $file = $upload['file'];
            
            create_thumb($file['full_path']);
            
            echo '##SUCCESS##'. $upload['sort_link'];
            exit();
        }
    }
    
    /**
     * Add Audio 
     */
    public function audio()
    {
        // set layout
        $this->layout->set_layout('xml');
        
        $xml = '';
        
        // set permission
        if (!$this->isACL('w'))
        {
            $xml .= '<status>0</status>';
            $xml .= '<message></message>';
        } else 
        {        
            // lib
            $this->load->library('Getid3');

            // upload
            $upload = upload_file('file_name_audio', 'musics', config_item('musics_audio_type'), config_item('musics_audio_size'));                

            if ($upload['error'] == 1)
            {            
                $xml .= '<status>1</status>';
                $xml .= '<message>' . $upload['message'] . '</message>';
            } else
            {   
                $file = $upload['file'];
                $file_info = $this->getid3->getTime($file['full_path']);

                $xml .= '<status>0</status>';
                $xml .= '<message></message>';
                $xml .= '<file>' . $upload['sort_link'] . '</file>';
                $xml .= '<length>' . $file_info['playtime_seconds'] . '</length>';            
                $xml .= '<bitrate>' . ($file_info['bitrate']/1000) . '</bitrate>';            
            }
        }
        
        $data = array(
            'xml' => $xml
        );
        
        $this->load->view('xml/admin_upload/audio', $data);
    }
    
    /**
     * Add Video 
     */
    public function video()
    {
        // set layout
        $this->layout->set_layout('xml');
        $xml = '';
        
        // set permission
        if (!$this->isACL('w'))
        {
            $xml .= '<status>0</status>';
            $xml .= '<message></message>';
        } else
        {        
            // lib
            $this->load->helper('ffmpeg');
            $this->load->library('Getid3');

            //video_thumb('D:/Proj/PenguinFW/media/videos/Wildlife.wmv', 'images/musics');
            // upload
            $upload = upload_file('file_name_video', 'videos', config_item('musics_video_type'), config_item('musics_video_size'));                

            if ($upload['error'] == 1)
            {            
                $xml .= '<status>1</status>';
                $xml .= '<message>' . $upload['message'] . '</message>';
            } else
            {   
                $file = $upload['file'];                        

                $file_info = $this->getid3->getTime($file['full_path']);

                $avatar_uri = video_thumb($file['full_path'], 'images', 20);

                $xml .= '<status>0</status>';
                $xml .= '<message></message>';
                $xml .= '<file>' . $upload['sort_link'] . '</file>';
                $xml .= '<avatar>' . $avatar_uri . '</avatar>';
                $xml .= '<length>' . $file_info['playtime_seconds'] . '</length>';
                $xml .= '<bitrate>' . ($file_info['bitrate']/1000) . '</bitrate>';

                create_thumb(FPENGUIN . 'media/images/' . $avatar_uri);
            }
        }
        
        $data = array(
            'xml' => $xml
        );
        
        $this->load->view('xml/admin_upload/video', $data);
    }
    
    /**
     * add exel file
     * file_import
     */
    public function file_import()
    {
        // set permission
        if (!$this->isACL('w'))
        {
            echo lang('You can not access allow');
            exit();
        }
        
        // set layout
        $this->layout->set_layout('empty');
        
        // upload
        $upload = upload_file('file_name_import', 'uploads', 'xls', 2000);
        
        if ($upload['error'] == 1)
        {            
            echo $upload['message'];
            exit();
        } else
        {            
            $file = $upload['file'];                        
            
            echo '##SUCCESS##'. $upload['sort_link'];
            exit();
        }
    }
}
                
?>