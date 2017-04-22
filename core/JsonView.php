<?php

namespace Core;

class JsonView
{
    private $_data = [];

    public function __construct(array $data)
    {
        $this->_data = $data;
    }

    public function render()
    {
        header('Content-type: application/json');
        echo json_encode($this->_data);
    }
}
