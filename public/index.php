<?php

require_once '../vendor/autoload.php';

LoggerDemo\LoggerDemoConfig::init();

\OLOG\Logger\RegisterRoutes::registerRoutes();
\OLOG\Auth\RegisterRoutes::registerRoutes();

\OLOG\Router::action(\LoggerDemo\DemoMainPageAction::class, 0);
