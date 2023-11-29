<?php
namespace app\controllers;

use framework\Session;
use framework\abstract\AbstractAuthentication;

class Authentication extends AbstractAuthentication
{
    private $session;

    public function __construct()
    {
        $this->session = Session::getInstance(); 
    }

    public function logout()
    {
        $this->session->unset_destroy();
    }

    public function isAuthenticated($key)
    {
        return $this->session->getSession($key);
    }

    public function getCurrentUser($key)
    {
        return $this->isAuthenticated($key) ? [
            'id' => $this->session->getSession('user_id'),
            'username' => $this->session->getSession('username')
        ] : null;
    }
}
