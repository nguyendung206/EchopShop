@extends('admin.layout.app')
<title>Quản lý người dùng</title>
@section('content')
<div class="row gutters-10">
</div>
<div class="row gutters-10 chart">
    <div class="col-md-12">
        <div class="card" style="border-radius: 10px">
            
            <div class="tab-content" id="pills-tabContent">
                @if (session('message'))
                    <div style="color: red;">
                        {{ session('message') }}
                    </div>
                @endif
            <form action="/admin/update-user/{{ $user->id }}" method="POST" style="padding: 10px">
                @csrf
                @method('PUT')
                <div class="form-group">
                  <h1>Sửa thông tin người dùng</h1>
                <label for="name">Tên tài khoản: </label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Tên của bạn" value="{{$user->name}}">
                {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                </div>
                <div class="form-group">
                    <label for="email">Email: </label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email"  value="{{$user->email}}">
                    </div>
                <div class="form-group">
                <label for="password">Mật khẩu: </label>
                <input type="password" class="form-control" id="password"  placeholder="Mật khẩu" value="{{$user->password}}" disabled>
                </div>
                <div class="form-group">
                    <label for="phone_number">Số điện thoại: </label>
                    <input type="phone_number" class="form-control" id="phone_number" name="phone_number" placeholder="Số điện thoại" value="{{$user->phone_number}}">
                </div>
                <div class="form-group">
                    <label for="citizen_identification_number">Căn cước công dân: </label>
                    <input type="citizen_identification_number" class="form-control" id="citizen_identification_number" name="citizen_identification_number" placeholder="Căn cước công dân" value="{{ $user->citizen_identification_number}}">
                </div>
                <div class="form-group">
                    <label for="day_of_issue">Ngày cấp: </label>
                    <input type="day_of_issue" class="form-control" id="day_of_issue" name="day_of_issue" placeholder="Ngày cấp">
                </div>
                <div class="form-group">
                    <label for="place_of_issue">Nơi cấp: </label>
                    <input type="place_of_issue" class="form-control" id="place_of_issue" name="place_of_issue" placeholder="Nơi cấp" value="{{ $user->place_of_issue}}">
                </div>
                <div class="form-group">
                    <label for="date_of_birth">Ngày sinh: </label>
                    <input type="date_of_birth" class="form-control" id="date_of_birth" name="date_of_birth" placeholder="Ngày sinh"  value="{{ $user->date_of_birth}}">
                </div>
                {{--  --}}
                <div class="form-group">
                <label class="" for="exampleCheck1">Giới tính</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="1" checked>
                    <label class="form-check-label" for="exampleRadios1">
                      Nam
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="0">
                    <label class="form-check-label" for="exampleRadios2">
                      Nữ
                    </label>
                  </div>
                </div>
                {{--  --}}
                <div class="form-group">
                    <label for="address">Địa chỉ: </label>
                    <input type="address" class="form-control" id="address" name="address" placeholder="Địa chỉ"  value="{{ $user->address }}">
                </div>
                <div class="form-group">
                    <label class="" for="exampleCheck1">Trạng thái tài khoản</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="1" checked>
                        <label class="form-check-label" for="exampleRadios1">
                          Đang hoạt động
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="0">
                        <label class="form-check-label" for="exampleRadios2">
                          Đã bị khoá
                        </label>
                      </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <a class="btn btn-secondary" style="color: white" href="/admin/list-users">Trở về</a>
            </form>
        </div>
        </div>
    </div>
</div>
@endsection


 