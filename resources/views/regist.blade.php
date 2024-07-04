<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>用户注册</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 50px;
        }
        .form-container {
            width: 300px;
            margin: auto;
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
        .captcha-container {
            position: relative;
        }
        .captcha-container img {
            cursor: pointer;
        }
        .captcha-container img:hover {
            opacity: 0.8;
        }
        .alert-danger {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1 class="text-center">注册</h1>
    @if($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="form-container">
        <form action="/deal_regist" method="post">
            @csrf
            <div class="form-group">
                <label for="loginname">用户名</label>
                <input type="text" class="form-control" id="loginname" name="loginname" required>
            </div>
            <div class="form-group">
                <label for="email">邮箱地址</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="pwd">密码</label>
                <input type="password" class="form-control" id="pwd" name="pwd" required>
            </div>
            <div class="form-group captcha-container">
                <label for="code">验证码</label>
                <input type="text" class="form-control" id="code" name="code" required>
                <img src="{{ captcha_src() }}" alt="点击刷新验证码" onclick="refreshCaptcha()">
            </div>
            <button type="submit" class="btn btn-primary btn-block">注册</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function refreshCaptcha() {
            var captchaImage = document.querySelector('img[src*="captcha"]');
            captchaImage.src = "{{ captcha_src() }}?refresh=" + new Date().getTime();
        }
    </script>
</body>
</html>