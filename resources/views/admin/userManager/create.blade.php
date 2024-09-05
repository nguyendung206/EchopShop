@extends('admin.layout.app')
@section('title')
    @lang('user.create_customers')
@endsection
@section('content')
<div class="backnow">
    <div class="backpage">
        <a href="{{route('manager-user.index', session('old_query'))}}" class="back btn"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg></a>
    </div>
</div>
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            
            <div class="card-header">
                <h5 class="mb-0 h6">Thêm người dùng</h5>
            </div>
            <div class="card-body">
                <form action="{{route('manager-user.store')}}" method="POST" enctype="multipart/form-data">
                  	@csrf
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Tên người dùng<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="Nhập tên người dùng" name="name" class="form-control
                             @error('name') is-invalid  @enderror" value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500" >Email<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="email" placeholder="Nhập email"name="email" class="form-control
                             @error('email') is-invalid  @enderror" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Mật khẩu<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="password" id="password" placeholder="Nhập mật khẩu" name="password" class="form-control
                            @error('password') is-invalid  @enderror" >
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Xác nhận mật khẩu<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="password" id="passwordConfirm" placeholder="Xác nhận mật khẩu" name="passwordConfirm" class="form-control
                             @error('passwordConfirm') is-invalid  @enderror" >
                            <span class="mt-1" id='message'></span>
                            @error('passwordConfirm')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Số điện thoại<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="number" placeholder="Nhập số điện thoại"name="phone_number" class="form-control
                            @error('phone_number') is-invalid  @enderror" value="{{ old('phone_number') }}">
                            @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Căn cước công dân<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="Nhập căn cước công dân" name="citizen_identification_number" class="form-control
                            @error('citizen_identification_number') is-invalid  @enderror" value="{{ old('citizen_identification_number') }}">
                            @error('citizen_identification_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Ngày cấp<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="date" placeholder="Nhập ngày cấp" name="date_of_issue" class="form-control
                            @error('date_of_issue') is-invalid  @enderror" value="{{ old('date_of_issue') }}">
                            @error('date_of_issue')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Nơi cấp<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="Nhập nơi cấp" name="place_of_issue" class="form-control
                            @error('place_of_issue') is-invalid  @enderror" value="{{ old('place_of_issue') }}">
                            @error('place_of_issue')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Ngày sinh<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="date" placeholder="Nhập ngày cấp" name="date_of_birth" class="form-control
                            @error('date_of_birth') is-invalid  @enderror" value="{{ old('date_of_birth') }}">
                            @error('date_of_birth')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Thành Phố<span class="text-vali">&#9913;</span></label></label>
                        <div class="col-sm-9">
                            <select class="text-center form-control font-weight-500"  name="province_id" id="province_select" >
                                <option class=" text-center" value="0">Tỉnh/Thành phố *</option>
                                    @foreach($provinces as $province)
                                        <option class=" text-center" value="{{$province->id}}">{{ $province->province_name }}</option>
                                    @endforeach
                            </select>
                                @error('province_id')
                                    <div style="width: 100%;margin-top: .25rem;font-size: 80%;color: #dc3545;">{{ $message }}</div>
                                @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Quận/Huyện <span class="text-vali">&#9913;</span></label></label>
                        <div class="col-sm-9">
                            <select class="text-center form-control font-weight-500" name="district_id" id="district_select" >
                                <option value="0" class=" text-center">Quận/Huyện *</option>
                                <option value="0" class=" text-center" disabled>Vui lòng chọn thành phố trước</option>
                            </select>
                                @error('district_id')
                                <div style="width: 100%;margin-top: .25rem;font-size: 80%;color: #dc3545;">{{ $message }}</div>
                                @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Phường/Thị xã <span class="text-vali">&#9913;</span></label></label>
                        <div class="col-sm-9">
                            <select class="text-center form-control font-weight-500" name="ward_id" id="ward_select" >
                                <option value="0" class=" text-center">Phường/Thị xã *</option>
                                <option value="0" class=" text-center" disabled>Vui lòng chọn quận huyện trước</option>
                            </select>
                            @error('ward_id')
                            <div style="width: 100%;margin-top: .25rem;font-size: 80%;color: #dc3545;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Địa chỉ<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="Nhập địa chỉ" name="address" class="form-control
                            @error('address') is-invalid  @enderror" value="{{ old('address') }}">
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Giới tính</label>
                        <div class="col-sm-9">
                            <select class="text-center form-control font-weight-500" name="gender" >
                                <option class=" text-center" value="{{ App\Enums\UserGender::Male}}" {!! old('gender') != null && old('gender') == 0 ? ' selected' : null !!}>Nam</option>
                                <option class=" text-center" value="{{ App\Enums\UserGender::Female }}" {!! old('gender') != null && old('gender') == 1 ? ' selected' : null !!}>Nữ</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Trạng thái tài khoản</label>
                        <div class="col-sm-9">
                            <select class="text-center form-control font-weight-500" name="status" >
                                <option class=" text-center" value="0" {!! old('status') != null && old('status') == 0 ? ' selected' : null !!}>Đang hoạt động</option>
                                <option class=" text-center" value="1" {!! old('status') != null && old('status') == 1 ? ' selected' : null !!}>Đã bị khoá</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Ảnh đại diện:</label>
                        <input type="file" class="form-control" name="uploadFile" onchange="document.getElementById('Photo').src = window.URL.createObjectURL(this.files[0])" />
                    </div>
                    <div class="form-group">
                        <img id="Photo" src="{{ getImage() }}" class="img img-bordered" style="width:200px" />
                    </div>
                    
                    <div class="form-group mb-0 text-right">
                        <a href="{{route('manager-user.index', session('old_query'))}}" type="button" class="btn btn-light mr-2">Trở lại</a>
                        <button type="submit" class="btn btn-primary">Thêm tài khoản</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
    <script type="text/javascript">
        $('#password, #passwordConfirm').on('keyup', function () {
            if ($('#password').val() == $('#passwordConfirm').val()) {
                $('#message').html('Hợp lệ').css('color', 'green');
            } else
                $('#message').html('Mật khẩu xác nhận không đúng').css('color', 'red');
        });

    </script>
    <script>
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
@endsection

























