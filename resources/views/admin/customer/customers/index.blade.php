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
                    <span>@lang('user.add')</span>
                </a>
            </div>
            <div class="col-md-3 text-md-right download" style="padding-left: 3px">
                <a href="{{ route('admin.users.defaultImport') . '?' . $newRequest }}"  type="button" class=" pl-0 pr-0 btn btn-info w-100 mr-2 d-flex  btn-responsive justify-content-center">
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
<form action="{{ route('admin.importUser') }}" id="form-import" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" accept=".csv,.xls,.xlsx" hidden name="file" class="form-control" id="file">
</form>
<div class="card">
    <div class="custom-overflow repon">
        <table class="table aiz-table mb-0 table_repon">
            <thead>
                <tr>
                    <th class="w-60 font-weight-800">ID</th>
                    <th class="">@lang('user.name')</th>
                    <th class="">@lang('user.email')</th>
                    <th class="w-180">@lang('user.phone')</th>
                    <th class="w-140">@lang('user.point')</th>
                    <th class="w-140">@lang('user.level')</th>
                    <th class="w-140">@lang('user.create_at')</th>
                    <th class="w-140">@lang('user.status')</th>
                    <th class="w-150 text-right">@lang('user.options')</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($customers) && count($customers))
                @foreach ($customers as $key => $customer)
                    <tr>
                        <td class="font-weight-800 align-middle">#{{ ($key + 1) + ($customers->currentPage() - 1) * $customers->perPage() }}</td>
                        <td class="font-weight-400 align-middle text-overflow">{{optional($customer)->name}}</td>
                        <td class="font-weight-400 align-middle">{{$customer->email}}</td>
                        <td class="font-weight-400 align-middle">{{$customer->phone}}</td>
                        <td class="font-weight-400 align-middle">{{optional($customer)->point}}</td>
                        <td class="font-weight-400 align-middle">{{optional($customer)->level}}</td>
                        <td class="font-weight-400 align-middle">{{date('Y/m/d', strtotime(optional($customer)->created_at))}}</td>
                        <td class="font-weight-400 align-middle">{{optional($customer)->statusText('status')}}</td>
                        <td class="text-right">
                            <form action="{{ route('admin.updateStatusUser',$customer->id)}}" method="POST" class="mr-2" id="form-active-user">
                                <input type="hidden" name="status" value="{{ $customer->status == 1? '2':'1'}}">
                                    @csrf
                                    @if ($customer->status==2)
                                        <a class="btn mb-1 btn-soft-danger btn-icon btn-circle btn-sm btn_status" href="#" id="active-popup" title="@lang('user.deactivate')">
                                            <i class="las la-ban"></i>
                                        </a>
                                    @else
                                        <a class="btn btn-soft-success btn-icon btn-circle btn-sm btn_status" href="#" id="inactive-popup" title="@lang('user.active')">
                                            <i class="las la-ban"></i>
                                        </a>
                                    @endif
                                    <a class="btn mb-1 btn-soft-primary btn-icon btn-circle btn-sm" href="{{ route('manager-user.edit',$customer->id) }}" title="@lang('user.edit')">
                                        <i class="las la-edit"></i>
                                    </a>
                                    <a href="javascript:void(0)" data-href="{{route('manager-user.destroy',$customer->id)}}" data-id="{{$customer->id}}" class="btn btn-delete btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" title="@lang('user.delete')">
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
        {{ $customers->withQueryString()->render("pagination::bootstrap-4")}}
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
                title: '@lang('user.delete_cf')',
                text: '@lang('user.continue')',
                // icon: 'error',
                confirmButtonText: '@lang('user.yes')',
                cancelButtonText: '@lang('user.no')',
                showCancelButton: true,
                showCloseButton: true,

            }).then((result) => {
                if (result.isConfirmed) {
                    var data = {
                        "_token": "{{ csrf_token() }}",
                        "id": delete_id,
                    };
                    $.ajax({
                        type: "DELETE",
                        url: delete_href,
                        data: data,
                        success: function (response){
                            location.reload();
                        },
                        error : function(err) {
                            console.log(err.responseText);
                            Swal.fire('Changes are not saved', '', 'info');
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
