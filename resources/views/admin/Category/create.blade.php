@extends('admin.layout.app')
@section('title')
@lang('create_customers')
@endsection
@section('content')
<div class="backnow">
    <div class="backpage">
        <a href="{{route('category.index')}}" class="back btn"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg></a>
    </div>
</div>
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">@lang('create_user')</h5>
            </div>
            <div class="card-body">
                <form action="{{route('category.save')}}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">@lang('name')<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{__('name')}}" name="name" class="form-control @error('name') is-invalid  @enderror" value="{{ old('name') }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">@lang('email')<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="email" placeholder="{{__('email')}}" name="email" class="form-control @error('email') is-invalid  @enderror" value="{{ old('email') }}">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">@lang('pw')<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="password" id="password" placeholder="{{__('placeholder_pw')}}" name="password" class="form-control @error('password') is-invalid  @enderror" value="{{ old('password') }}">
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">@lang('cf_pw')<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="password" id="password_confirmation" placeholder="{{__('cf_pw')}}" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid  @enderror" value="{{ old('password_confirmation') }}">
                            <span class="mt-1" id='message'></span>
                            @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">@lang('phone')<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="number" placeholder="{{__('phone')}}" name="phone" class="form-control @error('phone') is-invalid  @enderror" value="{{ old('phone') }}">
                            @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">@lang('point')<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="number" placeholder="{{__('point')}}" name="point" class="form-control @error('point') is-invalid  @enderror" value="{{ old('point') }}">
                            @error('point')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">@lang('level')<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="number" placeholder="{{__('level')}}" name="level" class="form-control @error('level') is-invalid  @enderror" value="{{ old('level') }}">
                            @error('level')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">@lang('status')</label>
                        <div class="col-sm-9">
                            <select class="text-center form-control font-weight-500" name="status">
                                <option class=" text-center" value="1" {!! old('status') !=null && old('status')==1 ? ' selected' : null !!}>@lang('active')</option>
                                <option class=" text-center" value="0" {!! old('status') !=null && old('status')==0 ? ' selected' : null !!}>@lang('unverify')</option>
                                <option class=" text-center" value="2" {!! old('status') !=null && old('status')==2 ? ' selected' : null !!}>@lang('deactivate')</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">@lang('ảnh')<span class="text-vali">&#9913;</span></label>
                        <div class="col-sm-9">
                            <input type="hidden" name="old_photo" value="" />
                            <input type="file" class="form-control @error('photo') is-invalid @enderror" name="photo" onchange="previewPhoto(this)" />
                            @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <img id="photo_preview" src="" class="img img-bordered" style="width:200px" />
                    </div>
            </div>
            <div class="form-group mb-0 text-right">
                <a href="" type="button" class="btn btn-light mr-2">@lang('cancel')</a>
                <button type="submit" class="btn btn-primary">@lang('save')</button>
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
@section('script')
<script type="text/javascript">
    $('#password, #password_confirmation').on('keyup', function() {
        if ($('#password').val() == $('#password_confirmation').val()) {
            $('#message').html('Matching').css('color', 'green');
        } else
            $('#message').html('Not Matching').css('color', 'red');
    });
</script>
@endsection