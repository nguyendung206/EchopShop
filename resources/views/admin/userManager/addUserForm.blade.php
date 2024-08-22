@extends('admin.layout.app')
<title>Quản lý người dùng</title>
@section('content')
<div class="row gutters-10">
    {{-- <div class="col-lg-12">
        <div class="row gutters-10">
            <div class="col-3">
                <div class="bg-grad-2 text-white rounded-lg mb-4 overflow-hidden">
                    <div class="px-3 pt-3">
                        <div class="opacity-50">
                            <span class="fs-12 d-block">{{ translate('Total') }}</span>
                            {{ translate('Customer') }}
                        </div>
                        <div class="h3 fw-700 mb-3"></div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                        <path fill="rgba(255,255,255,0.3)" fill-opacity="1" d="M0,128L34.3,112C68.6,96,137,64,206,96C274.3,128,343,224,411,250.7C480,277,549,235,617,213.3C685.7,192,754,192,823,181.3C891.4,171,960,149,1029,117.3C1097.1,85,1166,43,1234,58.7C1302.9,75,1371,149,1406,186.7L1440,224L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
                    </svg>
                </div>
            </div>
            <div class="col-3">
                <div class="bg-grad-3 text-white rounded-lg mb-4 overflow-hidden">
                    <div class="px-3 pt-3">
                        <div class="opacity-50">
                            <span class="fs-12 d-block">{{ translate('Total') }}</span>
                            {{ translate('Order') }}
                        </div>
                        <div class="h3 fw-700 mb-3"></div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                        <path fill="rgba(255,255,255,0.3)" fill-opacity="1" d="M0,128L34.3,112C68.6,96,137,64,206,96C274.3,128,343,224,411,250.7C480,277,549,235,617,213.3C685.7,192,754,192,823,181.3C891.4,171,960,149,1029,117.3C1097.1,85,1166,43,1234,58.7C1302.9,75,1371,149,1406,186.7L1440,224L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
                    </svg>
                </div>
            </div>
            <div class="col-3">
                <div class="bg-grad-1 text-white rounded-lg mb-4 overflow-hidden">
                    <div class="d-flex justify-content-between">
                        <div class="px-3 pt-3">
                            <div class="opacity-50">
                                <span class="fs-12 d-block"></span>
                                {{ translate('Food') }}
                            </div>
                            <div class="h3 fw-700 mb-3"></div>
                        </div>
                        <div class="px-3 pt-3">
                            <div class="opacity-50">
                                <span class="fs-12 d-block"></span>
                                {{ translate('Combo') }}
                            </div>
                            <div class="h3 fw-700 mb-3"></div>
                        </div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                        <path fill="rgba(255,255,255,0.3)" fill-opacity="1" d="M0,128L34.3,112C68.6,96,137,64,206,96C274.3,128,343,224,411,250.7C480,277,549,235,617,213.3C685.7,192,754,192,823,181.3C891.4,171,960,149,1029,117.3C1097.1,85,1166,43,1234,58.7C1302.9,75,1371,149,1406,186.7L1440,224L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
                    </svg>
                </div>
            </div>
            <div class="col-3">
                <div class="bg-grad-4 text-white rounded-lg mb-4 overflow-hidden">
                    <div class="px-3 pt-3">
                        <div class="opacity-50">
                            <span class="fs-12 d-block">{{ translate('Total') }}</span>
                            {{ translate('Flash Sale') }}
                        </div>
                        <div class="h3 fw-700 mb-3"></div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                        <path fill="rgba(255,255,255,0.3)" fill-opacity="1" d="M0,128L34.3,112C68.6,96,137,64,206,96C274.3,128,343,224,411,250.7C480,277,549,235,617,213.3C685.7,192,754,192,823,181.3C891.4,171,960,149,1029,117.3C1097.1,85,1166,43,1234,58.7C1302.9,75,1371,149,1406,186.7L1440,224L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div> --}}
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
            <form action="/admin/add-user" method="POST" style="padding: 10px">
                @csrf
                <div class="form-group">
                <label for="name">Tên tài khoản: </label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Tên của bạn" value="{{old('name')}}">
                {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                </div>
                <div class="form-group">
                    <label for="email">Email: </label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{old('email')}}">
                    </div>
                <div class="form-group">
                <label for="password">Mật khẩu: </label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" value="{{old('password')}}">
                </div>
                <div class="form-group">
                    <label for="phone_number">Số điện thoại: </label>
                    <input type="phone_number" class="form-control" id="phone_number" name="phone_number" placeholder="Số điện thoại" value="{{old('phone_number')}}">
                </div>
                <div class="form-group">
                    <label for="citizen_identification_number">Căn cước công dân: </label>
                    <input type="citizen_identification_number" class="form-control" id="citizen_identification_number" name="citizen_identification_number" placeholder="Căn cước công dân" value="{{old('citizen_identification_number')}}">
                </div>
                <div class="form-group">
                    <label for="day_of_issue">Ngày cấp: </label>
                    <input type="day_of_issue" class="form-control" id="day_of_issue" name="day_of_issue" placeholder="Ngày cấp">
                </div>
                <div class="form-group">
                    <label for="place_of_issue">Nơi cấp: </label>
                    <input type="place_of_issue" class="form-control" id="place_of_issue" name="place_of_issue" placeholder="Nơi cấp" value="{{old('place_of_issue')}}">
                </div>
                <div class="form-group">
                    <label for="date_of_birth">Ngày sinh: </label>
                    <input type="date_of_birth" class="form-control" id="date_of_birth" name="date_of_birth" placeholder="Ngày sinh"  value="{{old('date_of_birth')}}">
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
                    <input type="address" class="form-control" id="address" name="address" placeholder="Địa chỉ"  value="{{old('address')}}">
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
            </form>
        </div>
        </div>
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