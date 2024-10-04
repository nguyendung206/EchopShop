@extends('admin.layout.app')
@section('title')
@lang('Chi tiết sản phẩm')
@endsection
@section('content')
<div class="backnow">
    <div class="backpage">
        <a href="{{ route('admin.userproduct.index') }}" class="back btn">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">@lang('Chi tiết sản phẩm cũ')</h5>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label font-weight-500" style="font-size: 1rem;">@lang('Cửa hàng:')</label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext pt-0" style="font-size: 1rem;">{{ $product->shop->name }}</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label font-weight-500" style="font-size: 1rem;">@lang('Tên sản phẩm:')</label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext pt-0" style="font-size: 1rem;">{{ $product->name }}</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-from-label font-weight-500" style="font-size: 1rem;">@lang('Giá:')</label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext pt-0" style="font-size: 1rem;">{{ format_price($product->price) }}</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-from-label font-weight-500" style="font-size: 1rem;">@lang('Kiểu sản phấm:')</label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext pt-0" style="font-size: 1rem;">{{ $product->type->label() }}</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-from-label font-weight-500" style="font-size: 1rem;">@lang('Mô tả:')</label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext pt-0" style="font-size: 1rem;">{{strip_tags($product->description)}}</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-from-label font-weight-500" style="font-size: 1rem;">@lang('Loại sản phẩm:')</label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext pt-0" style="font-size: 1rem;">{{ $product->category->name ?? ""}}</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-from-label font-weight-500" style="font-size: 1rem;">@lang('Hãng sản phẩm:')</label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext pt-0" style="font-size: 1rem;">{{ $product->brand->name ?? ""}}</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-from-label font-weight-500" style="font-size: 1rem;">@lang('Trạng thái:')</label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext pt-0" style="font-size: 1rem;">{{ $product->status->label() }}</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-from-label font-weight-500" style="font-size: 1rem;">@lang('Ảnh:')</label>
                    <div class="col-sm-9">
                        <img src="{{ $product->photo ? getImage($product->photo) : asset('storage/upload/product/noproduct.png') }}" class="img img-bordered" style="width:200px" />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-from-label font-weight-500" style="font-size: 1rem;">@lang('Thư viện ảnh:')</label>
                    @if($product->list_photo)
                    <div class="col-sm-9 d-flex flex-wrap">
                        @foreach(json_decode($product->list_photo) as $index => $photo)
                        <img src="{{ getImage($photo) }}" class="img img-bordered m-2" style="width:100px;" />
                        @endforeach
                    </div>
                    @else
                    <div class="col-sm-9">
                        <p class="form-control-plaintext pt-0" style="font-size: 1rem;">Chưa có ảnh nào</p>
                    </div>
                    @endif
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-from-label font-weight-500 mt-2" style="font-size: 1rem;">@lang('Số lượng:')</label>
                    <div class="col-sm-9">
                        <table class="table table-bordered" style="font-size: 1rem;">
                            <thead>
                                <tr>
                                    <th>@lang('Màu sắc')</th>
                                    <th>@lang('Kích cở')</th>
                                    <th>@lang('Số lượng')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($product->productUnits as $unit)
                                <tr>
                                    <td>{{ $unit->color }}</td>
                                    <td>{{ $unit->size }}</td>
                                    <td>{{ $unit->quantity }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">@lang('Chi tiết sản phẩm yêu cầu cập nhật')</h5>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label font-weight-500" style="font-size: 1rem;">@lang('Cửa hàng:')</label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext pt-0" style="font-size: 1rem;">{{ $wait->shop->name }}</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label font-weight-500" style="font-size: 1rem;">@lang('Tên sản phẩm:')</label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext pt-0" style="font-size: 1rem;">{{ $wait->name }}</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-from-label font-weight-500" style="font-size: 1rem;">@lang('Giá:')</label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext pt-0" style="font-size: 1rem;">{{ format_price($wait->price) }}</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-from-label font-weight-500" style="font-size: 1rem;">@lang('Kiểu sản phấm:')</label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext pt-0" style="font-size: 1rem;">{{ $wait->type->label() }}</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-from-label font-weight-500" style="font-size: 1rem;">@lang('Mô tả:')</label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext pt-0" style="font-size: 1rem;">{{strip_tags($wait->description)}}</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-from-label font-weight-500" style="font-size: 1rem;">@lang('Loại sản phẩm:')</label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext pt-0" style="font-size: 1rem;">{{ $wait->category->name ?? ""}}</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-from-label font-weight-500" style="font-size: 1rem;">@lang('Hãng sản phẩm:')</label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext pt-0" style="font-size: 1rem;">{{ $wait->brand->name ?? ""}}</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-from-label font-weight-500" style="font-size: 1rem;">@lang('Trạng thái:')</label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext pt-0" style="font-size: 1rem;">{{ $wait->status->label() }}</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-from-label font-weight-500" style="font-size: 1rem;">@lang('Ảnh:')</label>
                    <div class="col-sm-9">
                        <img src="{{ $wait->photo ? getImage($wait->photo) : asset('storage/upload/product/noproduct.png') }}" class="img img-bordered" style="width:200px" />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-from-label font-weight-500" style="font-size: 1rem;">@lang('Thư viện ảnh:')</label>
                    @if($wait->list_photo)
                    <div class="col-sm-9 d-flex flex-wrap">
                        @foreach(json_decode($wait->list_photo) as $index => $photo)
                        <img src="{{ getImage($photo) }}" class="img img-bordered m-2" style="width:100px;" />
                        @endforeach
                    </div>
                    @else
                    <div class="col-sm-9">
                        <p class="form-control-plaintext pt-0" style="font-size: 1rem;">Chưa có ảnh nào</p>
                    </div>
                    @endif
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-from-label font-weight-500 mt-2" style="font-size: 1rem;">@lang('Số lượng:')</label>
                    <div class="col-sm-9">
                        <table class="table table-bordered" style="font-size: 1rem;">
                            <thead>
                                <tr>
                                    <th>@lang('Màu sắc')</th>
                                    <th>@lang('Kích cở')</th>
                                    <th>@lang('Số lượng')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($wait->waitproductUnits as $unit)
                                <tr>
                                    <td>{{ $unit->color }}</td>
                                    <td>{{ $unit->size }}</td>
                                    <td>{{ $unit->quantity }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="form-group mb-0 text-right">
                    <a href="{{ route('admin.wait.index') }}" class="btn btn-light mr-2">@lang('Quay về')</a>
                    <a class="btn btn-danger text-white mr-2 wait"
                        data-id="{{ $wait->id }}"
                        data-product-id="{{ $wait->product_id }}"
                        data-href="{{ route('admin.wait.reject') }}"
                        data-status="1"
                        title="@lang('user.deactivate')">
                        Từ chối
                    </a>
                    <a class="btn btn-success text-white mr-2 wait"
                        data-id="{{ $wait->id }}"
                        data-product-id="{{ $wait->product_id }}"
                        data-href="{{ route('admin.wait.accept') }}"
                        data-status="2"
                        title="@lang('user.active')">
                        Phê duyệt
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@section('script')
<script>
    $(document).on('click', '.wait', function() {
        let id = $(this).attr('data-id');
        let product_id = $(this).attr('data-product-id');
        let href = $(this).attr('data-href');
        let status = $(this).attr('data-status');
        let titleText = status == 1 ? '@lang("Từ chối")' : '@lang("Phê duyệt")';
        let confirmText = status == 1 ? '@lang("Bạn muốn từ chối cập nhật sản phẩm này?")' : '@lang("Bạn muốn phê duyệt cập nhật sản phẩm này?")';

        Swal.fire({
            title: titleText,
            text: confirmText,
            icon: 'warning',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: '@lang("Có")',
            cancelButtonText: '@lang("Không")',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: href,
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id,
                        product_id: product_id,
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Thông báo!',
                            text: status == 1 ? 'Từ chối thành công!' : 'Phê duyệt thành công!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            location.reload(); // Tải lại trang
                        });
                    },
                    error: function(err) {
                        Swal.fire('Đã xảy ra lỗi!', 'Không thể thay đổi trạng thái.', 'error');
                    }
                });
            }
        });
    });
</script>
@endsection
@endsection