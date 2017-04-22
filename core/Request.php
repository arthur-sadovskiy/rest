<?php

namespace Core;

class Request
{
    private $_controller;

    private $_action;

    private $_id;

    private $_bodyParams;

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
     * used to parse bodies for PUT/POST
     */
    private function _parseBodyParams()
    {
        $params = [];

        $body = file_get_contents('php://input');
        $bodyParams = json_decode($body);
        if ($bodyParams) {
            foreach ($bodyParams as $paramName => $paramValue) {
                $params[$paramName] = $paramValue;
            }
        }

        $this->_bodyParams = $params;
    }

    public function getController()
    {
        return $this->_controller;
    }

    public function setController($controller)
    {
        $this->_controller = $controller;
    }

    public function getAction()
    {
        return $this->_action;
    }

    public function setAction($action)
    {
        $this->_action = $action;
    }

    public function isIdSet()
    {
        return !empty($this->_id);
    }

    public function getId()
    {
        return $this->_id;
    }

    public function getBodyParams()
    {
        return $this->_bodyParams;
    }
}
