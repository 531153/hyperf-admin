<?php
declare(strict_types=1);
namespace Mzh\Admin\Traits;


use Hyperf\Database\Model\Model;

trait ShouldSnakeAttributes
{
    /**
     * Indicates whether attributes are snake cased on arrays.
     *
     * @var bool
     */
    protected static $snakeAttributes;

    /**
     * Indicates if model should snake attribute name.
     *
     * @return bool
     */
    public function shouldSnakeAttributes()
    {
        if (is_bool(static::$snakeAttributes)) {
            return static::$snakeAttributes;
        }

        $model = ($this->model instanceof Model) ?
            $this->model->eloquent() : $this->model;

        $class = get_class($model);

        return static::$snakeAttributes = $class::$snakeAttributes;
    }
}