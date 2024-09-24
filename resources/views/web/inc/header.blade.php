<div id="overlay">
    <div class="l-navbar" id="navbar">
        <div class="nav">
            <div>
                <div class="row">
                    <div class="close-sidebar" id="close-sidebar">
                        <i class="fa-solid fa-xmark"></i>
                    </div>
                    <a href="{{ route('home') }}" class="nav-logo">
                        <img src="{{ asset('/img/image/logo.png') }}" alt="" class="nav-logo-img">
                    </a>
                </div>
                <ul class="nav-list" id="menu-toggle">
                    <li>
                        <a href="{{ route('home') }}" class="nav-link active">
                            <i class="fa-solid fa-table-list nav-icon"></i>
                            <span class="nav-text">Danh mục sản phẩm</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('exchangeProduct') }}" class="nav-link">
                            <i class="fa-solid fa-arrow-right-arrow-left nav-icon"></i>
                            <span class="nav-text">Trao đổi hàng hóa</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('secondhandProduct') }}" class="nav-link">
                            <i class="fa-solid fa-cart-shopping nav-icon"></i>
                            <span class="nav-text">Mua bán đồ secondhand</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('giveawayProduct') }}" class="nav-link">
                            <i class="fa-solid fa-gifts nav-icon"></i>
                            <span class="nav-text">Hàng cũ đem tặng</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<header>
    <div class="header">
        <div class="topheader px-4">
            <div class="container-fluid py-2 mw-1200">
                <div class="row justify-content-between align-items-center ">
                    <div class="hotline ">
                        <a href="" class="text-white">
                            <i class="fa-regular fa-circle-question"></i>
                            <strong>Trợ giúp</strong>
                        </a>
                    </div>
                    <div class="about">
                        <div class="language px-2">
                            <a class="text-white" href="#">
                                <i class="fa-solid fa-gear"></i>
                                <span class="mx-2">Cài đặt</span>
                            </a>
                        </div>
                        <div class="about-me px-2">
                            <a class="text-white" href="#">Tải ứng dụng</a>
                        </div>
                        <div class="contact px-2">
                            <a class="text-white" href="#">Hướng dẫn sử dụng ứng dụng</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mainheader px-4">
            <div class="container-fluid mw-1200">
                <div class="row justify-content-between align-items-center">
                    <div class="row justify-content-between align-items-center col-lg-2 col-md-2 col-2 col-sm-2 ml-1">
                        <a href="{{ route('home') }}" style="width: 75%;">
                            <img class="logo w-100" src="{{ asset('/img/image/logo.png') }}" alt="">
                        </a>
                        <a href="" class="d-n">
                            <i class="fa-regular fa-heart"></i>
                        </a>
                    </div>
                    <div class="col-6 menu">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-magnifying-glass"></i></span>
                            </div>
                            <input type="text" class="form-control border-l-r-none forcus-none" placeholder="Nhập từ khoá tìm kiếm như váy, mỹ phẩm, áo, điện thoại,..." aria-label="Username" aria-describedby="basic-addon1">

                            <div class="input-group-append">
                                <div style="position: relative;">
                                    <div style="border-left: 2px solid #000; height: 50%; position: absolute; left: 1px; top: 25%;"></div>

                                    <select class="form-control w-120px forcus-none">
                                        <option value="" disabled selected>Địa điểm</option>
                                        <option value="hanoi">Hà Nội</option>
                                        <option value="hcm">TP. Hồ Chí Minh</option>
                                        <option value="danang">Đà Nẵng</option>
                                    </select>
                                </div>
                            </div>
                            <div class="input-group-append">
                                <button class="btn btn-search" type="button">
                                    Tìm kiếm
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-4 col-sm-4">
                        <div class="row justify-content-around align-items-center">
                            <div class="header-icon">
                                <div class="search d-n">
                                    <a href="#"><i class="fa-regular fa-bell"></i></i></a>
                                </div>
                                <div class="search">
                                    <a href="#">
                                        <i class="fa-solid fa-cart-shopping"></i>
                                    </a>
                                </div>
                                <div class="search d-n">
                                    <a href="#">
                                        <i class="fa-regular fa-comment-dots"></i>
                                    </a>
                                </div>
                            </div>
                            @guest
                            <div class="btn-post px-2">
                                <a href="{{ route('web.login') }}">
                                    <i class="fa-solid fa-right-to-bracket mr-2"></i>
                                    <span>Đăng nhập</span>
                                </a>
                            </div>
                            @else
                            @if(isset(optional(Auth::user()->shop)->status->value) && optional(Auth::user()->shop)->status->value === 1)
                            <div class="btn-post px-2">
                                <a href="{{ route('post.create') }}">
                                    <i class="fa-regular fa-file-lines mr-2"></i>
                                    <span>Đăng bài</span>
                                </a>
                            </div>
                            @endif
                            <div class="dropdown ml-3">
                                <a href="#" class="row align-items-center" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img class="avt" src="{{ getImage(Auth::user()->avatar) }}" alt="">
                                    <span class="d-n ml-2 color-232323 header-name">{{ Auth::user()->name }} </span>
                                    <i class="d-n fa-solid fa-sort-down ml-2 mb-2 color-232323 header-name"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                    <a class="drop-user-item profile-tab" href="{{route('profile.index', Session::get('user')->id)}}" data-tab="profile">
                                        <i class="fa-solid fa-user mr-2"></i> Hồ sơ cá nhân
                                    </a>
                                    <a class="drop-user-item" href="{{ route('web.logout') }}">
                                        <i class="fa-solid fa-right-from-bracket mr-2"></i> Đăng xuất
                                    </a>
                                </div>
                            </div>
                            @endguest
                            <div id="nav-toggle" class="d-block d-md-none">
                                <i class="fa-solid fa-bars p-3 menu-bars"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid d-n" style="box-shadow: 0px 1px 10px 0px rgba(0, 0, 0, 0.15);">
            <div class="category">
                <ul class="row align-items-center">
                    <li class="mx-4">
                        <div class="dropdown">
                            <a href="#" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa-solid fa-bars mr-2"></i> Danh mục sản phẩm <i class="fa-solid fa-caret-down pl-2"></i>
                            </a>
                            @if(isset($categories) && $categories->count())
                            <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu" style="width: 250px;">
                                @foreach($categories as $category)
                                <li class="dropdown-submenu" style="position: relative;">
                                    <a class="dropdown-item dropdown-item-custom" href="{{ route('filter.category', ['slug' => $category->slug]) }}">
                                        <img src="{{ getImage($category->photo) }}" alt="" class="dropdown-img">
                                        <p class="dropdown-title">{{ $category->name }}</p>
                                        <i class="fa-solid fa-caret-right"></i>
                                    </a>
                                    @if($category->activeBrands->count())
                                    <ul class="dropdown-menu" style="width: 250px;">
                                        @foreach($category->activeBrands as $brand)
                                        <li>
                                            <a class="dropdown-item dropdown-item-custom" href="{{ route('filter.category.brand', ['categorySlug' => $category->slug, 'brandSlug' => $brand->slug]) }}">
                                                <p class="dropdown-title">{{ $brand->name }}</p>
                                                <i class="fa-solid fa-caret-right"></i>
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </li>
                                @endforeach
                                <li>
                                    <a class="dropdown-item dropdown-item-custom" href="#">
                                        <img src="{{ asset('/img/icon/khac.png') }}" alt="" class="dropdown-img">
                                        <p class="dropdown-title">Khác</p>
                                        <i class="fa-solid fa-caret-right"></i>
                                    </a>
                                </li>
                            </ul>
                            @endif
                        </div>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="{{ route('exchangeProduct') }}" class="row align-items-center mx-4">
                            <img src="{{asset('img/icon/exchange.png')}}" alt="" class="mr-2">
                            <span>Trao đổi hàng hóa</span>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="{{ route('secondhandProduct') }}" class="row align-items-center mx-4">
                            <img src="{{asset('img/icon/secondhand.png')}}" alt="" class="mr-2">
                            <span>Mua bán đồ secondhand</span>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="{{ route('giveawayProduct') }}" class="row align-items-center mx-4">
                            <img src="{{asset('img/icon/giveaway.png')}}" alt="" class="mr-2">
                            <span>Hàng cũ đem tặng</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>