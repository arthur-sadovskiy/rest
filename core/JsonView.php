<?php

namespace Core;

/**
 * Class JsonView
 * @package Core
 */
class JsonView
{
    /**
     * Stores data which will be sent to the client
     * @var array
     */
    private $_data = [];

    /**
     * Flag which indicates whether request page was found or not
     * @var bool
     */
    private $_isNotFound = false;

    /**
     * Flag which indicates a bad request from the client
     * @var bool
     */
    private $_isBadRequest = false;

    /**
     * Flag which indicates a successful creation of the new item
     * @var bool
     */
    private $_isCreated = false;

    /**
     * Stores location of newly creation item
     * @var string
     */
    private $_location = '';

    /**
     * JsonView constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->_data = $data;
    }

    /**
     * Sends response to the client with appropriate headers
     */
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

    /**
     * Sets 'not found' flag
     * @param bool $isNotFound
     */
    public function setIsNotFound($isNotFound)
    {
        $this->_isNotFound = $isNotFound;
    }

    /**
     * Sets 'bad request' flag
     * @param bool $isBadRequest
     */
    public function setIsBadRequest($isBadRequest)
    {
        $this->_isBadRequest = $isBadRequest;
    }

    /**
     * Sets 'is created' flag
     * @param bool $isCreated
     */
    public function setIsCreated($isCreated)
    {
        $this->_isCreated = $isCreated;
    }

    /**
     * Sets location
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->_location = $location;
    }
}
