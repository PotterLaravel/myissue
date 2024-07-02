<?php
// 公共文件
// 跳转提示函数
function showMessage(array $array)
{
    if(!empty( $array["success"]) && !empty($array['url'])){
        $data = [
            'status' => 1,
            'message' => $array['success'],
            'url' => $array['url'],
            'jumpTime' => !empty($array['time']) ? $array['time']: 2,
            'ok' => !empty($array['ok']) ? $array['ok']: true
        ];
    } elseif(!empty( $array['error'])){
        $data = [
            'status' => 0,
            'message' => $array['error'],
            'url' => isset($array['url']) ? $array['url'] : 'javascript:history.back();',
            'jumpTime' => !empty($array['time']) ? $array['time']: 2,
            'ok' => !empty($array['ok']) ? $array['ok']: true
        ];
    } else {
        $data = [
            'status' => 0,
            'message' => '非法访问！',
            'url' => 'javascript:history.back();',
            'jumpTime' => 5,
            'ok' => !empty($array['ok']) ? $array['ok']: true
        ];
    }
    return view('public/message', ['data' => $data]);
}