<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Echop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('/css/auth.css') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="login-page">
        <img class="background-1" src="{{ asset('/img/b1.png') }}" alt="b1">
        <img class="background-2" src="{{ asset('/img/b2.png') }}" alt="b2">
        <div class=" content-wrap">
        <div class="row center-item">
            <div class="content-1">
                <div class="login-form">
                    <form action="{{route('web.authentication')}}" method="POST">
                        @csrf
                      @method("POST")
                        <div>
                            <img src="{{ asset('/img/logo-2.png') }}" alt="logo">
                        </div>
                        <div class="c-1-title">Đăng nhập</div>
                        <div class="c-1-label">Email</div>
                        <div class="c-1-input"><input type="text" placeholder="Email" name="email"></div>
                        <div class="c-1-label" >Mật khẩu</div>
                        <div class="c-1-input" >
                            <input  type="password" placeholder="Mật khẩu" name="password">
                        </div>
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="c-1-button"><button>Đăng nhập</button></div>
                        <div class="c-1-register"><a href="{{route('web.forgotPassword')}}">Quên mật khẩu? </a></div>
                        <div class="c-1-register">Bạn mới biết Echop? <a href="{{route('web.register')}}">Đăng ký</a></div>
                    </form>
                </div>
            </div>
            <div class=" content-2 ">
                <img src="{{ asset('/img/testbg.png') }}" class="c-img-2" alt="">
            </div>
        </div>
    </div>
</div>

</body>
</html>