<?php
declare(strict_types=1);
namespace Mzh\Admin\Grid\Concerns;

use Mzh\Admin\Components\Widgets\Dialog;

trait HasDialog
{
    protected $dialog;

    public function dialog(\Closure $closure)
    {
        $this->dialog = new Dialog();
        call_user_func($closure, $this->dialog);
        return $this;
    }

}
