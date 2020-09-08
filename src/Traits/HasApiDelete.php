<?php

namespace Mzh\Admin\Traits;


use Mzh\Swagger\Annotation\DeleteApi;
use Mzh\Swagger\Annotation\Path;

trait HasApiDelete
{
    use HasApiBase;

    /**
     * @DeleteApi(path="{id}",summary="删除接口")
     * @Path(key="id")
     * @param $id
     * @return array|mixed
     */
    public function delete($id)
    {
        return $this->form(true)->destroy($id);
    }
}