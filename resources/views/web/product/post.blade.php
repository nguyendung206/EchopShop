@extends('web.layout.app')
@section('css')
<link rel="stylesheet" href="{{ asset('/css/profile.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="col-md-12">
        <h1 class="profile-title">Thông tin sản phẩm</h1>
    </div>
    <div class="p-4">
        <form action="{{route('post.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="shop_id" value="{{ optional(Auth::user()->shop)->id }}">
            <input type="hidden" name="status" value="2">
            <div class="form-group">
                <label for="productName">Tên sản phẩm *</label>
                <input name="name" type="text" id="productName" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Tên sản phẩm">
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputGender">Danh mục *</label>
                    <select class="form-control font-weight-500" name="category_id">
                        <option value="" {{ old('category_id') === null ? 'selected' : '' }}>Chọn Danh mục</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="inputGender">Thương hiệu *</label>
                    <select class="form-control font-weight-500" name="brand_id">
                        <option value="" {{ old('brand_id') === null ? 'selected' : '' }}>Chọn Danh mục</option>
                        @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('brand_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputGender">Hình thức *</label>
                    <select class="form-control @error('type') is-invalid @enderror" name="type" id="inputType">
                        <option value="">Chọn hình thức</option>
                        @foreach(\App\Enums\TypeProduct::cases() as $type)
                        <option value="{{ $type->value }}" {{ old('type') == $type->value ? 'selected' : '' }}>
                            {{ $type->label() }}
                        </option>
                        @endforeach
                    </select>
                    @error('type')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="inputDateOfBirth">Giá sản phẩm *</label>
                    <input type="number" placeholder="Giá bán" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}">
                    @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="description">Mô tả sản phẩm *</label>
                <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Chi tiết </label>
                <div id="color_boxes">
                </div>
                <button type="button" class="btn btn-secondary mt-2" onclick="addColorBox()">+ @lang('Chi tiết')</button>

            </div>

            <div class="form-group">
                <label for="photoImage">Ảnh chính *</label>
                <div id="photoImageContainer">
                    <img id="photoImagePreview" src="{{ asset('/img/image/upload.png') }}" alt="Ảnh sản phẩm" class="upload-img" style="cursor: pointer; object-fit:cover; margin: 0;">
                    <input type="file" id="photoImageInput" name="photo" style="display: none;" accept="image/*" onchange="previewPhotoImage(event)">
                </div>
            </div>
            @error('photo')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            <div class="form-group">
                <label for="listPhoto">Ảnh khác</label>
                <input type="file" class="form-control @error('list_photo') is-invalid @enderror" name="list_photo[]" multiple onchange="previewListPhotos(this)">
                <div id="list_photo_preview" class="d-flex flex-wrap">
                </div>
                @error('list_photo')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="float-right form-btn">
                <a href="{{ route('home') }}" class="form-btn-cancel">Hủy</a>
                <button type="submit" class="form-btn-save">Lưu</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Preview ảnh chính
    function previewPhotoImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('photoImagePreview');
            output.src = reader.result;
            output.style.width = '200px';
            output.style.height = 'auto';
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    document.getElementById('photoImagePreview').addEventListener('click', function() {
        document.getElementById('photoImageInput').click();
    });

    // Preview nhiều ảnh
    function previewListPhotos(input) {
        const previewContainer = document.getElementById('list_photo_preview');
        previewContainer.innerHTML = '';

        // Đảm bảo không có file nào trong danh sách đã tồn tại
        const files = Array.from(input.files);

        files.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgWrapper = document.createElement('div');
                imgWrapper.className = 'position-relative m-2';

                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'img img-bordered';
                img.style.width = '200px';

                const deleteBtn = document.createElement('button');
                deleteBtn.type = 'button'; // Ngăn chặn việc gửi form
                deleteBtn.className = 'btn btn-danger btn-sm position-absolute';
                deleteBtn.style.top = '0';
                deleteBtn.style.right = '0';
                deleteBtn.innerHTML = '&times;';
                deleteBtn.dataset.index = index; // Gán chỉ số vào thuộc tính dữ liệu
                deleteBtn.onclick = function() {
                    removePhoto(this.dataset.index); // Sử dụng thuộc tính dữ liệu để lấy chỉ số
                };

                imgWrapper.appendChild(img);
                imgWrapper.appendChild(deleteBtn);
                previewContainer.appendChild(imgWrapper);
            };
            reader.readAsDataURL(file);
        });
    }

    // Hàm xóa ảnh
    function removePhoto(index) {
        const previewContainer = document.getElementById('list_photo_preview');
        const input = document.querySelector('input[name="list_photo[]"]');
        const files = Array.from(input.files);

        // Xóa ảnh trong giao diện
        if (index >= 0 && index < previewContainer.children.length) {
            previewContainer.children[index].remove();

            // Tạo một mảng file mới sau khi xóa
            const dt = new DataTransfer();
            files.forEach((file, i) => {
                if (i !== parseInt(index, 10)) { // Đảm bảo rằng chỉ số được so sánh đúng kiểu dữ liệu
                    dt.items.add(file); // Giữ lại các file không bị xóa
                }
            });

            // Cập nhật lại input với danh sách file mới
            input.files = dt.files;

            // Nếu không còn ảnh nào, reset input file
            if (previewContainer.children.length === 0) {
                input.value = ''; // Reset input file nếu không còn ảnh nào
            }
        } else {
            console.error('Index không hợp lệ hoặc ảnh không tồn tại.');
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