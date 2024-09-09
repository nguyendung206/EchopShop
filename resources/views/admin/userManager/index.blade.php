@extends('admin.layout.app')
@section('title')
    @lang('user.customers')
@endsection
@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="align-items-center">
			<h1 class="h3"><strong>@lang('user.customers')</strong></h1>
	</div>
</div>
<div class="filter">
    <form class="" id="food" action="" method="GET">
        <?php
            $request = request()->all();
        $newRequest = http_build_query($request);
        ?>
        <div class="row gutters-5 mb-2">
            <div class="col-md-6 d-flex search">
                <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6 search_icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" class="form-control res-placeholder res-FormControl" id="search" name="search" value="{{ request('search')}}" @isset($sort_search) @endisset placeholder="@lang('user.search')">
            </div>
            <div class="col-md-3 text-md-right add-new ">
                <a href="{{route('manager-user.create')}}" class="btn btn-info btn-add-food d-flex justify-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Thêm người dùng</span>
                </a>
            </div>
            <div class="col-md-3 text-md-right download" style="padding-left: 3px">
                <a href="/"  type="button" class=" pl-0 pr-0 btn btn-info w-100 mr-2 d-flex  btn-responsive justify-content-center">
                    <i class="las la-cloud-download-alt m-auto-5 w-6 h-6"></i>
                    <span class="custom-FontSize ml-1">{{__('base.download-default-import')}}</span>
                </a>
            </div>
        </div>
        <div class="row gutters-5 mb-3 custom-change">
            <div class="col-md-3 ">
                <input type="text" onkeypress='return event.charCode >=48 && event.charCode<=57' autocomplete="off" class="form-control custom-placeholder"
                    name="joined_date" id="joined_date" placeholder="{{__('user.create_at')}}" value="{{ request('joined_date') }}">
                <div class="custom-down"><i class="fas fa-chevron-down"></i></div>
            </div>
            <div class="col-md-3 res-status">
                <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0 font-weight-500" id="status" name="status">
                    <option value="">@lang('user.status')</option>
                    <option @if(request('status') == (1)) selected @endif value="1">@lang('user.active')</option>
                    <option @if(request('status') == (2)) selected @endif value="2">@lang('user.deactivate')</option>
                </select>
            </div>
            <div class="col-md-6 d-flex">
                <button type="submit" class=" pl-0 pr-0 btn btn-info w-25 d-flex btn-responsive justify-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                      </svg>
                      {{-- <i class="las la-search la-lg mr-1"></i> --}}
                    <span class="custom-FontSize">@lang('user.search1')</span>
                </button>
                <a href="{{url()->current()}}" class="pl-0 pr-0 w-25 btn btn-info ml-2 d-flex btn-responsive justify-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                      </svg>
                    <span class="custom-FontSize">@lang('base.reset')</span>
                </a>
                <a href="{{ request()->fullUrlWithQuery(['export' => 1]) }}" class="font-size btn btn-info w-25 ml-2 d-flex  btn-responsive justify-content-center">
                    <i class="las la-cloud-download-alt m-auto-5 w-6 h-6"></i>
                    <span class="custom-FontSize ml-1">@lang('base.export')</span>
                </a>
                <button type="button" class="btn btn-info w-25 btn_import ml-2 d-flex btn-responsive justify-content-center">
					<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                      </svg>
                    <span class="custom-FontSize ml-1">@lang('user.import')</span>
                </button>
            </div>
        </div>
    </form>
