<?php

namespace framework\abstract;

use framework\interface\InterfaceSecurity;

abstract class AbstractSecurity implements InterfaceSecurity
{
    public static function sanitizeInput($input) {
        // Check if input is a string
        if (!is_string($input)) {
            // Log or handle the error
            trigger_error("Input must be a string");
            return false;
        }

        return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    }

    public static function enforceHTTPS() {
        // Check if the request is already using HTTPS
        if ($_SERVER['HTTPS'] !== 'on') {
            // Redirect to the same URL with HTTPS
            $url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            header('Location: ' . $url);
            exit();
        }
    }

    public static function setSecurityHeaders() {
        // Set security-related HTTP headers
        header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: DENY');
        header('X-XSS-Protection: 1; mode=block');
    }
    
    abstract public static function generateCSRFToken();

    abstract public static function validateCSRFToken($token);

    abstract public static function hashPassword($password);
}