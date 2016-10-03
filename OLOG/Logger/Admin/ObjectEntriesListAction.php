<?php

namespace OLOG\Logger\Admin;

use OLOG\Auth\Operator;
use OLOG\CRUD\CRUDTableFilter;
use OLOG\Exits;
use OLOG\InterfaceAction;
use OLOG\Layouts\AdminLayoutSelector;
use OLOG\Layouts\InterfacePageTitle;

class ObjectEntriesListAction implements
    InterfacePageTitle,
    InterfaceAction
{
    protected $object_fullid;

    public function __construct($object_fullid)
    {
        $this->object_fullid = $object_fullid;
    }

    public function url(){
        return '/admin/logger/objectentries/' . $this->object_fullid;
    }

    public function urlMask(){
        return '/admin/logger/objectentries/([\w\.%]+)';
    }

    public function pageTitle(){
        return 'Logger entries';
    }

    public function action(){
        Exits::exit403If(
            !Operator::currentOperatorHasAnyOfPermissions([\OLOG\Logger\Permissions::PERMISSION_PHPLOGGER_ACCESS])
        );

        $object_fullid = $this->object_fullid;

        $html = \OLOG\CRUD\CRUDTable::html(
            \OLOG\Logger\Entry::class,
            '',
            [
                new \OLOG\CRUD\CRUDTableColumn(
                    'user_fullid',
                    new \OLOG\CRUD\CRUDTableWidgetTextWithLink('{this->user_fullid}', (new EntryEditAction('{this->id}'))->url())
                ),
                new \OLOG\CRUD\CRUDTableColumn(
                    'object_fullid',
                    new \OLOG\CRUD\CRUDTableWidgetText('{this->object_fullid}')
                ),
                new \OLOG\CRUD\CRUDTableColumn(
                    'created at',
                    new \OLOG\CRUD\CRUDTableWidgetText('{this->created_at_ts}')
                )
            ],
            [
                new CRUDTableFilter('object_fullid', CRUDTableFilter::FILTER_EQUAL, $object_fullid)
            ],
            'created_at_ts desc'
        );

        AdminLayoutSelector::render($html, $this);
    }
}