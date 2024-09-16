@extends('admin.layout.app')
@section('title')
@lang('Thêm Banner')
@endsection
@section('content')
<div class="backnow">
    <div class="backpage">
        <a href="{{route('admin.banner.index')}}" class="back btn"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg></a>
    </div>
</div>
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">Thêm mới Banner</h5>
            </div>
            <div class="card-body">
                <form action="{{route('admin.banner.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Tiêu đề</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="Tiêu đề" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Liên kết</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="Liên kết" name="link" class="form-control @error('link') is-invalid @enderror" value="{{ old('link') }}">
                            @error('link')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Mô tả</label>
                        <div class="col-sm-9">
                        <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}
                        </textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Trạng thái</label>
                        <div class="col-sm-9">
                            <select class="text-center font-weight-500 form-control @error('status') is-invalid  @enderror" name="status" >
                                <option value="{{ StatusEnums::ACTIVE->value }}" {{old('status') ? old('status') == StatusEnums::ACTIVE->value ? 'selected' : '' : ''}}>
                                    @lang(StatusEnums::ACTIVE->label())
                                </option>
                                <option value="{{ StatusEnums::INACTIVE->value }}" {{old('status') ? old('status') == StatusEnums::INACTIVE->value ? 'selected' : '' : ''}}>
                                    @lang(StatusEnums::INACTIVE->label())
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Thứ tự hiển thị</label>
                        <div class="col-sm-9">
                            <input type="number" placeholder="Nhập thứ tự hiển thị"name="display_order" class="form-control
                            @error('display_order') is-invalid  @enderror" value="{{ old('display_order') }}">
                            @error('display_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">@lang('Ảnh')<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="hidden" name="old_photo" value="{{ old('old_photo') }}" />
                            <input type="file" class="form-control @error('photo') is-invalid @enderror" name="photo" onchange="previewPhoto(this)" />
                            <img id="photo_preview" src="{{ getImage('nobanner.png')}}" class="img img-bordered mt-4" style="width:200px" />
                            @error('photo')
                              <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <a href="{{ route('admin.banner.index') }}" type="button" class="btn btn-light mr-2">Hủy</a>
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