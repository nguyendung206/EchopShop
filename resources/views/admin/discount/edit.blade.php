@extends('admin.layout.app')
@section('title')
@lang('Sửa Giảm giá')
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
                <h5 class="mb-0 h6">Sửa Giảm giá</h5>
            </div>
            <div class="card-body">
                <form action="{{route('admin.discount.update', $discount->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Tiêu đề<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="Tiêu đề" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') ? old('title') : $discount->title }}">
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Mã giảm giá<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="Mã giảm giá" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code') ? old('code') : $discount->code }}">
                            @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Mô tả<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                        <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') ? old('description') : $discount->description }}
                        </textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Giá trị<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="Giá trị" name="value" class="form-control @error('value') is-invalid @enderror" value="{{ old('value') ? old('value') : $discount->value }}">
                            @error('value')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Giá trị Tối đa<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="Giá trị" name="maxValue" class="form-control @error('maxValue') is-invalid @enderror" value="{{ old('maxValue') ? old('maxValue') : $discount->max_value }}">
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
                            @error('startTime') is-invalid  @enderror" value="{{ old('startTime') ? old('startTime') : date('Y-m-d\TH:i', strtotime(optional($discount)->start_date)) }}">
                            @error('startTime')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Ngày kết thúc<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="datetime-local" placeholder="Ngày kết thúc" name="endTime" class="form-control
                            @error('endTime') is-invalid  @enderror" value="{{ old('endTime') ? old('endTime') : date('Y-m-d\TH:i', strtotime(optional($discount)->end_date)) }}">
                            @error('endTime')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Số lượng mã<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="number" placeholder="Số lượng mã" name="maxUses" class="form-control @error('maxUses') is-invalid @enderror" value="{{ old('maxUses') ? old('maxUses') : $discount->max_uses }}">
                            @error('maxUses')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Số lần dùng mỗi người<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="number" placeholder="Số lần dùng mỗi người" name="limitUses" class="form-control @error('limitUses') is-invalid @enderror" value="{{ old('limitUses') ? old('limitUses') : $discount->limit_uses }}">
                            @error('limitUses')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Trạng thái</label>
                        <div class="col-sm-9">
                            <select class="font-weight-500 form-control" name="status" >
                                <option value="{{ StatusEnums::ACTIVE->value }}" {{ $discount->status->value == StatusEnums::ACTIVE->value ? 'selected' : '' }} {{old('status') ? old('status') == StatusEnums::ACTIVE->value ? 'selected' : '' : ''}}>
                                    @lang(StatusEnums::ACTIVE->label())
                                </option>
                                <option value="{{ StatusEnums::INACTIVE->value }}" {{ $discount->status->value == StatusEnums::INACTIVE->value ? 'selected' : '' }} {{old('status') ? old('status') == StatusEnums::INACTIVE->value ? 'selected' : '' : ''}}>
                                    @lang(StatusEnums::INACTIVE->label())
                                </option>

                            </select>
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Ảnh<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="hidden" name="old_photo" value="{{ old('old_photo') }}" />
                            <input type="file" class="form-control @error('photo') is-invalid @enderror" name="photo" onchange="previewPhoto(this)" />
                            <img id="photo_preview" src="{{ old('old_photo') ? getImage(old('old_photo')) : getImage($discount->photo) }}" class="img img-bordered mt-4" style="width:200px" />

                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group mb-0 text-right">
                        <a href="{{ route('admin.discount.index') }}" type="button" class="btn btn-light mr-2">Hủy</a>
                        <button type="submit" class="btn btn-primary">@lang('Sửa')</button>
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