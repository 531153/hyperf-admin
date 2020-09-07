<?php
declare(strict_types=1);
namespace Mzh\Admin\Grid\Concerns;


use Closure;
use Mzh\Admin\Grid\Filter;

trait HasFilter
{
    /**
     * @var Filter
     */
    protected $filter;



    public function applyFilter($toArray = true)
    {

        return $this->filter->execute($toArray);
    }


    public function filter(Closure $callback)
    {
        call_user_func($callback, $this->filter);
    }
}
