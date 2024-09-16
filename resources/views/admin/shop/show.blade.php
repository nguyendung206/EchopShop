@extends('admin.layout.app')
@section('title')
@lang('Chi tiết cửa hàng')
@endsection
@section('content')
<div class="backnow">
    <div class="backpage">
        <a href="{{ route('admin.shop.index') }}" class="back btn">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">@lang('Chi tiết cửa hàng')</h5>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label font-weight-500" style="font-size: 1rem;">@lang('Tên cửa hàng:')</label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext pt-0" style="font-size: 1rem;">{{ $shop->name }}</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-from-label font-weight-500" style="font-size: 1rem;">@lang('Tên chủ cửa hàng:')</label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext pt-0" style="font-size: 1rem;">{{ $shop->user->name }}</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-from-label font-weight-500" style="font-size: 1rem;">@lang('Hotline:')</label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext pt-0" style="font-size: 1rem;">{{ $shop->hotline }}</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-from-label font-weight-500" style="font-size: 1rem;">@lang('Email:')</label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext pt-0" style="font-size: 1rem;">{{ $shop->email }}</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-from-label font-weight-500" style="font-size: 1rem;">@lang('Giờ mở cửa:')</label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext pt-0" style="font-size: 1rem;">{{ $shop->open }}h</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-from-label font-weight-500" style="font-size: 1rem;">@lang('Giờ đóng cửa:')</label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext pt-0" style="font-size: 1rem;">{{ $shop->close }}h</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-from-label font-weight-500" style="font-size: 1rem;">@lang('Địa chỉ:')</label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext pt-0" style="font-size: 1rem;">{{ $shop->address }}</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-from-label font-weight-500" style="font-size: 1rem;">@lang('Trạng thái:')</label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext pt-0" style="font-size: 1rem;">{{ $shop->status->label() }}</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-from-label font-weight-500" style="font-size: 1rem;">@lang('Logo cửa hàng:')</label>
                    <div class="col-sm-9">
                        <img src="{{ $shop->logo ? getImage($shop->logo) : asset('storage/upload/shop/noshop.png') }}" class="img img-bordered" style="width:200px" />
                    </div>
                </div>

                <div class="form-group mb-0 text-right">
                    <a href="{{ route('admin.shop.index') }}" class="btn btn-light mr-2">@lang('Quay về')</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection