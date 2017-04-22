<?php

namespace Core;

class Application
{
    private static $_config = [];

    public function __construct(array $config)
    {
        self::$_config = $config;
    }

    public static function getConfig()
    {
        return self::$_config;
    }

    public function bootstrap()
    {
        require_once self::$_config['paths']['bootstrapFile'];

        return $this;
    }

    public function run()
    {
        $request = (new Router())->route();

        $controllerName = ucfirst(strtolower($request->getController()));
        $controllerClass = "Application\\Controllers\\{$controllerName}Controller";
        $action = $request->getAction() . 'Action';

        if (class_exists($controllerClass)) {
            $controller = new $controllerClass($request);
        }

        if (is_callable([$controller, $action])) {
            $view = $controller->$action();
            $view->render();
        }
    }
}
