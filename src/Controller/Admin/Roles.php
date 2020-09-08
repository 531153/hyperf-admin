<?php
declare(strict_types=1);

namespace Mzh\Admin\Controller\Admin;

use Mzh\Admin\Components\Form\Select;
use Mzh\Admin\Components\Grid\GSwitch;
use Mzh\Admin\Components\Widgets\Button;
use Mzh\Admin\Components\Widgets\Dialog;
use Mzh\Admin\Components\Widgets\Markdown;
use Mzh\Admin\Controller\AbstractAdminController;
use Mzh\Admin\Components\Attrs\TransferData;
use Mzh\Admin\Components\Form\Transfer;
use Mzh\Admin\Components\Grid\Tag;
use Mzh\Admin\Form;
use Mzh\Admin\Grid;
use Mzh\Admin\Layout\Content;
use Mzh\Swagger\Annotation\ApiController;
use Mzh\Swagger\Annotation\GetApi;

/**
 * @ApiController(prefix="/admin/roles",tag="角色管理",ignore=true))
 * Class Auth
 * @package App\Controller
 */
class Roles extends AbstractAdminController
{

    protected function grid()
    {
        $roleModel = config('admin.database.roles_model');
        $grid = new Grid(new $roleModel());
        $grid->quickSearch(['slug', 'name']);
        $grid->column('id', 'ID')->width('80px')->sortable();
        $grid->column('slug', "标识");
        $grid->column('name', "名称");
        $grid->column('permissions.name', "权限")->component(Tag::make()->type('info'));
        $grid->column('created_at');
        $grid->column('updated_at');
        return $grid;
    }

    public function form()
    {
        $permissionModel = config('admin.database.permissions_model');
        $roleModel = config('admin.database.roles_model');
        $form = new Form(new $roleModel());
        $form->item('slug', "标识")->required();
        $form->item('name', "名称")->required();
        $form->item('permissions', "权限", 'permissions.id')->component(
            Transfer::make()->data($permissionModel::get()->map(function ($item) {
                return TransferData::make($item->id, $item->name);
            }))->titles(['可授权', '已授权'])->filterable()
        );
        return $form;
    }



    protected function code($name = "查看源代码", $ref = "codeButton")
    {
        return Button::make($name)->ref($ref)->dialog(function (Dialog $dialog) use ($name) {
            $dialog->width('80%')->title($name);
            $dialog->slot(function (Content $content) {
                $code = "```php\n";
                $code .= file_get_contents(__FILE__);
                $code .= "\n```";
                $content->body(Markdown::make($code)->style("height:60vh;"));
            });
        });
    }

    /**
     * 重写list 默认也可以不写此方法
     * @GetApi ()
     * @return array|mixed
     */
    public function list()
    {
        $content = new Content();
        $content->className('m-15');
        $content->row($this->code());
        $content->row($this->br());
        //可以重写这里，实现自定义布局
        $content->body($this->grid());
        //这里必须这样写
        return $this->isGetData() ? $this->grid()->jsonSerialize() : $content->jsonSerialize();
    }

}
