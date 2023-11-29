<?php

namespace framework\interface;

interface InterfaceResponse
{
    public function setContentType($contentType);

    public function setData($data);

    public function render();
}
