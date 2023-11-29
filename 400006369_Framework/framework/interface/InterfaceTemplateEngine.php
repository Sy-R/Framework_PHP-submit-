<?php

namespace framework\interface;

interface InterfaceTemplateEngine
{
    public function __construct($templateDir);

    public function render($template, $data = []);
}
