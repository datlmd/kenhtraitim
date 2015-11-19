<?php

/**
 * hungtd
 * administrator page
 */

class Administrator extends MY_Controller
{
    public function index()
    {
        redirect('users/admin_users/login');
    }
}