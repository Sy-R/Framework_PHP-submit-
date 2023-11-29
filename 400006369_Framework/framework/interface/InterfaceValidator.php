<?php

namespace framework\interface;

interface InterfaceValidator
{
    public static function validate($data, $rules);

    public static function applyRule($rule, $value);

    public static function containsUppercase($value);

    public static function containsDigit($value);

    public static function validateLength($value, $minLength = null, $maxLength = null);
}