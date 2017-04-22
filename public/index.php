<?php

use Core\Application;

require_once '../core/Application.php';

$config = require_once '../application/config/application.php';

(new Application($config))->bootstrap()->run();