</div>
<form action="/" id="form-import" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" accept=".csv,.xls,.xlsx" hidden name="file" class="form-control" id="file">
</form>
<div class="card">
    <div class="custom-overflow repon">
       
        <table class="table aiz-table mb-0 table_repon">
            <thead>
                <tr>
                    {{-- <th class="w-60 font-weight-800">ID</th>
                    <th class="">@lang('user.name')</th>
                    <th class="">@lang('user.email')</th>
                    <th class="w-180">@lang('user.phone')</th>
                    <th class="w-140">@lang('user.point')</th>
                    <th class="w-140">@lang('user.level')</th>
                    <th class="w-140">@lang('user.create_at')</th>
                    <th class="w-140">@lang('user.status')</th>
                    <th class="w-150 text-right">@lang('user.options')</th> --}}
                    <th class="w-60 font-weight-800">STT</th>
                    <th class="w-140">Tên người dùng</th>
                    <th class="w-140">Email</th>
                    <th class="w-140">Địa chỉ</th>
                    <th class="w-140">Trạng thái</th>
                    <th class="w-140">Giới tính</th>
                    <th class="w-140">Ngày sinh</th>
                    <th class="w-140">Tuỳ chọn</th>   
                </tr>
            </thead>
            <tbody>
                @if (!empty($users) && count($users))
                @foreach ($users as $key => $user)
                    <tr>
                        <td class="font-weight-800 align-middle">#{{ ($key + 1) + ($users->currentPage() - 1) * $users->perPage() }}</td>
                        <td class="font-weight-400 align-middle text-overflow">{{optional($user)->name}}</td>
                        <td class="font-weight-400 align-middle">{{$user->email}}</td>
                        <td class="font-weight-400 align-middle">{{$user->address}}</td>
                        <td class="font-weight-400 align-middle">
                            {{-- {{ App\Enums\UserStatus::getKey($user->status) == 'Active' ? 'Đang hoạt động' : 'Đã bị khoá'}} --}}
                            <form action="{{ route('manager-user.updateStatus', $user->id)}}" id="status-form-{{$user->id}}" method="POST"  style="display: inline-block">
                                @csrf
                                @method("PUT")
                            <select class="text-center font-weight-500" name="status" style="border: none" id="status-select{{$user->id}}">
                                <option class=" text-center" value="{{ App\Enums\UserStatus::Active }}" {!! $user->status == App\Enums\UserStatus::Active ? ' selected' : null !!}>Đang hoạt động</option>
                                <option class=" text-center" value="{{ App\Enums\UserStatus::Block }}" {!! $user->status == App\Enums\UserStatus::Block ? ' selected' : null !!}>Đã bị khoá</option>
                            </select>
                            </form>
                        </td>
                        <td class="font-weight-400 align-middle">{{ App\Enums\UserGender::getKey($user->gender) == 'Male' ? 'Nam' : 'Nữ' }}</td>
                        <td class="font-weight-400 align-middle">{{date('d/m/Y', strtotime(optional($user)->date_of_birth))}}</td>
                        <td class="">
                           
                            <a class="btn mb-1 btn-soft-primary btn-icon btn-circle btn-sm"  href="{{ route("manager-user.show", $user->id)}}"  >
                                <i class="las la-list"></i>
                            </a>
                            <a class="btn mb-1 btn-soft-primary btn-icon btn-circle btn-sm" href="{{ route("manager-user.edit", $user->id)}}" >
                                <i class="las la-edit"></i>
                            </a>
                            
                            <form action="{{ route('manager-user.destroy', $user->id)}}" id="delete-form" method="POST"  style="display: inline-block">
                                @csrf
                                @method("DELETE")
                                {{-- <button class="btn btn-danger" type="submit">Xoá</button> --}}
                                <a href="javascript:void(0)" data-href="{{route('manager-user.destroy',$user->id)}}" data-id="{{$user->id}}" class="btn btn-delete btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" title="@lang('user.delete')">
                                    <i class="las la-trash"></i>
                                </a>
                            </form>
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
        {{ $users->withQueryString()->render("pagination::bootstrap-4")}}
    </div>
</div>
@endsection

