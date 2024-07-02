<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Issue_Comment extends Model
{
    use HasFactory;
    protected $table = "issue_comment";
    protected $primarykey="id";
    public $timestamps = false;
    protected $guarded = [];
    public static function check_comment($id)
    {
        $obj=self::join('issue_user as iu', 'issue_comment.user_id', '=', 'iu.id')
                   ->select('issue_comment.content', 'issue_comment.created_at', 'issue_comment.updated_at', 'iu.email');
        $obj->where('issue_comment.issue_id', $id);
        //$obj->where('issue_comment.user_id','=', session('userinfo')['id']);
        $comments = $obj->get();
        return $comments;
    }
    public static function create_comment($issue_id, $creator_id, $comment)
    {
        try
        {
            $data = [
                'issue_id'=>$issue_id,
                'user_id'=>$creator_id,
                'content'=>$comment,
                'created_at'=>Carbon::now()->toDateTimeString()
            ];
            self::create($data);
            $arr=['error'=>0,'msg'=> '提交成功'];
        }
        catch(\Exception $e)
        {
            $arr=['error'=>2,'msg'=>'系统错误', 'eMsg'=> $e->getMessage()];
        }
        return $arr;
    }
    
}
