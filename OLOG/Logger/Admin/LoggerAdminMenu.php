<?php

namespace OLOG\Logger\Admin;

use OLOG\Layouts\InterfaceMenu;
use OLOG\Layouts\MenuItem;

class LoggerAdminMenu implements InterfaceMenu
{
    static public function menuArr()
    {
            $menu_arr = [
                new MenuItem((new EntriesListAction())->pageTitle(), (new EntriesListAction())->url(), null, 'glyphicon glyphicon-flag')
            ];
        return $menu_arr;
    }

}