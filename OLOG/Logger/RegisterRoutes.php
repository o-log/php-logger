<?php

namespace OLOG\Logger;

use OLOG\Logger\Admin\EntriesListAction;
use OLOG\Logger\Admin\EntryEditAction;
use OLOG\Logger\Admin\ObjectEntriesListAction;
use OLOG\Router;

class RegisterRoutes
{
    static public function registerRoutes(){
        Router::matchAction(EntriesListAction::class, 0);
        Router::matchAction(EntryEditAction::class, 0);
        Router::matchAction(ObjectEntriesListAction::class, 0);
    }
}