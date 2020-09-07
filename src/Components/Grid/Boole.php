<?php
declare(strict_types=1);
namespace Mzh\Admin\Components\Grid;


use Mzh\Admin\Components\Component;

class Boole extends Component
{
    protected $componentName = "Boole";


    public static function make($value = null)
    {
        return new Boole($value);
    }

}
