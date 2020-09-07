<?php
declare(strict_types=1);
namespace Mzh\Admin\Components\Widgets;


use Mzh\Admin\Components\Attrs\Button;
use Mzh\Admin\Components\Component;

class DialogButton extends Component
{

    use Button;

    protected $componentName = 'DialogButton';


    public static function make()
    {
        return new DialogButton();
    }

}
