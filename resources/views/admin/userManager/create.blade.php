@extends('admin.layout.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Thêm người dùng')}}</h5>
    </div>
    <div class="card-body">
            <form action="{{route('manager-user.store')}}" method="POST" style="padding: 10px" enctype="multipart/form-data">
                @csrf

                
                <div class="form-group">
                <label for="name">Tên tài khoản: </label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Tên của bạn" value="{{old('name')}}">
                @error('name')
                    <span class="text-danger">{{$message}}</span>
                @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email: </label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="{{old('email')}}">
                    @error('email')
                    <span class="text-danger">{{ $message; }}</span>
                    @enderror
                    </div>
                <div class="form-group">
                <label for="password">Mật khẩu: </label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" value="{{old('password')}}">
                </div>
                @error('password')
                    <span class="text-danger">{{$message}}</span>
                @enderror
                <div class="form-group">
                    <label for="passwordComfirm">Xác nhận mật khẩu: </label>
                    <input type="password" class="form-control" id="passwordComfirm" name="passwordComfirm" placeholder="Mật khẩu">
                    </div>
                    @error('passwordComfirm')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                <div class="form-group">
                    <label for="phone_number">Số điện thoại: </label>
                    <input type="phone_number" class="form-control" id="phone_number" name="phone_number" placeholder="Số điện thoại" value="{{old('phone_number')}}">
                </div>
                @error('phone_number')
                    <span class="text-danger">{{$message}}</span>
                @enderror
                <div class="form-group">
                    <label for="citizen_identification_number">Căn cước công dân: </label>
                    <input type="citizen_identification_number" class="form-control" id="citizen_identification_number" name="citizen_identification_number" placeholder="Căn cước công dân" value="{{old('citizen_identification_number')}}">
                </div>
                @error('citizen_identification_number')
                    <span class="text-danger">{{$message}}</span>
                @enderror
                <div class="form-group">
                    <label for="day_of_issue">Ngày cấp: </label>
                    <input type="text" class="form-control" id="day_of_issue" name="day_of_issue" placeholder="Ngày cấp" value="{{old('day_of_issue')}}">
                </div>
                @error('day_of_issue')
                    <span class="text-danger">{{$message}}</span>
                @enderror
                <div class="form-group">
                    <label for="place_of_issue">Nơi cấp: </label>
                    <input type="text" class="form-control" id="place_of_issue" name="place_of_issue" placeholder="Nơi cấp" value="{{old('place_of_issue')}}">
                </div>
                @error('place_of_issue')
                    <span class="text-danger">{{$message}}</span>
                @enderror
                <div class="form-group">
                    <label for="date_of_birth">Ngày sinh: </label>
                    <input type="text" class="form-control" id="date_of_birth" name="date_of_birth" placeholder="Ngày sinh"  value="{{old('date_of_birth')}}">
                </div>
                @error('date_of_birth')
                    <span class="text-danger">{{$message}}</span>
                @enderror
                {{--  --}}
                <div class="form-group">
                <label class="" for="exampleCheck1">Giới tính</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="exampleRadios1" value="0" checked>
                    <label class="form-check-label" for="exampleRadios1">
                      Nam
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="exampleRadios2" value="1">
                    <label class="form-check-label" for="exampleRadios2">
                      Nữ
                    </label>
                  </div>
                </div>
                {{--  --}}
                <div class="form-group">
                    <label for="address">Địa chỉ: </label>
                    <input type="address" class="form-control" id="address" name="address" placeholder="Địa chỉ"  value="{{old('address')}}">
                </div>
                @error('address')
                    <span class="text-danger">{{$message}}</span>
                @enderror
                <div class="form-group">
                    <label class="" for="exampleCheck1">Trạng thái tài khoản</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="exampleRadios3" value="0" checked/>
                        <label class="form-check-label" for="exampleRadios1">
                          Đang hoạt động
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="exampleRadios4" value="1"/>
                        <label class="form-check-label" for="exampleRadios2">
                          Đã bị khoá
                        </label>
                      </div>
                </div>
                <button type="submit" class="btn btn-primary">Tạo tài khoản</button>
                <a class="btn btn-secondary" style="color: white" href="{{route("manager-user.index")}}">Trở về</a>
            </form>
        </div>
    </div>
 @endsection


  {{-- 'name',
        'password',
        'email',
        'avatar',
        'phone_number',
        'citizen_identification_number',
        'day_of_issue',
        'place_of_issue',
        'date_of_birth',
        'gender',
        'rank_id',
        'address',
        'province_id',
        'district_id',
        'ward_id',
        'status',
        'shop_id',
        'role', --}}