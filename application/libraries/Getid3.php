<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(FPENGUIN . APPPATH . 'third_party/getid3/getid3.php'); 

class CI_GetID3
{
    private $getID3;

    function __construct()
    {
        $this->getID3 = new getID3();
    }
    
    /**
     * Get time audio 
     * 
     * ['playtime_seconds']
     * ['bitrate'] / 1000
     */
    public function getTime($file_path)
    {
        $ThisFileInfo = $this->getID3->analyze($file_path); 
        getid3_lib::CopyTagsToComments($ThisFileInfo); 
        
        return @$ThisFileInfo;
    }
    
}