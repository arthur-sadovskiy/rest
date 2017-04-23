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

    public function helpGetAction()
    {
        $data = ['message' => 'Correct format for GET'];

        return new JsonView($data);
    }

    public function helpPostAction()
    {
        $data = ['message' => 'Correct format for POST'];

        return new JsonView($data);
    }
}
