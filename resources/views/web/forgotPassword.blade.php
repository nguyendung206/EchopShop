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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
                    <form action="{{ route('web.handleForgotPassword')}}" method="POST">
                        @csrf
                        <div>
                            <img src="{{ asset('/img/logo-2.png') }}" alt="logo">
                        </div>
                        <div class="c-1-title">Lấy lại mật khẩu</div>
                        <div class="c-1-label">Vui lòng nhập email của bạn</div>
                        <div class="c-1-input"><input type="text" placeholder="Email" name="email"></div>
                        @error('email')
                            <div style="color: rgba(117,0,0,1);text-align: left; margin-bottom: 25px">{{ $message }}</div>
                        @enderror
                        <div class="c-1-button"><button type="submit">Tiếp tục</button></div>
                        <div class="c-1-register">Bạn mới biết Echop? <a href="{{route('web.login')}}">Đăng nhập</a></div>
                    </form>
                </div>
            </div>
            <div class="col-lg-6 content-2 col-12 col-md-12">
                <img src="{{ asset('/img/Untitled-2.png') }}" class="c-img-2" alt="">
            </div>
        </div>
    </div>
    {{-- @include('flash::message')
    @if (session()->has('flash_notification'))
    <div class="flash-message {{ session('flash_notification.class') }}">
        {{ session('flash_notification.message') }}
    </div>
    @endif --}}
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        @if (session()->has('flash_notification'))
            Swal.fire({
                icon: '{{ session('flash_notification.class', 'success') }}',
                title: '{{ session('flash_notification.title', 'Thông báo') }}',
                text: '{{ session('flash_notification.message', 'Đã gửi tin nhắn đến mail của bạn vui lòng kiểm tra mail') }}',
                showConfirmButton: true,
            });
        @endif
    });
</script>

</body>
</html>