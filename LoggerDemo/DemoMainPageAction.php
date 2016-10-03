<?php

namespace LoggerDemo;

use OLOG\InterfaceAction;
use OLOG\Layouts\AdminLayoutSelector;

class DemoMainPageAction implements InterfaceAction
{
    public function url(){
        return '/';
    }

    public function action()
    {
        $html = '';

        AdminLayoutSelector::render($html, $this);


    }

}