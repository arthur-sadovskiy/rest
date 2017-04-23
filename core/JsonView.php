<?php

namespace Core;

class JsonView
{
    private $_data = [];

    private $_isNotFound = false;

    private $_isBadRequest = false;

    private $_isCreated = false;

    private $_location = '';

    public function __construct(array $data)
    {
        $this->_data = $data;
    }

    public function render()
    {
        if ($this->_isNotFound) {
            header('HTTP/1.1 404 Not Found');
        } elseif ($this->_isBadRequest) {
            header('HTTP/1.1 400 Bad Request');
        } elseif ($this->_isCreated && !empty($this->_location)) {
            header('HTTP/1.1 201 Created');
            header('Location: ' . $this->_location);
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

    public function setIsBadRequest($isBadRequest)
    {
        $this->_isBadRequest = $isBadRequest;
    }

    public function setIsCreated($isCreated)
    {
        $this->_isCreated = $isCreated;
    }

    public function setLocation($location)
    {
        $this->_location = $location;
    }
}
