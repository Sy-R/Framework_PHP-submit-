<?php
namespace app\views;

use framework\abstract\AbstractValidator;

class Validator extends AbstractValidator
{

    public static function applyRule($rule, $value)
    {
        switch ($rule) {
            case 'required':
                return empty($value) ? 'Field(s) required' : null;
            case 'email':
                return filter_var($value, FILTER_VALIDATE_EMAIL) === false ? 'Invalid Email' : null;
            // Add more validation rules as needed
        }

        return null; // No error
    }


    public static function containsUppercase($value)
    {
        return preg_match('/[A-Z]/', $value) === 1;
    }

    public static function containsDigit($value)
    {
        return preg_match('/\d/', $value) === 1;
    }

    public static function validateLength($value, $minLength = null, $maxLength = null)
    {
        $length = strlen($value);

        if ($minLength !== null && $length < $minLength) {
            return "Length must be at least $minLength characters";
        }

        if ($maxLength !== null && $length > $maxLength) {
            return "Length must be at most $maxLength characters";
        }

        return null;
    }
}

