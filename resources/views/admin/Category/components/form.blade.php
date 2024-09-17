<div class="form-group row">
    <label class="col-sm-3 col-from-label font-weight-500">@lang('Tên loại hàng')<span class="text-vali">&#9913;</span></label>
    <div class="col-sm-9">
        <input type="text" placeholder="@lang('Tên loại hàng')" name="name"
            class="form-control @error('name') is-invalid @enderror" value="{{ $name }}">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-from-label font-weight-500">@lang('Mô tả')<span
            class="text-vali">&#9913;</span></label>
    <div class="col-sm-9">
        <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror">{{ $description }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-from-label font-weight-500">@lang('Trạng thái')</label>
    <div class="col-sm-9">
        <select class="form-control font-weight-500" name="status">
            <option value="{{ StatusEnums::ACTIVE->value }}" @selected(StatusEnums::ACTIVE->value == $status)>
                Hoạt động
            </option>
            <option value="{{ StatusEnums::INACTIVE->value }}" @selected(StatusEnums::INACTIVE->value == $status)>
                Không hoạt động
            </option>
        </select>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-from-label font-weight-500">@lang('Ảnh')<span
            class="text-vali">&#9913;</span></label>
    <div class="col-sm-9">
        <input type="hidden" name="old_photo" value="{{ $old_photo }}" />
        <input type="file" class="form-control @error('photo') is-invalid @enderror" name="photo"
            onchange="previewPhoto(this)" />
        <img id="photo_preview"
            src="{{ $old_photo ? getImage($old_photo) : '' }}"class="img img-bordered mt-4"
            style="width:200px" />
        @error('photo')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="form-group mb-0 text-right">
    <a href="{{ route('admin.category.index') }}" type="button" class="btn btn-light mr-2">@lang('Hủy')</a>
    <button type="submit" class="btn btn-primary">@lang('Lưu')</button>
</div>
