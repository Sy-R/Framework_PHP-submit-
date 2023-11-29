<?php

namespace framework\interface;

interface InterfaceAuthentication
{

    public function logout();

    public function isAuthenticated($key);

    public function getCurrentUser($key);

    public static function verifyPassword($password, $hashedPassword);
}
