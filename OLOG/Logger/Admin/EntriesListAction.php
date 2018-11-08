<?php

namespace OLOG\Logger\Admin;


use OLOG\ActionInterface;
use OLOG\Auth\Auth;
use OLOG\CRUD\CTable;
use OLOG\CRUD\TCol;
use OLOG\CRUD\TFLikeInline;
use OLOG\CRUD\TWText;
use OLOG\CRUD\TWTextWithLink;
use OLOG\CRUD\TWTimestamp;
use OLOG\Exits;
use OLOG\Layouts\AdminLayoutSelector;
use OLOG\Layouts\PageTitleInterface;

class EntriesListAction extends LoggerAdminActionsBaseProxy implements
    PageTitleInterface,
    ActionInterface
{

    public function url()
    {
        return '/admin/logger/entries';
    }

    public function pageTitle()
    {
        return 'Журнал';
    }

    public function action()
    {
        Exits::exit403If(
            !Auth::currentUserHasAnyOfPermissions([\OLOG\Logger\Permissions::PERMISSION_PHPLOGGER_ACCESS])
        );

        $html = CTable::html(
            \OLOG\Logger\Entry::class,
            '',
            [
                new TCol(
                    'Объект',
                    new TWText('{this->object_fullid}')
                ),
                new TCol(
                    'Дата создания',
                    new TWTimestamp('{this->created_at_ts}')
                ),
                new TCol(
                    'Пользователь',
                    new TWTextWithLink('{this->user_fullid}', (new EntryEditAction('{this->id}'))->url())
                )
            ],
            [
                new TFLikeInline('38947yt7ywssserkit22uy', 'Object Fullid', \OLOG\Logger\Entry::_OBJECT_FULLID),
            ],
            'created_at_ts desc',
            '8273649529'
        );

        AdminLayoutSelector::render($html, $this);
    }
}
