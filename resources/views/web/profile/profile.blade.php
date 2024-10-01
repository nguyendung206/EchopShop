@extends('web.layout.app')
@section('css')
<link rel="stylesheet" href="{{ asset('/css/profile.css') }}">
@endsection
@section('content')
<div class="profile-slider">
    <h1 class="profile-heading text-center">hồ sơ của tôi</h1>
</div>
@include('web.profile.sidebarMobile')
<div class="container">
    <div class="row">
        @include('web.profile.sidebar')
        <div class="col-lg-9 col-sm-12 col-12 mt-4">
            <div class="col-md-12">
                <h1 class="profile-title">Thông tin cá nhân</h1>
                <p class="profile-content">Những thông tin dưới đây mang tính bảo mật. Chỉ bạn mới có thể thấy và chỉnh sửa những thông tin này.</p>
            </div>
            <form action="{{ route('profile.save') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $user->id }}">

                <div class="row">
                    <div class="col-lg-3 col-sm-12 col-12 text-center mb-4">
                        <img id="profileImage" src="{{ getImage($user->avatar) }}" alt="Avatar" class="profile-img profile-img-2">
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
                                <input name="name" type="text" id="inputName" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" placeholder="Họ và tên">
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
                                    <input name="phone_number" type="text" id="inputPhoneNumber" class="form-control @error('phone_number') is-invalid @enderror" value="{{ old('phone_number', $user->phone_number) }}" placeholder="Số điện thoại">
                                </div>
                                @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputEmail">Email *</label>
                            <input name="email" type="email" id="inputEmail" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" placeholder="Email">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                            <input name="address" type="text" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', $user->address) }}" placeholder="Địa chỉ chi tiết">
                            @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="float-right form-btn">
                            <a href="{{ route('home') }}" class="form-btn-cancel">Hủy</a>
                            <button type="submit" class="form-btn-save">Lưu</button>
                        </div>
                    </div>
                </div>
            </form>
            <br>
            <hr class="hr">
            <br>
            <div class="col-md-12">
                <h1 class="profile-title">Thông tin bảo mật</h1>
                <p class="profile-content">Những thông tin dưới đây mang tính bảo mật. Chỉ bạn mới có thể thấy và chỉnh sửa những thông tin này.</p>
            </div>
            <form action="{{ route('identification.save') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $user->id }}">
                <div class="row">
                    <div class="col-lg-3">
                        <div id="identificationImageContainer">
                            <img id="identificationImagePreview" src="{{ $user->identification_image ? getImage('upload/users/'. $user->identification_image) : asset('/img/image/upload.png') }}" alt="Ảnh CCCD/Hộ chiếu" class="upload-img" style="cursor: pointer; object-fit:cover; height: 100%; width: 100%;">
                            <input type="file" id="identificationImageInput" name="identification_image" style="display: none;" accept="image/*" onchange="previewIdentificationImage(event)">
                        </div>

                        <p class="text-center upload-text">Ảnh CCCD/Hộ chiếu*</p>
                        @error('identification_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-lg-9">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputIdentification">CCCD/Hộ chiếu *</label>
                                <input name="citizen_identification_number" type="text" id="inputIdentification" class="form-control @error('citizen_identification_number') is-invalid @enderror" value="{{ old('citizen_identification_number', $user->citizen_identification_number) }}" placeholder="Số CCCD/Hộ chiếu">
                                @error('citizen_identification_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="inputDateOfIssue">Ngày cấp *</label>
                                <input name="date_of_issue" type="date" id="inputDateOfIssue" class="form-control @error('date_of_issue') is-invalid @enderror" value="{{ old('date_of_issue', $user->date_of_issue ? date('Y-m-d', strtotime($user->date_of_issue)) : '') }}" placeholder="Ngày cấp">
                                @error('date_of_issue')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPlaceOfIssue">Nơi cấp *</label>
                            <input name="place_of_issue" type="text" id="inputPlaceOfIssue" class="form-control @error('place_of_issue') is-invalid @enderror" value="{{ old('place_of_issue', $user->place_of_issue) }}" placeholder="Nơi cấp">
                            @error('place_of_issue')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputGender">Giới tính</label>
                                <select class="form-control @error('gender') is-invalid @enderror" name="gender" id="inputGender">
                                    <option value="{{ App\Enums\UserGender::Male }}" {{ old('gender', $user->gender) == App\Enums\UserGender::Male ? 'selected' : '' }}>Nam</option>
                                    <option value="{{ App\Enums\UserGender::Female }}" {{ old('gender', $user->gender) == App\Enums\UserGender::Female ? 'selected' : '' }}>Nữ</option>
                                </select>
                                @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="inputDateOfBirth">Ngày sinh</label>
                                <input type="date" id="inputDateOfBirth" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" value="{{ old('date_of_birth', $user->date_of_birth ? date('Y-m-d', strtotime($user->date_of_birth)) : '') }}" placeholder="Ngày sinh">
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
@include('admin.customer.province')
@endsection