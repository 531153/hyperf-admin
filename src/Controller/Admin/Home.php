<?php
declare(strict_types=1);

namespace Mzh\Admin\Controller\Admin;

use Mzh\Admin\Components\Widgets\Button;
use Mzh\Admin\Components\Widgets\Dialog;
use Mzh\Admin\Components\Widgets\Markdown;
use Mzh\Admin\Controller\AbstractAdminController;
use Mzh\Admin\Components\Antv\Area;
use Mzh\Admin\Components\Antv\Column;
use Mzh\Admin\Components\Antv\Line;
use Mzh\Admin\Components\Antv\StepLine;
use Mzh\Admin\Components\Widgets\Alert;
use Mzh\Admin\Components\Widgets\Card;
use Mzh\Admin\Layout\Content;
use Mzh\Admin\Layout\Row;
use Mzh\Admin\Traits\HasApiCreate;
use Mzh\Admin\Traits\HasApiDelete;
use Mzh\Admin\Traits\HasApiList;
use Mzh\Admin\Traits\HasApiPut;
use Mzh\Swagger\Annotation\ApiController;
use Mzh\Swagger\Annotation\GetApi;

/**
 * @ApiController(prefix="/admin/home",tag="首页",ignore={"list"}))
 * @package App\Controller
 */
class Home extends AbstractAdminController
{

    use HasApiCreate,HasApiDelete,HasApiList,HasApiPut;

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

    /**
     * @GetApi()
     * @return Content
     */
    public function main(){
        $content = new Content();
        $content->className('m-10')
            ->row(function (Row $row) {
                $row->gutter(10);
                $row->column(12, Alert::make("你好，同学！！", "欢迎使用 hyperf-admin")->showIcon()->closable(false)->type("success"));
                $row->column(12, Alert::make("你好，同学！！", "欢迎使用 hyperf-admin")->showIcon()->closable(false)->type("error"));
            })->row(function (Row $row) {
                $row->gutter(10);
                $row->className('mt-10');
                $row->column(12, Alert::make("你好，同学！！", "欢迎使用 hyperf-admin")->showIcon()->closable(false)->type("info"));
                $row->column(12, Alert::make("你好，同学！！", "欢迎使用 hyperf-admin")->showIcon()->closable(false)->type("warning"));
            })->row(function (Row $row) {
                $row->gutter(10)->className('mt-10');
                $row->column(12, Card::make()->bodyStyle(['padding' => '0'])->content(
                    Line::make()
                        ->data(function () {
                            $data = collect();
                            for ($year = 2010; $year <= 2020; $year++) {
                                $data->push([
                                    'year' => (string)$year,
                                    'type' => '小红',
                                    'value' => rand(100, 1000)
                                ]);
                                $data->push([
                                    'year' => (string)$year,
                                    'type' => '小白',
                                    'value' => rand(100, 1000)
                                ]);
                            }
                            return $data;
                        })
                        ->config(function () {
                            return [
                                'title' => [
                                    'visible' => true,
                                    'text' => '折线图',
                                ],
                                'description' => [
                                    'visible' => true,
                                    'text' => '他们最常用于表现趋势和关系，而不是传达特定的值。',
                                ],
                                'seriesField' => 'type',
                                'smooth' => true,
                                'xField' => 'year',
                                'yField' => 'value'
                            ];
                        })
                ));
                $row->column(12, Card::make()->bodyStyle(['padding' => '0'])->content(
                    Area::make()
                        ->data(function () {
                            $data = collect();
                            for ($year = 2010; $year <= 2020; $year++) {
                                $data->push([
                                    'year' => (string)$year,
                                    'type' => '小红面积',
                                    'value' => rand(100, 1000)
                                ]);
                                $data->push([
                                    'year' => (string)$year,
                                    'type' => '小白面积',
                                    'value' => rand(100, 1000)
                                ]);
                            }
                            return $data;
                        })
                        ->config(function () {
                            return [
                                'title' => [
                                    'visible' => true,
                                    'text' => '面积图',
                                ],
                                'description' => [
                                    'visible' => true,
                                    'text' => '他们最常用于表现趋势和关系，而不是传达特定的值。',
                                ],
                                'seriesField' => 'type',
                                'smooth' => false,
                                'xField' => 'year',
                                'yField' => 'value'
                            ];
                        })
                ));
            })->row(function (Row $row) {
                $row->gutter(10)->className('mt-10');
                $row->column(12, Card::make()->bodyStyle(['padding' => '0'])->content(
                    StepLine::make()
                        ->data(function () {
                            $data = collect();
                            for ($year = 2010; $year <= 2020; $year++) {
                                $data->push([
                                    'year' => (string)$year,
                                    'type' => '小红面积',
                                    'value' => rand(100, 1000)
                                ]);
                            }
                            return $data;
                        })
                        ->config(function () {
                            return [
                                'title' => [
                                    'visible' => true,
                                    'text' => '阶梯图',
                                ],
                                'description' => [
                                    'visible' => true,
                                    'text' => '阶梯线图用于表示连续时间跨度内的数据',
                                ],
                                'smooth' => false,
                                'xField' => 'year',
                                'yField' => 'value'
                            ];
                        })
                ));
                $row->column(12, Card::make()->bodyStyle(['padding' => '0'])->content(
                    Column::make()
                        ->data(function () {
                            $data = collect();
                            for ($year = 2010; $year <= 2020; $year++) {
                                $data->push([
                                    'year' => (string)$year,
                                    'type' => '小红面积',
                                    'value' => rand(100, 1000)
                                ]);
                            }
                            return $data;
                        })
                        ->config(function () {
                            return [
                                'title' => [
                                    'visible' => true,
                                    'text' => '条形图',
                                ],
                                'description' => [
                                    'visible' => true,
                                    'text' => '条形图即是横向柱状图，相比基础柱状图，条形图的分类文本可以横向排布，因此适合用于分类较多的场景',
                                ],
                                'smooth' => false,
                                'xField' => 'year',
                                'yField' => 'value'
                            ];
                        })
                ));
            });
        return $content;
    }
}
