<?php
namespace app\views;

use framework\abstract\AbstractFormGenerator;

class FormGenerator extends AbstractFormGenerator
{

    public static function generateFormField($field)
    {
        $content = $field['content']??'';
        $type = $field['type']??'';
        $label = $field['label'] ?? '';
        $name = $field['name'] ?? '';
        $id = $field['id'] ?? '';
        $class = $field['class'] ?? '';
        $value = $field['value'] ?? '';
        $options = $field['options'] ?? [];
        $url = $field['url'] ?? '#';

        $html = "<label for='$name'>$label</label>";
        switch ($type) {
            case 'heading1':
                $html .= "<h1>$content</h1>";
                break;
                
            case 'heading2':
                $html .= "<h2>$content</h2>";
                break;

            case 'heading3':
                $html .= "<h3>$content</h3>";
                break;

            case 'paragraph':
                $html.= "<p id='$id'>$content</p>";
                break;

            case 'link':
                $html .= "<a href='$url'>$value</a>";
                break;

            case 'paralink':
                $html .= "<p>$content <a href='$url'>$value</a></p>";
                break;

            case 'text':
                $html .= "<input type='text' id='$id' name='$name' value='$value'>";
                break;

            case 'textarea':
                $html .= "<textarea id='$id' name='$name'>$value</textarea>";
                break;

            case 'submit':
                $html .= "<button type='submit' class ='$class'> $value</button>";
                break;

            case 'select':
                $html .= "<select id='$id' name='$name'>";
                foreach ($options as $optionValue => $optionLabel) {
                    $selected = ($optionValue == $value) ? "selected" : "";
                    $html .= "<option value='$optionValue' $selected>$optionLabel</option>";
                }
                $html .= "</select>";
                break;

            // Add more field types as needed
        }

        return $html;
    }
}
