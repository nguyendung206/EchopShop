@extends('admin.layout.app')
@section('title')
@lang('Thêm mới chí phí vận chuyển')
@endsection
@section('content')
<div class="backnow">
    <div class="backpage">
        <a href="{{route('admin.feeship.index')}}" class="back btn"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg></a>
    </div>
</div>
<div class="row">
    <div class="col-lg-10 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">@lang('Thêm mới chí phí vận chuyển')</h5>
            </div>
            <div class="card-body">
                <form action="{{route('admin.feeship.store')}}" method="post">
                    @csrf
                    <div class="form-group row align-items-center">
                        <label style="font-size: 1rem;" class="col-sm-3 col-from-label font-weight-500">@lang('Tên chi phí')<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="@lang('Tên chi phí')" name="feename" class="form-control @error('feename') is-invalid @enderror" value="{{ old('feename') }}">
                            @error('feename')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label style="font-size: 1rem;" class="col-sm-3 col-from-label font-weight-500">@lang('Mô tả')</label>
                        <div class="col-sm-9">
                            <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label style="font-size: 1rem;" class="col-sm-3 col-from-label font-weight-500">@lang('Chọn địa điểm')<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-3">
                            <select class="text-center form-control font-weight-500 choose province" id="province" name="province_id">
                                <option value="">@lang('--Chọn Tỉnh/Thành phố--')</option>
                                @foreach ($provinces as $key => $province)
                                <option value="{{ $province->id }}">
                                    {{ $province->province_name }}
                                </option>
                                @endforeach
                            </select>
                            @error('province_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-3">
                            <select class="text-center form-control font-weight-500 choose district" id="district" name="district_id">
                                <option value="">@lang('--Chọn Quận/Huyện--')</option>
                            </select>
                            @error('district_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-3">
                            <select class="text-center form-control font-weight-500 ward" id="ward" name="ward_id">
                                <option value="">@lang('--Chọn Phường/Thị xã--')</option>
                            </select>
                            @error('ward_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label style="font-size: 1rem;" class="col-sm-3 col-from-label font-weight-500">@lang('Chi phí vận chuyển')<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="@lang('Chi phí')" name="feeship" class="form-control @error('feeship') is-invalid @enderror" value="{{ old('feeship') }}">
                            @error('feeship')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <a href="{{ route('admin.feeship.index') }}" type="button" class="btn btn-light mr-2">@lang('Hủy')</a>
                        <button type="submit" class="btn btn-primary">@lang('Lưu')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@section('script')
<script src="{{ asset('/js/province.js')}}"></script>
@endsection
@endsection