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
    <link href="https://fonts.googleapis.com/css2?family=Alatsi&family=Exo:ital,wght@0,100..900;1,100..900&family=Source+Sans+3:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="login-page">
        <img class="background-1" src="{{ asset('/img/b1.png') }}" alt="b1">
        <img class="background-2" src="{{ asset('/img/b2.png') }}" alt="b2">
        <div class="container content-wrap">
        <div class="row center-item">
            <div class="col-lg-6 content-1 col-12 col-md-12">
                <div class="login-form">
                    <form action="{{route('web.handleResetPassword', $token)}}" method="POST">
                        @csrf
                        <div>
                            <img src="{{ asset('/img/logo-2.png') }}" alt="logo">
                        </div>
                        <div class="c-1-title">Lấy lại mật khẩu</div>
                        <div class="c-1-label">Mật khẩu mới</div>
                        <div class="c-1-input">
                            <input type="password" placeholder="Mật khẩu mới" name="password" >
                        </div>
                        @error('password')
                            <div style="color: rgba(117,0,0,1);text-align: left; margin-bottom: 25px">
                                @switch($message)
                                    @case('The password field is required.')
                                        Vui lòng nhập mật khẩu
                                        @break
                                    @case('The password must be at least 3 characters.')
                                        Mật khẩu phải có ít nhất 3 ký tự
                                        @break
                                    @case('The password may not be greater than 255 characters.')
                                        Mật khẩu không được vượt quá 255 ký tự
                                        @break
                                    @default
                                        {{ $message }}
                                @endswitch
                            </div>
                        @enderror
                        <div class="c-1-label">Xác nhận mật khẩu</div>
                        <div class="c-1-input">
                            <input type="password" placeholder="Xác nhận mật khẩu" name="passwordConfirm" >
                        </div>
                        @error('passwordConfirm')
                            <div style="color: rgba(117,0,0,1);text-align: left; margin-bottom: 25px">{{ $message == "The password field is required."? "Vui lòng nhập mật khẩu xác nhận" : "Mật khẩu xác nhận không trùng khớp"  }}</div>
                        @enderror
                        <div class="c-1-button">
                            <button type="submit">Xác nhận</button>
                        </div>
                        
                    </form>
                </div>
            </div>
            <div class="col-lg-6 content-2 col-12 col-md-12">
                <img src="{{ asset('/img/Untitled-2.png') }}" class="c-img-2" alt="">
            </div>
        </div>
    </div>
</div>



</body>
</html>