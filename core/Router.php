<?php

namespace Core;

class Router
{
    public function route()
    {
        $config = Application::getConfig();
        $request = new Request();

        if (empty($request->getController())) {
            $request->setController($config['routes']['defaultController']);

            $oldAction = $request->getAction();
            $helpAction = $config['routes']['defaultAction'] . ucfirst($oldAction);
            $request->setAction($helpAction);
        }

        return $request;
    }
}
