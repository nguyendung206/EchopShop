@extends('admin.layout.app')
@section('title')
@lang('Thêm Chính sách')
@endsection
@section('content')
<div class="backnow">
    <div class="backpage">
        <a href="{{route('admin.policy.index')}}" class="back btn"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg></a>
    </div>
</div>
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">Thêm mới Chính sách</h5>
            </div>
            <div class="card-body">
                <form action="{{route('admin.policy.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Mô tả</label>
                        <div class="col-sm-9">
                        <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}
                        </textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">Trạng thái</label>
                        <div class="col-sm-9">
                            <select class="text-center font-weight-500 form-control @error('status') is-invalid  @enderror" name="status" >
                                <option class=" " value="{{StatusEnums::ACTIVE}}" {!! old('status') != null && old('status') == 0 ? ' selected' : null !!}>Đang hoạt động</option>
                                <option class=" " value="{{StatusEnums::INACTIVE}}" {!! old('status') != null && old('status') == 1 ? ' selected' : null !!}>Đã bị khoá</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label style="font-size: 1rem;" class="col-sm-3 col-form-label font-weight-500">@lang('Kiểu chính sách')</label>
                        <div class="col-sm-9 mt-2">
                            @foreach(\App\Enums\TypePolicy::cases() as $type)
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
                    <div class="form-group mb-0 text-right">
                        <a href="{{ route('admin.policy.index') }}" type="button" class="btn btn-light mr-2">Hủy</a>
                        <button type="submit" class="btn btn-primary">@lang('Lưu')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection