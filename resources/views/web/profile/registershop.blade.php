@extends('web.layout.app')
@section('css')
<link rel="stylesheet" href="{{ asset('/css/profile.css') }}">
@endsection
@section('title')
SALES REGISTRATION
@endsection
@section('content')
<div class="profile-slider">
    <h1 class="profile-heading text-center">đăng ký bán hàng</h1>
</div>
@include('web.profile.sidebarMobile')
<div class="container">
    <div class="row">
        @include('web.profile.sidebar')
        <div class="col-lg-9 col-sm-12 col-12 mt-4">
            @if(isset(optional(Auth::user()->shop)->status->value) && optional(Auth::user()->shop)->status->value === 2)
            <h1 class="profile-title text-center">Đang chờ phê duyệt</h1>
            @else
            <div class="col-md-12">
                <h1 class="profile-title">Thông tin Shop</h1>
                <p class="profile-content">Những thông tin dưới đây đại diện cho Shop của bạn. Vui lòng nhập đầy đủ các thông tin.</p>
            </div>
            <form action="{{route('registershop.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" value="{{ optional(Auth::user())->id }}">
                <div class="row">
                    <div class="col-lg-3 col-sm-12 col-12 text-center mb-4">
                        <div id="logoImageContainer">
                            <img id="logoImagePreview" src="{{asset('/img/image/upload.png') }}" alt="Logo Shop" class="upload-img" style="cursor: pointer; object-fit:cover; height: 100%; width: 100%;">
                            <input type="file" id="logoImageInput" name="logo" style="display: none;" accept="image/*" onchange="previewLogoImage(event)">
                        </div>

                        <p class="text-center upload-text">Logo Shop <span class="text-danger">*</span></p>
                        @error('logo')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-lg-9 col-sm-12 col-12">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputShopName">Tên Shop <span class="text-danger">*</span></label>
                                <input value="{{old('name')}}" name="name" type="text" id="inputShopName" class="form-control @error('name') is-invalid @enderror" placeholder="Tên Shop">
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="inputHotline">Hotline <span class="text-danger">*</span></label>
                                <input value="{{old('hotline')}}" name="hotline" type="text" id="inputHotline" class="form-control @error('hotline') is-invalid @enderror" placeholder="Hotline">
                                @error('hotline')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputEmail">Email <span class="text-danger">*</span></label>
                            <input value="{{old('email')}}" name="email" type="email" id="inputEmail" class="form-control @error('email') is-invalid @enderror" placeholder="Email">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputOpen">Giờ mở cửa <span class="text-danger">*</span></label>
                                <input value="{{old('open')}}" name="open" type="time" id="inputOpen" class="form-control @error('open') is-invalid @enderror" placeholder="Giờ mở cửa (0-24)">
                                @error('open')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="inputClose">Giờ đóng cửa <span class="text-danger">*</span></label>
                                <input value="{{old('close')}}" name="close" type="time" id="inputClose" class="form-control @error('close') is-invalid @enderror" placeholder="Giờ đóng cửa (0-24)">
                                @error('close')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <label>Địa chỉ *</label>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <select class="form-control @error('province_id') is-invalid @enderror" name="province_id" id="province_select">
                                    <option value="0">Tỉnh/Thành phố *</option>
                                    @foreach($provinces as $province)
                                    <option value="{{$province->id}}">{{ $province->province_name }}</option>
                                    @endforeach
                                </select>
                                @error('province_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <select class="form-control @error('district_id') is-invalid @enderror" name="district_id" id="district_select">
                                    <option value="0">Quận/Huyện *</option>
                                    <option value="0" disabled>Vui lòng chọn thành phố trước</option>
                                </select>
                                @error('district_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <select class="form-control @error('ward_id') is-invalid @enderror" name="ward_id" id="ward_select">
                                    <option value="0">Phường/Thị xã *</option>
                                    <option value="0" disabled>Vui lòng chọn quận huyện trước</option>
                                </select>
                                @error('ward_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <input name="address" type="text" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') ?  old('address') : '' }}" placeholder="Địa chỉ chi tiết">
                            @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="float-right form-btn">
                            <a href="{{ route('home') }}" class="form-btn-cancel">Hủy</a>
                            <button type="submit" class="form-btn-save">Đăng ký</button>
                        </div>
                    </div>
                </div>
            </form>
            @endif
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous"
    referrerpolicy="no-referrer">
</script>
<script>
    function previewLogoImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var image = document.getElementById('logoImagePreview');
            image.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    // Kích hoạt trường tải lên khi nhấp vào ảnh
    document.getElementById('logoImagePreview').addEventListener('click', function() {
        document.getElementById('logoImageInput').click();
    });
</script>

@section('script')
    @include('admin.customer.province')
@endsection
@endsection