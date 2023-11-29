<?php

namespace framework\abstract;

use framework\interface\InterfaceAuthentication;

abstract class AbstractAuthentication implements InterfaceAuthentication
{    

    abstract public function logout();

    abstract public function isAuthenticated($key);
    
    abstract public function getCurrentUser($key);

     
    public static function verifyPassword($password, $hashedPassword) {
        // Verify the password against the hashed password
        return password_verify($password, $hashedPassword);
    }

}