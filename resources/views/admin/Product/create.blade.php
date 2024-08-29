@extends('admin.layout.app')
@section('title')
@lang('Tạo loại hàng')
@endsection
@section('content')
<div class="backnow">
    <div class="backpage">
        <a href="{{route('product.index')}}" class="back btn"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                <form action="{{route('product.add.save')}}" method="post" enctype="multipart/form-data">
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
                        <label class="col-sm-3 col-from-label font-weight-500">@lang('Giá')<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="number" placeholder="@lang('Giá bán')" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}">
                            @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">@lang('Mô tả')<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">@lang('Loại hàng')</label>
                        <div class="col-sm-9">
                            <select class="text-center form-control font-weight-500" name="category_id">
                                <option value="" {{ old('category_id', $brand->category_id ?? null) === null ? 'selected' : '' }}>
                                    Chọn loại hàng
                                </option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $brand->category_id ?? null) == $category->id ? 'selected' : '' }}>
                                    @lang($category->name)
                                </option>
                                @endforeach
                            </select>
                            @error('product_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">@lang('Hãng hàng')</label>
                        <div class="col-sm-9">
                            <select class="text-center form-control font-weight-500" name="brand_id">
                                <option value="" {{ old('brand_id', $brand->brand_id ?? null) === null ? 'selected' : '' }}>
                                    Chọn hãng hàng
                                </option>
                                @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id', $brand->brand_id ?? null) == $brand->id ? 'selected' : '' }}>
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
                        <label class="col-sm-3 col-from-label font-weight-500">@lang('Trạng thái')</label>
                        <div class="col-sm-9">
                            <select class="text-center form-control font-weight-500" name="status">
                                @foreach(\App\Enums\Status::cases() as $status)
                                <option value="{{ $status->value }}" {{ old('status', $product->status->value ?? null) == $status->value ? 'selected' : '' }}>
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
                        <img id="photo_preview" src="{{ old('old_photo') ? asset('upload/product/' . old('old_photo')) : '' }}" class="img img-bordered" style="width:200px" />
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">@lang('Ảnh khác')</label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control @error('list_photo') is-invalid @enderror" name="list_photo[]" multiple onchange="previewListPhotos(this)" />
                        </div>
                        @error('list_photo')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div id="list_photo_preview" class="d-flex flex-wrap">
                            <!-- Preview will be inserted here -->
                        </div>
                    </div>

                    <div class="form-group mb-0 text-right">
                        <a href="{{ route('product.index') }}" type="button" class="btn btn-light mr-2">@lang('Hủy')</a>
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
            Array.from(input.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'img img-bordered m-2';
                    img.style.width = '100px';
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        }
    }
</script>
@endsection