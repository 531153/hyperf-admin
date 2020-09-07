<?php
declare(strict_types=1);
namespace Mzh\Admin\Components\Grid;


use Mzh\Admin\Components\GridComponent;

class Icon extends GridComponent
{
    protected $componentName = "Icon";

    static public function make($value = null)
    {
        return new Icon($value);
    }

}
