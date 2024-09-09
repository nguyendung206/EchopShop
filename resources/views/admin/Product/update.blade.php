@extends('admin.layout.app')
@section('title')
@lang('Cập nhật sản phẩm')
@endsection
@section('content')
<div class="backnow">
    <div class="backpage">
        <a href="{{ route('product.index') }}" class="back btn">
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
                <h5 class="mb-0 h6">@lang('Cập nhật sản phẩm')</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('product.edit.save', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group row">
                        <label style="font-size: 1rem;" class="col-sm-3 col-from-label font-weight-500">@lang('Tên sản phẩm')</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="@lang('Tên sản phẩm')" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $product->name }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label style="font-size: 1rem;" class="col-sm-3 col-from-label font-weight-500">@lang('Giá')</label>
                        <div class="col-sm-9">
                            <input type="number" placeholder="@lang('Giá sản phẩm')" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ $product->price }}" required>
                            @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label style="font-size: 1rem;" class="col-sm-3 col-from-label font-weight-500">@lang('Mô tả')</label>
                        <div class="col-sm-9">
                            <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror">{{ $product->description }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label style="font-size: 1rem;" class="col-sm-3 col-from-label font-weight-500">@lang('Loại sản phẩm')</label>
                        <div class="col-sm-9">
                            <select class="form-control @error('category_id') is-invalid @enderror" name="category_id">
                                <option value="" {{ old('category_id', $brand->category_id ?? null) === null ? 'selected' : '' }}>@lang('Chọn loại sản phẩm')</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label style="font-size: 1rem;" class="col-sm-3 col-from-label font-weight-500">@lang('Hãng sản phẩm')</label>
                        <div class="col-sm-9">
                            <select class="form-control @error('brand_id') is-invalid @enderror" name="brand_id">
                                <option value="" {{ old('brand_id', $brand->brand_id ?? null) === null ? 'selected' : '' }}>@lang('Chọn hãng sản phẩm')</option>
                                @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ $brand->id == $product->brand_id ? 'selected' : '' }}>
                                    {{ $brand->name }}
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
                                    {{ old('type', $product->type->value ?? null) === $type->value ? 'checked' : '' }}>
                                <label style="font-size: 1rem;" class="form-check-label" for="type_{{ $type->value }}">
                                    {{ $type->label() }}
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
                                <input class="form-check-input @error('status') is-invalid @enderror" type="radio" name="status" id="status_{{ $status->value }}" value="{{ $status->value }}"
                                    {{ old('status', $product->status->value ?? null) === $status->value ? 'checked' : '' }}>
                                <label style="font-size: 1rem;" class="form-check-label" for="status_{{ $status->value }}">
                                    {{ $status->label() }}
                                </label>
                            </div>
                            @endforeach
                            @error('status')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label style="font-size: 1rem;" class="col-sm-3 col-from-label font-weight-500">@lang('Số lượng')</label>
                        <div class="col-sm-9">
                            <div id="color_boxes">
                                @foreach ($product->productUnits as $unit)
                                <div class="input-group mb-2">
                                    <input type="text" name="colors[]" class="form-control" value="{{ $unit->color }}" placeholder="Nhập màu">
                                    <input type="text" name="sizes[]" class="form-control ml-2" value="{{ $unit->size }}" placeholder="Nhập kích cỡ">
                                    <input type="number" name="quantities[]" class="form-control ml-2" value="{{ $unit->quantity }}" placeholder="Nhập số lượng">
                                    <button type="button" class="btn btn-danger ml-2" onclick="removeColorBox(this)">X</button>
                                </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-secondary mt-2" onclick="addColorBox()">+ @lang('Chi tiết')</button>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label style="font-size: 1rem;" class="col-sm-3 col-from-label font-weight-500">@lang('Ảnh')</label>
                        <div class="col-sm-9">
                            <input type="hidden" name="old_photo" value="{{ $product->photo }}">
                            <input type="file" class="form-control @error('photo') is-invalid @enderror" name="photo" onchange="previewPhoto(this)">
                            @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <img id="photo_preview" src="{{ $product->photo ? getImage($product->photo) : asset('storage/upload/product/noproduct.png') }}" class="img img-bordered" style="width:200px" />
                    </div>

                    <div class="form-group row">
                        <label style="font-size: 1rem;" class="col-sm-3 col-from-label font-weight-500">@lang('Ảnh khác')</label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control @error('list_photo') is-invalid @enderror" name="list_photo[]" multiple onchange="previewListPhotos(this)">
                            @error('list_photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <div id="list_photo_preview" class="d-flex flex-wrap">
                            @if($product->list_photo)
                            @foreach(json_decode($product->list_photo) as $index => $photo)
                            <div class="position-relative m-2">
                                <img src="{{ getImage($photo) }}" class="img img-bordered" style="width:100px; height: 150px;" />
                                <button type="button" class="btn btn-danger btn-sm position-absolute" style="top:0; right:0;" onclick="removePhoto(this, '{{ $photo }}')">X</button>
                                <input type="hidden" name="photos_to_keep[]" value="{{ $photo }}">
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="form-group mb-0 text-right">
                        <a href="{{ route('product.index') }}" class="btn btn-light mr-2">@lang('Hủy')</a>
                        <button type="submit" class="btn btn-primary">@lang('Lưu')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function addColorBox() {
        const colorBoxContainer = document.getElementById('color_boxes');

        const newColorBox = document.createElement('div');
        newColorBox.className = 'input-group mb-2';

        const colorInput = document.createElement('input');
        colorInput.type = 'text';
        colorInput.name = 'colors[]';
        colorInput.className = 'form-control';
        colorInput.placeholder = 'Nhập màu';

        const sizeInput = document.createElement('input');
        sizeInput.type = 'text';
        sizeInput.name = 'sizes[]';
        sizeInput.className = 'form-control ml-2';
        sizeInput.placeholder = 'Nhập kích cỡ';

        const quantityInput = document.createElement('input');
        quantityInput.type = 'number';
        quantityInput.name = 'quantities[]';
        quantityInput.className = 'form-control ml-2';
        quantityInput.placeholder = 'Nhập số lượng';

        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.className = 'btn btn-danger ml-2';
        removeButton.textContent = 'X';
        removeButton.onclick = function() {
            colorBoxContainer.removeChild(newColorBox);
        };

        newColorBox.appendChild(colorInput);
        newColorBox.appendChild(sizeInput);
        newColorBox.appendChild(quantityInput);
        newColorBox.appendChild(removeButton);

        colorBoxContainer.appendChild(newColorBox);
    }


    existingColors.forEach(item => addColorBox(item.name, item.quantity));
    existingSizes.forEach(item => addSizeBox(item.name, item.quantity));

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
                    img.style.width = '100px';

                    const deleteBtn = document.createElement('button');
                    deleteBtn.className = 'btn btn-danger btn-sm position-absolute';
                    deleteBtn.style.top = '0';
                    deleteBtn.style.right = '0';
                    deleteBtn.textContent = 'X';
                    deleteBtn.type = 'button';
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

    function removePhoto(button, photoName) {
        const photoWrapper = button.parentElement;
        photoWrapper.remove();

        const deletePhotosInput = document.getElementById('delete_photos');
        let deletePhotos = JSON.parse(deletePhotosInput.value || '[]');
        deletePhotos.push(photoName);
        deletePhotosInput.value = JSON.stringify(deletePhotos);
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