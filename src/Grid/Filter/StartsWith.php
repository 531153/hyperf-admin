<?php
declare(strict_types=1);
namespace Mzh\Admin\Grid\Filter;

class StartsWith extends Like
{
    protected $exprFormat = '{value}%';
}
