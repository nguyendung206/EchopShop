@extends('admin.layout.app')
@section('title')
@lang('Tạo loại hàng')
@endsection
@section('content')
<div class="backnow">
    <div class="backpage">
        <a href="{{route('category.index')}}" class="back btn"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg></a>
    </div>
</div>
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">@lang('Thêm mới loại hàng')</h5>
            </div>
            <div class="card-body">
                <form action="{{route('category.add.save')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">@lang('Tên loại hàng')<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="@lang('Tên loại hàng')" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">@lang('Mô tả')<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="@lang('Mô tả')" name="description" class="form-control @error('description') is-invalid @enderror" value="{{ old('description') }}">
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">@lang('Trạng thái')</label>
                        <div class="col-sm-9">
                            <select class="text-center form-control font-weight-500" name="status">
                                @foreach(\App\Enums\CategoryStatus::cases() as $status)
                                    <option value="{{ $status->value }}" {{ old('status', $category->status->value ?? null) == $status->value ? 'selected' : '' }}>
                                        @lang($status->label())
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">@lang('Ảnh')<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="hidden" name="old_photo" value="{{ old('old_photo') }}" />
                            <input type="file" class="form-control @error('photo') is-invalid @enderror" name="photo" onchange="previewPhoto(this)" />
                        </div>
                    </div>
                    @error('photo')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-group">
                        <img id="photo_preview" src="{{ old('old_photo') ? asset('upload/category/' . old('old_photo')) : '' }}" class="img img-bordered" style="width:200px" />
                    </div>
                    <div class="form-group mb-0 text-right">
                        <a href="{{ route('category.index') }}" type="button" class="btn btn-light mr-2">@lang('Hủy')</a>
                        <button type="submit" class="btn btn-primary">@lang('Lưu')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $('#password, #password_confirmation').on('keyup', function() {
        if ($('#password').val() == $('#password_confirmation').val()) {
            $('#message').html('Khớp').css('color', 'green');
        } else {
            $('#message').html('Không khớp').css('color', 'red');
        }
    });
</script>
@endsection