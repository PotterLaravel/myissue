<?php
namespace App\Http\Controllers;

use App\Http\Requests\RegistRequest;
Use App\Models\Issue_User;
use Illuminate\Support\Facades\Session;

class Regist extends Controller
{
    //为避免继承Controller类的验证session方法，写一个空的覆盖
    public function init()
    {
        
    }
    public function deal_regist(RegistRequest $request){
        //接用户提交的登录值
        $post_content = $request->post();
        $rt = Issue_User::checkregist($post_content);
        if($rt['error'] == 0){
            //存储session
            //Session::put('userinfo', $rt['info']);
            return showMessage(['success'=>$rt['msg'], 'url'=>'/login', 'time'=>10]);
        }else{
            return showMessage(['success'=>$rt['msg'], 'url'=>'/regist', 'time'=>10]);
        }
    }
}