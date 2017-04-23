<?php

namespace Core;

/**
 * Class Controller
 * @package Core
 */
class Controller
{
    /**
     * Stores instance of request
     * @var Request
     */
    protected $_request;

    /**
     * Controller constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->_request = $request;
    }

    /*** Block with helper methods ***/

    /**
     * Returns error message when non-existing resource is requested
     * @return JsonView
     */
    public function getAvailableResources()
    {
        $data = ['error' => "For now only 'addresses' resource is supported"];
        $view = new JsonView($data);
        $view->setIsBadRequest(true);

        return $view;
    }

    /**
     * Returns error message when non-supported action is called
     * @return JsonView
     */
    public function getAvailableActions()
    {
        $data = ['error' => "For now only 'GET, POST, PATCH, DELETE' actions are supported"];
        $view = new JsonView($data);
        $view->setIsBadRequest(true);

        return $view;
    }
}
