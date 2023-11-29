<?php
namespace app\views;

use framework\abstract\AbstractTemplateEngine;

class TemplateEngine extends AbstractTemplateEngine
{
    protected $templateDir;

    public function render($template, $data = [])//abstract method
    {
        $templatePath = $this->templateDir . DIRECTORY_SEPARATOR . $template . '.html';

        if (!file_exists($templatePath)) {
            throw new \Exception("Template file not found: $templatePath");
        }

        ob_start();
        extract($data);
        include $templatePath;
        return ob_get_clean();
    }

}
