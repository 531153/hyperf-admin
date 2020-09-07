<?php
declare(strict_types=1);
namespace Mzh\Admin\Grid\Actions;


use Mzh\Admin\Actions\BaseRowAction;

class DeleteAction extends BaseRowAction
{
    protected $componentName = "DeleteAction";

    protected $type = "text";

    protected $content = "删除";


    protected $message = "确定要删除此内容？";


}
