<?php

namespace Core;

/**
 * Class Request
 * @package Core
 */
class Request
{
    /**
     * Stores resource name
     * @var string
     */
    private $_controller;

    /**
     * Stores action name
     * @var string
     */
    private $_action;

    /**
     * Stores resource id
     * @var int
     */
    private $_id;

    /**
     * Stores params received from request body
     * @var array
     */
    private $_bodyParams;

    /**
     * Flag which indicates whether current data has valid JSON format
     * @var bool
     */
    private $_isJson;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $urlParts = explode('/', $_SERVER['REQUEST_URI']);
        if (!empty($urlParts[1])) {
            $this->_controller = $urlParts[1];
        }

        $method = $_SERVER['REQUEST_METHOD'];
        $this->_action = strtolower($method);

        if (!empty($urlParts[2])) {
            $this->_id = $urlParts[2];
        }

        $this->_parseBodyParams();
    }

    /**
     * Used to parse bodies for PUT/POST.
     * Sets parsed data into appropriate variable
     */
    private function _parseBodyParams()
    {
        $params = [];

        $body = file_get_contents('php://input');
        $bodyParams = json_decode($body);

        $this->_isJson = json_last_error() === JSON_ERROR_NONE;

        if ($bodyParams) {
            foreach ($bodyParams as $paramName => $paramValue) {
                $paramName = strtolower($paramName);
                $params[$paramName] = $paramValue;
            }
        }

        $this->_bodyParams = $params;
    }

    /**
     * Retrieves current resource name
     * @return string
     */
    public function getController()
    {
        return $this->_controller;
    }

    /**
     * Retrieves current action name
     * @return string
     */
    public function getAction()
    {
        return $this->_action;
    }

    /**
     * Checks if resource id is set
     * @return bool
     */
    public function isIdSet()
    {
        return !empty($this->_id);
    }

    /**
     * Retrieves set resource id
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Retrieved params from body request
     * @return array
     */
    public function getBodyParams()
    {
        return $this->_bodyParams;
    }

    /**
     * Indicates if current request provides data as JSON
     * @return bool
     */
    public function getIsJson()
    {
        return $this->_isJson;
    }
}
