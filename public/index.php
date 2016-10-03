<?php

require_once '../vendor/autoload.php';

\LoggerDemo\LoggerDemoConfig::init();

\OLOG\Router::processAction(\LoggerDemo\DemoMainPageAction::class);