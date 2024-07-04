<?php

use App\Events\Messages;
use App\Http\Controllers\Regist;
use App\Http\Controllers\Login;
use App\Http\Controllers\Mainpage;
use App\Http\Middleware\ContentAuditMiddleware;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

//注册视图
Route::view('regist', 'regist');
//注册处理路由
Route::post('deal_regist', [Regist::class,'deal_regist']);
//登录表单视图
Route::view('login', 'login');
Route::get('/', [Mainpage::class, 'issues']);
//登录处理路由
Route::post('deal_login', [Login::class,'deal_login']); 
//主页路由
Route::get('mainpage', [Mainpage::class, 'issues']);
//显示个人信息
Route::view('show_userinfo', 'show_userinfo');
//修改用户信息
Route::post('edit_userinfo', [Mainpage::class, 'edit_userinfo']);
//退出登录
Route::post('logout', [Mainpage::class, 'logout']);
//保存发布的issue
Route::post('store_issue', [Mainpage::class,'store_issue'])
       ->middleware(ContentAuditMiddleware::class);
//issue筛选
Route::post('issue_filter', [Mainpage::class,'issue_filter']);
//显示issue详情
Route::get('show_issue/{id}', [Mainpage::class, 'show_issue'])
       ->where('id', '[0-9]+');
//提交comment
Route::post('store_comment', [Mainpage::class,'store_comment'])
       ->middleware(ContentAuditMiddleware::class);
//关闭issue
Route::get('close_issue/{id}', [Mainpage::class, 'close_issue'])
       ->where('id', '[0-9]+');
//重新打开issue
Route::get('reopen_issue/{id}', [Mainpage::class, 'reopen_issue'])
       ->where('id', '[0-9]+');
//处理404
Route::fallback(function () {
    return redirect('/');
});

// //广播消息
// Route::get('broadcasting/test', function () {
//        //broadcast(new \App\Events\Messages("[".date("Y-m-d H:i:s")."] 新消息来了"));
//        broadcast(new Messages("".date("Y-m-d H:i:s").""));
// });