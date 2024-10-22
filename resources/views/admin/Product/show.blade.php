@extends('admin.layout.app')
@section('title')
@lang('Chi tiết sản phẩm')
@endsection
@section('content')
<div class="backnow">
    <div class="backpage">
        <a href="{{ route('admin.product.index') }}" class="back btn">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">@lang('Chi tiết sản phẩm')</h5>
            </div>
            <div class="card-body">
                @if(isset($product->shop->name))
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label font-weight-500" style="font-size: 1rem;">@lang('Cửa hàng:')</label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext pt-0" style="font-size: 1rem;">{{ $product->shop->name }}</p>
                    </div>
                </div>
                @endif
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
                    <label class="col-sm-3 col-from-label font-weight-500" style="font-size: 1rem;">@lang('Tên thương hiệu:')</label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext pt-0" style="font-size: 1rem;">{{ $product->brand->name ?? ""}}</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-from-label font-weight-500" style="font-size: 1rem;">@lang('Tình trạng sản phẩm:')</label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext pt-0" style="font-size: 1rem;">{{ $product->quality }}/100%</p>
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
                    @if($product->list_photo && !empty(json_decode($product->list_photo)))
                    <div class="col-sm-9 d-flex flex-wrap">
                        @foreach(json_decode($product->list_photo) as $index => $photo)
                        <img src="{{ getImage($photo) }}" class="img img-bordered m-2" style="width:200px;" />
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

                <div class="form-group mb-0 text-right">
                    <a href="{{ route('admin.product.index') }}" class="btn btn-light mr-2">@lang('Quay về')</a>
                    <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-primary">@lang('Sửa')</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection