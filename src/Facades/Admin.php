<?php
declare(strict_types=1);
namespace Mzh\Admin\Facades;

/**
 * Class Admin
 * @package Mzh\Admin\Facades
 */
class Admin extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Mzh\Admin\Admin::class;
    }
}
