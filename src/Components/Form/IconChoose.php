<?php
declare(strict_types=1);
namespace Mzh\Admin\Components\Form;

use Mzh\Admin\Components\Component;

class IconChoose extends Component
{
    protected $componentName = "IconChoose";

    public static function make($value = null)
    {
        return new IconChoose($value);
    }

}
