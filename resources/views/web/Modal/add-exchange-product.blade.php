@section('css')
<link rel="stylesheet" href="{{ asset('/css/profile.css') }}">
<link rel="stylesheet" href="{{ asset('/css/inputRangerQuality.css') }}">
<style>
    .add {
        color: #B10000 !important;
        border: none !important;
        padding: 0 !important;
        cursor: pointer;
    }

    .add:hover {
        background-color: #fff !important;
        color: #B10000 !important;
    }

    .apply {
        padding: 8px 40px;
        border: 1px solid #B10000;
        cursor: pointer;
        border-radius: 10px;
        background-color: #B10000;
        color: #fff;
    }

    .apply:hover {
        background-color: #4f0000;
        color: #fff !important;
    }

    .back {
        color: #B10000;
        background-color: #fff;
    }
</style>
@endsection
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Thêm sản phẩm mới</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formExchangeProduct" action="{{route('post.store')}}" method="post" enctype="multipart/form-data">
                <div class="modal-body" style="overflow-y: auto; height: 540px !important;">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ optional(Auth::user())->id }}">
                    <input type="hidden" name="status" value="2">
                    <div class="form-group">
                        <label for="productName">Tên sản phẩm *</label>
                        <input name="name" type="text" id="productName" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Tên sản phẩm">
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
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputBrand">Thương hiệu *</label>
                            <select class="form-control font-weight-500" name="brand_id" id="inputBrand">
                                <option value="">Chọn Thương hiệu</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputType">Hình thức *</label>
                            <input name="" type="text" id="inputType" class="form-control" value="Hàng trao đổi" readonly placeholder="Tên sản phẩm">
                            <input type="hidden" name="type" value="1">
                        </div>

                        <div class="form-group col-md-6">
                            <label>Giá sản phẩm *</label>
                            <input type="number" placeholder="Giá bán" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">Mô tả sản phẩm *</label>
                        <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Chi tiết *</label>
                        <div class="ml-4 form-check form-check-inline">
                            <input name="unittype" type="radio" id="unitType1" class="form-check-input" value="1" {{ old('unittype') == '1' ? 'checked' : '' }} checked style="cursor: pointer;" onchange="toggleDetailInput()">
                            <label class="form-check-label" for="unitType1" style="cursor: pointer;">Chỉ có số lượng</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input name="unittype" type="radio" id="unitType2" class="form-check-input" value="2" {{ old('unittype') == '2' ? 'checked' : '' }} style="cursor: pointer;" onchange="toggleDetailInput()">
                            <label class="form-check-label" for="unitType2" style="cursor: pointer;">Kích cỡ, màu, số lượng</label>
                        </div>
                    </div>

                    <!-- Phần nhập chỉ có số lượng -->
                    <div class="form-group" id="quantityInputAdd" style="display: none;">
                        <label for="quantity">Số lượng</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" min="1" placeholder="Nhập số lượng" value="{{ old('quantity') }}">
                    </div>

                    <!-- Phần nhập chi tiết màu sắc -->
                    <div class="form-group" id="colorSizeInput" style="display: none;">
                        <label>Chi tiết màu sắc</label>
                        <div id="color_boxes"></div>
                        <button type="button" class="btn btn-secondary mt-2" onclick="addColorBox()">+ Thêm chi tiết</button>
                    </div>

                    <div class="form-group">
                        <label>Tình trạng sản phẩm </label>
                        <div>
                            <div class="range">
                                <input type="range" min="0" step="1" max="100" value="{{old('quality') ? old('quality') : 100}}" name="quality" id="qualityRange">
                            </div>

                            <ul class="range-labels">
                                <li id="qualityLabel">Chất lượng sản phẩm: {{old('quality') ? old('quality') : 100}}%</li>
                            </ul>
                        </div>
                    </div>

                    <div class="form-group mt-5">
                        <label>Ảnh chính *</label>
                        <div id="photoImageContainer">
                            <img id="photoImagePreview" src="{{ asset('/img/image/upload.png') }}" alt="Ảnh sản phẩm" class="upload-img" style="cursor: pointer; object-fit:cover; margin: 0;">
                            <input type="file" id="photoImageInput" name="photo" style="display: none;" accept="image/*" onchange="previewPhotoImage(event)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Ảnh khác</label>
                        <img src="{{ asset('/img/image/upload.png') }}"
                            alt="Ảnh sản phẩm"
                            class="upload-img"
                            style="cursor: pointer; object-fit:cover; margin: 0; width: 100px; height: 100px;"
                            onclick="document.getElementById('list_photo_input').click();">

                        <input type="file"
                            id="list_photo_input"
                            class="form-control d-none @error('list_photo') is-invalid @enderror"
                            name="list_photo[]"
                            multiple
                            onchange="previewImages(event, 'list_photo_preview')">

                        <div id="list_photo_preview" class="d-flex flex-wrap"></div>
                    </div>
                </div>
                <div class="modal-footer form-btn" style="border: none;">
                    <div class="px-3 float-right">
                        <button type="button" class="apply back" href="" data-dismiss="modal" aria-label="Close">Huỷ</button>
                        <button type="submit" class="form-btn-save apply">Lưu</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#formExchangeProduct').submit(function(event) {
            event.preventDefault();

            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();

            var formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        $('#addProductModal').modal('hide');
                        $('#exchangeModal').modal('show');
                        toastr.success(response.message, null, {
                            positionClass: 'toast-bottom-left'
                        });
                        $('#formExchangeProduct').trigger("reset");
                        $('.invalid-feedback').empty();
                    } else {
                        toastr.error('Đã có lỗi xảy ra. Vui lòng thử lại!', null, {
                            positionClass: 'toast-bottom-left'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    var errors = xhr.responseJSON.errors;

                    if (errors) {
                        $('#addProductModal').modal('show');
                        $.each(errors, function(field, messages) {
                            var fieldElement = $('[name="' + field + '"]');
                            fieldElement.addClass('is-invalid');
                            $.each(messages, function(index, message) {
                                fieldElement.after('<div class="invalid-feedback">' + message + '</div>');
                            });
                        });
                        toastr.error('Đã có lỗi xảy ra. Vui lòng thử lại!', null, {
                            positionClass: 'toast-bottom-left'
                        });
                    } else {
                        toastr.error('Đã có lỗi xảy ra. Vui lòng thử lại!', null, {
                            positionClass: 'toast-bottom-left'
                        });
                    }
                }
            });
        });
    });
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
    function toggleDetailInput() {
        const unitType1 = document.getElementById('unitType1').checked;
        const unitType2 = document.getElementById('unitType2').checked;
        const quantityInput = document.getElementById('quantityInputAdd');
        const colorSizeInput = document.getElementById('colorSizeInput');
        const colorBoxContainer = document.getElementById('color_boxes');

        colorSizeInput.style.display = 'none';
        quantityInput.style.display = 'none';
        colorBoxContainer.innerHTML = '';

        if (unitType1) {
            quantityInput.style.display = 'block';
            colorSizeInput.style.display = 'none';
        } else if (unitType2) {
            quantityInput.style.display = 'none';
            colorSizeInput.style.display = 'block';
            addColorBox();
        }
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
        colorInput.required = true;

        const sizeInput = document.createElement('input');
        sizeInput.type = 'text';
        sizeInput.name = 'sizes[]';
        sizeInput.className = 'form-control ml-2';
        sizeInput.placeholder = 'Nhập kích cỡ';
        sizeInput.required = true;

        const quantityInput = document.createElement('input');
        quantityInput.type = 'number';
        quantityInput.name = 'quantities[]';
        quantityInput.className = 'form-control ml-2';
        quantityInput.placeholder = 'Nhập số lượng';
        quantityInput.required = true;

        const removeButton = createRemoveButton(colorBox);

        colorBox.appendChild(colorInput);
        colorBox.appendChild(sizeInput);
        colorBox.appendChild(quantityInput);
        colorBox.appendChild(removeButton);

        return colorBox;
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

    document.addEventListener('DOMContentLoaded', toggleDetailInput);
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
    function updateFileList(inputElement, updatedFiles) {
        const dataTransfer = new DataTransfer();
        updatedFiles.forEach(file => dataTransfer.items.add(file));
        inputElement.files = dataTransfer.files;
    }

    function previewImages(event, previewContainerId) {
        const files = Array.from(event.target.files);
        const inputElement = event.target;
        const previewContainer = document.getElementById(previewContainerId);

        previewContainer.innerHTML = '';

        files.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const wrapper = document.createElement('div');
                wrapper.classList.add('position-relative', 'm-2');
                wrapper.style.width = '150px';
                wrapper.style.height = '150px';

                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = '100%';
                img.style.height = '100%';
                img.style.objectFit = 'cover';
                img.style.borderRadius = '5px';

                const deleteBtn = document.createElement('button');
                deleteBtn.innerText = 'X';
                deleteBtn.classList.add('btn', 'btn-danger', 'btn-sm', 'position-absolute');
                deleteBtn.style.top = '0';
                deleteBtn.style.right = '0';

                deleteBtn.onclick = () => {
                    files.splice(index, 1);
                    updateFileList(inputElement, files);
                    wrapper.remove();
                };

                wrapper.appendChild(img);
                wrapper.appendChild(deleteBtn);
                previewContainer.appendChild(wrapper);
            };
            reader.readAsDataURL(file);
        });
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
<script>
    const qualityRange = document.getElementById('qualityRange');
    const qualityLabel = document.getElementById('qualityLabel');
    qualityRange.addEventListener('input', function() {
        qualityLabel.textContent = `Chất lượng sản phẩm: ${this.value}%`;
    });
</script>