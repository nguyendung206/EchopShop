@extends('admin.layout.app')
@section('title')
    @lang('Giảm giá')
@endsection
@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="align-items-center">
            <h1 class="h3"><strong>Giảm giá</strong></h1>
        </div>
    </div>
    <div class="filter">
        <form class="" id="food" action="{{ route('admin.discount.index') }}" method="GET">
            <div class="row gutters-5 mb-2">
                <div class="col-md-6 d-flex search">
                    <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6 search_icon" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2}
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" class="form-control res-placeholder res-FormControl" id="search" name="search"
                        value="{{ request('search') }}" placeholder="@lang('Tìm kiếm theo tên và mô tả')">
                </div>
                <div class="col-md-3 text-md-right add-new ">
                    <a href="{{ route('admin.discount.create') }}"
                        class="btn btn-info btn-add-food d-flex justify-content-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>@lang('Bổ sung')</span>
                    </a>
                </div>
                <div class="col-md-3 text-md-right download" style="padding-left: 3px">
                    <a href="" type="button"
                        class=" pl-0 pr-0 btn btn-info w-100 mr-2 d-flex btn-responsive justify-content-center">
                        <i class="las la-cloud-download-alt m-auto-5 w-6 h-6"></i>
                        <span class="custom-FontSize ml-1">{{ __('Tải về') }}</span>
                    </a>
                </div>
            </div>
            <div class="row gutters-5 mb-3 custom-change">
                <div class="col-md-3 ">
                    <input type="text" onkeypress='return event.charCode >=48 && event.charCode<=57' autocomplete="off"
                        class="form-control custom-placeholder" name="joined_date" id="joined_date"
                        placeholder="{{ __('Ngày tạo') }}" value="{{ request('joined_date') }}">
                    <div class="custom-down"><i class="fas fa-chevron-down"></i></div>
                </div>
                <div class="col-md-3 res-status">
                    <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0 font-weight-500"
                        id="status" name="status">
                        <option value="">Trạng thái</option>
                        <option value="1" @if (request('status') == 1) selected @endif>
                            Đang sử dụng
                        </option>
                        <option value="2"
                            @if (request('status') == 2) selected @endif>
                            Hết hạn sử dụng
                        </option>

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
                        <th class="w-60 font-weight-800">STT</th>
                        <th class="">@lang('Ảnh giảm giá')</th>
                        <th class="w-25">@lang('Tiêu đề')</th>
                        <th class="">@lang('Mã giảm giá')</th>
                        <th class="">@lang('Giá trị giảm')</th>
                        <th class="">@lang('Ngày bắt đầu')</th>
                        <th class="">@lang('Ngày kết thúc')</th>
                        <th>@lang('trạng thái')</th>
                        <th class="w-150">@lang('Điều chỉnh')</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($discounts) && count($discounts))
                        @foreach ($discounts as $key => $discount)
                            <tr class="text-center">
                                <td class="font-weight-800 align-middle">
                                    {{ $key + 1 + ($discounts->currentPage() - 1) * $discounts->perPage() }}</td>
                                <td class="font-weight-400 align-middle">
                                        <img style="height: 90px;" class="profile-user-img img-responsive img-bordered"
                                        src="{{ getImage($discount->photo) }}">
                                </td>
                                <td class="font-weight-400 align-middle text-overflow">{{ optional($discount)->title }}</td>
                                <td class="font-weight-400 align-middle">{{ $discount->code }}</td>

                                <td class="font-weight-400 align-middle">
                                    {{$discount->type == TypeDiscountEnums::PERCENT ? $discount->value : number_format($discount->value, 0)}}
                                    @if ($discount->type == TypeDiscountEnums::PERCENT)
                                    %
                                    @else
                                    VNĐ 
                                    @endif
                                </td>


                                <td>{{ $discount->start_time }}</td>
                                <td>{{ $discount->end_time }}</td>
                                <td>{{ $discount->status->label() }}</td>
                                <td class="text-left">
                                    @if ($discount->status == StatusEnums::ACTIVE)
                                    <a class="btn mb-1 btn-soft-danger btn-icon btn-circle btn-sm btn_status changeStatus"
                                        data-id="{{ $discount->id }}"
                                        data-href="{{ route('admin.discount.changeStatus', ['id' => $discount->id]) }}"
                                        id="active-popup" >
                                        <i class="las la-ban"></i>
                                    </a>
                                @else
                                    <a class="btn btn-soft-success btn-icon btn-circle btn-sm btn_status changeStatus"
                                        data-id="{{ $discount->id }}"
                                        data-href="{{ route('admin.discount.changeStatus', ['id' => $discount->id]) }}"
                                        id="inactive-popup" >
                                        <i class="las la-check-circle"></i>
                                    </a>
                                @endif
                                    <a class="btn mb-1 btn-soft-primary btn-icon btn-circle btn-sm"
                                        href="{{ route('admin.discount.show', $discount->id) }}">
                                        <i class="las la-list"></i>
                                    </a>
                                    <a class="btn mb-1 btn-soft-primary btn-icon btn-circle btn-sm"
                                        href="{{ route('admin.discount.edit', $discount->id) }}">
                                        <i class="las la-edit"></i>
                                    </a>
                                    <a href="javascript:void(0)"
                                        data-href="{{ route('admin.discount.destroy', $discount->id) }}"
                                        data-id="{{ $discount->id }}"
                                        class="btn btn-delete btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                        title="@lang('discount.delete')">
                                        <i class="las la-trash"></i>
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
            {{ $discounts->appends(request()->input())->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        //deletee
        $(document).on('click', '.btn-delete', function() {
            let delete_id = $(this).attr('data-id');
            let delete_href = $(this).attr('data-href');

            Swal.fire({
                title: '@lang('Xóa Giảm giá')',
                text: '@lang('Bạn có muốn xóa Giảm giá này không ?')',
                icon: 'warning',
                confirmButtonText: '@lang('Có')',
                cancelButtonText: '@lang('Không')',
                showCancelButton: true,
                showCloseButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: delete_href,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "_method": "DELETE",
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Xóa thành công!',
                                text: 'Giảm giá đã được xóa.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(err) {

                            Swal.fire('Đã xảy ra lỗi!', 'Không thể xóa Giảm giá.', 'error');
                        }
                    });
                }
            });
        });


        //Date
        $('#joined_date').daterangepicker({
            autoUpdateInput: false,
            minDate: '1921/01/01',
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                format: 'YYYY/MM/DD',
                applyLabel: "Ok",
                cancelLabel: "Cancel",
                "monthNames": [
                    "@lang('Tháng 1')",
                    "@lang('Tháng 2')",
                    "@lang('Tháng 3')",
                    "@lang('Tháng 4')",
                    "@lang('Tháng 5')",
                    "@lang('Tháng 6')",
                    "@lang('Tháng 7')",
                    "@lang('Tháng 8')",
                    "@lang('Tháng 9')",
                    "@lang('Tháng 10')",
                    "@lang('Tháng 11')",
                    "@lang('Tháng 12')",
                ],
                daysOfWeek: [
                    "@lang('Chủ nhật')",
                    "@lang('Thứ 2')",
                    "@lang('Thứ 3')",
                    "@lang('Thứ 4')",
                    "@lang('Thứ 5')",
                    "@lang('Thứ 6')",
                    "@lang('Thứ 7')",
                ]
            }
        });
        $('#joined_date').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY/MM/DD'));
        });

        $('#joined_date').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

        @if (request('joined_date'))
            $('#joined_date').value("{{ request('joined_date') }}");
        @endif
        $('input[name="joined_date"]').val('');

        //
        $(document).on('click', '.changeStatus', function() {
            let id = $(this).attr('data-id');
            let href = $(this).attr('data-href');
            
            Swal.fire({
                title: '@lang('Trạng thái')',
                text: '@lang('Bạn muốn thay đổi trạng thái Giảm giá này?')',
                confirmButtonText: '@lang('Có')',
                cancelButtonText: '@lang('Không')',
                showCancelButton: true,
                showCloseButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "PUT",
                        url: href,
                        success: function(response) {
                            Swal.fire({
                                title: 'Thông báo!',
                                text: 'Thay đổi trạng thái thành công!',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(err) {
                            Swal.fire('Đã xảy ra lỗi!', 'Không thể thay đổi trạng thái.',
                                'error');
                        }
                    });
                }
            });
        });

        $(document).on('click', '.changeStatus', function() {
            let id = $(this).attr('data-id');
            let href = $(this).attr('data-href');
            
            Swal.fire({
                title: '@lang('Trạng thái')',
                text: '@lang('Bạn muốn thay đổi trạng thái Banner này?')',
                confirmButtonText: '@lang('Có')',
                cancelButtonText: '@lang('Không')',
                showCancelButton: true,
                showCloseButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "PUT",
                        url: href,
                        success: function(response) {
                            Swal.fire({
                                title: 'Thông báo!',
                                text: 'Thay đổi trạng thái thành công!',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(err) {
                            Swal.fire('Đã xảy ra lỗi!', 'Không thể thay đổi trạng thái.',
                                'error');
                        }
                    });
                }
            });
        });
    </script>
@endsection
