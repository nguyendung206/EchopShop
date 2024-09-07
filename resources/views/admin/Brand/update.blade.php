@extends('admin.layout.app')
@section('title')
@lang('Cập nhật Loại hàng')
@endsection
@section('content')
<div class="backnow">
    <div class="backpage">
        <a href="{{ route('brand.index') }}" class="back btn">
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
                <h5 class="mb-0 h6">@lang('Cập nhật Loại hàng')</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('brand.edit.save', $brand->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">@lang('Tên loại hàng')</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="@lang('Tên loại hàng')" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $brand->name }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">@lang('Mô tả')</label>
                        <div class="col-sm-9">
                            <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror">{{ $brand->description}}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">@lang('Trạng thái')</label>
                        <div class="col-sm-9">
                            <select class="form-control @error('status') is-invalid @enderror" name="status">
                                @foreach(\App\Enums\Status::cases() as $status)
                                <option value="{{ $status->value }}" {{ old('status', $brand->status->value ?? null) === $status->value ? 'selected' : '' }}>
                                    {{ $status->label() }}
                                </option>
                                @endforeach
                            </select>
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">@lang('Loại hàng')</label>
                        <div class="col-sm-9">
                            <select class="text-center form-control font-weight-500" name="category_id">
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $brand->category_id ?? null) == $category->id ? 'selected' : '' }}>
                                    @lang($category->name)
                                </option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">@lang('Ảnh')</label>
                        <div class="col-sm-9">
                            <input type="hidden" name="old_photo" value="{{ $brand->photo }}">
                            <input type="file" class="form-control @error('photo') is-invalid @enderror" name="photo" onchange="previewPhoto(this)">
                            @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <img id="photo_preview" src="{{ $brand->photo ? getImage('upload/product/', $brand->photo) : asset('upload/product/noproduct.png') }}" class="img img-bordered" style="width:200px" />
                    </div>

                    <div class="form-group mb-0 text-right">
                        <a href="{{ route('brand.index') }}" class="btn btn-light mr-2">@lang('Hủy')</a>
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
<script type="importmap">
    {
        "imports": {
            "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.js",
            "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/43.0.0/"
        }
    }
</script>
<script type="module">
    import {
        ClassicEditor,
        Essentials,
        Paragraph,
        Bold,
        Italic,
        Font
    } from 'ckeditor5';
    ClassicEditor
        .create(document.querySelector('#description'), {
            plugins: [Essentials, Paragraph, Bold, Italic, Font],
            toolbar: [
                'undo', 'redo', '|', 'bold', 'italic', '|',
                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
            ]
        })
        .then(editor => {
            window.editor = editor;
        })
        .catch(error => {
            console.error(error);
        });
</script>
@endsection