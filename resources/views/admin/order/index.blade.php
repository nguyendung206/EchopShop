@extends('admin.layout.app')
@section('title')
    @lang('Đơn hàng')
@endsection
@section('header')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
@endsection
@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="align-items-center">
            <h1 class="h3"><strong>Đơn hàng</strong></h1>
        </div>
    </div>
    <div class="filter">
        <form class="" id="food" action="{{ route('admin.order.index') }}" method="GET">
            <div class="row gutters-5 mb-2">
                <div class="col-md-6 d-flex search">
                    <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6 search_icon" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2}
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" class="form-control res-placeholder res-FormControl" id="search" name="search"
                        value="{{ request('search') }}" placeholder="@lang('Tìm kiếm theo tên địa chỉ nhận hàng hoặc tên khách hàng')">
                </div>

                <div class="col-md-3">
                    <div class="row  align-items-center">
                        <div class="col-3" >Mức giá </div>
                        <div class="col-4" style="padding-left: 0px;">
                            <input type="number" class="w-100 form-control " name="min" min="0"  placeholder="từ" value="{{ request()->get('min') }}"> 
                        </div>
                        <div class="col-5" style="padding-left: 0px;">
                            <input type="number" class="w-100 form-control " name="max" placeholder="đến (VNĐ)" value="{{ request()->get('max') }}"> 
                        </div>
                    </div>
                </div>

                <div class="col-md-3 text-md-right download" style="padding-left: 3px">
                    <a href="{{ route('admin.order.create') }}"
                        class="btn btn-info btn-add-food d-flex justify-content-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>@lang('Bổ sung')</span>
                    </a>
                </div>
            </div>
            <div class="row gutters-5 mb-3 custom-change">
                <div class="col-md-3">
                    <input type="text" class="form-control" name="daterange" id="daterange" placeholder="Chọn khoảng thời gian" onkeypress='return event.charCode >=48 && event.charCode<=57' autocomplete="off">
                </div>
                <div class="col-md-3 res-status">
                    <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0 font-weight-500"
                        id="status" name="status">
                        <option value="">Trạng thái</option>
                        @foreach (StatusOrderEnums::cases() as $statusOrder)
                        <option value="{{ $statusOrder->value }}" 
                            @if (request('status') == $statusOrder->value) selected @endif>
                            {{ $statusOrder->label() }}
                        </option>
                    @endforeach

                    </select>
                </div>
                <div class="col-md-6 d-flex">
                    <button type="submit" class="pl-0 pr-0 btn btn-info w-25 d-flex btn-responsive justify-content-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <span class="custom-FontSize">@lang('Tìm kiếm')</span>
                    </button>
                    <a href="{{ url()->current() }}"
                        class="pl-0 pr-0 w-25 btn btn-info ml-2 d-flex btn-responsive justify-content-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <span class="custom-FontSize">@lang('Làm mới')</span>
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['export' => 1]) }}"
                        class="font-size btn btn-info w-25 ml-2 d-flex  btn-responsive justify-content-center">
                        <i class="las la-cloud-download-alt m-auto-5 w-6 h-6"></i>
                        <span class="custom-FontSize ml-1">@lang('Xuất file')</span>
                    </a>
                    <button type="button"
                        class="btn btn-info w-25 btn_import ml-2 d-flex btn-responsive justify-content-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        <span class="custom-FontSize ml-1">@lang('Tải lên')</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <form action="" id="form-import" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" accept=".csv,.xls,.xlsx" hidden name="file" class="form-control" id="file">
    </form>
    <div class="card">
        <div class="custom-overflow repon">
            <table class="table aiz-table mb-0 table_repon">
                <thead>
                    <tr class="text-center">
                        <th class="font-weight-800">STT</th>
                        <th >@lang('Tên khách hàng')</th>
                        <th >@lang('Ngày tạo')</th>
                        <th >@lang('Địa chỉ nhận hàng')</th>
                        <th >@lang('Giá gốc')</th>
                        <th >@lang('Giảm giá')</th>
                        <th >@lang('Thành tiền')</th>
                        <th >@lang('Trạng thái')</th>
                        <th >@lang('Điều chỉnh')</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($orders) && count($orders))
                        @foreach ($orders as $key => $order)
                            <tr class="text-center">
                                <td class="font-weight-800 align-middle">
                                    {{ $key + 1 + ($orders->currentPage() - 1) * $orders->perPage() }}</td>
                                    <td class="font-weight-400 align-middle text-overflow">{{ optional($order)->customer->name }}</td>   
                                <td class="font-weight-400 align-middle text-overflow">{{ optional($order)->created_at }}</td>
                                <td class="font-weight-400 align-middle">{{ $order->shipping_address}}, {{optional($order->ward)->ward_name}}, {{optional($order->district)->district_name}}, {{optional($order->province)->province_name}}</td>
                                <td class="font-weight-400 align-middle">
                                    {{ format_price($order->total_amount)}}
                                </td>
                                <td class="font-weight-400 align-middle">
                                    {{!empty($order->discount) ? format_price(calculateDiscountAmount($order->discount->type->value, $order->total_amount, $order->discount->value, $order->discount->max_value)) : 'Không giảm giá'}}
                                </td>
                                <td class="font-weight-400 align-middle">
                                    {{!empty($order->discount) ? format_price(calculateDiscountedPrice($order->discount->type->value, $order->total_amount, $order->discount->value, $order->discount->max_value)) : format_price($order->total_amount)}}
                                </td>
                                <td>
                                    @foreach (StatusOrderEnums::cases() as $statusOrder)
                                        @if ($statusOrder->value == $order->status->value)
                                            <span>{{ $statusOrder->label() }}</span> <!-- In ra label tương ứng -->
                                            @break
                                        @endif
                                    @endforeach
                                </td>
                                <td class="text-left">
                                    <a class="btn mb-1 btn-soft-primary btn-icon btn-circle btn-sm"
                                        href="{{ route('admin.order.show', $order->id) }}"
                                        >
                                        <i class="las la-list"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="pagination-us">
        <div class="aiz-pagination">
            {{ $orders->appends(request()->input())->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection

@section('script')
   


        <script>
        $(function() {
            var startDay = moment().startOf('month');
            var endDay = moment().endOf('month');

            function getParameterByName(name) {
                const urlParams = new URLSearchParams(window.location.search);
                return urlParams.get(name);
            }

            let daterange = getParameterByName('daterange');

            if (daterange) {
                
                let dates = daterange.split(' - '); 
                startDay = moment(dates[0], 'DD/MM/YYYY');
                endDay = moment(dates[1], 'DD/MM/YYYY');
            }

            $('#daterange').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY',
                    applyLabel: "Áp dụng",
                    cancelLabel: "Hủy",
                    fromLabel: "Từ ngày",
                    toLabel: "Đến ngày",
                    customRangeLabel: "Tùy chỉnh",
                    daysOfWeek: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
                    monthNames: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"]
                },
                startDate: startDay, 
                endDate: endDay
            });
        });

        

    </script>
    
@endsection
