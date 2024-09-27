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
                    <label for="inputCategory">Danh mục *</label>
                    <select class="form-control font-weight-500" name="category_id" id="inputCategory">
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
                    <label for="inputBrand">Thương hiệu *</label>
                    <select class="form-control font-weight-500" name="brand_id" id="inputBrand">
                        <option value="">Chọn Thương hiệu</option>
                        <!-- Options will be populated by JavaScript -->
                    </select>
                    @error('brand_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputType">Hình thức *</label>
                    <select class="form-control @error('type') is-invalid @enderror" name="type" id="inputType" onchange="checkType()">
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

            <div class="form-group" id="detailQuantity" style="display: none;">
                <label for="quantity">Số lượng chi tiết</label>
                <div id="quantity_boxes"></div>
            </div>

            <div class="form-group" id="detailContainer" style="display: none;">
                <label for="colors">Chi tiết màu sắc</label>
                <div id="color_boxes"></div>
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
    document.addEventListener('DOMContentLoaded', function() {
        const categories = @json($categories);
        const brands = @json($brands);
        const categorySelect = document.getElementById('inputCategory');
        const brandSelect = document.getElementById('inputBrand');

        categorySelect.addEventListener('change', function() {
            const selectedCategoryId = this.value;

            brandSelect.innerHTML = '<option value="">Chọn Thương hiệu</option>';

            if (selectedCategoryId) {
                const filteredBrands = brands.filter(brand => brand.category_id == selectedCategoryId);

                filteredBrands.forEach(brand => {
                    const option = document.createElement('option');
                    option.value = brand.id;
                    option.textContent = brand.name;
                    brandSelect.appendChild(option);
                });
            }
        });
    });
</script>

<script>
    function checkType() {
        const typeSelect = document.getElementById('inputType');
        const detailContainer = document.getElementById('detailContainer');
        const detailQuantity = document.getElementById('detailQuantity');
        const selectedValue = typeSelect.value;

        detailContainer.style.display = 'none';
        detailQuantity.style.display = 'none';
        clearContainer('color_boxes');
        clearContainer('quantity_boxes');

        if (selectedValue == 2 || selectedValue == 4) {
            detailContainer.style.display = 'block';
        } else if (selectedValue == 1 || selectedValue == 3) {
            detailQuantity.style.display = 'block';
            addQuantityBox(); 
        }
    }

    function clearContainer(containerId) {
        const container = document.getElementById(containerId);
        container.innerHTML = '';
    }

    function addColorBox() {
        const colorBoxContainer = document.getElementById('color_boxes');
        const newColorBox = createColorBox();
        colorBoxContainer.appendChild(newColorBox);
    }

    function createColorBox() {
        const colorBox = document.createElement('div');
        colorBox.className = 'input-group mb-2';

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

        const removeButton = createRemoveButton(colorBox);

        colorBox.appendChild(colorInput);
        colorBox.appendChild(sizeInput);
        colorBox.appendChild(quantityInput);
        colorBox.appendChild(removeButton);

        return colorBox;
    }

    function addQuantityBox() {
        const quantityBoxContainer = document.getElementById('quantity_boxes');

        if (quantityBoxContainer.children.length === 0) {
            const newQuantityBox = createQuantityBox();
            quantityBoxContainer.appendChild(newQuantityBox);
        }
    }

    function createQuantityBox() {
        const quantityBox = document.createElement('div');
        quantityBox.className = 'input-group mb-2';

        const quantityInput = document.createElement('input');
        quantityInput.type = 'number';
        quantityInput.name = 'quantities[]';
        quantityInput.className = 'form-control';
        quantityInput.placeholder = 'Nhập số lượng';

        quantityBox.appendChild(quantityInput);

        return quantityBox;
    }

    function createRemoveButton(box) {
        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.className = 'btn btn-danger ml-2';
        removeButton.textContent = 'X';
        removeButton.onclick = function() {
            box.parentNode.removeChild(box);
        };
        return removeButton;
    }

    document.addEventListener('DOMContentLoaded', checkType);
</script>

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