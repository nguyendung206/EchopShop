@extends('backend.layouts.app')
@section('title')
    @lang('user.edit_customers')
@endsection
@section('content')
<div class="backnow">
    <div class="backpage">
        <a href="{{route('admin.users.index', session('old_query'))}}" class="back btn"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg></a>
    </div>
</div>
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">@lang('user.update_user')</h5>
            </div>
            <div class="card-body">
                <form action="{{route('admin.updateUser', $customer->id) }}" method="POST">
                  	@csrf
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">@lang('user.name')</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{translate('Name')}}" name="name" class="form-control @error('name') is-invalid  @enderror" value="{{$customer->name}}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">@lang('user.email')</label>
                        <div class="col-sm-9">
                            <input type="email" placeholder="{{translate('Email')}}" name="email" class="form-control @error('email') is-invalid  @enderror" value="{{$customer->email}}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    {{-- <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">@lang('user.pw')</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{translate('New Password')}}" name="password" class="form-control @error('password') is-invalid  @enderror" value="">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div> --}}
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">@lang('user.phone')</label>
                        <div class="col-sm-9">
                            <input type="number" placeholder="{{translate('Phone')}}" name="phone" class="form-control @error('phone') is-invalid  @enderror" value="{{$customer->phone}}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500">@lang('user.point')</label>
                        <div class="col-sm-9">
                            <input type="number" placeholder="{{translate('Point')}}" name="point" class="form-control @error('point') is-invalid  @enderror" value="{{$customer->point}}">
                            @error('point')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label font-weight-500" >@lang('user.level')</label>
                        <div class="col-sm-9">
                            <input type="number" placeholder="{{translate('Level')}}" name="level" class="form-control @error('level') is-invalid  @enderror" value="{{$customer->level}}">
                            @error('level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        {{-- <a href="{{url()->previous()}}" type="button" class="btn btn-light mr-2">{{translate('Cancel')}}</a> --}}
                        <a href="{{route('admin.users.index', session('old_query'))}}" type="button" class="btn btn-light mr-2">@lang('user.cancel')</a>
                        <button type="submit" class="btn btn-primary">@lang('user.save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
