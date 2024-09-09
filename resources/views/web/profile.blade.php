@extends('web.layout.app')
@section('content')
<div class="profile-slider">
    <h1 class="profile-heading text-center">hồ sơ của tôi</h1>
</div>
<div class="container-fluid mt-4">
    <div class="menu-profile">
        <div class="row align-items-center">
            <div class="col-6">
                <div class="float-left">
                    <a href="#" class="profile-back">
                        <i class="fa-solid fa-angle-left"></i>
                        Quay lại
                    </a>
                </div>
            </div>
            <div class="col-6">
                <div class="float-right" id="menu-profile-toggle">
                    <i class="fa-solid fa-bars"></i>
                </div>
            </div>
            <div class="col-12">
                <nav class="category-profile" id="category-profile">
                    <ul class="list text-center">
                        <a href="{{route('web.profile.index', Session::get('user')->id)}}">
                            <i class="fa-regular fa-circle-user mr-1"></i>
                            Hồ sơ của tôi
                        </a>
                        <a href="#">
                            <i class="fa-solid fa-cart-plus mr-1"></i>
                            Đơn hàng của tôi
                        </a>
                        <a href="#">
                            <i class="fa-regular fa-comment-dots mr-1"></i>
                            Lịch sử chat
                        </a>
                        <a href="#">
                            <i class="fa-regular fa-file-lines mr-1"></i>
                            Quản lý bài đăng
                        </a>
                        <a href="#">
                            <i class="fa-solid fa-crown mr-1"></i>
                            Gói cước của tôi
                        </a>
                        <a href="#">
                            <i class="fa-regular fa-heart mr-1"></i>
                            Đã thích
                        </a>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-lg-3 profile-list">
            <img src="{{getImage('upload/users/',$profile->avatar)}}" alt="" class="profile-img">
            <p class="profile-name text-center">{{$profile->name}}</p>
            <a class="profile-update-btn text-center">
                <i class="fa-regular fa-pen-to-square"></i>
                Chỉnh sửa
            </a>
            <ul class="list">
                <a href="#">
                    <i class="fa-regular fa-circle-user mr-1"></i>
                    Hồ sơ của tôi
                </a>
                <a href="#">
                    <i class="fa-solid fa-cart-plus mr-1"></i>
                    Đơn hàng của tôi
                </a>
                <a href="#">
                    <i class="fa-regular fa-comment-dots mr-1"></i>
                    Lịch sử chat
                </a>
                <a href="#">
                    <i class="fa-regular fa-file-lines mr-1"></i>
                    Quản lý bài đăng
                </a>
                <a href="#">
                    <i class="fa-solid fa-crown mr-1"></i>
                    Gói cước của tôi
                </a>
                <a href="#">
                    <i class="fa-regular fa-heart mr-1"></i>
                    Đã thích
                </a>
            </ul>
            <div class="advanced-package mb-5">
                <h1 class="profile-name text-center">Gói nâng cao</h1>
                <img src="{{asset('/img/image/Component.png')}}" alt="">
                <div class="package-text text-center">
                    <p>
                        <strong>100</strong> Bài viết
                    </p>
                    <hr>
                    <p>
                        <strong>200</strong> Bài viết
                    </p>
                </div>
                <a class="package-btn">
                    Đổi gói cược
                </a>
            </div>
        </div>
        <div class="col-lg-9 col-sm-12 col-12 mt-4">
            <form action="{{ route('web.profile.save') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $profile->id }}">
                <input type="hidden" name="password" value="{{ $profile->password }}">

                <div class="row">
                    <div class="col-lg-3 col-sm-12 col-12 text-center mb-4">
                        <img id="profileImage" src="{{ getImage('upload/users/', $profile->avatar) }}" alt="Avatar" class="profile-img profile-img-2">
                        <input type="file" id="fileInput" name="avatar" style="display: none;" accept="image/*" onchange="previewImage(event)">
                        <a href="#" id="uploadButton" class="profile-update-btn profile-update-btn-2 text-center">
                            <i class="fa-regular fa-pen-to-square"></i> Chỉnh sửa
                        </a>
                        @error('avatar')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-lg-9 col-sm-12 col-12">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputName">Tên *</label>
                                <input name="name" type="text" id="inputName" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $profile->name) }}" placeholder="Họ và tên">
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="inputPhoneNumber">Số điện thoại *</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <img src="{{ asset('/img/image/vietnam.png') }}" alt="Vietnam Flag" class="img-vietnam"> +84
                                        </div>
                                    </div>
                                    <input name="phone_number" type="text" id="inputPhoneNumber" class="form-control @error('phone_number') is-invalid @enderror" value="{{ old('phone_number', $profile->phone_number) }}" placeholder="Số điện thoại">
                                </div>
                                @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputEmail">Email *</label>
                            <input name="email" type="email" id="inputEmail" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $profile->email) }}" placeholder="Email">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <label for="inputState">Địa chỉ *</label>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <select class="form-control @error('province_id') is-invalid @enderror" name="province_id" id="province_select">
                                    <option value="0" selected>Tỉnh/ Thành phố *</option>
                                    @foreach($provinces as $province)
                                    <option value="{{ $province->id }}" {{ old('province_id', $profile->province_id) == $province->id ? 'selected' : '' }}>
                                        {{ $province->province_name }}
                                    </option>
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
                            <input name="address" type="text" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', $profile->address) }}" placeholder="Địa chỉ chi tiết">
                            @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <br>
                <hr class="hr">
                <br>

                <div class="row">
                    <div class="col-md-12">
                        <h1 class="profile-title">Thông tin bảo mật</h1>
                        <p class="profile-content">Những thông tin dưới đây mang tính bảo mật. Chỉ bạn mới có thể thấy và chỉnh sửa những thông tin này.</p>
                    </div>
                    <div class="col-md-3">
                        <div id="identificationImageContainer">
                            <img id="identificationImagePreview" src="{{ $profile->identification_image ? getImage('upload/users/', $profile->identification_image) : asset('/img/image/upload.png') }}" alt="Ảnh CCCD/Hộ chiếu" class="upload-img" style="cursor: pointer; object-fit:cover; height: 100%; width: 100%;">
                            <input type="file" id="identificationImageInput" name="identification_image" style="display: none;" accept="image/*" onchange="previewIdentificationImage(event)">
                        </div>

                        <p class="text-center upload-text">Ảnh CCCD/Hộ chiếu*</p>
                        @error('identification_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-9">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputIdentification">CCCD/Hộ chiếu *</label>
                                <input name="citizen_identification_number" type="text" id="inputIdentification" class="form-control @error('citizen_identification_number') is-invalid @enderror" value="{{ old('citizen_identification_number', $profile->citizen_identification_number) }}" placeholder="Số CCCD/Hộ chiếu">
                                @error('citizen_identification_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="inputDateOfIssue">Ngày cấp *</label>
                                <input name="date_of_issue" type="date" id="inputDateOfIssue" class="form-control @error('date_of_issue') is-invalid @enderror" value="{{ old('date_of_issue', $profile->date_of_issue ? date('Y-m-d', strtotime($profile->date_of_issue)) : '') }}" placeholder="Ngày cấp">
                                @error('date_of_issue')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPlaceOfIssue">Nơi cấp *</label>
                            <input name="place_of_issue" type="text" id="inputPlaceOfIssue" class="form-control @error('place_of_issue') is-invalid @enderror" value="{{ old('place_of_issue', $profile->place_of_issue) }}" placeholder="Nơi cấp">
                            @error('place_of_issue')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputGender">Giới tính</label>
                                <select class="form-control @error('gender') is-invalid @enderror" name="gender" id="inputGender">
                                    <option value="{{ App\Enums\UserGender::Male }}" {{ old('gender', $profile->gender) == App\Enums\UserGender::Male ? 'selected' : '' }}>Nam</option>
                                    <option value="{{ App\Enums\UserGender::Female }}" {{ old('gender', $profile->gender) == App\Enums\UserGender::Female ? 'selected' : '' }}>Nữ</option>
                                </select>
                                @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="inputDateOfBirth">Ngày sinh</label>
                                <input type="date" id="inputDateOfBirth" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" value="{{ old('date_of_birth', $profile->date_of_birth ? date('Y-m-d', strtotime($profile->date_of_birth)) : '') }}" placeholder="Ngày sinh">
                                @error('date_of_birth')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="float-right form-btn">
                            <a href="{{ route('home') }}" class="form-btn-cancel">Hủy</a>
                            <button type="submit" class="form-btn-save">Lưu</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous"
    referrerpolicy="no-referrer">
</script>
<script>
    // Khi nhấn nút chỉnh sửa, kích hoạt chọn file
    document.getElementById('uploadButton').addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('fileInput').click();
    });

    // Hiển thị ảnh xem trước khi chọn
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profileImage').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
    // Hàm xem trước ảnh và thay thế thẻ img
    function previewIdentificationImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var image = document.getElementById('identificationImagePreview');
            image.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    // Kích hoạt trường tải lên khi nhấp vào ảnh
    document.getElementById('identificationImagePreview').addEventListener('click', function() {
        document.getElementById('identificationImageInput').click();
    });
</script>
@include('admin.userManager.province')
@endsection