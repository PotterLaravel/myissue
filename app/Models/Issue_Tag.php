<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue_Tag extends Model
{
    use HasFactory;
    protected $table = "issue_tag";
    protected $primarykey="id";
    public $timestamps = false;
    protected $guarded = [];
    public static function check_tags()
    {
        $obj=self::select('id', 'name');
        $obj->where('id', '>=', 0);
        $tags = $obj->get();
        return $tags;
    }
    public static function iftag($search_tag)
    {
        $obj=self::select('id');
        $obj->where('name', '=', $search_tag);
        $tagid = $obj->first();
        return $tagid;
    }
}
