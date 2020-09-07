<?php
declare(strict_types=1);
namespace Mzh\Admin\Components\Widgets;


use Mzh\Admin\Components\Component;

class Markdown extends Component
{
    protected $componentName = "Markdown";

    protected $content;


    public function __construct($content)
    {

        $this->content = $content;
    }

    public static function make($content=""){
        return new Markdown($content);
    }


    public function content($content)
    {
        $this->content = $content;
        return $this;
    }


}
