<?php

namespace framework;

use framework\interface\InterfaceSession;


class Session implements InterfaceSession
{
    private static $instance;

    private function __construct()
    {
        
    }

    public static function getInstance()
    {
        if(!self::$instance){
            self::$instance = new self();
            self::$instance->start();
        }
        return self::$instance;
    }

    public function start()
{
    if (session_status() === PHP_SESSION_NONE) {
        if (session_start() === false) {
            //echo "Session start failed"; //log error
            return false;
        }
        return true;
    }
}

public function sessionStatus()
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function getSession($key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    public function remove($key)
    {
        unset($_SESSION[$key]);
    }

    public function destroy()
    {
        session_destroy();
    }

    public function unset_destroy()
    {
        session_destroy();
        session_unset();
    }
}
