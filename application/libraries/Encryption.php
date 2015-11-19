<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hoanhk
 * Date: 5/15/12
 * Time: 2:26 PM
 * To change this template use File | Settings | File Templates.
 */
class Encryption
{
    public $key = 'penguin2012';

    function encode($data){
        $result = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($this->key), $data, MCRYPT_MODE_CBC, md5(md5($this->key))));
        return $result;
    }

    function  decode($data){
        $result = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($this->key), base64_decode($data), MCRYPT_MODE_CBC, md5(md5($this->key))), "\0");
        return $result;
    }
}