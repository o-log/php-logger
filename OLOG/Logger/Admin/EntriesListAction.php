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
use OLOG\CRUD\TFLikeInline;
use OLOG\CRUD\TWText;
use OLOG\CRUD\TWTextWithLink;
use OLOG\CRUD\TWTimestamp;
use OLOG\Exits;
use OLOG\Layouts\PageTitleInterface;
use OLOG\Logger\Entry;

class EntriesListAction
    extends LoggerAdminActionsBaseProxy
    implements PageTitleInterface, ActionInterface
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
                        function(Entry $entry){
                            return (new EntryEditAction($entry->getId()))->url();
                        }
                    )
                )
            ],
            [
                new TFLikeInline('38947yt7ywssserkit22uy', 'Object Fullid', Entry::_OBJECT_FULLID),
            ],
            'created_at_ts desc',
            '8273649529'
        );

        $this->renderInLayout($html);
    }
}
