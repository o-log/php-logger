<?php

namespace LoggerDemo;

use OLOG\Auth\AuthConfig;
use OLOG\Auth\AuthConstants;
use OLOG\DB\DBConfig;
use OLOG\DB\DBSettings;
use OLOG\Logger\LoggerConstants;

class LoggerDemoConfig
{
    static public function init(){
        date_default_timezone_set('Europe/Moscow');

        AuthConfig::setFullAccessCookieName('shdfgklsdgf');

        DBConfig::setDBSettingsObj(
            AuthConstants::DB_NAME_PHPAUTH,
            new DBSettings('localhost', 'db_phploggerdemo', 'root', 1, 'vendor/o-log/php-auth/db_phpauth.sql')
        );
        DBConfig::setDBSettingsObj(
            LoggerConstants::DB_NAME_PHPLOGGER,
            new DBSettings('localhost', 'db_phploggerdemo', 'root', 1)
        );
    }
}