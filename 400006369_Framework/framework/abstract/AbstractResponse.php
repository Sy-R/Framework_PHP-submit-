<?php

namespace framework\abstract;

use framework\interface\InterfaceResponse;

abstract class AbstractResponse implements InterfaceResponse
{
    protected $data = [];
    protected $contentType = 'text/html'; // Default content type

    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    abstract public function render();
}
