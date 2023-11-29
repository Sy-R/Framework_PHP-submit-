<?php
namespace app\controllers;

use framework\abstract\AbstractSecurity;

class Security extends AbstractSecurity
{

    public static function generateCSRFToken() {
        // Generate a random token
        $token = bin2hex(random_bytes(32));

        // Store the token in the session
        $_SESSION['csrf_token'] = $token;

        return $token;
    }

    public static function validateCSRFToken($token) {
        // Check if the session token is set
        if (!isset($_SESSION['csrf_token'])) {
            // Log or handle the error
            trigger_error("Invalid CSRF token");
            return false;
        }

        // Use hash_equals to compare tokens in a timing-attack resistant manner
        return hash_equals($_SESSION['csrf_token'], $token);
    }

    public static function hashPassword($password) {
        // Hash the password using bcrypt
        return password_hash($password, PASSWORD_BCRYPT);
    }


}
