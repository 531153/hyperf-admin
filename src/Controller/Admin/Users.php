<?php
declare(strict_types=1);
namespace Mzh\Admin\Controller\Admin;

use Mzh\Admin\Components\Attrs\SelectOption;
use Mzh\Admin\Components\Form\Input;
use Mzh\Admin\Components\Form\Select;
use Mzh\Admin\Components\Form\Upload;
use Mzh\Admin\Components\Grid\Avatar;
use Mzh\Admin\Components\Grid\GSwitch;
use Mzh\Admin\Components\Grid\Tag;
use Mzh\Admin\Components\Widgets\Button;
use Mzh\Admin\Components\Widgets\Dialog;
use Mzh\Admin\Components\Widgets\Markdown;
use Mzh\Admin\Controller\AbstractAdminController;
use Mzh\Admin\Facades\Admin;
use Mzh\Admin\Form;
use Mzh\Admin\Grid;
use Mzh\Admin\Layout\Content;
use Mzh\Swagger\Annotation\ApiController;
use Mzh\Swagger\Annotation\GetApi;

/**
 * @ApiController(prefix="/admin/users",tag="管理员管理",ignore=true))
 * @package Mzh\Admin\Controllers
 */
class Users extends AbstractAdminController
{

    protected function grid()
    {

        $userModel = config('admin.database.users_model');
        $grid = new Grid(new $userModel());
        $grid
            ->quickSearch(['name', 'username'])
            ->quickSearchPlaceholder("用户名 / 名称")
            ->pageBackground()
            ->defaultSort('id', 'asc')
            ->selection()
            ->stripe(true)->emptyText("暂无用户")
            ->perPage(10)
            ->autoHeight();

        $grid->column('id', "ID")->width(80);
        $grid->column('avatar', '头像')->width(80)->align('center')->component(Avatar::make());
        $grid->column('username', "用户名");
        $grid->column('name', '用户昵称');
        $grid->column('roles.name', "角色")->component(Tag::make()->effect('dark'));
        $grid->column('created_at');
        $grid->column('updated_at');

        return $grid;
    }

    protected function form()
    {

        $userModel = config('admin.database.users_model');
        $permissionModel = config('admin.database.permissions_model');
        $roleModel = config('admin.database.roles_model');
        $form = new Form(new $userModel());

        $userTable = config('admin.database.users_table');

        $form->item('username', '用户名')
            ->serveCreationRules(['required', "unique:{$userTable}"])
            ->serveUpdateRules(['required', "unique:{$userTable},username,{{id}}"])
            ->component(Input::make());
        $form->item('name', '名称')->component(Input::make()->showWordLimit()->maxlength(20));
        $form->item('avatar', '头像')->component(Upload::make()->avatar()->path('avatar')->uniqueName());
        $form->item('password', '密码')->serveCreationRules(['required', 'string', 'confirmed'])->serveUpdateRules(['confirmed'])->ignoreEmpty()
            ->component(function () {
                return Input::make()->password()->showPassword();
            });
        $form->item('password_confirm', '确认密码')
            ->copyValue('password')->ignoreEmpty()
            ->component(function () {
                return Input::make()->password()->showPassword();
            });
        $form->item('roles', '角色')->component(Select::make()->block()->multiple()->options($roleModel::all()->map(function ($role) {
            return SelectOption::make($role->id, $role->name);
        })->toArray()));
        $form->item('permissions', '权限')->component(Select::make()->clearable()->block()->multiple()->options($permissionModel::all()->map(function ($role) {
            return SelectOption::make($role->id, $role->name);
        })->toArray()));

        $form->saving(function (Form $form) {
            if ($form->password) {
                $form->password = md5($form->password);
            }
        });

        $form->deleting(function (Form $form, $id) {
            //if (Admin::user()->id == $id || $id == 1) {
               // return Admin::responseError("删除失败");
           // }
        });
        return $form;
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
