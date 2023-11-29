<?php

namespace framework;

use framework\interface\InterfaceValidator;

class Validator implements InterfaceValidator
{
    public static function validate($data, $rules)
    {
        $errors = [];

        foreach ($rules as $field => $fieldRules) {
            foreach ($fieldRules as $rule) {
                $errorMessage = static::applyRule($rule, $data[$field] ?? null);

                if ($errorMessage) {
                    $errors[$field] = $errorMessage;
                    break; // Stop validating this field after the first error
                }
            }
        }

        return $errors;
    }

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