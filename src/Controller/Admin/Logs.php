<?php
declare(strict_types=1);

namespace Mzh\Admin\Controller\Admin;

use Hyperf\Database\Model\Model;
use Mzh\Admin\Auth\Database\OperationLog;
use Mzh\Admin\Components\Attrs\SelectOption;
use Mzh\Admin\Components\Form\Input;
use Mzh\Admin\Components\Form\Select;
use Mzh\Admin\Components\Grid\Avatar;
use Mzh\Admin\Components\Grid\Route;
use Mzh\Admin\Components\Grid\Tag;
use Mzh\Admin\Components\Widgets\Button;
use Mzh\Admin\Components\Widgets\Dialog;
use Mzh\Admin\Components\Widgets\Html;
use Mzh\Admin\Components\Widgets\Markdown;
use Mzh\Admin\Controller\AbstractAdminController;
use Mzh\Admin\Form;
use Mzh\Admin\Grid;
use Mzh\Admin\Layout\Content;
use Mzh\Swagger\Annotation\ApiController;
use Mzh\Swagger\Annotation\GetApi;

/**
 * @ApiController(prefix="/admin/logs",tag="日志管理",ignore=true))
 * @package Mzh\Admin\Controllers
 */
class Logs extends AbstractAdminController
{

    protected function grid()
    {
        $grid = new Grid(new OperationLog());

        $grid->perPage(20)
            ->selection()
            ->defaultSort('id', 'desc')
            ->stripe()
            ->emptyText("暂无日志")
            ->height('auto')
            ->appendFields(["user.id"]);

        $grid->column('id', "ID")->width("100");
        $grid->column('user.avatar', '头像', 'user_id')->component(Avatar::make()->size('small'))->width(80);
        $grid->column('user.name', '用户', 'user_id')->help("操作用户")->sortable()->component(Route::make("/admin/logs/list?user_id={user.id}")->type("primary"));
        $grid->column('method', '请求方式')->width(100)->align('center')->component(Tag::make()->type(['GET' => 'info', 'POST' => 'success']));
        $grid->column('path', '路径')->help('操作URL')->sortable();
        $grid->column('ip', 'IP')->component(Route::make("/admin/logs/list?ip={ip}")->type("primary"));
        $grid->column('created_at', "创建时间")->sortable();

        $grid->actions(function (Grid\Actions $actions) {
            $actions->hideEditAction();
            $actions->hideViewAction();
        })->toolbars(function (Grid\Toolbars $toolbars) {
            $toolbars->hideCreateButton();
        });

        $grid->filter(function (Grid\Filter $filter) {
            $user_id = (int)request('user_id');
            $filter->equal('user_id')->component(Select::make($user_id)->placeholder("请选择用户")->options(function () {
                $user_ids = OperationLog::query()->groupBy("user_id")->get(["user_id"])->pluck("user_id")->toArray();
                /**@var Model $userModel */
                $userModel = config('admin.database.users_model');
                return $userModel::query()->whereIn("id", $user_ids)->get()->map(function ($user) {
                    return SelectOption::make($user->id, $user->name);
                })->all();
            }));
            $filter->equal('ip')->component(Input::make(request('ip'))->placeholder("IP"));
        });

        return $grid;
    }

    protected function form()
    {
        $form = new Form(new OperationLog());

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
