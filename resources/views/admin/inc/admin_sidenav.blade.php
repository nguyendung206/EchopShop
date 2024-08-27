<div class="aiz-sidebar-wrap">
    <div class="aiz-sidebar left c-scrollbar">
        <div class="aiz-side-nav-logo-wrap">
            <a href="#" class="d-block text-left">
                <img class="mw-100" src="" class="brand-icon" alt="">
            </a>
        </div>
        <div class="aiz-side-nav-wrap">

            <ul class="aiz-side-nav-list" id="search-menu">
            </ul>
            <ul class="aiz-side-nav-list" id="main-menu" data-toggle="aiz-side-menu">
                <li class="aiz-side-nav-item">
                    <a href="" class="aiz-side-nav-link">
                        <i class="las la-home aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{translate('Dashboard')}}</span>
                    </a>
                </li>

               
                <!-- Settings -->
                <li class="aiz-side-nav-item">
                    <a href="#" class="aiz-side-nav-link">
                        <i class="las la-tools aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">@lang('settings.setting')</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">
                            <a href="" class="aiz-side-nav-link">
                                <span class="aiz-side-nav-text">@lang('base.roles')</span>
                            </a>
                        </li>
                        <li class="aiz-side-nav-item">
                            <a href="" class="aiz-side-nav-link ">
                                <span class="aiz-side-nav-text">thông tin công ty</span>
                            </a>
                        </li>
                        <li class="aiz-side-nav-item">
                            <a href="{{route("manager-user.index")}}" class="aiz-side-nav-link ">
                                <span class="aiz-side-nav-text">Quản lý người dùng</span>
                            </a>
                        </li>
                    </ul>
                </li>

                

              
            </ul><!-- .aiz-side-nav -->
        </div><!-- .aiz-side-nav-wrap -->
    </div><!-- .aiz-sidebar -->
    <div class="aiz-sidebar-overlay"></div>
</div><!-- .aiz-sidebar -->
