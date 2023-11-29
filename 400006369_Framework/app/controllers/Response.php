<?php
namespace app\controllers;

use framework\abstract\AbstractResponse;

class Response extends AbstractResponse
{
    public function render()
    {
        header('Content-Type: ' . $this->contentType);

        // Output data based on content type
        if ($this->contentType === 'application/json') {
            echo json_encode($this->data);
        } else {
            echo $this->data;
        }
    }
}
