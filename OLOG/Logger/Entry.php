<?php

namespace OLOG\Logger;

use OLOG\Auth\Auth;
use OLOG\FullObjectId;

class Entry implements
    \OLOG\Model\InterfaceFactory,
    \OLOG\Model\InterfaceLoad,
    \OLOG\Model\InterfaceSave,
    \OLOG\Model\InterfaceDelete
{
    use \OLOG\Model\FactoryTrait;
    use \OLOG\Model\ActiveRecordTrait;
    use \OLOG\Model\ProtectPropertiesTrait;

    const DB_ID = 'DB_NAME_PHPLOGGER';
    const DB_TABLE_NAME = 'olog_logger_entry';

    protected $created_at_ts; // initialized by constructor
    protected $user_fullid;
    protected $object_fullid;
    protected $serialized_object;
    protected $user_ip;
    protected $comment;
    protected $id;

    public function getComment(){
        return $this->comment;
    }

    public function setComment($value){
        $this->comment = $value;
    }



    public function getUserIp(){
        return $this->user_ip;
    }

    public function setUserIp($value){
        $this->user_ip = $value;
    }



    public function getSerializedObject(){
        return $this->serialized_object;
    }

    public function setSerializedObject($value){
        $this->serialized_object = $value;
    }



    static public function getIdsArrForObjectFullidByCreatedAtDesc($value, $offset = 0, $page_size = 30){
        if (is_null($value)) {
            return \OLOG\DB\DBWrapper::readColumn(
                self::DB_ID,
                'select id from ' . self::DB_TABLE_NAME . ' where object_fullid is null order by created_at_ts desc limit ' . intval($page_size) . ' offset ' . intval($offset)
            );
        } else {
            return \OLOG\DB\DBWrapper::readColumn(
                self::DB_ID,
                'select id from ' . self::DB_TABLE_NAME . ' where object_fullid = ? order by created_at_ts desc limit ' . intval($page_size) . ' offset ' . intval($offset),
                array($value)
            );
        }
    }


    public function getObjectFullid(){
        return $this->object_fullid;
    }

    public function setObjectFullid($value){
        $this->object_fullid = $value;
    }



    static public function getIdsArrForUserFullidByCreatedAtDesc($value, $offset = 0, $page_size = 30){
        if (is_null($value)) {
            return \OLOG\DB\DBWrapper::readColumn(
                self::DB_ID,
                'select id from ' . self::DB_TABLE_NAME . ' where user_fullid is null order by created_at_ts desc limit ' . intval($page_size) . ' offset ' . intval($offset)
            );
        } else {
            return \OLOG\DB\DBWrapper::readColumn(
                self::DB_ID,
                'select id from ' . self::DB_TABLE_NAME . ' where user_fullid = ? order by created_at_ts desc limit ' . intval($page_size) . ' offset ' . intval($offset),
                array($value)
            );
        }
    }


    public function getUserFullid(){
        return $this->user_fullid;
    }

    public function setUserFullid($value){
        $this->user_fullid = $value;
    }



    static public function logObjectEvent($object, $comment, $user_fullid, $object_fullid = null)
    {
        $remote_addr = array_key_exists('REMOTE_ADDR', $_SERVER) ? $_SERVER['REMOTE_ADDR'] : '';
        $ip_address = $remote_addr;

        if (is_null($object_fullid)){
            $object_fullid = FullObjectId::getFullObjectId($object);
        }
        $serialized_object = serialize($object);

        $new_entry_obj = new Entry();
        $new_entry_obj->setUserIp($ip_address);
        $new_entry_obj->setUserFullid($user_fullid);
        $new_entry_obj->setObjectFullid($object_fullid);
        $new_entry_obj->setSerializedObject($serialized_object);
        $new_entry_obj->setComment($comment);
        $new_entry_obj->save();

        /*
        DBWrapper::query(
            self::DB_ID,
            "INSERT INTO " . self::DB_TABLE_NAME . " (user_id, user_fullid, ts, ip, action, entity_id, object) VALUES (?, ?, CURRENT_TIMESTAMP, ?, ?, ?, ?)",
            array($drupal_user_id, $user_full_id, $ip_address, $action, $entity_id, $serialized_object)
        );
        */
    }


    static public function getAllIdsArrByCreatedAtDesc($offset = 0, $page_size = 30){
        $ids_arr = \OLOG\DB\DBWrapper::readColumn(
            self::DB_ID,
            'select id from ' . self::DB_TABLE_NAME . ' order by created_at_ts desc limit ' . intval($page_size) . ' offset ' . intval($offset)
        );
        return $ids_arr;
    }

    public function __construct(){
        $this->created_at_ts = time();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getCreatedAtTs()
    {
        return $this->created_at_ts;
    }

    /**
     * @param string $timestamp
     */
    public function setCreatedAtTs($timestamp)
    {
        $this->created_at_ts = $timestamp;
    }
}