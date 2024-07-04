<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>个人信息</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            padding: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group .form-control {
            height: auto;
        }
        .btn {
            width: 100%;
        }
    </style>
</head>
<body>
    <h1 class="text-center">个人信息</h1>
    @if($errors->any())
        <div class="container">
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    <div class="container">
        <form action="/edit_userinfo" method="post">
            @csrf
            <div class="form-group">
                <label for="new_loginname">昵称</label>
                <input type="text" class="form-control" id="new_loginname" name="new_loginname" value="{{session('userinfo')['loginname']??''}}" required>
            </div>
            <div class="form-group">
                <label for="old_pwd">旧密码</label>
                <input type="password" class="form-control" id="old_pwd" name="old_pwd">
            </div>
            <div class="form-group">
                <label for="new_pwd">新密码</label>
                <input type="password" class="form-control" id="new_pwd" name="new_pwd">
            </div>
            <button type="submit" class="btn btn-primary">提交修改</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>