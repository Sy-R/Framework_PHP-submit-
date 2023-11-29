<?php

namespace framework\abstract;

use framework\interface\InterfaceFormGenerator;

abstract class AbstractFormGenerator implements InterfaceFormGenerator
{
    public static function generateForm($action, $method, $fields, $formAttributes = [])
    {
        $form = "<form action='" . htmlspecialchars($action, ENT_QUOTES) . "' method='" . htmlspecialchars($method, ENT_QUOTES) . "'";

        foreach ($formAttributes as $attribute => $value) {
            $form .= " $attribute='" . htmlspecialchars($value, ENT_QUOTES) . "'";
        }
        $form .= ">";


        foreach ($fields as $field) {
            $form .= static::generateFormField($field);
        }

        $form .= "</form>";

        return $form;
    }

    abstract public static function generateFormField($field);

}