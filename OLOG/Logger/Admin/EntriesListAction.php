<?php

namespace OLOG\Logger\Admin;

use OLOG\Auth\Operator;
use OLOG\BT\InterfaceBreadcrumbs;
use OLOG\BT\InterfacePageTitle;
use OLOG\BT\Layout;
use OLOG\Exits;

class EntriesListAction implements
    InterfaceBreadcrumbs,
    InterfacePageTitle//,
    //InterfaceUserName
{
    //use CurrentUserNameTrait;

    static public function getUrl(){
        return '/admin/logger/entries';
    }

    public function currentPageTitle()
    {
        return self::pageTitle();
    }

    static public function pageTitle(){
        return 'Logger entries';
    }

    public function currentBreadcrumbsArr(){
        return self::breadcrumbsArr();
    }

    static public function breadcrumbsArr()
    {
        //return array_merge(AuthAdminAction::breadcrumbsArr(), [BT::a(self::getUrl(), self::pageTitle())]);
        return [];
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
                    new \OLOG\CRUD\CRUDTableWidgetTextWithLink('{this->user_fullid}', EntryEditAction::getUrl('{this->id}'))
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

        Layout::render($html, $this);
    }
}