<?php
declare(strict_types=1);
namespace Mzh\Admin\Facades;

class Facade{
    public function __construct(){
        //
    }

    protected static function getInstance($classname){
        return new $classname();
    }

    protected static function getFacadeAccessor(){
        //
    }

    public static function __callstatic($method,$arg){
        $instance= static::getInstance(static::getFacadeAccessor());
        return call_user_func_array(array($instance,$method),$arg);
    }
}