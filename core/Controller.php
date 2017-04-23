<?php

namespace Core;

class Controller
{
    protected $_request;

    public function __construct(Request $request)
    {
        $this->_request = $request;
    }

    /*** Block with helper methods ***/

    public function getAvailableResources()
    {
        $data = ['error' => "For now only 'addresses' resource is supported"];
        $view = new JsonView($data);
        $view->setIsBadRequest(true);

        return $view;
    }

    public function getAvailableActions()
    {
        $data = ['error' => "For now only 'GET, POST, PATCH, DELETE' actions are supported"];
        $view = new JsonView($data);
        $view->setIsBadRequest(true);

        return $view;
    }
}
