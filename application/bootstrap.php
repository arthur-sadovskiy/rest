<?php

spl_autoload_register(function($className) {
    $namespaces = self::$_config['namespaces'];
    $classNameParts = explode('\\', $className);

    if (isset($namespaces[$classNameParts[0]])) {
        $classNameParts[0] = $namespaces[$classNameParts[0]];
    }

    $lastPartName = array_pop($classNameParts);
    foreach ($classNameParts as &$classNamePart) {
        $classNamePart = lcfirst($classNamePart);
    }

    $className = implode('/', $classNameParts) . '/' . $lastPartName;

    if (is_readable("../{$className}.php")) {
        require_once "../{$className}.php";
    }
});
