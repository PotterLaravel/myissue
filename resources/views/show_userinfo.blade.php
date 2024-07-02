<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>个人信息</title>	
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h1>个人信息</h1>
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                 <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="/edit_userinfo" method="post">
        @csrf
        昵称 : <input type="text", name="new_loginname" value="{{session('userinfo')['loginname']??''}}"> <br>
        旧密码 :   <input type="password", name="old_pwd"> <br>
        新密码 : <input type="password", name="new_pwd"> <br>
        <button>提交修改</button>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>