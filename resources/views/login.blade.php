<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>用户登录</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        .captcha img {
            cursor: pointer;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1 class="text-center mb-4">登录</h1>
        @if($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form action="/deal_login" method="post">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">邮箱地址</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="pwd" class="form-label">密码</label>
                <input type="password" class="form-control" id="pwd" name="pwd" required>
            </div>
            <div class="mb-3">
                <label for="code" class="form-label">验证码</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="code" name="code" required>
                    <span class="input-group-append">
                        <img src="{{ captcha_src() }}" alt="点击刷新验证码" class="captcha" onclick="refreshCaptcha()">
                    </span>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100">登录</button>
        </form>
        <div class="text-center mt-3">
            <a href="/regist" class="btn btn-link">注册</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function refreshCaptcha() {
            var captchaImage = document.querySelector('.captcha img');
            captchaImage.src = "{{ captcha_src() }}?refresh=" + new Date().getTime();
        }
    </script>
</body>
</html>