<?php
declare(strict_types=1);
namespace Mzh\Admin\Grid\Filter;

class Ilike extends Like
{
    protected $operator = 'ilike';
}
