<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class Issue_User extends Model
{
    use HasFactory;
    protected $table = "issue_user";
    protected $primarykey="id";
    public $timestamps = false;
    protected $guarded = [];
    public static function checkregist($post)
    {
        try{
            $data = [
                'loginname'=>$post['loginname'],
                'email'=>$post['email'],
                'pwd'=>md5($post['pwd']),
                'created_at'=>Carbon::now()->toDateTimeString(),
                'ip'=>Request::ip(),
                'updated_at'=>Carbon::now()->toDateTimeString(),
                'times'=>0,
                'level'=>0
            ];
            self::create($data);
            $arr=['error'=>0,'msg'=> '注册成功,请登录', 'info'=>$data];
            //return showMessage(['success'=>$arr['msg'], 'url'=>'/login', 'time'=>5]);
        }catch(\Exception $e){
            $arr=['error'=>1,'msg'=> $e->getMessage()];
            //return showMessage(['success'=>$arr['msg'], 'url'=>'/regist', 'time'=>5]);
        }
        return $arr;
    }
    public static function checklogin($post)
    {
        try{
        $one=self::where("email", $post['email'])
            ->where('pwd', md5($post['pwd']))
            ->first();
        if($one){
            //修改登录次数，时间，ip
            $data = [
                'ip'=>Request::ip(),
                'updated_at'=>Carbon::now()->toDateTimeString(),
                'times'=>DB::raw('times+1')
            ];
            self::where('id', $one->id)
                ->update($data);
            $arr=['error'=>0,'msg'=> '登录成功', 'info'=>$one];
        }
        else{
            $arr=['error'=>1,'msg'=> '用户名或密码错误'];
        }
        }catch(\Exception $e){
            $arr=['error'=>2,'msg'=>'系统错误', 'eMsg'=> $e->getMessage()];
        }
        return $arr;
    }
    public static function userinfo($thisone)
    {
        try
        {
            $session_pwd = Session('userinfo')['pwd'];
            $session_id = Session('userinfo')['id'];
            if($session_pwd==md5($thisone['old_pwd'])){
                $data = [
                    'loginname'=>$thisone['new_loginname'],
                    'pwd'=>md5($thisone['new_pwd'])
                ];
                self::where('id', $session_id)->update($data);
                $arr=['error'=>0,'msg'=> '修改成功,请重新登录'];
            }else{
                $arr=['error'=>0,'msg'=> '旧密码错误'];
            }
        }
        catch(\Exception $e)
        {
            $arr=['error'=>2,'msg'=>'系统错误', 'eMsg'=> $e->getMessage()];
        }
        return $arr;
    }
}
