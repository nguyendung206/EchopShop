@extends('web.auth.layout.blank')
@section('extra-css')
    <link rel="stylesheet" href="{{ asset('/css/register.css') }}">
@endsection

@section('content')
    <div class="login-page">
        <img class="background-1" src="{{ asset('/img/image/b1.png') }}" alt="b1">
        <img class="background-2" src="{{ asset('/img/image/b2.png') }}" alt="b2">
        
        <div class="center-large-item">
            <div class="row center-item">
                <div class="content-1">
                    <div class="register-form login-form">
                        <form action="{{route('web.register.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method("POST")
                            <div>
                                <img src="{{ asset('/img/image/logo-2.png') }}" alt="logo">
                            </div>
                            <div class="c-1-title">Đăng ký</div>
                            <div class="c-1-label-title">Nhập thông tin của bạn</div>
                            <div class="c-1-upload">
                                <div>
                                    {{-- <img src="{{ asset('/img/image/upload.png') }}" id="triggerImage"  alt=""> --}}
                                    <img id="Photo" src="{{ asset('/img/image/upload.png') }}" class="img img-bordered" onclick="document.getElementById('file').click();" style="width:100px;border-radius: 50%;" />

                                    <input type="file" id="file"  name="uploadFile" onchange="document.getElementById('Photo').src = window.URL.createObjectURL(this.files[0])" style="display: none;"/>
                                </div>
                            </div>
                            <div class="c-1-input c-1-name">
                                <input type="text" placeholder="Tên *" name="name"
                                class="@error('name') is-invalid  @enderror" value="{{ old('name') ? old('name') : null}}">
                                <img src="{{ asset('/img/icon/user-icon.png') }}" alt="">
                                @error('name')
                                    <div class="" style="color: rgba(117,0,0,1);text-align: left">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="c-1-input c-1-email">
                                <input type="text" placeholder="Email *" name="email" 
                                class="@error('email') is-invalid  @enderror" value="{{ old('email') ? old('email') : null}}">
                                <img src="{{ asset('/img/icon/sms-icon.png') }}" alt="" >
                            </div>
                            @error('email')
                                    <div class="" style="color: rgba(117,0,0,1);text-align: left">{{ $message }}</div>
                                @enderror
                            <div class="c-1-input c-1-phone">
                                <input type="text" placeholder="0123456789" class="text-phone" name="phone_number" 
                                class="@error('phone_number') is-invalid  @enderror" value="{{ old('phone_number') ? old('phone_number') : null}}">
                                <img src="{{ asset('/img/icon/phone-icon.png') }}" alt="">
                            </div>
                            @error('phone_number')
                                    <div class="" style="color: rgba(117,0,0,1);text-align: left">{{ $message }}</div>
                                @enderror
                            <div class="c-1-input c-1-email">
                                <input type="password" placeholder="Mật khẩu *" name="password" 
                                class="@error('password') is-invalid  @enderror" value="{{ old('password') ? old('password') : null}}">
                                <img src="{{ asset('/img/icon/user-icon.png') }}" alt="" >
                            </div>
                            @error('password')
                                    <div class="" style="color: rgba(117,0,0,1);text-align: left">{{ $message }}</div>
                                @enderror
                            <div class="c-1-input c-1-email">
                                <input type="password" placeholder="Xác nhận mật khẩu *" name="passwordConfirm" 
                                class="@error('passwordConfirm') is-invalid  @enderror" value="{{ old('passwordConfirm') ? old('passwordConfirm') : null}}">
                                <img src="{{ asset('/img/icon/user-icon.png') }}" alt="" >
                            </div>
                            @error('passwordConfirm')
                                    <div class="" style="color: rgba(117,0,0,1);text-align: left">{{ $message }}</div>
                                @enderror
                            <div class="c-1-input c-1-location"><img src="{{ asset('/img/image/location.png') }}" alt="">
                                <select class="text-center font-weight-500" name="province_id" id="province_select" >
                                    <option value="0">Tỉnh/Thành phố *</option>
                                    @foreach($provinces as $province)
                                        <option value="{{$province->id}}" >{{ $province->province_name }}</option>
                                    @endforeach
                                </select>
                                @error('province_id')
                                    <div class="" style="color: rgba(117,0,0,1);text-align: left">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="location-wrap">
                                <div class="c-1-input c-1-location-1">
                                    <select name="district_id" id="district_select" class="select-2">
                                        <option value="0" >Quận/Huyện *</option>
                                        <option value="0" disabled>Vui lòng chọn thành phố trước</option>
                                    </select>
                                    @error('district_id')
                                    <div class="" style="color: rgba(117,0,0,1);text-align: left">{{ $message }}</div>
                                @enderror
                                </div>
                                <div class="c-1-input c-1-location-2">
                                    <select name="ward_id" id="ward_select" class="select-2">
                                        <option value="0">Phường/Thị xã *</option>
                                        <option value="0" disabled>Vui lòng chọn quận huyện trước</option>
                                    </select>
                                    @error('ward_id')
                                    <div class="" style="color: rgba(117,0,0,1);text-align: left">{{ $message }}</div>
                                @enderror
                                </div>
                            </div>
                            <div class="c-1-input c-1-address">
                                <input type="text" placeholder="Địa chỉ chi tiết" name="address" 
                                class="@error('address') is-invalid  @enderror" value="{{ old('address') ? old('address') : null}}">
                            </div>
                            @error('address')
                                    <div class="" style="color: rgba(117,0,0,1);text-align: left">{{ $message }}</div>
                                @enderror
                            <div class="c-1-register">
                                <div class="custom-checkbox"></div>
                                <div class="term">
                                    Tôi đồng ý với <a href="#">Điều khoản sử dụng</a> và <a href="#">chính sách dịch vụ </a> của Echop</div>
                                    Bạn đã có tài khoản? <a href="{{route('web.login')}}">Đăng nhập</a>
                                    <div class="c-1-button"><button type="submit">Đăng ký</button></div>
                                </div>
                        </form>
                    </div>
                </div>
                <div class="content-2">
                        <img src="{{ asset('/img/image/testbg.png') }}" class="c-img-2" alt="">
                </div>
            </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>
<script>

    document.querySelector('.custom-checkbox').addEventListener('click', function() {
        this.classList.toggle('checked');
    });


    
</script>
@include('admin.customer.province')
<script>
    console.log(provinceIdUser);
    
</script>

@endsection