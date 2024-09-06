@extends('web.auth.layout.blank')
@section('content')
    <div class="login-page">
        <img class="background-1" src="{{ asset('/img/image/b1.png') }}" alt="b1">
        <img class="background-2" src="{{ asset('/img/image/b2.png') }}" alt="b2">
        <div class=" content-wrap">
        <div class="row center-item">
            <div class="content-1">
                <div class="login-form">
                    <form action="{{route('web.authentication')}}" method="POST">
                        @csrf
                      @method("POST")
                        <div>
                            <img src="{{ asset('/img/image/logo-2.png') }}" alt="logo">
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
                <img src="{{ asset('/img/image/testbg.png') }}" class="c-img-2" alt="">
            </div>
        </div>
    </div>
</div>

@endsection