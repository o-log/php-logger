<?php
declare(strict_types=1);

namespace LoggerDemo;

use OLOG\BT\LayoutBootstrap4;
use OLOG\Layouts\RenderInLayoutInterface;

class LoggerDemoABase
    implements RenderInLayoutInterface
{
    public function renderInLayout($html_or_callable)
    {
        LayoutBootstrap4::render($html_or_callable, $this);
    }
}
