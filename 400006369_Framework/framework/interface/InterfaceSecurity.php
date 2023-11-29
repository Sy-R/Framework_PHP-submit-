<?php

namespace framework\interface;

interface InterfaceSecurity
{
    public static function sanitizeInput($input);

    public static function generateCSRFToken();

    public static function validateCSRFToken($token);

    public static function hashPassword($password);

    public static function enforceHTTPS();

    public static function setSecurityHeaders();
}
