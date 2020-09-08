<?php
declare(strict_types=1);
namespace Mzh\Admin\Components\Widgets;

use Hyperf\Database\Model\Model as Eloquent;
use Mzh\Admin\Components\Component;
use Mzh\Admin\Grid\BatchActions;
use Mzh\Admin\Grid\Column;
use Mzh\Admin\Grid\Concerns\HasDefaultSort;
use Mzh\Admin\Grid\Concerns\HasFilter;
use Mzh\Admin\Grid\Concerns\HasGridAttributes;
use Mzh\Admin\Grid\Concerns\HasPageAttributes;
use Mzh\Admin\Grid\Concerns\HasQuickSearch;
use Mzh\Admin\Grid\Filter;
use Mzh\Admin\Grid\Model;
use Mzh\Admin\Grid\Table\Attributes;
use Mzh\Admin\Grid\Toolbars;
use Mzh\Admin\Layout\Content;

class Category extends Component
{
    protected $componentName = "Tree";
    protected $header;
    protected $bodyStyle;

    protected $content;
    use HasGridAttributes, HasPageAttributes, HasDefaultSort, HasQuickSearch, HasFilter;

    /**
     * @var Model
     */
    protected $model;
    /**
     * 组件字段
     * @var Column[]
     */
    protected $columns = [];
    protected $rows;
    /**
     * 组件字段属性
     * @var array
     */
    protected $columnAttributes = [];
    /**
     * @var string
     */
    protected $keyName = 'id';
    /**
     * @var bool
     */
    protected $tree = false;
    /**
     * 表格数据来源
     * @var string
     */
    protected $dataUrl;

    protected $customData;

    protected $isGetData = false;
    private $actions;
    private $batchActions;
    private $toolbars;
    private $top;
    private $bottom;

    public function __construct(Eloquent $model = null)
    {
        $this->attributes = new Attributes();
        $this->dataUrl = admin_api_url(request()->path()).'/list';
        $this->model = new Model($model, $this);
        if ($model) {
            $this->keyName = $model->getKeyName();
            $this->defaultSort($model->getKeyName(), "asc");
        }
        $this->isGetData = request('get_data') == "true";
        $this->toolbars = new Toolbars($this);
        $this->batchActions = new BatchActions();
        $this->filter = new Filter($this->model);
    }

    public static function make()
    {
        return new Category();
    }
}
