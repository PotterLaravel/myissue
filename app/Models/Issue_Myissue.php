<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Issue_Myissue extends Model
{
    use HasFactory;
    protected $table = "issue_myissue";
    protected $primarykey="id";
    public $timestamps = false;
    protected $guarded = [];
    public static function check_issue($creator_id)
    {
        $obj=self::join('issue_user as iu', 'issue_myissue.creator_id', '=', 'iu.id')
        ->select('issue_myissue.title', 'issue_myissue.content', 'issue_myissue.status', 'issue_myissue.tags_name', 'issue_myissue.id', 'issue_myissue.created_at', 'issue_myissue.updated_at', 'issue_myissue.creator_id','iu.email');
        $obj->where('creator_id', $creator_id);
        $issues = $obj->paginate(5);
        return $issues;
    }
    public static function check_all_issue()
    {
        //$obj=self::select('title', 'content', 'status', 'tags_name', 'id', 'created_at', 'updated_at', 'creator_id');
        $obj=self::join('issue_user as iu', 'issue_myissue.creator_id', '=', 'iu.id')
        ->select('issue_myissue.title', 'issue_myissue.content', 'issue_myissue.status', 'issue_myissue.tags_name', 'issue_myissue.id', 'issue_myissue.created_at', 'issue_myissue.updated_at', 'issue_myissue.creator_id','iu.email');
        $issues = $obj->paginate(5);
        return $issues;
    }
    public static function to_close_issue($issue_id)
    {
        try{
            $data = [
                'status'=>'close',
                'updated_at'=>Carbon::now()->toDateTimeString()
            ];
            self::where('id', $issue_id)->update($data);
            $arr=['error'=>0,'msg'=> '关闭成功'];
        }catch(\Exception $e){
            $arr=['error'=> 1,'msg'=>$e->getMessage()];
        }
        return $arr; 
    }
    public static function to_reopen_issue($issue_id)
    {
        try{
            $data = [
                'status'=>'reopen',
                'updated_at'=>Carbon::now()->toDateTimeString()
            ];
            self::where('id', $issue_id)->update($data);
            $arr=['error'=>0,'msg'=> '重开成功'];
        }catch(\Exception $e){
            $arr=['error'=> 1,'msg'=>$e->getMessage()];
        }
        return $arr;
    }
    public static function create_issue($post_content, $session_id)
    {
        try
        {
            if(!isset($post_content['tags'])){
                $tags_id = '[]';
            }else{
                //查询tags_name
                $tags_name = [];
                for($i=0;$i<count($post_content['tags']);$i++){
                    $result = DB::table('issue_tag')->select('name')->where('id', $post_content['tags'][$i])->first();
                    $tags_name[] = $result->name;
                }
                $tags_id = json_encode($post_content['tags']);
                $sql_tags_name = json_encode($tags_name);
            }
            $data=[
                'title'=> $post_content['title'],
                'content'=> $post_content['content'],
                'creator_id'=>$session_id,
                'status'=> 'open',
                'created_at'=>Carbon::now()->toDateTimeString(),
                'tags_id'=>$tags_id,
                'tags_name'=>$sql_tags_name
            ];
            $rt = self::create($data);
            $arr = ['error'=> 0,'msg'=> '添加成功', 'issue_id'=>$rt['id']];
        }catch(\Exception $e){
            $arr = ['error'=> 1,'msg'=> $e->getMessage(), 'eMsg'=> $e->getMessage()];
        }
        return $arr;
    }
    public static function search_issue_tag($creator_id, $tag_id)
    {
        $obj = DB::select("SELECT * FROM issue_myissue WHERE JSON_CONTAINS(tags_id, JSON_QUOTE(:tag_id), '$') AND creator_id = :creator_id", ['tag_id'=>"$tag_id", 'creator_id'=>$creator_id]);
        return $obj;
    }
    public static function search_issue_title($creator_id, $search_title)
    {
        $obj = DB::select("SELECT * FROM issue_myissue WHERE title = :search_title AND creator_id = :creator_id", ['search_title'=>$search_title, 'creator_id'=>$creator_id]);
        return $obj;
    }
    public static function search_issue_tag_title($creator_id, $tag_id, $search_title)
    {
        $obj = DB::select("SELECT * FROM issue_myissue WHERE JSON_CONTAINS(tags_id, JSON_QUOTE(:tag_id), '$') AND creator_id = :creator_id AND title = :search_title", ['tag_id'=>"$tag_id", 'creator_id'=>$creator_id,'search_title'=>$search_title]);
        return $obj;
    }
    public static function issue_detail($id)
    {
        //$obj=self::select('title', 'content', 'creator_id', 'status', 'tags_name', 'tags_id', 'created_at', 'updated_at', 'id');
        $obj=self::join('issue_user as iu', 'issue_myissue.creator_id', '=', 'iu.id')
        ->select('issue_myissue.title', 'issue_myissue.content', 'issue_myissue.status', 'issue_myissue.tags_name', 'issue_myissue.id', 'issue_myissue.created_at', 'issue_myissue.updated_at', 'issue_myissue.creator_id','iu.email');
        $obj->where('issue_myissue.id', $id);
        $issues = $obj->first();
        return $issues;
    }
}
