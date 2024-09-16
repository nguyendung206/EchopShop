@extends('admin.layout.app')
@section('title')
@lang('Sửa đối tác')
@endsection
@section('content')
<div class="backnow">
    <div class="backpage">
        <a href="{{route('admin.partner.index')}}" class="back btn"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg></a>
    </div>
</div>
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">Sửa đối tác</h5>
            </div>
            <div class="card-body">
                <form action="{{route('admin.partner.update', $partner->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Tên công ty</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="Tên công ty" name="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{ old('company_name') ? old('company_name') : $partner->company_name }}">
                            @error('company_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Email</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="Eamil" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') ? old('email') : $partner->email }}">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Số điện thoại</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="Số điện thoại" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" value="{{ old('phone_number') ? old('phone_number') : $partner->phone_number }}">
                            @error('phone_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Trạng thái</label>
                        <div class="col-sm-9">
                            <select class="font-weight-500 form-control" name="status" >
                                <option value="{{ StatusEnums::ACTIVE->value }}" {{ $partner->status->value == StatusEnums::ACTIVE->value ? 'selected' : '' }} {{old('status') ? old('status') == StatusEnums::ACTIVE->value ? 'selected' : '' : ''}}>
                                    @lang(StatusEnums::ACTIVE->label())
                                </option>
                                <option value="{{ StatusEnums::INACTIVE->value }}" {{ $partner->status->value == StatusEnums::INACTIVE->value ? 'selected' : '' }} {{old('status') ? old('status') == StatusEnums::INACTIVE->value ? 'selected' : '' : ''}}>
                                    @lang(StatusEnums::INACTIVE->label())
                                </option>

                            </select>
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Ảnh<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="hidden" name="old_photo" value="{{ old('old_photo') }}" />
                            <input type="file" class="form-control @error('photo') is-invalid @enderror" name="photo" onchange="previewPhoto(this)" />
                            <img id="photo_preview" src="{{ old('old_photo') ? getImage(old('old_photo')) : getImage($partner->photo) }}" class="img img-bordered mt-4" style="width:200px" />
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <a href="{{ route('admin.partner.index') }}" type="button" class="btn btn-light mr-2">Hủy</a>
                        <button type="submit" class="btn btn-primary">Sửa</button>
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
@endsection