<?php

namespace Core;

/**
 * Class Router
 * @package Core
 */
class Router
{
    /**
     * Application router
     * @return Request
     */
    public function route()
    {
        return new Request();
    }
}
