<?php


namespace Mzh\Admin\Traits;

use Mzh\Admin\Layout\Content;
use Mzh\Swagger\Annotation\GetApi;

trait HasUiList
{
    use HasUiBase;

    /**
     * @GetApi ()
     * @return array|mixed
     */
    public function list()
    {
        $content = new Content();
        //可以重写这里，实现自定义布局
        $content->body($this->grid())->className("p-10");
        //这里必须这样写
        return $this->isGetData() ? $this->grid()->jsonSerialize() : $content->jsonSerialize();
    }
}