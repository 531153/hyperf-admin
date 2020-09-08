<?php

use Hyperf\HttpMessage\Server\Response;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\HttpServer\Request;
use Hyperf\Utils\Context;
use Mzh\Admin\Components\Widgets\Html;
use Mzh\Admin\Layout\Content;
use Mzh\Admin\StorageFactory;
use Psr\Http\Message\ServerRequestInterface;


if (!function_exists('Storage')) {
    /**
     * @param string $fileSystem
     * @return StorageFactory
     */
    function Storage($fileSystem = '')
    {
        return getContainer(StorageFactory::class)->disk($fileSystem);
    }
}
if (!function_exists('generate_tree')) {
    function generate_tree(array $array, $pid_key = 'pid', $id_key = 'id', $children_key = 'children', $callback = null)
    {
        if (!$array) {
            return [];
        }
        //第一步 构造数据
        $items = [];
        foreach ($array as $value) {
            if ($callback && is_callable($callback)) {
                $callback($value);
            }
            $items[$value[$id_key]] = $value;
        }
        //第二部 遍历数据 生成树状结构
        $tree = [];
        foreach ($items as $key => $value) {
            //如果pid这个节点存在
            if (isset($items[$value[$pid_key]])) {
                $items[$value[$pid_key]][$children_key][] = &$items[$key];
            } else {
                $tree[] = &$items[$key];
            }
        }

        return $tree;
    }
}


if (!function_exists('is_validURL')) {

    function is_validURL($url)
    {
        $check = 0;
        if (filter_var($url, FILTER_VALIDATE_URL) !== false) {
            $check = 1;
        }
        return $check;
    }
}


if (!function_exists('request')) {
    function route($url, $param = [])
    {
        if (is_validURL($url)) {
            return $url;
        }
        $uri = request()->getUri();
        if (!empty($param)) {
            $param = http_build_query($param);
            $uri->withQuery($param);
        }
        return $uri->withPath($url)->__toString();
    }

}
if (!function_exists('request')) {
    /**
     * Get admin path.
     *
     * @param string $path
     *
     * @return string
     */
    function request($key = null)
    {
        if ($key !== null) {
            return (new  Request())->all()[$key] ?? '';
        }
        return new  Request();
    }
}


if (!function_exists('response')) {
    /**
     * Get admin path.
     *
     * @param string $path
     *
     * @return string
     */
    function response(): ResponseInterface
    {
        return new Response();//return $res->withBody(new SwooleStream(json_encode($re_data,256)));
    }
}


if (!function_exists('admin_path')) {

    /**
     * Get admin path.
     *
     * @param string $path
     *
     * @return string
     */
    function admin_path($path = '')
    {
        return ucfirst(config('admin.directory')) . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}

if (!function_exists('admin_base_path')) {
    /**
     * Get admin url.
     *
     * @param string $path
     *
     * @return string
     */
    function admin_base_path($path = '')
    {
        $prefix = '/' . trim(config('admin.route.prefix'), '/');

        $prefix = ($prefix == '/') ? '' : $prefix;

        $path = trim($path, '/');

        if (is_null($path) || strlen($path) == 0) {
            return $prefix ?: '/';
        }

        return $prefix . '/' . $path;
    }
}

if (!function_exists('admin_api_base_path')) {
    /**
     * Get admin url.
     *
     * @param string $path
     *
     * @return string
     */
    function admin_api_base_path($path = '')
    {
        $prefix = '/' . trim(config('admin.route.prefix_api'), '/');

        $prefix = ($prefix == '/') ? '' : $prefix;

        $path = trim($path, '/');

        if (is_null($path) || strlen($path) == 0) {
            return $prefix ?: '/';
        }

        return $prefix . '/' . $path;
    }
}

if (!function_exists('admin_url')) {
    /**
     * Get admin url.
     *
     * @param string $path
     * @param mixed $parameters
     * @param bool $secure
     *
     * @return string
     */
    function admin_url($path = '', $parameters = [], $secure = null)
    {
        if (\Illuminate\Support\Facades\URL::isValidUrl($path)) {
            return $path;
        }
        $secure = $secure ?: (config('admin.https') || config('admin.secure'));
        return url(admin_base_path($path), $parameters, $secure);
    }
}

if (!function_exists('admin_api_url')) {
    /**
     * Get admin url.
     *
     * @param string $path
     * @param mixed $parameters
     * @param bool $secure
     *
     * @return string
     */
    function admin_api_url($path = '', $parameters = [], $secure = null)
    {
        return str_replace('/list', '', $path);

        if (\Illuminate\Support\Facades\URL::isValidUrl($path)) {
            return $path;
        }
        $secure = $secure ?: (config('admin.https') || config('admin.secure'));
        return url(admin_api_base_path($path), $parameters, $secure);
    }
}

if (!function_exists('admin_file_url')) {
    function admin_file_url($path)
    {
        if (\Illuminate\Support\Str::contains($path, "//")) {
            return $path;
        }

        return \Storage::disk(config('admin.upload.disk'))->url($path);
    }
};

if (!function_exists('admin_toastr')) {

    /**
     * Flash a toastr message bag to session.
     *
     * @param string $message
     * @param string $type
     * @param array $options
     */
    function admin_toastr($message = '', $type = 'success', $options = [])
    {
        $toastr = new MessageBag(get_defined_vars());

        session()->flash('toastr', $toastr);
    }
}

if (!function_exists('admin_asset')) {

    /**
     * @param $path
     *
     * @return string
     */
    function admin_asset($path)
    {
        return $path;
        return (config('admin.https') || config('admin.secure')) ? secure_asset($path) : asset($path);
    }
}
if (!function_exists('instance_content')) {

    function instance_content($content = '')
    {
        if (is_string($content)) {
            return Html::make()->html($content);
        } elseif ($content instanceof \Closure) {
            $c_content = new Content();
            call_user_func($content, $c_content);
            return $c_content;
        } else {
            return $content;
        }
    }
}
