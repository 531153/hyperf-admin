<?php
declare(strict_types=1);
namespace Mzh\Admin\Components\Widgets;


use Mzh\Admin\Components\Attrs\ElDialog;
use Mzh\Admin\Components\Component;

class Dialog extends Component
{
    use ElDialog;

    protected $componentName = "Dialog";


    public static function make()
    {
        return new Dialog();
    }

}
