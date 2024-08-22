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
            <div class="card-header ">
                <h6 class="mb-0 fs-14">@lang('dashboards.db_revenue')</h6>
                <div class="total">
                    <ul class="nav nav-pills mb-0  fs-14" id="pills-tab2" role="tablist">
                        <li class="nav-item">
                        <a class="nav-link active btn-ab" id="pills-day2-tab" data-toggle="pill" href="#pills-day2" role="tab" aria-controls="pills-day2" aria-selected="true">@lang('dashboards.day')</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link btn-ab" id="pills-week2-tab" data-toggle="pill" href="#pills-week2" role="tab" aria-controls="pills-week2" aria-selected="false">@lang('dashboards.week')</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link btn-ab" id="pills-jun2-tab" data-toggle="pill" href="#pills-jun2" role="tab" aria-controls="pills-jun2" aria-selected="false">@lang('dashboards.month')</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-content" id="pills-tabContent">
                <div><a class="btn btn-primary" style="color: white" href="/admin/add-user">Thêm người dùng</a></div>
                @if (session('message'))
                    <div style="color: red;">
                        {{ session('message') }}
                    </div>
                @endif
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Tên người dùng</th>
                        <th scope="col">Email</th>
                        <th scope="col">Địa chỉ</th>
                        <th scope="col">Tuỳ chọn</th>
                      </tr>
                    </thead>
                    <tbody>
                     @for ($i = 0 ; $i < count($users); $i++)
                     <tr>
                        <th scope="row">{{$i+1;}}</th>
                        <td>{{$users[$i]->name}}</td>
                        <td>{{$users[$i]->email}}</td>
                        <td>{{$users[$i]->address}}</td>
                        <td>
                            <a class="btn btn-primary" style="color: white" href="/admin/get-user/{{$users[$i]->id}}">Xem</a>
                            <a class="btn btn-primary" style="color: white" href="/admin/update-user/{{$users[$i]->id}}">Sửa</a>
                            <form action="/admin/delete-user/{{$users[$i]->id}}" method="POST"  style="display: inline-block">
                                @csrf
                                @method("DELETE")
                                <button class="btn btn-danger" type="submit">Xoá</button>
                            </form>
                        </td>
                      </tr>
                     @endfor
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
    {{-- <div class="col-md-6">
        <div class="card" style="border-radius: 10px">
            <div class="card-header ">
                <h6 class="mb-0 fs-14">@lang('dashboards.db_order')</h6>
                <div class="total">
                    <ul class="nav nav-pills mb-0  fs-14" id="pills-tab" role="tablist">
                        <li class="nav-item">
                        <a class="nav-link active btn-ab" id="pills-day-tab" data-toggle="pill" href="#pills-day" role="tab" aria-controls="pills-day" aria-selected="true">@lang('dashboards.day')</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link btn-ab" id="pills-week-tab" data-toggle="pill" href="#pills-week" role="tab" aria-controls="pills-week" aria-selected="false">@lang('dashboards.week')</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link btn-ab" id="pills-jun-tab" data-toggle="pill" href="#pills-jun" role="tab" aria-controls="pills-jun" aria-selected="false">@lang('dashboards.month')</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-day" role="tabpanel" aria-labelledby="pills-day-tab">
                    <div class="card-body-title">
                        <h6 class="card-title label ml-4 mt-2">{{__('dashboards.total')}}: {{ format_price($orderHourTotal) }} </h6>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="hour1" class="w-100" style="height: 400px"></canvas>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-week" role="tabpanel" aria-labelledby="pills-week-tab">
                    <div class="card-body-title">
                        <h6 class="card-title label ml-4 mt-2">{{__('dashboards.total')}}: {{ format_price($orderWeekToTal) }} </h6>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="day1" class="w-100" style="height: 500px"></canvas>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-jun" role="tabpanel" aria-labelledby="pills-jun-tab">
                    <div class="card-body-title">
                        <h6 class="card-title label ml-4 mt-2">{{__('dashboards.total')}}: {{ format_price($orderMonthTotal) }} </h6>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="month1" class="w-100" style="height: 500px"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
</div>

@endsection

