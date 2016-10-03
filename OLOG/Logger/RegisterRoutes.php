<?php

namespace OLOG\Logger;

use OLOG\Logger\Admin\EntriesListAction;
use OLOG\Logger\Admin\EntryEditAction;
use OLOG\Logger\Admin\ObjectEntriesListAction;
use OLOG\Router;

class RegisterRoutes
{
    static public function registerRoutes(){
        Router::processAction(EntriesListAction::class, 0);
        Router::processAction(EntryEditAction::class, 0);
        Router::processAction(ObjectEntriesListAction::class, 0);
    }
}