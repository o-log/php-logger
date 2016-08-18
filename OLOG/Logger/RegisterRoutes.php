<?php

namespace OLOG\Logger;

use OLOG\Logger\Admin\EntriesListAction;
use OLOG\Router;

class RegisterRoutes
{
    static public function registerRoutes(){
        Router::matchAction(EntriesListAction::class, 0);
    }
}