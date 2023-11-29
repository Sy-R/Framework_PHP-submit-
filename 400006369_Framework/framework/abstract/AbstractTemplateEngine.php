<?php
namespace framework\abstract;

use framework\interface\InterfaceTemplateEngine;

abstract class AbstractTemplateEngine implements InterfaceTemplateEngine
{
    protected $templateDir;

    public function __construct($templateDir)
    {
        $this->templateDir = $templateDir;
    }

   abstract public function render($template, $data = []);
}
