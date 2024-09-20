@extends('admin.layout.app')
@section('title')
@lang('Thêm giảm giá')
@endsection
@section('content')
<div class="backnow">
    <div class="backpage">
        <a href="{{route('admin.discount.index')}}" class="back btn"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg></a>
    </div>
</div>
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">Thêm mới giảm giá</h5>
            </div>
            <div class="card-body">
                <form action="{{route('admin.discount.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Tiêu đề<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="Tiêu đề" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Mã giảm giá<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="Mã giảm giá" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code') }}">
                            @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Mô tả<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                        <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}
                        </textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Giá trị<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="Giá trị" name="value" class="form-control @error('value') is-invalid @enderror" value="{{ old('value') }}">
                            @error('value')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Giá giảm tối đa<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="Giá trị" name="maxValue" class="form-control @error('maxValue') is-invalid @enderror" value="{{ old('maxValue') }}">
                            @error('maxValue')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Kiểu giảm giá</label>
                        <div class="col-sm-9">
                            <select class="text-center font-weight-500 form-control @error('type') is-invalid  @enderror" name="type" >
                                <option value="{{ TypeDiscountEnums::PERCENT->value }}" {{old('type') ? old('type') == TypeDiscountEnums::PERCENT->value ? 'selected' : '' : ''}}>
                                    @lang(TypeDiscountEnums::PERCENT->label())
                                </option>
                                <option value="{{ TypeDiscountEnums::FIXED->value }}" {{old('type') ? old('type') == TypeDiscountEnums::FIXED->value ? 'selected' : '' : ''}}>
                                    @lang(TypeDiscountEnums::FIXED->label())
                                </option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Ngày bắt đầu<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="datetime-local" placeholder="Ngày bắt đầu" name="startTime" class="form-control
                            @error('startTime') is-invalid  @enderror" value="{{ old('startTime') }}">
                            @error('startTime')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Ngày kết thúc<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="datetime-local" placeholder="Ngày kết thúc" name="endTime" class="form-control
                            @error('endTime') is-invalid  @enderror" value="{{ old('endTime') }}">
                            @error('endTime')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Số lượng mã<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="number" placeholder="Số lượng mã" name="maxUses" class="form-control @error('maxUses') is-invalid @enderror" value="{{ old('maxUses') }}">
                            @error('maxUses')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Số lần dùng mỗi người<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="number" placeholder="Số lần dùng mỗi người" name="limitUses" class="form-control @error('limitUses') is-invalid @enderror" value="{{ old('limitUses') }}">
                            @error('limitUses')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">@lang('Ảnh')<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="hidden" name="old_photo" value="{{ old('old_photo') }}" />
                            <input type="file" class="form-control @error('photo') is-invalid @enderror" name="photo" onchange="previewPhoto(this)" />
                            <img id="photo_preview" src="{{ getImage('nodiscount.png')}}" class="img img-bordered mt-4" style="width:200px" />
                            @error('photo')
                              <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

                    <div class="form-group mb-0 text-right">
                        <a href="{{ route('admin.discount.index') }}" type="button" class="btn btn-light mr-2">Hủy</a>
                        <button type="submit" class="btn btn-primary">@lang('Lưu')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function previewPhoto(input) {
        const preview = document.getElementById('photo_preview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection