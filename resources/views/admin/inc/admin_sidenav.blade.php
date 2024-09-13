<div class="aiz-sidebar-wrap">
    <div class="aiz-sidebar left c-scrollbar">
        <div class="aiz-side-nav-logo-wrap">
            <a href="#" class="d-block text-left">
                <!-- <img class="mw-100" src="" class="brand-icon" alt=""> -->
            </a>
        </div>
        <div class="aiz-side-nav-wrap">

            <ul class="aiz-side-nav-list" id="search-menu">
            </ul>
            <ul class="aiz-side-nav-list" id="main-menu" data-toggle="aiz-side-menu">
                <li class="aiz-side-nav-item">
                    <a href="{{ route('admin.index') }}" class="aiz-side-nav-link">
                        <i class="las la-home aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{translate('Trang chủ')}}</span>
                    </a>
                </li>

                <!-- Quản lý -->
                <li class="aiz-side-nav-item">
                    <a href="#" class="aiz-side-nav-link">
                        <i class="las la-tools aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">@lang('Quản lý')</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">
                            <a href="{{route('category.index')}}" class="aiz-side-nav-link">
                                <span class="aiz-side-nav-text">@lang('Danh mục')</span>
                            </a>
                        </li>
                        <li class="aiz-side-nav-item">
                            <a href="{{route('brand.index')}}" class="aiz-side-nav-link ">
                                <span class="aiz-side-nav-text">Hãng hàng</span>
                            </a>
                        </li>
                        <li class="aiz-side-nav-item">
                            <a href="{{route("manager-user.index")}}" class="aiz-side-nav-link ">
                                <span class="aiz-side-nav-text">Người dùng</span>
                            </a>
                        </li>
                        <li class="aiz-side-nav-item">
                            <a href="{{route("shop.index")}}" class="aiz-side-nav-link ">
                                <span class="aiz-side-nav-text">Đăng ký bán hàng</span>
                            </a>
                        </li>
                        <li class="aiz-side-nav-item">
                            <a href="{{route('product.index')}}" class="aiz-side-nav-link ">
                                <span class="aiz-side-nav-text">Sản phẩm</span>
                            </a>
                        </li>
                        <li class="aiz-side-nav-item">
                            <a href="{{route('banner.index')}}" class="aiz-side-nav-link ">
                                <span class="aiz-side-nav-text">Banner</span>
                            </a>
                        </li>
                        <li class="aiz-side-nav-item">
                            <a href="{{route('partner.index')}}" class="aiz-side-nav-link ">
                                <span class="aiz-side-nav-text">Đối tác</span>
                            </a>
                        </li>
                    </ul>
                </li>


                <!-- Settings -->
                <li class="aiz-side-nav-item">
                    <a href="#" class="aiz-side-nav-link">
                        <i class="las la-tools aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">@lang('Cài đặt')</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">
                            <a href="" class="aiz-side-nav-link">
                                <span class="aiz-side-nav-text">@lang('Phân quyền')</span>
                            </a>
                        </li>
                        <li class="aiz-side-nav-item">
                            <a href="" class="aiz-side-nav-link ">
                                <span class="aiz-side-nav-text">thông tin công ty</span>
                            </a>
                        </li>
                    </ul>
                </li>




            </ul><!-- .aiz-side-nav -->
        </div><!-- .aiz-side-nav-wrap -->
    </div><!-- .aiz-sidebar -->
    <div class="aiz-sidebar-overlay"></div>
</div><!-- .aiz-sidebar -->