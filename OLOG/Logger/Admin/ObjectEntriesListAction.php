<?php

namespace OLOG\Logger\Admin;

use OLOG\ActionInterface;
use OLOG\Auth\Auth;
use OLOG\CRUD\CTable;
use OLOG\CRUD\TCol;
use OLOG\CRUD\TFEqualHidden;
use OLOG\CRUD\TWText;
use OLOG\CRUD\TWTextWithLink;
use OLOG\CRUD\TWTimestamp;
use OLOG\Exits;
use OLOG\Layouts\AdminLayoutSelector;
use OLOG\Layouts\PageTitleInterface;
use OLOG\MaskActionInterface;

class ObjectEntriesListAction extends LoggerAdminActionsBaseProxy implements
    PageTitleInterface,
    ActionInterface,
    MaskActionInterface
{
    protected $object_fullid;

    public function __construct($object_fullid)
    {
        $this->object_fullid = $object_fullid;
    }

    public function url()
    {
        return '/admin/logger/objectentries/' . urlencode($this->object_fullid);
    }

    static public function mask()
    {
        return '/admin/logger/objectentries/([\w\.%]+)';
    }

    public function pageTitle()
    {
        return 'Объект ' . $this->object_fullid;
    }

    public function topActionObj()
    {
        return new EntriesListAction();
    }

    public function action()
    {
        Exits::exit403If(
            !Auth::currentUserHasAnyOfPermissions([\OLOG\Logger\Permissions::PERMISSION_PHPLOGGER_ACCESS])
        );

        $object_fullid = $this->object_fullid;

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
                new TFEqualHidden('object_fullid', $object_fullid)
            ],
            'created_at_ts desc'
        );

        AdminLayoutSelector::render($html, $this);
    }
}
