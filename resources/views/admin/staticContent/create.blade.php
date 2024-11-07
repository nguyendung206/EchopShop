@extends('admin.layout.app')
@section('title')
    Thêm nội dung mới
@endsection
@section('content')
<div class="backnow">
    <div class="backpage">
        <a href="{{route('admin.static-content.index')}}" class="back btn"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg></a>
    </div>
</div>
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">Thêm nội dung mới</h5>
            </div>
            <div class="card-body">
                <form action="{{route('admin.static-content.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                   
                    <div class="form-group row " id="title-group" style="display: none;">
                        <label class="col-sm-3 col-from-label font-weight-500">Tiêu đề</label>
                        <div class="col-sm-9">
                        <input name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}"/>
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

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
                        <div class="col-sm-12 mt-2 row">
                            @foreach ( TypeStaticContentEnums::cases() as $type )
                                @if ($type->value != 'blog' && $type->value != 'contact-us')
                                    <div class="col-sm-4">
                                        <input type="radio" name="type" class="type-radio" id="type-{{$type->value}}" value="{{$type->value}}">
                                        <label for="type-{{$type->value}}">{{$type->label()}}</label>
                                    </div>
                                @endif
                            @endforeach

                            @error('type')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <a href="{{ route('admin.static-content.index') }}" type="button" class="btn btn-light mr-2">Hủy</a>
                        <button type="submit" class="btn btn-primary">@lang('Lưu')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@section('script')
    <script>
        $(document).ready(function() {
            function toggleTitleGroup() {
                const selectedType = $('input[name="type"]:checked').val();
                if (selectedType === 'faq') {
                    
                    $('#title-group').slideDown();
                } else {
                    $('#title-group').slideUp(); 
                }
            }

            toggleTitleGroup();

            $('.type-radio').change(function() {
                toggleTitleGroup();
            });
        });
    </script>
@endsection
@endsection