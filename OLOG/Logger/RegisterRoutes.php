<?php

namespace OLOG\Logger;

use OLOG\Auth\Admin\EntriesListAction;
use OLOG\Router;

class RegisterRoutes
{
    static public function registerRoutes(){
        Router::matchAction(EntriesListAction::class, 0);
    }
}