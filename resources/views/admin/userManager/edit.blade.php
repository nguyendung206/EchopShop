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
                <h5 class="mb-0 h6">@lang('user.create_user')</h5>
            </div>
            <div class="card-body">
                @if(session('message'))
                <div class="alert alert-danger">
                    {{ session('message') }}
                </div>
                @endif
                <form action="{{ route("manager-user.update", $user->id) }}" method="POST">
                  	@csrf
                      @method("PUT")
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Tên người dùng<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="Nhập tên người dùng" name="name" class="form-control
                             @error('name') is-invalid  @enderror" value="{{ old('name') ? old('name') : $user->name}}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500" >Email<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="email" placeholder="Nhập email"name="email" class="form-control
                             @error('email') is-invalid  @enderror" value="{{ old('email') ? old('email') : $user->email }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Số điện thoại<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="number" placeholder="Nhập số điện thoại"name="phone_number" class="form-control
                            @error('phone_number') is-invalid  @enderror" value="{{ old('phone_number') ? old('phone_number') : $user->phone_number }}">
                            @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Căn cước công dân<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="Nhập căn cước công dân" name="citizen_identification_number" class="form-control
                            @error('citizen_identification_number') is-invalid  @enderror" value="{{ old('citizen_identification_number') ? old('citizen_identification_number') : $user->citizen_identification_number }}">
                            @error('citizen_identification_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Ngày cấp<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="date" placeholder="Nhập ngày cấp" name="date_of_issue" class="form-control
                            @error('date_of_issue') is-invalid  @enderror" value="{{ old('date_of_issue') ? old('date_of_issue') : date('Y-m-d', strtotime(optional($user)->date_of_issue)) }}">
                            @error('date_of_issue')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Nơi cấp<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="Nhập ngày cấp" name="place_of_issue" class="form-control
                            @error('place_of_issue') is-invalid  @enderror" value="{{ old('place_of_issue') ? old('place_of_issue') : $user->place_of_issue }}">
                            @error('place_of_issue')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Ngày sinh<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="date" placeholder="Nhập ngày cấp" name="date_of_birth" class="form-control
                            @error('date_of_birth') is-invalid  @enderror" value="{{ old('date_of_birth') ?  old('date_of_birth') :  date('Y-m-d', strtotime(optional($user)->date_of_birth)) }}">
                            @error('date_of_birth')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Địa chỉ<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="Nhập ngày cấp" name="address" class="form-control
                            @error('address') is-invalid  @enderror" value="{{ old('address') ? old('address') : $user->address }}">
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Giới tính</label>
                        <div class="col-sm-9">
                            <select class="text-center form-control font-weight-500" name="gender" >
                                <option class=" text-center" value="0" {!! $user->gender != null && $user->gender == 0 ? ' selected' : null !!}>Nam</option>
                                <option class=" text-center" value="1" {!! $user->gender != null && $user->gender == 1 ? ' selected' : null !!}>Nữ</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Trạng thái tài khoản</label>
                        <div class="col-sm-9">
                            <select class="text-center form-control font-weight-500" name="status" >
                                <option class=" text-center" value="0" {!! $user->status != null && $user->status == 0 ? ' selected' : null !!}>Đang hoạt động</option>
                                <option class=" text-center" value="1" {!! $user->status != null && $user->status == 1 ? ' selected' : null !!}>Đã bị khoá</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <a href="{{route('manager-user.index', session('old_query'))}}" type="button" class="btn btn-light mr-2">Trở lại</a>
                        <button type="submit" class="btn btn-primary">Sửa tài khoản</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
    <script type="text/javascript">
        $('#password, #password_confirmation').on('keyup', function () {
            if ($('#password').val() == $('#password_confirmation').val()) {
                $('#message').html('Matching').css('color', 'green');
            } else
                $('#message').html('Not Matching').css('color', 'red');
        });

    </script>
@endsection























