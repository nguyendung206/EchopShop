@extends('admin.layout.app')
@section('title')
@lang('Sản phẩm')
@endsection
@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="align-items-center">
		<h1 class="h3"><strong>@lang('Sản phẩm')</strong></h1>
	</div>
</div>
<div class="filter">
    <form class="" id="food" action="{{ route('product.index') }}" method="GET">
        <div class="row gutters-5 mb-2">
            <div class="col-md-6 d-flex search">
                <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6 search_icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" class="form-control res-placeholder res-FormControl" id="search" name="search" value="{{ request('search') }}" placeholder="@lang('Tìm kiếm theo tên và mô tả')">
            </div>
            <div class="col-md-3 text-md-right add-new ">
                <a href="{{route('product.add')}}" class="btn btn-info btn-add-food d-flex justify-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>@lang('Bổ sung')</span>
                </a>
            </div>
            <div class="col-md-3 text-md-right download" style="padding-left: 3px">
                <a href="" type="button" class=" pl-0 pr-0 btn btn-info w-100 mr-2 d-flex btn-responsive justify-content-center">
                    <i class="las la-cloud-download-alt m-auto-5 w-6 h-6"></i>
                    <span class="custom-FontSize ml-1">{{__('Tải về')}}</span>
                </a>
            </div>
        </div>
        <div class="row gutters-5 mb-3 custom-change">
            <div class="col-md-3 ">
                <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0 font-weight-500" id="types" name="type">
                    <option value="">@lang('Kiểu sản phẩm')</option>
                    @foreach (\App\Enums\TypeProduct::cases() as $type)
                    <option value="{{ $type->value }}" @if(request('type')==$type->value) selected @endif>
                        {{ $type->label() }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 res-status">
                <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0 font-weight-500" id="status" name="status">
                    <option value="">@lang('Trạng thái')</option>
                    @foreach (\App\Enums\Status::cases() as $status)
                    <option value="{{ $status->value }}" @if(request('status') == $status->value) selected @endif>
                        {{ $status->label() }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 d-flex">
                <button type="submit" class="pl-0 pr-0 btn btn-info w-25 d-flex btn-responsive justify-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <span class="custom-FontSize">@lang('Tìm kiếm')</span>
                </button>
                <a href="{{ url()->current() }}" class="pl-0 pr-0 w-25 btn btn-info ml-2 d-flex btn-responsive justify-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span class="custom-FontSize">@lang('Làm mới')</span>
                </a>
                <a href="{{ request()->fullUrlWithQuery(['export' => 1]) }}" class="font-size btn btn-info w-25 ml-2 d-flex  btn-responsive justify-content-center">
                    <i class="las la-cloud-download-alt m-auto-5 w-6 h-6"></i>
                    <span class="custom-FontSize ml-1">@lang('Xuất file')</span>
                </a>
                <button type="button" class="btn btn-info w-25 btn_import ml-2 d-flex btn-responsive justify-content-center">
					<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
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
                    <th class="w-60">@lang('Ảnh')</th>
                    <th class="w-25">@lang('Tên sản phẩm')</th>
                    <th class="">@lang('Mô tả')</th>
                    <th class="">@lang('Giá')</th>
                    <th class="">@lang('Kiểu sản phẩm')</th>
                    <th class="w-140">@lang('Trạng thái')</th>
                    <th class="" style="width: 15%;">@lang('Điều chỉnh')</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($datas) && count($datas))
                @foreach ($datas as $key => $data)
                    <tr class="text-center">
                        <td class="font-weight-800 align-middle">{{ ($key + 1) + ($datas->currentPage() - 1) * $datas->perPage() }}</td>
                        <td class="font-weight-400 align-middle">
                            <img style="height: 90px;" class="profile-user-img img-responsive img-bordered" src="{{ getImage('upload/product/', $data->photo) }}">
                        </td>
                        <td class="font-weight-400 align-middle text-overflow">{{optional($data)->name}}</td>
                        <td class="font-weight-400 align-middle">{{strip_tags($data->description)}}</td>
                        <td class="font-weight-400 align-middle">{{format_price($data->price)}}</td>
                        <td>{{ $data->type->label()}}</td>
                        <td>{{ $data->status->label() }}</td>
                        <td class="text-right">
                            <a class="btn mb-1 btn-soft-primary btn-icon btn-circle btn-sm" href="{{ route('product.show', ['id' => $data->id]) }}"  title="@lang('Show')">
                                <i class="las la-bars"></i>
                            </a>
                            @if ($data->status->value == 1)
                                <a class="btn mb-1 btn-soft-danger btn-icon btn-circle btn-sm btn_status" data-id="{{ $data->id }}" 
                                data-href="{{ route('product.changestatus', ['id' => $data->id]) }}" id="active-popup" title="@lang('user.deactivate')">
                                    <i class="las la-ban"></i>
                                </a>
                            @else
                                <a class="btn btn-soft-success btn-icon btn-circle btn-sm btn_status" data-id="{{ $data->id }}" 
                                data-href="{{ route('product.changestatus', ['id' => $data->id]) }}" id="inactive-popup" title="@lang('user.active')">
                                    <i class="las la-check-circle"></i>
                                </a>
                            @endif
                            <a class="btn mb-1 btn-soft-primary btn-icon btn-circle btn-sm" href="{{ route('product.edit', ['id' => $data->id]) }}"  title="@lang('Update')">
                                <i class="las la-edit"></i>
                            </a>
                            <a href="javascript:void(0)" data-href="{{ route('product.delete', ['id' => $data->id]) }}" data-id="{{$data->id}}" class="btn btn-delete btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" title="@lang('user.delete')">
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
        {{ $datas->appends(request()->input())->links("pagination::bootstrap-4") }}
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
    $(document).on('click', '#inactive-popup', function() {
        let id = $(this).attr('data-id');
        let href = $(this).attr('data-href');

        Swal.fire({
            title: '@lang("Kích hoạt")',
            text: '@lang("Bạn muốn kích hoạt Danh mục này?")',
            confirmButtonText: '@lang("Có")',
            cancelButtonText: '@lang("Không")',
            showCancelButton: true,
            showCloseButton: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "GET", 
                    url: href,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "_method": "GET",
                    },
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
                        Swal.fire('Đã xảy ra lỗi!', 'Không thể thay đổi trạng thái.', 'error');
                    }
                });  
            }
        });
    });

    $(document).on('click', '#active-popup', function() {
        let id = $(this).attr('data-id');
        let href = $(this).attr('data-href');

        Swal.fire({
            title: '@lang("Vô hiêu hóa")',
            text: '@lang("Bạn muốn vô hiệu hóa Danh mục này")',
            confirmButtonText: '@lang("Có")',
            cancelButtonText: '@lang("Không")',
            showCancelButton: true,
            showCloseButton: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "GET", 
                    url: href,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "_method": "GET",
                    },
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
                        Swal.fire('Đã xảy ra lỗi!', 'Không thể thay đổi trạng thái.', 'error');
                    }
                }); 
            }
        });
    });

    //deletee
    $(document).on('click', '.btn-delete', function() {
        let delete_id = $(this).attr('data-id');
        let delete_href = $(this).attr('data-href');

        Swal.fire({
            title: '@lang("Xóa Sản phẩm")',
            text: '@lang("Bạn có muốn xóa Sản phẩm này không ?")',
            icon: 'warning',
            confirmButtonText: '@lang("Có")',
            cancelButtonText: '@lang("Không")',
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
                            text: 'Sản phẩm đã được xóa.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(err) {
                        Swal.fire('Đã xảy ra lỗi!', 'Không thể xóa Sản phẩm.', 'error');
                    }
                });
            }
        });
    });
</script>
@endsection
