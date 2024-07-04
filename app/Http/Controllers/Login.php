<?php
namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request as HttpRequest;
Use App\Models\Issue_User;
use Illuminate\Support\Facades\Session;

class Login extends Controller
{
    //为避免继承Controller类的验证session方法，写一个空的覆盖
    public function init()
    {
        
    }
    public function deal_login(LoginRequest $request){
        $post_content = $request->post();
        $rt = Issue_User::checklogin($post_content);
        if($rt['error'] == 0){
            Session::put('userinfo', $rt['info']);
            return showMessage(['success'=>$rt['msg'], 'url'=>'/mainpage', 'time'=>5]);
        }else{
            return showMessage(['success'=>$rt['msg'], 'url'=>'/login', 'time'=>5]);
        }
    }
}