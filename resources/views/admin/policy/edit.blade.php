@extends('admin.layout.app')
@section('title')
@lang('Sửa chính sách')
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
                <h5 class="mb-0 h6">Sửa chính sách</h5>
            </div>
            <div class="card-body">
                <form action="{{route('admin.policy.update', $policy->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
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
                            <select class="font-weight-500 form-control" name="status" >
                                <option value="{{ StatusEnums::ACTIVE->value }}" {{ $policy->status->value == StatusEnums::ACTIVE->value ? 'selected' : '' }} {{old('status') ? old('status') == StatusEnums::ACTIVE->value ? 'selected' : '' : ''}}>
                                    @lang(StatusEnums::ACTIVE->label())
                                </option>
                                <option value="{{ StatusEnums::INACTIVE->value }}" {{ $policy->status->value == StatusEnums::INACTIVE->value ? 'selected' : '' }} {{old('status') ? old('status') == StatusEnums::INACTIVE->value ? 'selected' : '' : ''}}>
                                    @lang(StatusEnums::INACTIVE->label())
                                </option>

                            </select>
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <a href="{{ route('admin.policy.index') }}" type="button" class="btn btn-light mr-2">Hủy</a>
                        <button type="submit" class="btn btn-primary">Sửa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection