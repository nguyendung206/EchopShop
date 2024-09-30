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
        <form action="{{ route('post.update', $post->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="shop_id" value="{{ optional(Auth::user()->shop)->id }}">
            <input type="hidden" name="status" value="{{$post->status}}">
            <div class="form-group">
                <label for="productName">Tên sản phẩm *</label>
                <input name="name" type="text" id="productName" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $post->name) }}" placeholder="Tên sản phẩm">
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputCategory">Danh mục *</label>
                    <select class="form-control font-weight-500" name="category_id" id="categorySelect">
                        <option value="" {{ old('category_id', $post->category_id) === null ? 'selected' : '' }}>Chọn Danh mục</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
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
                    <select class="form-control font-weight-500" name="brand_id" id="brandSelect">
                        <option value="" {{ old('brand_id', $post->brand_id) === null ? 'selected' : '' }}>Chọn Thương hiệu</option>
                        @foreach($brands as $brand)
                        @if($brand->category_id == $post->category_id)
                        <option value="{{ $brand->id }}" {{ old('brand_id', $post->brand_id) == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                        @endif
                        @endforeach
                    </select>
                    @error('brand_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputType">Hình thức *</label>
                    <select class="form-control @error('type') is-invalid @enderror" name="type" id="inputType">
                        <option value="" {{ old('type', $post->type->value) === null ? 'selected' : '' }}>Chọn hình thức</option>
                        @foreach(\App\Enums\TypeProduct::cases() as $type)
                        <option value="{{ $type->value }}" {{ old('type', $post->type->value) == $type->value ? 'selected' : '' }}>
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
                    <input type="number" placeholder="Giá bán" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $post->price) }}">
                    @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="description">Mô tả sản phẩm *</label>
                <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $post->description) }}</textarea>
                @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="productDetails">Chi tiết *</label>
                <div class="ml-4 form-check form-check-inline">
                    <input name="unittype" type="radio" id="unitType1" class="form-check-input" value="1" {{ old('unittype', $post->productUnits->first()->type ?? null) == '1' ? 'checked' : '' }} style="cursor: pointer;" onchange="toggleDetailInput()">
                    <label class="form-check-label" for="unitType1" style="cursor: pointer;">Chỉ có số lượng</label>
                </div>

                <div class="form-check form-check-inline">
                    <input name="unittype" type="radio" id="unitType2" class="form-check-input" value="2" {{ old('unittype', $post->productUnits->first()->type ?? null) == '2' ? 'checked' : '' }} style="cursor: pointer;" onchange="toggleDetailInput()">
                    <label class="form-check-label" for="unitType2" style="cursor: pointer;">Kích cỡ, màu, số lượng</label>
                </div>
            </div>

            <div class="form-group" id="quantityInput" style="{{ old('unittype', $post->productUnits->first()->type ?? null) == '1' ? 'display: block;' : 'display: none;' }}">
                <label for="quantity">Số lượng</label>
                <input type="number" name="quantity" id="quantity" class="form-control" min="1" placeholder="Nhập số lượng" value="{{ old('quantity', $post->productUnits->isNotEmpty() ? $post->productUnits->first()->quantity : '') }}">
            </div>

            <div class="form-group" id="colorSizeInput" style="{{ old('unittype', $post->productUnits->first()->type ?? null) == '2' ? 'display: block;' : 'display: none;' }}">
                <label for="colors">Chi tiết màu sắc</label>
                <div id="color_boxes">
                    @foreach($post->productUnits as $unit)
                    <div class="input-group mb-2">
                        <input type="text" name="colors[]" class="form-control" placeholder="Nhập màu" value="{{ old('colors.'.$loop->index, $unit->color) }}">
                        <input type="text" name="sizes[]" class="form-control ml-2" placeholder="Nhập kích cỡ" value="{{ old('sizes.'.$loop->index, $unit->size) }}">
                        <input type="number" name="quantities[]" class="form-control ml-2" placeholder="Nhập số lượng" min="1" value="{{ old('quantities.'.$loop->index, $unit->quantity) }}">
                        <button type="button" class="btn btn-danger ml-2" onclick="this.parentElement.remove()">X</button>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-secondary mt-2" onclick="addColorBox()">+ Thêm chi tiết</button>
            </div>


            <div class="form-group">
                <label for="photoImage">Ảnh chính *</label>
                <div id="photoImageContainer">
                    <img id="photoImagePreview" src="{{ getImage($post->photo) }}" alt="Ảnh sản phẩm" class="upload-img" style="cursor: pointer; object-fit:cover; margin: 0; width:200px; height:auto;">
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
                    @if($post->list_photo)
                    @foreach(json_decode($post->list_photo) as $index => $photo)
                    <div class="position-relative m-2">
                        <img src="{{ asset('storage/'.$photo) }}" class="img img-bordered" style="width: 200px;">
                        <button type="button" class="btn btn-danger btn-sm position-absolute" style="top: 0; right: 0;" data-index="{{ $index }}" onclick="removePhoto(this.dataset.index)">&times;</button>
                        <input type="hidden" name="photos_to_keep[]" value="{{ $photo }}">
                    </div>
                    @endforeach
                    @endif
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
    document.addEventListener('DOMContentLoaded', toggleDetailInput);

    function toggleDetailInput() {
        const selectedValue = document.querySelector('input[name="unittype"]:checked').value;
        const quantityInput = document.getElementById('quantityInput');
        const colorSizeInput = document.getElementById('colorSizeInput');

        if (selectedValue == '1') {
            quantityInput.style.display = 'block';
            colorSizeInput.style.display = 'none';
        } else {
            quantityInput.style.display = 'none';
            colorSizeInput.style.display = 'block';
        }
    }

    function addColorBox() {
        const colorBoxContainer = document.getElementById('color_boxes');
        const newColorBox = createColorBox();
        colorBoxContainer.appendChild(newColorBox);
    }

    function createColorBox(color = '', size = '', quantity = '') {
        const colorBox = document.createElement('div');
        colorBox.className = 'input-group mb-2';

        const colorInput = document.createElement('input');
        colorInput.type = 'text';
        colorInput.name = 'colors[]';
        colorInput.className = 'form-control';
        colorInput.placeholder = 'Nhập màu';
        colorInput.value = color;

        const sizeInput = document.createElement('input');
        sizeInput.type = 'text';
        sizeInput.name = 'sizes[]';
        sizeInput.className = 'form-control ml-2';
        sizeInput.placeholder = 'Nhập kích cỡ';
        sizeInput.value = size;

        const quantityInput = document.createElement('input');
        quantityInput.type = 'number';
        quantityInput.name = 'quantities[]';
        quantityInput.className = 'form-control ml-2';
        quantityInput.placeholder = 'Nhập số lượng';
        quantityInput.min = 1; 
        quantityInput.value = quantity;

        const removeButton = createRemoveButton(colorBox);

        colorBox.appendChild(colorInput);
        colorBox.appendChild(sizeInput);
        colorBox.appendChild(quantityInput);
        colorBox.appendChild(removeButton);

        return colorBox;
    }

    function createRemoveButton(parent) {
        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.className = 'btn btn-danger ml-2';
        removeButton.textContent = 'X';
        removeButton.onclick = function() {
            parent.remove();
        };
        return removeButton;
    }
</script>

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
    document.addEventListener('DOMContentLoaded', function() {
        const categories = @json($categories);
        const brands = @json($brands);
        const categorySelect = document.getElementById('categorySelect');
        const brandSelect = document.getElementById('brandSelect');

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
        const photosToKeepInput = document.querySelector('input[name="photos_to_keep[]"]');
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