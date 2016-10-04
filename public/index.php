<?php

require_once '../vendor/autoload.php';

\LoggerDemo\LoggerDemoConfig::init();

\OLOG\Logger\RegisterRoutes::registerRoutes();

\OLOG\Router::processAction(\LoggerDemo\DemoMainPageAction::class, 0);