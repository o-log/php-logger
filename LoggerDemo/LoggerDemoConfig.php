<?php

namespace LoggerDemo;

use OLOG\Auth\AuthConfig;
use OLOG\Cache\BucketRedis;
use OLOG\Cache\CacheConfig;
use OLOG\Cache\RedisServer;
use OLOG\DB\ConnectorMySQL;
use OLOG\DB\DBConfig;
use OLOG\DB\Space;
use OLOG\Logger\Entry;
use OLOG\Logger\LoggerConfig;

class LoggerDemoConfig
{
    const CONNECTOR_LOGGERDEMO = 'CONNECTOR_LOGGERDEMO';
    const SPACE_LOGGERDEMO = 'SPACE_LOGGERDEMO';

    static public function init(){
        date_default_timezone_set('Europe/Moscow');
        ini_set('assert.exception', true);

        DBConfig::setConnector(
            self::CONNECTOR_LOGGERDEMO,
            new ConnectorMySQL('127.0.0.1', 'db_phploggerdemo', 'root', '1')
        );

        DBConfig::setSpace(
            AuthConfig::SPACE_PHPAUTH,
            new Space(self::CONNECTOR_LOGGERDEMO, 'vendor/o-log/php-auth/db_phpauth.sql')
        );

        DBConfig::setSpace(
            Entry::DB_ID,
            new Space(self::CONNECTOR_LOGGERDEMO, 'DB_NAME_PHPLOGGER.sql')
        );

        CacheConfig::setBucket(
            '',
            new BucketRedis(
                [new RedisServer('localhost', 6379)]
            )
        );

        AuthConfig::setAdminActionsBaseClassname(LoggerDemoABase::class);
        LoggerConfig::setAdminActionsBaseClassname(LoggerDemoABase::class);
    }
}
