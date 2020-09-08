<?php
declare(strict_types=1);

namespace Mzh\Admin\Controller\Admin;

use Hyperf\Di\Annotation\Inject;
use Hyperf\Utils\Str;
use Mzh\Admin\Components\Widgets\Button;
use Mzh\Admin\Components\Widgets\Dialog;
use Mzh\Admin\Components\Widgets\Markdown;
use Mzh\Admin\Controller\AbstractAdminController;
use Mzh\Admin\Components\Attrs\SelectOption;
use Mzh\Admin\Components\Form\Select;
use Mzh\Admin\Components\Grid\Tag;
use Mzh\Admin\Form;
use Mzh\Admin\Grid;
use Mzh\Admin\Layout\Content;
use Mzh\Admin\Service\AuthService;
use Mzh\Swagger\Annotation\ApiController;
use Mzh\Swagger\Annotation\GetApi;

/**
 * @ApiController(prefix="/admin/permissions",tag="权限管理",ignore=true))
 * @package App\Controller
 */
class Permissions extends AbstractAdminController
{

    /**
     * @Inject()
     * @var AuthService
     */
    protected $authService;

    protected function showPageHeader()
    {
        return false;
    }

    /**
     * 重写标题
     * @return string
     */
    protected function title()
    {
        return '系统权限管理';
    }

    protected function grid()
    {
        $permissionModel = config('admin.database.permissions_model');
        $grid = new Grid(new $permissionModel());
        //$grid->dataUrl(route('admin.permissions.route'));
        $grid->tree();
        $grid->quickSearch(['kw', '搜索关键词']);
        $grid->tree();
        $grid->column('name', "名称");
        $grid->column('path', "授权节点")->component(Tag::make());


        $grid->dialogForm($this->form()->isDialog()->className('p-15')->labelWidth('auto'), '600px', ['添加权限', '编辑权限']);
        return $grid;
    }


    protected function form($isEdit = false)
    {
        $permissionModel = config('admin.database.permissions_model');

        $form = new Form(new $permissionModel());
        $form->item('name', "名称")->required();
        $form->item('path', "授权节点")
            ->help('可以输入搜索')
            ->component(Select::make()->filterable()
                ->remote(route('admin/permissions/route'))->multiple())->inputWidth(450);
        return $form;
    }

    protected function getHttpMethodsOptions()
    {
        $model = config('admin.database.permissions_model');
        return collect($model::$httpMethods)->map(function ($item) {
            return SelectOption::make($item, $item);
        })->toArray();
    }

    /**
     * @GetApi()
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function route()
    {
        $kw = $this->request->query('query', '');
        $routes = $this->authService->getSystemRouteOptions();
        $routes = array_filter($routes, function ($item) use ($kw) {
            if (empty($kw)) return true;
            return Str::contains($item['value'], $kw);
        });
        $routes = array_values($routes);
        //$routes = generate_tree($routes);
        //$routes =Arr::sortRecursive($routes);
        return $this->response->json(['code' => 200, 'data' => ['data' => $routes, 'total' => count($routes)]]);
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
