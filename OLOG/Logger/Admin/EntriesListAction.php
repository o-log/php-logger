<?php

namespace OLOG\Logger\Admin;

use OLOG\Auth\Operator;
use OLOG\Exits;
use OLOG\InterfaceAction;
use OLOG\Layouts\AdminLayoutSelector;
use OLOG\Layouts\InterfacePageTitle;

class EntriesListAction implements
    InterfacePageTitle,
    InterfaceAction
{
    public function url(){
        return '/admin/logger/entries';
    }

    public function pageTitle()
    {
        return 'Logger entries';
    }

    public function action(){
        Exits::exit403If(
            !Operator::currentOperatorHasAnyOfPermissions([\OLOG\Logger\Permissions::PERMISSION_PHPLOGGER_ACCESS])
        );

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
            [],
            'created_at_ts desc'
        );

        AdminLayoutSelector::render($html, $this);
    }
}