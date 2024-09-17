<div class="aiz-sidebar-wrap">
    <div class="aiz-sidebar left c-scrollbar">
        <div class="aiz-side-nav-logo-wrap">
            <a href="#" class="d-block text-left">
                <img class="mw-100" src="{{asset('/img/image/logo.png')}}" class="brand-icon" alt=""> 
            </a>
        </div>
        <div class="aiz-side-nav-wrap">

            <ul class="aiz-side-nav-list" id="search-menu">
            </ul>
            <ul class="aiz-side-nav-list" id="main-menu" data-toggle="aiz-side-menu">
                <li class="aiz-side-nav-item">
                    <a href="{{ route('admin.index') }}" class="aiz-side-nav-link">
                        <i class="las la-home aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Trang chủ') }}</span>
                    </a>
                </li>

                <!-- quản lý sản phẩm -->
                <li class="aiz-side-nav-item">
                    <a href="#" class="aiz-side-nav-link ">
                        <i class="las la-newspaper aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">Quản lý sản phẩm</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('admin.category.index') }}"
                                class="aiz-side-nav-link {{ areActiveRoutes(['admin.category.index', 'admin.category.create', 'admin.category.edit']) }}">
                                <span class="aiz-side-nav-text">Danh mục</span>
                            </a>
                        </li>
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('admin.brand.index') }}"
                                class="aiz-side-nav-link {{ areActiveRoutes(['admin.brand.index', 'admin.brand.create', 'admin.brand.edit']) }}">
                                <span class="aiz-side-nav-text">Thương hiệu</span>
                            </a>
                        </li>
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('admin.product.index') }}"
                                class="aiz-side-nav-link {{ areActiveRoutes(['admin.product.index', 'admin.product.create', 'admin.product.edit']) }}">
                                <span class="aiz-side-nav-text">Sản phẩm</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- quản lý người dùng -->
                <li class="aiz-side-nav-item">
                    <a href="#" class="aiz-side-nav-link">
                        <i class="las la-newspaper aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">người dùng</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('admin.customer.index') }}"
                                class="aiz-side-nav-link {{ areActiveRoutes(['admin.customer.index', 'admin.customer.create', 'admin.customer.edit']) }}">
                                <i class="las la-home aiz-side-nav-icon"></i>

                                <span class="aiz-side-nav-text">Khách hàng</span>
                            </a>
                        </li>

                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link ">
                                <i class="las la-home aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">Quản trị viên</span>
                            </a>
                        </li>
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('admin.shop.index') }}" class="aiz-side-nav-link ">
                                <i class="las la-home aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">Shop</span>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Quản lý banner --}}
                <li class="aiz-side-nav-item">
                    <a href="{{ route('admin.banner.index') }}"
                        class="aiz-side-nav-link {{ areActiveRoutes(['admin.banner.index']) }}">
                        <i class="las la-home aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">Banner</span>
                    </a>
                </li>
                <li class="aiz-side-nav-item">
                    <a href="{{ route('admin.partner.index') }}"
                        class="aiz-side-nav-link {{ areActiveRoutes(['admin.partner.index']) }}">
                        <i class="las la-tools aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">Đối tác</span>
                    </a>
                </li>
                <li class="aiz-side-nav-item">
                    <a href="{{ route('admin.term.index') }}"
                        class="aiz-side-nav-link {{ areActiveRoutes(['admin.term.index']) }}">
                        <i class="las la-home aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">Điều khoản</span>
                    </a>
                </li>
        
                
            </ul><!-- .aiz-side-nav -->
        </div><!-- .aiz-side-nav-wrap -->
    </div><!-- .aiz-sidebar -->
    <div class="aiz-sidebar-overlay"></div>
</div><!-- .aiz-sidebar -->
