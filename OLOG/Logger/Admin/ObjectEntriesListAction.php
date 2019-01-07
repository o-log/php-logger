<?php
declare(strict_types=1);

/**
 * @author Oleg Loginov <olognv@gmail.com>
 */

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
use OLOG\Layouts\PageTitleInterface;
use OLOG\Logger\Entry;
use OLOG\MaskActionInterface;

class ObjectEntriesListAction
    extends LoggerAdminActionsBaseProxy
    implements PageTitleInterface, ActionInterface, MaskActionInterface
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
            Entry::class,
            '',
            [
                new TCol(
                    'Объект',
                    new TWText(Entry::_OBJECT_FULLID)
                ),
                new TCol(
                    'Дата создания',
                    new TWTimestamp(Entry::_CREATED_AT_TS)
                ),
                new TCol(
                    'Пользователь',
                    new TWTextWithLink(
                        Entry::_USER_FULLID,
                        //(new EntryEditAction('{this->id}'))->url()
                        function (Entry $entry){
                            return (new EntryEditAction($entry->getId()))->url();
                        }
                    )
                )
            ],
            [
                new TFEqualHidden('object_fullid', $object_fullid)
            ],
            'created_at_ts desc'
        );

        $this->renderInLayout($html);
    }
}
