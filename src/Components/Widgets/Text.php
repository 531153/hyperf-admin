<?php
declare(strict_types=1);
namespace Mzh\Admin\Components\Widgets;


use Mzh\Admin\Components\Component;

class Text extends Component
{

    protected $componentName = "IText";

    protected $text = "";

    /**
     * LvaText constructor.
     * @param string $text
     */
    public function __construct(string $text)
    {
        $this->text = $text;
    }


    static public function make($text = "")
    {
        return new Text($text);
    }
}
