<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="{{URL::asset('js/jquery-1.8.3.js')}}"></script>
</head>
<body>
<style type="text/css">
    .body-bgcolor{ background-color: #fff}
    .showMsg{border: 1px solid #1e64c8; zoom:1; width:450px; height:172px;position:absolute;top:44%;left:50%;margin:-87px 0 0 -225px}
    .showMsg h5{margin:0px;background-image: url({{asset('images/message/msg.png')}});background-repeat: no-repeat; color:#fff; padding-left:35px; height:25px; line-height:26px;*line-height:28px; overflow:hidden; font-size:14px; text-align:left}
    .showMsg .content{ padding:46px 12px 73px 45px; font-size:14px; height:64px;display: inline-block;}
    .showMsg .bottom{ background:#e4ecf7; margin: 0 1px 1px 1px;line-height:26px; *line-height:30px; height:26px; text-align:center}
    .showMsg .ok,.showMsg .guery{background: url({{asset('images/message/msg_bg.png')}}) no-repeat 0px -560px;}
    .showMsg .guery{background-position: left -460px;}
    #ti{color:#171717;size:18px;margin:10px,20px;}
    .hiht{display: block;height: 30px;font-size:18px;}
    .succeed{color:#29A50D;}.error{color:red;}
</style>
 
<div class="panel-body">
    <div class="showMsg" style="text-align:center">
        <div id='ti'><br>  提示信息</div>
        <div class="content guery">
            <span class="hiht {{($data['status']==1)?'succeed' : 'error' }}">{{ $data['message'] }}</span>
            <div>将在<span class="loginTime" style="color: red">{{$data['jumpTime']}}</span>秒后跳转</div>
        </div>
        <div class="bottom">
            @if($data['url'] == 'goback')
 
            @else
                <a href="{{ $data['url']}}">如果您的浏览器没有自动跳转，请点击这里</a>
            @endif
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        var url = "{{$data['url']}}"
        var loginTime = parseInt($('.loginTime').text());
        var time = setInterval(function(){
            loginTime = loginTime-1;
            $('.loginTime').text(loginTime);
            if(loginTime==0){
                clearInterval(time);
                window.location.href=url;
            }
        },1000);
    })
</script>
 
</body>
</html>