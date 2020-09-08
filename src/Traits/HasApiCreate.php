<?php


namespace Mzh\Admin\Traits;

use Mzh\Admin\Layout\Content;
use Mzh\Swagger\Annotation\GetApi;
use Mzh\Swagger\Annotation\Path;
use Mzh\Swagger\Annotation\PostApi;
use Mzh\Swagger\Annotation\PutApi;

trait HasApiCreate
{
    use HasApiBase;

    /**
     * @PostApi(path="_self_path",summary="创建数据")
     * @return array|mixed
     */
    public function _self_post()
    {
        return $this->form(true)->store();
    }

    /**
     * @GetApi(summary="获取创建UI配置")
     * @return array|mixed
     */
    public function create()
    {
        $content = new Content;
        //可以重写这里，实现自定义布局
        $content->body($this->form())->className("m-10");
        //这里必须这样写
        return $content;
    }
}