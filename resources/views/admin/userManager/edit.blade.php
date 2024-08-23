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
                            <input type="text" placeholder="Nhập ngày cấp" name="day_of_issue" class="form-control
                            @error('day_of_issue') is-invalid  @enderror" value="{{ old('day_of_issue') ? old('day_of_issue') : date('d/m/Y', strtotime(optional($user)->day_of_issue)) }}">
                            @error('day_of_issue')
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
                            <input type="text" placeholder="Nhập ngày cấp" name="date_of_birth" class="form-control
                            @error('date_of_birth') is-invalid  @enderror" value="{{ old('date_of_birth') ?  old('date_of_birth') : date('d/m/Y', strtotime(optional($user)->date_of_birtht)) }}">
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























{{-- @extends('admin.layout.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Thêm người dùng')}}</h5>
    </div>
    <div class="card-body">
            <form action="{{ route("manager-user.update", $user->id) }}" method="POST" style="padding: 10px">
                @csrf
                @method("PUT")
                <div class="form-group">
                <label for="name">Tên tài khoản: </label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Tên của bạn" value="{{$user->name}}">
                @error('name')
                    <span class="text-danger">{{$message}}</span>
                @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email: </label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="{{$user->email}}">
                    @error('email')
                    <span class="text-danger">{{ $message; }}</span>
                    @enderror
                    </div>
                <div class="form-group">
                    <label for="phone_number">Số điện thoại: </label>
                    <input type="phone_number" class="form-control" id="phone_number" name="phone_number" placeholder="Số điện thoại" value="{{ old('phone_number') ? old('phone_number') : $user->phone_number}}">
                </div>
                @error('phone_number')
                    <span class="text-danger">{{$message}}</span>
                @enderror
                <div class="form-group">
                    <label for="citizen_identification_number">Căn cước công dân: </label>
                    <input type="citizen_identification_number" class="form-control" id="citizen_identification_number" name="citizen_identification_number" placeholder="Căn cước công dân" value="{{ $user->citizen_identification_number}}">
                </div>
                @error('citizen_identification_number')
                    <span class="text-danger">{{$message}}</span>
                @enderror
                <div class="form-group">
                    <label for="day_of_issue">Ngày cấp: </label>
                    <input type="text" class="form-control" id="day_of_issue" name="day_of_issue" placeholder="Ngày cấp" value="{{ \DateTime::createFromFormat('Y-m-d H:i:s', $user->day_of_issue)->format('d/m/Y');}}">
                </div>
                @error('day_of_issue')
                    <span class="text-danger">{{$message}}</span>
                @enderror
                <div class="form-group">
                    <label for="place_of_issue">Nơi cấp: </label>
                    <input type="text" class="form-control" id="place_of_issue" name="place_of_issue" placeholder="Nơi cấp" value="{{$user->place_of_issue}}">
                </div>
                @error('place_of_issue')
                    <span class="text-danger">{{$message}}</span>
                @enderror
                <div class="form-group">
                    <label for="date_of_birth">Ngày sinh: </label>
                    <input type="text" class="form-control" id="date_of_birth" name="date_of_birth" placeholder="Ngày sinh"  value="{{  \DateTime::createFromFormat('Y-m-d H:i:s', $user->date_of_birth)->format('d/m/Y');}}">
                </div>
                @error('date_of_birth')
                    <span class="text-danger">{{$message}}</span>
                @enderror
                <div class="form-group">
                <label class="" for="exampleCheck1">Giới tính</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="exampleRadios1" value="0" {{ $user->status == 0 ? 'checked' : '' }}>
                    <label class="form-check-label" for="exampleRadios1">
                      Nam
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="exampleRadios2" value="1" {{ $user->status == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="exampleRadios2">
                      Nữ
                    </label>
                  </div>
                </div>
                <div class="form-group">
                    <label for="address">Địa chỉ: </label>
                    <input type="address" class="form-control" id="address" name="address" placeholder="Địa chỉ"  value="{{ old('address') ? old('address') : $user->address}}"">
                </div>
                @error('address')
                    <span class="text-danger">{{$message}}</span>
                @enderror
                
                <div class="form-group">
                    <label class="" for="exampleCheck1">Trạng thái tài khoản</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="exampleRadios3" value="0" {{ $user->status == 0 ? 'checked' : '' }}/>
                        <label class="form-check-label" for="exampleRadios1">
                          Đang hoạt động
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="exampleRadios4" value="1" {{ $user->status == 1 ? 'checked' : '' }}/>
                        <label class="form-check-label" for="exampleRadios2">
                          Đã bị khoá
                        </label>
                      </div>
                </div>
                <button type="submit" class="btn btn-primary">Sửa thông tin</button>
                <a class="btn btn-secondary" style="color: white" href="{{route("manager-user.index")}}">Trở về</a>
            </form>
        </div>
    </div>
 @endsection


  









  --}}