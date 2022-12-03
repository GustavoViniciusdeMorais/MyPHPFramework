<?php

namespace Gustavovinicius\Mkfig\Renderer;

use Exception;

class PHPRenderer implements PHPRenderInterface
{
    private $data;

    public function setData($data)
    {
        $this->data = $data;
    }
    
    public function run()
    {
        if (is_string($this->data)) {
            header('Content-type:text/html; charset=UTF-8');
            echo $this->data;
            exit;
        }

        if (is_array($this->data)) {
            header('Content-type: aplication/json');
            echo json_encode($this->data);
            exit;
        }

        throw Exception("Route return is invalid");
    }
}
