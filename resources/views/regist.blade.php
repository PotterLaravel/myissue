<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>用户注册</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h1>注册</h1>
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                 <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="/deal_regist" method="post">
        @csrf
        用户名 : <input type="text", name="loginname"> <br>
        邮箱地址 :   <input type="text", name="email"> <br>
        密码 :   <input type="password", name="pwd"> <br>
        验证码 : <input type="text", name="code">
        <img src="{{ captcha_src() }}" alt="点击刷新验证码" onclick="refreshCaptcha()"> <br>
        <button>注册</button>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    		
    <script>
        function refreshCaptcha() {
            // 生成新的验证码图片
            var captchaImage = document.querySelector('img[src*="captcha"]');
            captchaImage.src = "{{ captcha_src() }}?refresh=" + new Date().getTime();
        }
    </script>
</body>
</html>