<?php
declare(strict_types=1);
namespace Mzh\Admin\Components\Widgets;


use Mzh\Admin\Components\Component;

class Html extends Component
{
    protected $componentName = "Html";

    protected $html = "";


    public function __construct(string $html)
    {
        $this->html = $html;
    }


    public static function make($html = "")
    {
        return new Html($html);
    }

    /**
     * @param string $html
     * @return $this
     */
    public function html(string $html)
    {
        $this->html = $html;
        return $this;
    }


}
