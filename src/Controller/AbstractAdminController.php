<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace Mzh\Admin\Controller;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Mzh\Admin\Components\Widgets\Button;
use Mzh\Admin\Components\Widgets\Dialog;
use Mzh\Admin\Components\Widgets\Html;
use Mzh\Admin\Components\Widgets\Markdown;
use Mzh\Admin\Layout\Content;
use Mzh\Admin\Traits\HasApiBase;
use Mzh\Admin\Traits\HasApiCreate;
use Mzh\Admin\Traits\HasApiDelete;
use Mzh\Admin\Traits\HasApiList;
use Mzh\Admin\Traits\HasApiPut;
use Mzh\Swagger\Annotation\DeleteApi;
use Mzh\Swagger\Annotation\GetApi;
use Mzh\Swagger\Annotation\Path;
use Mzh\Swagger\Annotation\PostApi;
use Mzh\Swagger\Annotation\PutApi;
use Psr\Container\ContainerInterface;

abstract class AbstractAdminController
{
    use HasApiCreate,HasApiDelete,HasApiList,HasApiPut;
}
