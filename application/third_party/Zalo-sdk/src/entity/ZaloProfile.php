<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace common;

class ZaloProfile {
    
    private $userId;
    private $displayName;
    private $userGender;
    private $avatar;

    public function __construct() {
        
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }
    
    function getUserId() {
        return $this->userId;
    }
    
    function setDisplayName($displayName) {
        $this->displayName = $displayName;
    }
    
    function getDisplayName() {
        return $this->displayName;
    }

    function setUserGender($userGender) {
        $this->userGender = $userGender;
    }

    function getUserGender() {
        return $this->userGender;
    }

    function setAvatar($avatar) {
        $this->avatar = $avatar;
    }

    function getAvatar() {
        return $this->avatar;
    }
}

?>