<?php

require_once '../vendor/autoload.php';

\Config\Config::init();

\OLOG\Logger\RegisterRoutes::registerRoutes();

\OLOG\Router::action(\LoggerDemo\DemoMainPageAction::class, 0);
