<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue_MyissueTag extends Model
{
    use HasFactory;
    protected $table = "issue_myissue_tag";
    protected $primarykey="id";
    public $timestamps = false;
    protected $guarded = [];
    public static function create_issue_tag($issue_id, $tags_arry)
    {
        try
        {
            foreach ($tags_arry as $tag)
            {
            $data=[
                'issue_id'=> $issue_id,
                'tag_id'=> $tag
            ];
            self::create($data);
            }
            $arr = ['error'=> 0,'msg'=> '添加成功'];
        }catch(\Exception $e){
            $arr = ['error'=> 1,'msg'=> '系统错误', 'eMsg'=> $e->getMessage()];
        }
        return $arr;
    }
}
