<?php
declare(strict_types=1);

namespace Mzh\Admin\Traits;

use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Utils\Str;
use Mzh\Admin\Exception\BusinessException;
use Mzh\Admin\Exception\ValidateException;
use Mzh\Helper\DbHelper\GetQueryHelper;
use Mzh\Swagger\Annotation\Body;
use Mzh\Swagger\Annotation\GetApi;
use Mzh\Swagger\Annotation\PostApi;
use Psr\Http\Message\ResponseInterface;

trait GetApiUI
{
    use GetApiBase;
    use GetUiBase;
    use GetQueryHelper;

    protected $options = null;

    /**
     * @GetApi(summary="获取UI配置",security=true)
     * @throws \Exception
     */
    public function info()
    {
        return $this->_info(null);
    }

//    /**
//     * 表单拉取接口
//     * @GetApi(summary="获取编辑表单配置",security=true)
//     */
//    public function edit()
//    {
//        $id = $this->request->query($this->getPk(), 0);
//        $record = $this->_detail($id);
//        $this->callback('response_before', $id, $record);
//        $form = $this->formOptionsConvert([], false, true, false, $record);
//        return $this->json(array_merge($this->formResponse($id, $form)));
//    }
//    /**
//     * @PostApi(path="edit",summary="UI界面更新单条信息",security=true)
//     * @Body(scene="update",security=true)
//     * @return ResponseInterface
//     * @throws ValidateException|BusinessException
//     */
//    public function edit_update()
//    {
//        return $this->json($this->_update());
//    }

    /**
     * @GetApi(summary="获取编辑表单配置",security=true)
     * @throws \Exception
     */
    public function form()
    {
        $record = [];
        $edit = false;
        $id = $this->request->query($this->getPk(), 0);
        if ($id > 0) {
            $record = $this->_detail($id);
            $edit = true;
        }
        $this->callback('response_before', $id, $record);
        $form = $this->formOptionsConvert([], false, $edit, false, $record);
        return $this->json(array_merge($this->formResponse($id, $form)));
    }

    /**
     * @PostApi(path="form",summary="创建单条信息",security=true)
     * @Body(scene="update",security=true)
     * @return ResponseInterface
     * @throws ValidateException|BusinessException
     */
    public function form_updateOrcreate()
    {
        return $this->json($this->_updateOrCreate());
    }

}