<?php

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Helper Hash Password
 * 
 * @package PenguinFW
 * @subpackage User
 * @version 1.0.0
 */

class HashPasswd
{
    /**
     * Hash password
     * 
     * @param string $passwd need hash
     * @return string password hashed
     */
    public function Hash($passwd)
    {
        $hash_string = config_item('penguin_hash');
        
        return md5(md5($passwd).md5($hash_string));
    }
    
    /**
     * So sánh password
     * @param string $password password lấy từ database
     * @param string $password_type password user gõ vào chưa hash
     * @return bool
     */
    public function CheckPassword($password, $password_type = null)
    {
        if (!$password_type) return FALSE;
        
        $password_hash = $this->Hash($password_type);
        
        return $password_hash == $password;
    }
}

?>
