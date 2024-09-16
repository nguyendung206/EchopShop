<div class="" id="overlay">
    <div class="l-navbar" id="navbar">
        <div class="nav">
            <div>
                <div class="row">
                    <div class="close-sidebar" id="close-sidebar">
                        <i class="fa-solid fa-xmark"></i>
                    </div>
                    <a href="#" class="nav-logo">
                        <img src="{{asset('/img/image/logo.png')}}" alt="" class="nav-logo-img">
                    </a>
                </div>
                <ul class="nav-list" id="menu-toggle">
                    <a href="" class="nav-link active">
                        <i class="fa-solid fa-table-list nav-icon"></i>
                        <span class="nav-text">Danh mục sản phẩm</span>
                    </a>
                    <a href="" class="nav-link active">
                        <i class="fa-solid fa-arrow-right-arrow-left nav-icon"></i>
                        <span class="nav-text">Trao đổi hàng hóa</span>
                    </a>
                    <a href="" class="nav-link active">
                        <i class="fa-solid fa-cart-shopping nav-icon"></i>
                        <span class="nav-text">Mua bán đồ secondhand</span>
                    </a>
                    <a href="" class="nav-link active">
                        <i class="fa-solid fa-gifts nav-icon"></i>
                        <span class="nav-text">Hàng cũ đem tặng</span>
                    </a>
                </ul>
            </div>
        </div>
    </div>
</div>
<header>
    <div class="header">
        <div class="container-fluid topheader">
            <div class="row justify-content-between align-items-center p-14px">
                <div class="hotline color-750000 col-md-6 col-6">
                    <i class="fa-regular fa-circle-question"></i>
                    Hotline: <strong>001 234-567-890</strong>
                </div>
                <div class="about col-md-6 col-6">
                    <div class="language color-750000 px-2">
                        <img class="logo-vietnam" src="{{asset('/img/image/vietnam.png')}}" alt="">
                        <span class="mr-2">Việt Nam</span>
                        <i class="fa-solid fa-caret-down"></i>
                    </div>
                    <div class="about-me">
                        <a class="color-750000 px-2" href="#">Về chúng tôi</a>
                    </div>
                    <div class="contact">
                        <a class="color-750000 px-2" href="#">Liên hệ</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="mainheader">
            <div class="container py-3">
                <div class="row justify-content-between align-items-center">
                    <div class="col-lg-2 col-md-6 col-2 col-sm-2">
                        <a href="{{route('home')}}">
                            <img class="logo" src="{{asset('/img/image/logo.png')}}" alt="">
                        </a>
                    </div>
                    <div class="col-lg-8 menu">
                        <ul class="row">
                            <li class="ml-3">
                                <div class="dropdown">
                                    <a href='#' class="" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Danh mục sản phẩm<i
                                            class="fa-solid fa-caret-down pl-2"></i></a>
                                    </a>
                                    @if(isset($categories))
                                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                        @foreach($categories as $category)
                                        <li class="dropdown-submenu">
                                            <a class="dropdown-item dropdown-item-custom" tabindex="-1" href="#">
                                                <img src="{{ getImage($category->photo) }}" alt="" class="dropdown-img">
                                                <p class="dropdown-title">{{$category->name}}</p>
                                            </a>
                                            @if($category->activeBrands->count())
                                            <ul class="dropdown-menu">
                                                @foreach($category->activeBrands as $brand)
                                                <li class="dropdown-item">
                                                    <a href="#">{{$brand->name}}</a>
                                                </li>
                                                @endforeach
                                            </ul>
                                            @endif
                                        </li>
                                        @endforeach
                                        <li class="dropdown-submenu" tabindex="-1" href="#">
                                            <a class="dropdown-item dropdown-item-custom" tabindex="-1" href="#">
                                                <img src="{{ asset('/img/icon/khac.png') }}" alt="" class="dropdown-img">
                                                <p class="dropdown-title">Khác</p>
                                            </a>
                                        </li>

                                    </ul>
                                    @endif
                                </div>
                            </li>


                            <li class="">
                                <a href="#">Trao đổi hàng hóa</a>
                            </li>
                            <li class="">
                                <a href="#">Mua bán đồ sencondhand</a>
                            </li>
                            <li class="">
                                <a href="#">Hàng cũ đem tặng</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-2 col-md-6 col-6 col-sm-6">
                        <div class="row justify-content-end align-items-center">
                            <div class="search mr-2">
                                <a href="#"><i class="color-750000 fa-solid fa-magnifying-glass"></i></a>
                            </div>

                            <!-- Nếu người dùng chưa đăng nhập -->
                            @guest
                            <div class="btn-post px-2">
                                <a href="{{ route('web.login') }}">
                                    <i class="fa-solid fa-right-to-bracket mr-2"></i>
                                    <span>Đăng nhập</span>
                                </a>
                            </div>
                            @else
                            <!-- Nếu người dùng đã đăng nhập -->
                            @if(optional(Auth::user()->shop)->status->value === 1)
                            <div class="btn-post px-2">
                                <a href="#">
                                    <i class="fa-regular fa-file-lines mr-2"></i>
                                    <span>Đăng bài</span>
                                </a>
                            </div>
                            @endif

                            <div class="dropdown">
                                <a href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img class="avt" src="{{ getImage(optional(Auth::user())->avatar) }}" alt="">
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                    <a class="drop-user-item profile-tab" href="{{route('web.profile.index', Session::get('user')->id)}}" data-tab="profile">
                                        <i class="fa-solid fa-user mr-2"></i> Hồ sơ cá nhân
                                    </a>
                                    <a class="drop-user-item" href="{{route('web.logout')}}">
                                        <i class="fa-solid fa-right-from-bracket mr-2"></i> Đăng xuất
                                    </a>
                                </div>
                            </div>
                            @endguest

                            <div id="nav-toggle">
                                <i class="fa-solid fa-bars p-3 menu-bars"></i>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


</header>