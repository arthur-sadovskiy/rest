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
