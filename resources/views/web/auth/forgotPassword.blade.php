@extends('web.auth.layout.blank')
@section('content')
    <div class="login-page">
        <img class="background-1" src="{{ getImage(null,'/b1.png') }}" alt="b1">
        <img class="background-2" src="{{ getImage(null,'/b2.png') }}" alt="b2">
        <div class=" content-wrap">
        <div class="row center-item"  >
            <div class="content-1">
                <div class="login-form" style="margin-top: -50px">
                    <form action="{{ route('web.handleForgotPassword')}}" method="POST">
                        @csrf
                        <div>
                            <img src="{{ getImage(null,'/logo-2.png') }}" alt="logo">
                        </div>
                        <div class="c-1-title">Lấy lại mật khẩu</div>
                        <div class="c-1-label" style="text-align: center">Vui lòng nhập email của bạn</div>
                        <div class="c-1-input"><input type="text" placeholder="Email" name="email"></div>
                        @error('email')
                            <div style="color: rgba(117,0,0,1);text-align: left; margin-bottom: 25px">{{ $message }}</div>
                        @enderror
                        <div class="c-1-button"><button type="submit">Tiếp tục</button></div>
                        <div class="c-1-register">Bạn mới biết Echop? <a href="{{route('web.login')}}">Đăng nhập</a></div>
                    </form>
                </div>
            </div>
            <div class="content-2">
                <img src="{{ getImage(null,'/Untitled-2.png') }}" class="c-img-2" alt="">
            </div>
        </div>
    </div>
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
@endsection