<?php
namespace App\Http\Controllers;

use App\Http\Requests\EditUserinfoRequest;
use App\Models\Issue_Comment;
use App\Models\Issue_Myissue;
use App\Models\Issue_User;
use App\Models\Issue_Tag;
use App\Models\Issue_MyissueTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;

use function PHPUnit\Framework\isEmpty;

class Mainpage extends Controller{
    public function issues()
    {
        $creator_id = Session('userinfo')['id'];
        $user_level = Session('userinfo')['level'];
        if($user_level == 0){
        $issues = Issue_Myissue::check_issue($creator_id);
        }else{
            $issues = Issue_Myissue::check_all_issue();
        }
        $tags = Issue_Tag::check_tags();
        return view(
            "mainpage",
            ['issues'=>$issues, 'tags'=>$tags]
        );
    }
    public function edit_userinfo(EditUserinfoRequest $request)
    {
        $thisone=$request->post();
        $rt=Issue_User::userinfo($thisone);
        if($rt['error'] == 0){
            //销毁session
            Session::flush();
            return showMessage(['success'=>$rt['msg'], 'url'=>'/login', 'time'=>5]);
        }else{
            return showMessage(['success'=>$rt['msg'], 'url'=>'/show_userinfo', 'time'=>5]);
        }
    }
    public function logout()
    {
        //销毁session
        Session::flush();
        return view(
            "login"
        );
    }

    public function store_issue(Request $request)
    {
        $post_content = $request->post();
        $session_id = Session("userinfo")["id"];
        $rt = Issue_Myissue::create_issue($post_content, $session_id);
        if($rt['error'] == 0){
            // 创建tags和issue关联数据
            // $issue_id = $rt['issue_id'];
            // $tags_arry = $post_content['tags'];
            // $rt = Issue_MyissueTag::create_issue_tag($issue_id, $tags_arry);
            return showMessage(['success'=>$rt['msg'], 'url'=>'/mainpage', 'time'=>5]);
        }else{
            return showMessage(['success'=>$rt['msg'], 'url'=>'/mainpage', 'time'=>5]);
        }
    }

    public function issue_filter(Request $request)
    {
        $post_content = $request->post();
        $search_tag = $post_content['tag'];
        $search_title = $post_content['title'];
        $creator_id = Session('userinfo')['id'];
        $tags = Issue_Tag::check_tags();
        if($search_tag == null and $search_title == null){
            //return showMessage(['success'=>'查询成功', 'url'=>"/mainpage", 'time'=>1]);
            return self::issues();
        }elseif(!$search_tag == null and $search_title == null){
            //判断tag是否存在
            $rt = Issue_Tag::iftag($search_tag);
            if($rt == null){
                return showMessage(['success'=>'tag不存在', 'url'=>"/mainpage", 'time'=>5]);
            }else{
                $tag_id = $rt['id'];
                $issues = Issue_Myissue::search_issue_tag($creator_id, $tag_id);
            }
        }elseif(!$search_title == null and $search_tag == null){
            $issues = Issue_Myissue::search_issue_title($creator_id, $search_title);
        }else{
            //判断tag是否存在
            $rt = Issue_Tag::iftag($search_tag);
            if($rt == null){
                return showMessage(['success'=>'tag不存在', 'url'=>"/mainpage", 'time'=>5]);
            }else{
                $tag_id = $rt['id'];
                $issues = Issue_Myissue::search_issue_tag_title($creator_id, $tag_id, $search_title);
            }
        }
        $issues = collect($issues);
        return view(
            "mainpage",
            ['issues'=>$issues, 'tags'=>$tags]
        );
        //$issues = Issue_Myissue::search_issue($creator_id, $post_content);
        //return showMessage(['success'=>'查询成功', 'url'=>"/show_issue/?id={{$issues['id']}}", 'time'=>5]);
    }

    public function show_issue($id)
    {
        $issues = Issue_Myissue::issue_detail($id);
        $comments = Issue_Comment::check_comment($id);
        return view(
            "show_issue",
            ['issue'=>$issues, 'comments'=>$comments]
        );
    }
    public function close_issue($id)
    {
        $rt = Issue_Myissue::to_close_issue($id);
        if($rt['error'] == 0){
            return showMessage(['success'=>$rt['msg'], 'url'=>'/mainpage', 'time'=>5]);
        }else{
            return showMessage(['success'=>$rt['msg'], 'url'=>'/mainpage', 'time'=>5]);
        }
    }
    public function reopen_issue($id)
    {
        $rt = Issue_Myissue::to_reopen_issue($id);
        if($rt['error'] == 0){
            return showMessage(['success'=>$rt['msg'], 'url'=>'/mainpage', 'time'=>5]);
        }else{
            return showMessage(['success'=>$rt['msg'], 'url'=>'/mainpage', 'time'=>5]);
        }
    }
    public function store_comment(Request $request)
    {
        $post_content = $request->post();
        $comment = $post_content['content'];
        $issue_id = $post_content['issue_id'];
        $creator_id = session('userinfo')['id'];
        $rt=Issue_Comment::create_comment($issue_id, $creator_id, $comment);
        if($rt['error'] == 0){
            return showMessage(['success'=>'提交成功', 'url'=>'/mainpage', 'time'=>5]); 
        }else{
            return showMessage(['success'=>$rt['msg'], 'url'=>'/mainpage', 'time'=>5]);
        }
    }

} 