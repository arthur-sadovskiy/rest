<?php

namespace Core;

class JsonView
{
    private $_data = [];

    private $_isNotFound = false;

    public function __construct(array $data)
    {
        $this->_data = $data;
    }

    public function render()
    {
        if ($this->_isNotFound) {
            header('HTTP/1.1 404 Not Found');
        }

        if (!empty($this->_data)) {
            header('Content-type: application/json');
            echo json_encode($this->_data);
        }
    }

    public function setIsNotFound($isNotFound)
    {
        $this->_isNotFound = $isNotFound;
    }
}
