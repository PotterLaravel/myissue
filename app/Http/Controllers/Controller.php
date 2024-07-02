<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;

abstract class Controller
{
    //构造方法
    public function __construct()
    {
        $this->init();
    }
    //初始化方法
    public function init()
    {
        //登录验证session
        if(!Session::has('userinfo')){
            echo showMessage(['success'=>'请登录', 'url'=>'/login', 'time'=>10]);
            exit;
        }
    }
}
