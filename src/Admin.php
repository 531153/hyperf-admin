<?php
declare(strict_types=1);
namespace Mzh\Admin;

use Mzh\Admin\Controller\Admin\Auth;
use Hyperf\HttpMessage\Server\Response;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Mzh\Admin\Auth\Database\Administrator;
use Mzh\Admin\Auth\Database\Menu;

class Admin
{

    protected $menu = [];
    protected $menuList = [];
    public static $metaTitle;

    public static $scripts = [];

    public static $styles = [];

    public static $css = [];

    public static function css($css = null)
    {
        if (!is_null($css)) {
            return self::$css = array_merge(self::$css, (array)$css);
        }
        $css = array_merge(static::$css, []);
        $css = array_filter(array_unique($css));
        return view('admin::partials.css', compact('css'));
    }


    public static function script($name, $path)
    {
        static::$scripts[$name] = $path;

        return new static;
    }

    public static function style($name, $path)
    {
        static::$styles[$name] = $path;

        return new static;
    }

    public static function scripts()
    {
        return static::$scripts;
    }

    public static function styles()
    {
        return static::$styles;
    }

    public static function setTitle($title)
    {
        self::$metaTitle = $title;
    }

    /**
     * Get admin title.
     *
     * @return string
     */
    public function title()
    {
        return self::$metaTitle ? self::$metaTitle : config('admin.title');
    }

    public function menu()
    {
        if (!empty($this->menu)) {
            return $this->menu;
        }
        $menuClass = config('admin.database.menu_model');
        /** @var Menu $menuModel */
        $menuModel = new $menuClass();

        $allNodes = $menuModel->allNodes();
        return $this->menu = $menuModel->buildNestedArray($allNodes);
    }

    public function menuList()
    {
        if (!empty($this->menuList)) {
            return $this->menuList;
        }
        $menuClass = config('admin.database.menu_model');
        /** @var Menu $menuModel */
        $menuModel = new $menuClass();
        return $this->menuList = collect($menuModel->allNodes())->map(function ($item) {
            return [
                'uri' => $item['uri'],
                'title' => $item['title'],
                'route' => $item['route'],
            ];
        })->all();
    }


    public function bootstrap()
    {
        require config('admin.bootstrap', admin_path('bootstrap.php'));
    }


    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable|null|Administrator
     */
    public function user()
    {
        return $this->guard()->user();
    }

    /**
     * Attempt to get the guard from the local cache.
     *
     * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    public function guard()
    {
        $guard = config('admin.auth.guard') ?: 'admin';

        return Auth::guard($guard);
    }


    public function validatorData(array $all, $rules, $message = [])
    {
        $validator = \Validator::make($all, $rules, $message);
        if ($validator->fails()) {
            abort(400, $validator->errors()->first());
        }
        return $validator;
    }

    public static function response($data, $message = '', $code = 200, $headers = [])
    {
        $re_data = [
            'code' => $code,
            'message' => $message,
        ];
        if ($data) {
            $re_data['data'] = $data;
        }
        $response = new Response();
        return $response->withBody(new SwooleStream(json_encode($re_data, 256)));
    }

    public static function responseMessage($message = '', $code = 200)
    {
        return self::response([], $message, $code);
    }

    public static function responseError($message = '', $code = 400)
    {
        return self::response([], $message, $code);
    }

    /**
     * @param $url
     * @param bool $isVueRoute
     * @param string $message
     * @param string $type info/success/warning/error
     */
    public static function responseRedirect($url, $isVueRoute = true, $message = null, $type = 'success')
    {
        return self::response([
            'url' => $url,
            'isVueRoute' => $isVueRoute,
            'type' => $type
        ], $message, 301);
    }
}