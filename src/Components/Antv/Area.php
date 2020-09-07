<?php
declare(strict_types=1);

namespace Mzh\Admin\Components\Antv;

use Illuminate\Support\Str;
use Mzh\Admin\Components\Component;

class Area extends Line
{
    protected $componentName = "AntvArea";
    protected $canvasId;
    protected $data;
    protected $config;


    public static function make()
    {
        return new Area();
    }


}
