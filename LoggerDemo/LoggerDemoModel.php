<?php

namespace LoggerDemo;

use OLOG\Auth\Auth;
use OLOG\DB\DB;
use OLOG\Logger\Entry;
use OLOG\Model\ActiveRecordInterface;
use OLOG\Model\ActiveRecordTrait;
use OLOG\Model\FullObjectId;

class LoggerDemoModel implements
    ActiveRecordInterface
{
    use ActiveRecordTrait;

    const DB_ID = 'DB_NAME_PHPLOGGER';
    const DB_TABLE_NAME = 'loggerdemo_loggerdemomodel';

    const _CREATED_AT_TS = 'created_at_ts';
    public $created_at_ts; // initialized by constructor
    const _TITLE = 'title';
    public $title = "default title";
    const _ID = 'id';
    public $id;

    public function getTitle(){
        return $this->title;
    }

    public function setTitle($value){
        $this->title = $value;
    }

    static public function getAllIdsArrByCreatedAtDesc($offset = 0, $page_size = 30){
        $ids_arr = DB::readColumn(
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
}
