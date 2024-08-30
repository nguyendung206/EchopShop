<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Echop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('/css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/register.css') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

</head>
<body>
    <div class="login-page">
        <img class="background-1" src="{{ asset('/img/b1.png') }}" alt="b1">
        <img class="background-2" src="{{ asset('/img/b2.png') }}" alt="b2">
        
        <div class="center-large-item">
            <div class="row center-item">
                <div class="content-1">
                    <div class="register-form login-form">
                        <form action="{{route('web.register.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method("POST")
                            <div>
                                <img src="{{ asset('/img/logo-2.png') }}" alt="logo">
                            </div>
                            <div class="c-1-title">Đăng ký</div>
                            <div class="c-1-label-title">Nhập thông tin của bạn</div>
                            <div class="c-1-upload">
                                <div>
                                    {{-- <img src="{{ asset('/img/upload.png') }}" id="triggerImage"  alt=""> --}}
                                    <img id="Photo" src="{{ asset('/img/upload.png') }}" class="img img-bordered" onclick="document.getElementById('file').click();" style="width:100px;border-radius: 50%;" />

                                    <input type="file" id="file"  name="uploadFile" onchange="document.getElementById('Photo').src = window.URL.createObjectURL(this.files[0])" style="display: none;"/>
                                </div>
                            </div>
                            <div class="c-1-input c-1-name">
                                <input type="text" placeholder="Tên *" name="name"
                                class="@error('name') is-invalid  @enderror" value="{{ old('name') ? old('name') : null}}">
                                <img src="{{ asset('/img/user-icon.png') }}" alt="">
                                @error('name')
                                    <div class="" style="color: rgba(117,0,0,1);text-align: left">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="c-1-input c-1-email">
                                <input type="text" placeholder="Email *" name="email" 
                                class="@error('email') is-invalid  @enderror" value="{{ old('email') ? old('email') : null}}">
                                <img src="{{ asset('/img/sms-icon.png') }}" alt="" >
                            </div>
                            @error('email')
                                    <div class="" style="color: rgba(117,0,0,1);text-align: left">{{ $message }}</div>
                                @enderror
                            <div class="c-1-input c-1-phone">
                                <input type="text" placeholder="0123456789" class="text-phone" name="phone_number" 
                                class="@error('phone_number') is-invalid  @enderror" value="{{ old('phone_number') ? old('phone_number') : null}}">
                                <img src="{{ asset('/img/phone-icon.png') }}" alt="">
                            </div>
                            @error('phone_number')
                                    <div class="" style="color: rgba(117,0,0,1);text-align: left">{{ $message }}</div>
                                @enderror
                            <div class="c-1-input c-1-email">
                                <input type="password" placeholder="Mật khẩu *" name="password" 
                                class="@error('password') is-invalid  @enderror" value="{{ old('password') ? old('password') : null}}">
                                <img src="{{ asset('/img/user-icon.png') }}" alt="" >
                            </div>
                            @error('password')
                                    <div class="" style="color: rgba(117,0,0,1);text-align: left">{{ $message }}</div>
                                @enderror
                            <div class="c-1-input c-1-email">
                                <input type="password" placeholder="Xác nhận mật khẩu *" name="passwordConfirm" 
                                class="@error('passwordConfirm') is-invalid  @enderror" value="{{ old('passwordConfirm') ? old('passwordConfirm') : null}}">
                                <img src="{{ asset('/img/user-icon.png') }}" alt="" >
                            </div>
                            @error('passwordConfirm')
                                    <div class="" style="color: rgba(117,0,0,1);text-align: left">{{ $message }}</div>
                                @enderror
                            <div class="c-1-input c-1-location"><img src="{{ asset('/img/location.png') }}" alt="">
                                    @csrf
                                <select class="text-center font-weight-500" name="province_id" id="province_select">
                                    <option value="0">Tỉnh/Thành phố *</option>
                                    @foreach($provinces as $province)
                                        <option value="{{$province->id}}">{{ $province->province_name }}</option>
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
                                    <div class="c-1-button"><button type="submit">Đăng ký</button></div>
                                </div>
                        </form>
                    </div>
                </div>
                <div class="content-2">
                        <img src="{{ asset('/img/testbg.png') }}" class="c-img-2" alt="">
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


    $(document).ready(function() {
        $('#province_select').change(function() {
            var provinceId = $(this).val(); // Lấy giá trị được chọn

            $.ajax({
                url: '{{ route('web.district') }}', 
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', 
                    provinceId: provinceId 
                },
                success: function(response) {
                    $('#district_select').empty().append('<option value="0">Quận/Huyện *</option>');

                    $.each(response.districts, function(index, district) {
                        $('#district_select').append('<option value="' + district.id + '">' + district.district_name + '</option>');
                    });

                    $('#ward_select').empty().append('<option value="0" >Phường/Thị xã *</option>');
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        });

        $('#district_select').change(function() {
            var districtId = $(this).val(); // Lấy giá trị được chọn
            $.ajax({
                url: '{{ route('web.ward') }}', 
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', 
                    districtId: districtId 
                },
                success: function(response) {
                    console.log(response.wards)
                    $('#ward_select').empty().append('<option value="0">Phường/Thị xã *</option>');

                    $.each(response.wards, function(index, ward) {
                        $('#ward_select').append('<option value="' + ward.id + '">' + ward.ward_name + '</option>');
                    });
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>
</body>
</html>