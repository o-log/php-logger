<?php
declare(strict_types=1);

/**
 * @author Oleg Loginov <olognv@gmail.com>
 */

namespace OLOG\Logger;

use OLOG\Logger\Admin\EntriesListAction;
use OLOG\Logger\Admin\EntryEditAction;
use OLOG\Logger\Admin\ObjectEntriesListAction;
use OLOG\Router;

class RegisterRoutes
{
    static public function registerRoutes(){
        Router::action(EntriesListAction::class, 0);
        Router::action(EntryEditAction::class, 0);
        Router::action(ObjectEntriesListAction::class, 0);
    }
}