@section('script')
    <script type="text/javascript">

        function sort_customers(el){
            $('#sort_customers').submit();
        }
        $(document).on('click','.btn_import',function(){
            $('#file').click();
        })
        $(document).on('change','#file',function(ev){
            let file,form = $('#form-import');
            if (file = ev.currentTarget.files[0]) {
            if (file instanceof File) {
                if (['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/vnd.ms-excel'].includes(file.type)) {
                form.submit();
                } else{
                AIZ.plugins.notify('danger', "Something wrong");
                }
            }
            }
            ev.currentTarget.value = null;
        })
        @foreach (session('errors', collect())->toArray() as $message)
            AIZ.plugins.notify('danger', '{{ $message[0] }}');
        @endforeach
        // active popup
        $(document).on('click', '#active-popup', function() {
            Swal.fire({
                title: '@lang('user.active_user')',
                text: '@lang('user.continue')',
                // icon: 'error',
                confirmButtonText: '@lang('user.yes')',
                cancelButtonText: '@lang('user.no')',
                showCancelButton: true,
                showCloseButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).parents('form').submit();
                }
            });
        });
        $(document).on('click', '#inactive-popup', function() {
            Swal.fire({
                title: '@lang('user.inactive_user')',
                text: '@lang('user.continue')',
                // icon: 'error',
                confirmButtonText: '@lang('user.yes')',
                cancelButtonText: '@lang('user.no')',
                showCancelButton: true,
                showCloseButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).parents('form').submit();
                }
            });
        });
        //deletee
        $(document).on('click', '.btn-delete', function() {
            let delete_id= $(this).attr('data-id');
            let delete_href = $(this).attr('data-href');
            Swal.fire({
                title: 'Xoá người dùng này',
                text: 'Bạn có muốn tiếp tục xoá',
                confirmButtonText: 'Tiếp tục',
                cancelButtonText: 'Huỷ',
                showCancelButton: true,
                showCloseButton: true,

            }).then((result) => {
                if (result.isConfirmed) {
                    let form = $('#delete-form');
                    form.attr('action', delete_href);
                    form.submit();
                }
            });
        });

        // 
        $(document).on('focus', '[id^=status-select]', function() {
            let $select = $(this);
            // Lưu giá trị hiện tại vào thuộc tính data-old-value khi thẻ select nhận được focus
            $select.data('old-value', $select.val());
        });
        $(document).on('change', '[id^=status-select]', function() {
            let $select = $(this);
            let oldValue = $select.data('old-value');
            
            let selectedText = $(this).find("option:selected").text(); // Lấy text của tùy chọn đã chọn
            let userId = $(this).attr('id').replace('status-select', ''); // Lấy user ID từ id của thẻ select
            let form = $('#status-form-' + userId); // Lấy form theo user ID
            let formData = form.serialize(); // Lấy dữ liệu từ form, bao gồm cả CSRF token
            let updateHref = form.attr('action'); // Lấy URL action của form
            
            Swal.fire({
                title: 'Đổi trạng thái người dùng này',
                text: `Bạn đã chọn trạng thái: ${selectedText}. Bạn có muốn tiếp tục?`,
                confirmButtonText: 'Tiếp tục',
                cancelButtonText: 'Huỷ',
                showCancelButton: true,
                showCloseButton: true,

            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "PUT",
                        url: updateHref,
                        data: formData,
                        success: function (response){
                            Swal.fire({
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                            });
                        },
                        error: function(err) {
                            Swal.fire({
                            title: 'Lỗi',
                            text: 'Có lỗi xảy ra khi cập nhật trạng thái người dùng.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                        }
                    });
                }else {
                        $select.val(oldValue);
                }

            });
        });
        //


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
            "monthNames":[
                    "@lang('daterangepicker.th1')",
                    "@lang('daterangepicker.th2')",
                    "@lang('daterangepicker.th3')",
                    "@lang('daterangepicker.th4')",
                    "@lang('daterangepicker.th5')",
                    "@lang('daterangepicker.th6')",
                    "@lang('daterangepicker.th7')",
                    "@lang('daterangepicker.th8')",
                    "@lang('daterangepicker.th9')",
                    "@lang('daterangepicker.th10')",
                    "@lang('daterangepicker.th11')",
                    "@lang('daterangepicker.th12')",
                ],
                daysOfWeek:[
                    "@lang('daterangepicker.cn')",
                    "@lang('daterangepicker.t2')",
                    "@lang('daterangepicker.t3')",
                    "@lang('daterangepicker.t4')",
                    "@lang('daterangepicker.t5')",
                    "@lang('daterangepicker.t6')",
                    "@lang('daterangepicker.t7')",
                ]
            }
        });
        $('#joined_date').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('YYYY/MM/DD'));
        });

        $('#joined_date').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });
        @if(request('joined_date'))
        $('#joined_date').value("{{request('joined_date')}}");
        @endif
        $('input[name="joined_date"]').val('');

    </script>
@endsection


















