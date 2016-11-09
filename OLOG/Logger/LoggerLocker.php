<?php

namespace OLOG\Logger;

class LoggerLocker
{
    private static  $locked_objects_arr = [];

    public static function lock($object_name)
    {
        if (self::isLocked($object_name)){
            return false;
        }
        self::$locked_objects_arr[$object_name] = true;
        return true;
    }

    public static function isLocked($object_name)
    {
        return array_key_exists($object_name, self::$locked_objects_arr);
    }

    public static function unlock($object_name)
    {
        unset(self::$locked_objects_arr[$object_name]);
    }

}