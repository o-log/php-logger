<?php

class LoggerLocker
{
    private static  $locked_objects_arr = [];

    public static function lock($object_name)
    {
        if ( (array_key_exists(self::$locked_objects_arr, $object_name))){
            return false;
        }
        self::$locked_objects_arr[$object_name] = true;
        return true;
    }

    public static function unlock($object_name)
    {
        unset(self::$locked_objects_arr[$object_name]);
    }

}