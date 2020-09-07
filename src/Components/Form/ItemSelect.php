<?php
declare(strict_types=1);

namespace Mzh\Admin\Components\Form;
use Mzh\Admin\Components\Component;

class ItemSelect extends Component
{
    protected $componentName = "ItemSelect";

    public static function make()
    {
        return new ItemSelect();
    }

}
