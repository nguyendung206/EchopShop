<div class="aiz-topbar px-15px px-lg-25px d-flex align-items-stretch justify-content-between">
    <div class="d-xl-none d-flex">
        <div class="aiz-topbar-nav-toggler d-flex align-items-center justify-content-start mr-2 mr-md-3" data-toggle="aiz-mobile-nav">
            <button class="aiz-mobile-toggler">
                <span></span>
            </button>
        </div>
        <div class="aiz-topbar-logo-wrap d-flex align-items-center justify-content-start">
            <a href="#" class="d-block">
                <img src="">
            </a>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-stretch flex-grow-xl-1">
        <div class="d-none d-md-flex justify-content-around align-items-center align-items-stretch">
            <div class="d-none d-md-flex justify-content-around align-items-center align-items-stretch">
                <div class="aiz-topbar-item">
                    <div class="d-flex align-items-center">
                        <a class="btn btn-icon btn-circle btn-light" href="" target="_blank" title="{{ translate('Browse Website') }}">
                            <i class="las la-globe"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-around align-items-center align-items-stretch">

            <div class="aiz-topbar-item ml-2">
                <div class="align-items-stretch d-flex dropdown">
                    <a class="dropdown-toggle no-arrow text-dark" data-toggle="dropdown" href="javascript:void(0);" role="button" aria-haspopup="false" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <span class="avatar avatar-sm mr-md-2">
                                <img
                                    src="{{asset('storage/upload/employee/' .optional(Auth::user())->avatar)}}">
                            </span>
                            <span class="d-none d-md-block">
                                <span class="d-block fw-500">{{optional(Auth::user())->name}}</span>
                            </span>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-menu-md">
                        <a href="{{route('admin.profile.index', Session::get('admin')->id)}}" class="dropdown-item">
                            <i class="las la-user-circle"></i>
                            <span>{{trans('Hồ sơ cá nhân')}}</span>
                        </a>

                        <a href="{{ route('admin.logout') }}" class="dropdown-item">
                            <i class="las la-sign-out-alt"></i>
                            <span>@lang('Đăng xuất')</span>
                            <!-- <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form> -->
                        </a>
                    </div>
                </div>
            </div><!-- .aiz-topbar-item -->
        </div>
    </div>
</div><!-- .aiz-topbar -->