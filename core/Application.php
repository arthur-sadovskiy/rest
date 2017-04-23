<?php

namespace Core;

/**
 * Class Application
 * @package Core
 */
class Application
{
    /**
     * Stores application config
     * @var array
     */
    private static $_config = [];

    /**
     * Application constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        self::$_config = $config;
    }

    /**
     * Returns app config
     * @return array
     */
    public static function getConfig()
    {
        return self::$_config;
    }

    /**
     * Includes files with autoload
     * @return $this
     */
    public function bootstrap()
    {
        require_once self::$_config['paths']['bootstrapFile'];

        return $this;
    }

    /**
     * Starts application.
     * Creates needed controller and calls appropriate action.
     */
    public function run()
    {
        $request = (new Router())->route();

        $controllerName = ucfirst(strtolower($request->getController()));
        $controllerClass = "Application\\Controllers\\{$controllerName}Controller";
        $action = $request->getAction() . 'Action';

        if (class_exists($controllerClass)) {
            $controller = new $controllerClass($request);
        } else {
            $controller = new Controller($request);
            $action = 'getAvailableResources';
        }

        if (is_callable([$controller, $action])) {
            $view = $controller->$action();
            $view->render();
        } else {
            $action = 'getAvailableActions';
            $view = $controller->$action();
            $view->render();
        }
    }
}
