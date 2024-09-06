@extends('web.auth.layout.blank')
@section('content')
    <div class="login-page">
        <img class="background-1" src="{{ asset('/img/image/b1.png') }}" alt="b1">
        <img class="background-2" src="{{ asset('/img/image/b2.png') }}" alt="b2">
        <div class=" content-wrap">
        <div class="row center-item">
            <div class=" content-1">
                <div class="login-form" style="margin-top: -200px">
                    <form action="{{route('web.handleResetPassword', $token)}}" method="POST">
                        @csrf
                        <div>
                            <img src="{{ asset('/img/image/logo-2.png') }}" alt="logo">
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
            <div class="content-2 ">
                <img src="{{ asset('/img/image/Untitled-2.png') }}" class="c-img-2" alt="">
            </div>
        </div>
    </div>
</div>


@endsection