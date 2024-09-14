@extends('admin.layout.app')
@section('title')
@lang('Tạo loại hàng')
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
                <h5 class="mb-0 h6">@lang('Thêm mới loại hàng')</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.product.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label style="font-size: 1rem;" class="col-sm-3 col-form-label font-weight-500">@lang('Tên loại hàng')<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="@lang('Tên loại hàng')" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label style="font-size: 1rem;" class="col-sm-3 col-form-label font-weight-500">@lang('Giá')<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="number" placeholder="@lang('Giá bán')" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}">
                            @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label style="font-size: 1rem;" class="col-sm-3 col-from-label font-weight-500">@lang('Mô tả')<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label style="font-size: 1rem;" class="col-sm-3 col-form-label font-weight-500">@lang('Loại hàng')</label>
                        <div class="col-sm-9">
                            <select class="form-control font-weight-500" name="category_id">
                                <option value="" {{ old('category_id') === null ? 'selected' : '' }}>
                                    @lang('Chọn loại hàng')
                                </option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                        <label style="font-size: 1rem;" class="col-sm-3 col-form-label font-weight-500">@lang('Thương hiệu')</label>
                        <div class="col-sm-9">
                            <select class="form-control font-weight-500" name="brand_id">
                                <option value="" {{ old('brand_id') === null ? 'selected' : '' }}>
                                    @lang('Chọn thương hiệu')
                                </option>
                                @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                    @lang($brand->name)
                                </option>
                                @endforeach
                            </select>
                            @error('brand_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label style="font-size: 1rem;" class="col-sm-3 col-form-label font-weight-500">@lang('Kiểu sản phẩm')</label>
                        <div class="col-sm-9 mt-2">
                            @foreach(\App\Enums\TypeProduct::cases() as $type)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input @error('type') is-invalid @enderror" type="radio" name="type" id="type_{{ $type->value }}" value="{{ $type->value }}"
                                    {{ old('type') == $type->value ? 'checked' : '' }}>
                                <label style="font-size: 1rem;" class="form-check-label" for="type_{{ $type->value }}">
                                    @lang($type->label())
                                </label>
                            </div>
                            @endforeach
                            @error('type')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label style="font-size: 1rem;" class="col-sm-3 col-form-label font-weight-500">@lang('Trạng thái')</label>
                        <div class="col-sm-9 mt-2">
                            @foreach(\App\Enums\Status::cases() as $status)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="status_{{ $status->value }}" value="{{ $status->value }}"
                                    {{ old('status', \App\Enums\Status::ACTIVE->value) == $status->value ? 'checked' : '' }}>
                                <label style="font-size: 1rem;" class="form-check-label" for="status_{{ $status->value }}">
                                    @lang($status->label())
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group row">
                        <label style="font-size: 1rem;" class="col-sm-3 col-form-label font-weight-500">@lang('Số lượng')</label>
                        <div class="col-sm-9">
                            <div id="color_boxes">
                                <!-- Dynamic color inputs will be added here -->
                            </div>
                            <button type="button" class="btn btn-secondary mt-2" onclick="addColorBox()">+ @lang('Chi tiết')</button>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label style="font-size: 1rem;" class="col-sm-3 col-form-label font-weight-500">@lang('Ảnh')<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="hidden" name="old_photo" value="{{ old('old_photo') }}" />
                            <input type="file" class="form-control @error('photo') is-invalid @enderror" name="photo" onchange="previewPhoto(this)" />
                            <img id="photo_preview" src="{{ old('old_photo') ? getImage('upload/product/', old('old_photo')) : '' }}" class="img img-bordered" style="width:200px" />

                            @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                    </div>

                    <div class="form-group row">
                        <label style="font-size: 1rem;" class="col-sm-3 col-form-label font-weight-500">@lang('Ảnh khác')</label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control @error('list_photo') is-invalid @enderror" name="list_photo[]" multiple onchange="previewListPhotos(this)">
                            <div id="list_photo_preview" class="d-flex flex-wrap">
                               
                            </div>
                            @error('list_photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <a href="{{ route('admin.product.index') }}" type="button" class="btn btn-light mr-2">@lang('Hủy')</a>
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

    function previewListPhotos(input) {
        const previewContainer = document.getElementById('list_photo_preview');
        previewContainer.innerHTML = ''; // Clear previous previews

        if (input.files) {
            Array.from(input.files).forEach((file) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgWrapper = document.createElement('div');
                    imgWrapper.className = 'position-relative m-2';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'img img-bordered';
                    img.style.width = '200px';

                    const deleteBtn = document.createElement('button');
                    deleteBtn.className = 'btn btn-danger btn-sm position-absolute';
                    deleteBtn.style.top = '0';
                    deleteBtn.style.right = '0';
                    deleteBtn.innerHTML = '&times;';
                    deleteBtn.onclick = function() {
                        imgWrapper.remove();
                    };

                    imgWrapper.appendChild(img);
                    imgWrapper.appendChild(deleteBtn);
                    previewContainer.appendChild(imgWrapper);
                };
                reader.readAsDataURL(file);
            });
        }
    }

    function addColorBox() {
        const colorBoxContainer = document.getElementById('color_boxes');

        const newColorBox = document.createElement('div');
        newColorBox.className = 'input-group mb-2';

        // Input để nhập màu
        const colorInput = document.createElement('input');
        colorInput.type = 'text';
        colorInput.name = 'colors[]';
        colorInput.className = 'form-control';
        colorInput.placeholder = 'Nhập màu';

        // Input để nhập kích cở
        const sizeInput = document.createElement('input');
        sizeInput.type = 'text';
        sizeInput.name = 'sizes[]';
        sizeInput.className = 'form-control ml-2';
        sizeInput.placeholder = 'Nhập kích cở';

        // Input để nhập số lượng
        const quantityInput = document.createElement('input');
        quantityInput.type = 'number';
        quantityInput.name = 'quantities[]';
        quantityInput.className = 'form-control ml-2';
        quantityInput.placeholder = 'Nhập số lượng';
        // Nút xóa
        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.className = 'btn btn-danger ml-2';
        removeButton.textContent = 'X';
        removeButton.onclick = function() {
            colorBoxContainer.removeChild(newColorBox);
        };

        // Thêm các input vào thẻ div mới
        newColorBox.appendChild(colorInput);
        newColorBox.appendChild(sizeInput);
        newColorBox.appendChild(quantityInput);
        newColorBox.appendChild(removeButton);

        // Thêm thẻ div mới vào container
        colorBoxContainer.appendChild(newColorBox);
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