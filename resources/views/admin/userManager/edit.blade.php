@extends('admin.layout.app')

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
                @error('password')
                    <span class="text-danger">{{$message}}</span>
                @enderror
                <div class="form-group">
                    <label for="phone_number">Số điện thoại: </label>
                    <input type="phone_number" class="form-control" id="phone_number" name="phone_number" placeholder="Số điện thoại" value="{{$user->phone_number}}">
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
                {{--  --}}
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
                {{--  --}}
                <div class="form-group">
                    <label for="address">Địa chỉ: </label>
                    <input type="address" class="form-control" id="address" name="address" placeholder="Địa chỉ"  value="{{$user->address}}">
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


  









 