<?php

namespace LoggerDemo;

use OLOG\DB\DBConfig;
use OLOG\DB\DBSettings;
use OLOG\Logger\LoggerConstants;

class LoggerDemoConfig
{
    static public function init(){
        date_default_timezone_set('Europe/Moscow');

        DBConfig::setDBSettingsObj(
            LoggerConstants::DB_NAME_PHPLOGGER,
            new DBSettings('localhost', 'db_phploggerdemo', 'root', 1)
        );
    }
}