<?php

namespace OLOG\Logger\Admin;

use OLOG\Auth\Auth;
use OLOG\Layouts\InterfaceMenu;
use OLOG\Layouts\MenuItem;
use OLOG\Logger\Permissions;

class LoggerAdminMenu implements InterfaceMenu
{
    static public function menuArr()
    {
        $menu_arr =  [];
        if (Auth::currentUserHasAnyOfPermissions([Permissions::PERMISSION_PHPLOGGER_ACCESS])) {
            $menu_arr = [
                new MenuItem((new EntriesListAction())->pageTitle(), (new EntriesListAction())->url(), null, 'glyphicon glyphicon-flag')
            ];
        }
        return $menu_arr;
    }

}