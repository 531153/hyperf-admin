<?php
declare(strict_types=1);

namespace Mzh\Admin\Controller\Admin;

use Mzh\Admin\Components\Form\Cascader;
use Mzh\Admin\Components\Grid\GSwitch;
use Mzh\Admin\Components\Widgets\Button;
use Mzh\Admin\Components\Widgets\Dialog;
use Mzh\Admin\Components\Widgets\Markdown;
use Mzh\Admin\Controller\AbstractAdminController;
use Hyperf\Database\Model\Model;
use Mzh\Admin\Components\Attrs\SelectOption;
use Mzh\Admin\Components\Form\IconChoose;
use Mzh\Admin\Components\Form\InputNumber;
use Mzh\Admin\Components\Form\Select;
use Mzh\Admin\Components\Grid\Icon;
use Mzh\Admin\Components\Grid\Tag;
use Mzh\Admin\Facades\Admin;
use Mzh\Admin\Form;
use Mzh\Admin\Grid;
use Mzh\Admin\Layout\Content;
use Mzh\Swagger\Annotation\ApiController;
use Mzh\Swagger\Annotation\GetApi;

/**
 * @ApiController(prefix="/admin/menu",tag="菜单管理",ignore=true))
 * @package App\Controller
 */
class Menu extends AbstractAdminController
{

    protected function grid()
    {
        $userModel = config('admin.database.menu_model');
        $grid = new Grid(new $userModel());
        $grid->model()->where('parent_id', 0);
        $grid->model()->with(['children', 'roles', 'children.roles']);
        $grid
            ->defaultSort('order', 'asc')
            ->tree()
            ->emptyText("暂无菜单")
            ->quickSearch(["title"])
            ->dialogForm($this->form()->isDialog()->backButtonName("关闭"));
        $grid->column('id', "ID")->width(80);
        $grid->column('icon', "图标")->component(Icon::make())->width(80);
        $grid->column('title', "名称");
        $grid->column('order', "排序");
        $grid->column('uri', "路径");
        $grid->column('roles.name', "授权角色")->component(Tag::make());
        return $grid;
    }

    protected function form()
    {
        /**@var Model $model */
        $model = config('admin.database.menu_model');
        $permissionModel = config('admin.database.permissions_model');
        $roleModel = config('admin.database.roles_model');
        $form = new Form(new $model());
        $form->size('medium');
        $form->item('parent_id', '上级目录')->component(Select::make(0)->options(function () use ($model) {
            return $model::query()->where('parent_id', 0)->orderBy('order')->get()->map(function ($item) {
                return SelectOption::make($item->id, $item->title);
            })->prepend(SelectOption::make(0, '根目录'));
        }));
        $form->item('title', '名称')->required();
        $form->item('icon', '图标')->component(IconChoose::make())->required();
        $form->item('uri', 'URL')->required();
        $form->item('order', '排序')->component(InputNumber::make(1)->min(0));
        $form->item('roles', '角色')->component(Select::make()->block()->multiple()->options(function () use ($roleModel) {
            return $roleModel::all()->map(function ($role) {
                return SelectOption::make($role->id, $role->name);
            });
        }));
        //编辑前置钩子
        $form->editing(function (Form $form) {


        });
        //编辑中钩子
        $form->saving(function (Form $form) {


        });
        //编辑后置钩子
        $form->saved(function (Form $form) {


        });
        if ((new $model())->withPermission()) {
            $form->item('permission', '权限')->component(Select::make()->clearable()->block()->multiple()->options(function () use ($permissionModel) {
                return $permissionModel::all()->map(function ($role) {
                    return SelectOption::make($role->id, $role->name);
                });
            }));
        };
        return $form;
    }

    /**
     * 重写list 默认也可以不写此方法
     * @GetApi()
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
}
