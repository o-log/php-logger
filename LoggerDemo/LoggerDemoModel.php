<?php

namespace LoggerDemo;

use OLOG\Auth\Auth;
use OLOG\FullObjectId;
use OLOG\Logger\Entry;

class LoggerDemoModel implements
    \OLOG\Model\InterfaceFactory,
    \OLOG\Model\InterfaceLoad,
    \OLOG\Model\InterfaceSave,
    \OLOG\Model\InterfaceDelete
{
    use \OLOG\Model\FactoryTrait;
    use \OLOG\Model\ActiveRecordTrait;
    use \OLOG\Model\ProtectPropertiesTrait;

    const DB_ID = 'DB_NAME_PHPLOGGER';
    const DB_TABLE_NAME = 'loggerdemo_loggerdemomodel';

    const _CREATED_AT_TS = 'created_at_ts';
    protected $created_at_ts; // initialized by constructor
    const _TITLE = 'title';
    protected $title = "default title";
    const _ID = 'id';
    protected $id;

    public function getTitle(){
        return $this->title;
    }

    public function setTitle($value){
        $this->title = $value;
    }

    static public function getAllIdsArrByCreatedAtDesc($offset = 0, $page_size = 30){
        $ids_arr = \OLOG\DB\DBWrapper::readColumn(
            self::DB_ID,
            'select ' . self::_ID . ' from ' . self::DB_TABLE_NAME . ' order by ' . self::_CREATED_AT_TS . ' desc limit ' . intval($page_size) . ' offset ' . intval($offset)
        );
        return $ids_arr;
    }

    public function afterSave()
    {
        Entry::logObjectEvent($this, 'save', FullObjectId::getFullObjectId(Auth::currentUserObj()));
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