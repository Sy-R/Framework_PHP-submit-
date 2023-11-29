<?php
 
namespace framework\interface;

interface InterfaceFormGenerator
{
    public static function generateForm($action, $method, $fields, $formAttributes = []);

    public static function generateFormField($field);
}
