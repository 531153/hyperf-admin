<?php
declare(strict_types=1);
namespace Mzh\Admin\Grid\Filter;

class EndsWith extends Like
{
    protected $exprFormat = '%{value}';
}
