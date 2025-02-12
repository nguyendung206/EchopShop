@php
$search = request()->get('search');
$provinceQuery = request()->get('province');

$url = Str::lower(request()->url());
$route = route('listProducts');

if (request()->has('type')) {
$route = route('listProducts', ['type' => request()->get('type')]);
}
@endphp
<div id="overlay">
    <div class="l-navbar" id="navbar">
        <div class="nav">
            <div>
                <div class="row" style="background-color: #FFDD15;">
                    <div class="close-sidebar" id="close-sidebar">
                        <i class="fa-solid fa-xmark"></i>
                    </div>
                    <a href="{{ route('home') }}" class="nav-logo">
                        <img src="{{ asset('/img/image/logo.png') }}" alt="" class="nav-logo-img">
                    </a>
                </div>
                <ul class="nav-list mt-3" id="menu-toggle">
                    @auth
                    @if(isset(optional(Auth::user()->shop)->status->value) && optional(Auth::user()->shop)->status->value === 1)
                    <li>
                        <a href="{{ route('post.create') }}" class="nav-link active">
                            <i class="fa-regular fa-file-lines mr-2"></i>
                            <span class="nav-text">Đăng bài</span>
                        </a>
                    </li>
                    @endif
                    @else
                    <li>
                        <a href="{{ route('web.login') }}" class="nav-link active">
                            <i class="fa-regular fa-file-lines mr-2"></i>
                            <span class="nav-text">Đăng bài</span>
                        </a>
                    </li>
                    @endauth
                    <li>
                        <a href="#" class="nav-link" id="toggle-categories">
                            <i class="fa-solid fa-bars mr-2"></i>
                            <span class="nav-text">Danh mục sản phẩm</span>
                            <i class="fa-solid fa-caret-down pl-2"></i>
                        </a>
                        <ul class="custom-dropdown-menu" id="categories-menu" style="display: none;">
                            @if(isset($categories) && $categories->count())
                            @foreach($categories as $category)
                            <li>
                                <a class="dropdown-item category-toggle" href="#" data-category="{{ $category->slug }}">
                                    <img src="{{ getImage($category->photo) }}" alt="" class="dropdown-img">
                                    <p class="dropdown-title">{{ $category->name }}</p>
                                    <i class="fa-solid fa-caret-right pl-2"></i>
                                </a>
                                @if($category->activeBrands->count())
                                <ul class="custom-dropdown-submenu" style="display: none;">
                                    @foreach($category->activeBrands as $brand)
                                    <li>
                                        <a class="dropdown-item" href="{{ route('listProducts', ['category-slug' => $category->slug, 'brandslug' => $brand->slug]) }}">
                                            <p class="dropdown-title">{{ $brand->name }}</p>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </li>
                            @endforeach
                            @endif
                        </ul>
                    </li>

                    <li>
                        <a href="{{ route('listProducts', ['type' => TypeProductEnums::EXCHANGE]) }}" class="nav-link">
                            <img src="{{asset('img/icon/exchange.png')}}" alt="" class="mr-2">
                            <span class="nav-text">Trao đổi hàng hóa</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('listProducts', ['type' => TypeProductEnums::SECONDHAND]) }}" class="nav-link">
                            <img src="{{asset('img/icon/secondhand.png')}}" alt="" class="mr-2">
                            <span class="nav-text">Mua bán đồ secondhand</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('listProducts', ['type' => TypeProductEnums::GIVEAWAY]) }}" class="nav-link">
                            <img src="{{asset('img/icon/giveaway.png')}}" alt="" class="mr-2">
                            <span class="nav-text">Hàng cũ đem tặng</span>
                        </a>
                    </li>

                    @auth
                    <li>
                        <a href="{{route('favoriteProduct')}}" class="nav-link active">
                            <i class="fa-regular fa-heart mr-2"></i>
                            <span class="nav-text">Bài viết yêu thích</span>
                        </a>
                    </li>
                    @else
                    <li>
                        <a href="{{route('web.login')}}" class="nav-link active">
                            <i class="fa-regular fa-heart mr-2"></i>
                            <span class="nav-text">Bài viết yêu thích</span>
                        </a>
                    </li>
                    @endauth
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
                    <div class="col-lg-2 col-md-2 col-sm-3 col-2 ml-1 row justify-content-between align-items-center">
                        <a href="{{ route('home') }}" style="width: 75%;">
                            <img class="logo w-100" src="{{ asset('/img/image/logo.png') }}" alt="">
                        </a>
                        <a href="{{route('favoriteProduct')}}" class="d-n display-none profile-tab" data-tab="favoriteProduct" style="position: relative; background-color: #FFDD15; border: none;">
                            <i class="fa-regular fa-heart"></i>
                            @if (Auth::check())
                            @if (Auth::user()->countFavorite() > 0)
                            <span id="favoriteCount" class="badge badge-danger"
                                style="position: absolute; bottom: 13px; left: 15px;">
                                {{ Auth::user()->countFavorite() }}
                            </span>
                            @endif
                            @endif
                        </a>

                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-3 col-1 menu">
                        <form action="{{$route}}" method="GET" class="display-none">
                            @csrf
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-magnifying-glass"></i></span>
                                </div>
                                <input type="text" id="search" name="search" value="{{$search ? $search : ''}}" 
                                class="form-control border-l-r-none forcus-none search-input" 
                                placeholder="Nhập từ khoá tìm kiếm như váy, mỹ phẩm, áo, điện thoại,..." aria-label="Username" aria-describedby="basic-addon1"
                                style="border-radius: 0 !important;">
                                <div class="input-group-append">
                                    <div style="position: relative;">
                                        <div style="border-left: 2px solid #000; height: 50%; position: absolute; left: 1px; top: 25%;"></div>
                                        @if (request()->has('type'))
                                        <input type="hidden" name="type" value="{{request()->get('type')}}">
                                        @endif
                                        <select class="form-control w-120px forcus-none province-select" name="province" style="border-radius: 0 !important;">
                                            <option value="0" disabled selected>Địa điểm</option>
                                            <option value="" {{request()->has('province') && empty($provinceQuery) ? 'selected' : ''}}>Tất cả</option>
                                            @foreach ($provinces as $province)
                                            <option value="{{$province->id}}" {{$provinceQuery && $provinceQuery == $province->id ? 'selected' : ''}}>{{$province->province_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="input-group-append">
                                    <button class="btn btn-search" type="submit">
                                        Tìm kiếm
                                    </button>
                                </div>

                                <div class="list-result" style="position: absolute; width: 100%; top: 38px; z-index: 100">

                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-9">
                        <div class="d-flex justify-content-around align-items-center">
                            <div class="header-icon">
                                <div class="search">
                                    <a href="{{ route('cart.index') }}" style="position: relative;">
                                        <i class="fa-solid fa-cart-shopping"></i>
                                        @if (Auth::check())
                                        @if (Auth::user()->countCart() > 0)
                                        <span id="cart-count" class="badge badge-danger"
                                            style="position: absolute; bottom: 13px; left: 15px;">
                                            {{ Auth::user()->countCart() }}
                                        </span>
                                        @endif
                                        @endif
                                    </a>
                                </div>
                                <div class="search d-n">
                                    <a href="#">
                                        <i class="fa-regular fa-comment-dots"></i>
                                    </a>
                                </div>
                                <div id="notification" class="search" style="position: relative;">
                                    <a href="#" id="notificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa-regular fa-bell"></i>
                                        @if (Auth::check())
                                        @if (Auth::user()->countNotification() > 0 && Auth::user()->countNotification() < 100)
                                            <span id="notificationCount" class="badge badge-danger"
                                            style="position: absolute; bottom: 12px; left: 10px;">
                                            {{ Auth::user()->countNotification() }}
                                            </span>
                                            @elseif(Auth::user()->countNotification() >= 100)
                                            <span id="notificationCount" class="badge badge-danger"
                                                style="position: absolute; bottom: 12px; left: 10px;">
                                                99+
                                            </span>
                                            @endif
                                            @endif
                                    </a>
                                    <div id="notificationList" class="dropdown-menu dropdown-menu-right px-2"
                                        aria-labelledby="notificationDropdown">
                                        <div class="notification-header mx-3 py-3 mb-2 row justify-content-between align-items-center">
                                            <strong style="font-size: 24px;">Thông báo</strong>
                                            <a href="#" id="markAllAsRead" data-href="{{ route('notification.readall') }}"
                                                style="font-size: 14px;">Đánh dấu đã đọc tất cả</a>
                                        </div>
                                        <div style="max-height: 450px; overflow-y: auto; width: 450px; white-space: nowrap; overflow-x: hidden;">
                                            @if(isset($notifications) && count($notifications) > 0)
                                            @foreach($notifications as $notification)
                                            <a href="{{ route('notification.isreaded', ['id' => $notification->id]) }}">
                                                <div style="border-radius: 10px;"
                                                    class="py-notification dropdown-item d-flex align-items-center notification {{ !$notification->is_read ? 'is_read' : '' }}">
                                                    <div class="mr-3">
                                                        <img style="height: 50px; width: 50px; border-radius: 50%; object-fit: cover;"
                                                            src="{{ $notification->product ? getImage($notification->product->photo) : asset('/img/image/change-status-order.png') }}">
                                                    </div>

                                                    <div class="d-flex align-items-center justify-content-between w-100">
                                                        <div style="max-width: 95%;">
                                                            <strong>{{ $notification->title }}</strong>
                                                            <div class="text-muted my-2 text-body">{{ $notification->body }}</div>
                                                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                                        </div>
                                                        <div id="dot" class="ml-auto {{ !$notification->is_read ? 'dot' : '' }}"></div>
                                                    </div>
                                                </div>
                                            </a>
                                            @endforeach
                                            @else
                                            <div class="dropdown-item text-center">@lang('Không có thông báo mới')</div>
                                            @endif
                                        </div>
                                        <a class="notification-all profile-tab mt-2" href="{{ route('notification.index') }}"
                                            data-tab="notifications">Xem tất cả</a>
                                    </div>
                                </div>
                            </div>
                            @guest
                            <div class="btn-post px-2 ">
                                <a href="{{ route('web.login') }}">
                                    <i class="fa-solid fa-right-to-bracket mr-2"></i>
                                    <span>Đăng nhập</span>
                                </a>
                            </div>
                            @else
                            @if(isset(optional(Auth::user()->shop)->status->value) && optional(Auth::user()->shop)->status->value === 1)
                            <div class="btn-post  display-none">
                                <a href="{{ route('post.create') }}">
                                    <i class="fa-regular fa-file-lines mr-2"></i>
                                    <span>Đăng bài</span>
                                </a>
                            </div>
                            @endif
                            <div class="dropdown ">
                                <a href="#" class="row align-items-center" style="max-width: 140px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img class="avt mr-1" src="{{ getImage(Auth::user()->avatar) }}" alt="">
                                    <span class="d-n display-none color-232323 header-name" style="max-width: 70px;white-space: nowrap;overflow: hidden; text-overflow: ellipsis;">{{ Auth::user()->name }} </span>
                                    <i class="d-n display-none fa-solid fa-sort-down  mb-2 color-232323 header-name"></i>
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
                    <div class="col-sm-12 col-12 menu display-block mt-3">
                        <form action="{{$route}}" method="GET" class="">
                            @csrf
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-magnifying-glass"></i></span>
                                </div>
                                <input type="text" id="search" name="search" value="{{$search ? $search : ''}}" class="form-control border-l-r-none forcus-none search-input" placeholder="Nhập từ khoá tìm kiếm như váy, mỹ phẩm, áo, điện thoại,..." aria-label="Username" aria-describedby="basic-addon1">

                                <div class="input-group-append">
                                    <div style="position: relative;">
                                        <div style="border-left: 2px solid #000; height: 50%; position: absolute; left: 1px; top: 25%;"></div>

                                        <select class="form-control w-120px forcus-none province-select" name="province">
                                            <option value="0" disabled selected>Địa điểm</option>
                                            <option value="" {{request()->has('province') && empty($provinceQuery) ? 'selected' : ''}}>Tất cả</option>
                                            @foreach ($provinces as $province)
                                            <option value="{{$province->id}}" {{$provinceQuery && $provinceQuery == $province->id ? 'selected' : ''}}>{{$province->province_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="input-group-append">
                                    <button class="btn btn-search" type="submit">
                                        Tìm kiếm
                                    </button>
                                </div>

                                <div class="list-result" style="position: absolute; width: 100%; top: 38px; z-index: 100">

                                </div>
                            </div>
                        </form>
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
                                    <a class="dropdown-item dropdown-item-custom" href="{{ route('listProducts', ['category-slug' => $category->slug]) }}">
                                        <img src="{{ getImage($category->photo) }}" alt="" class="dropdown-img">
                                        <p class="dropdown-title">{{ $category->name }}</p>
                                        <i class="fa-solid fa-caret-right"></i>
                                    </a>
                                    @if($category->activeBrands->count())
                                    <ul class="dropdown-menu" style="width: 250px;">
                                        @foreach($category->activeBrands as $brand)
                                        <li>
                                            <a class="dropdown-item dropdown-item-custom" href="{{ route('listProducts', ['category-slug' => $category->slug, 'brand-slug' => $brand->slug]) }}">
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
                        <a href="{{ route('listProducts', ['type' => TypeProductEnums::EXCHANGE]) }}" class="row align-items-center mx-4">
                            <img src="{{asset('img/icon/exchange.png')}}" alt="" class="mr-2">
                            <span>Trao đổi hàng hóa</span>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="{{ route('listProducts', ['type' => TypeProductEnums::SECONDHAND]) }}" class="row align-items-center mx-4">
                            <img src="{{asset('img/icon/secondhand.png')}}" alt="" class="mr-2">
                            <span>Mua bán đồ secondhand</span>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="{{ route('listProducts', ['type' => TypeProductEnums::GIVEAWAY]) }}" class="row align-items-center mx-4">
                            <img src="{{asset('img/icon/giveaway.png')}}" alt="" class="mr-2">
                            <span>Hàng cũ đem tặng</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {
        $('#notificationDropdown').on('click', function(e) {
            e.preventDefault();
            $(this).next('.dropdown-menu').toggle();
        });

        $(document).on('click', '#markAllAsRead', function(e) {
            e.preventDefault();
            e.stopPropagation();

            let url = $(this).data('href');

            $.ajax({
                type: 'GET',
                url: url,
                success: function(response) {
                    if (response.status === 200) {
                        $('.dot').removeClass('dot');
                        $('.notification').removeClass('is_read');
                        $('#notificationCount').text('');
                    }
                },
                error: function() {
                    alert('Có lỗi xảy ra, vui lòng thử lại.');
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#toggle-categories').on('click', function(e) {
            e.preventDefault();
            $('#categories-menu').slideToggle(300);
        });

        $('.category-toggle').on('click', function(e) {
            e.preventDefault();
            $(this).next('.custom-dropdown-submenu').slideToggle(300);
        });
    });
</script>



<script>
    $(document).ready(function() {
        $('.search-input').on('focus', function() {
            $('.list-result').show();
        });

        $('.search-input').on('blur', function() {
            // Delay việc ẩn div để có thời gian chọn các item
            setTimeout(function() {
                $('.list-result').hide();
            }, 200);
        });

        $('.list-result').on('mousedown', function(event) {
            event.preventDefault();
        });

        let checkTimeout;
        $('.search-input').on('input', function() {

            var searchValue = $(this).val();
            checkInputValue();
            clearTimeout(checkTimeout);

            checkTimeout = setTimeout(function() {
                $.ajax({
                    url: @json(route('search')),
                    method: 'GET',
                    data: {
                        search: searchValue
                    },
                    success: function(response) {
                        $('.list-result').empty();
                        $('.list-result').append(response.resultHtml);
                    },
                    error: function(xhr, status, error) {
                        $('.list-result').append('<li class="list-group-item">Đã có lỗi xảy ra vui lòng thử lại sau</li>');
                    }
                });
            }, 300)
        });
        checkInputValue();

        function checkInputValue() {
            let isAnyInputFilled = false;

            $('.search-input').each(function() {
                if ($(this).val().trim() !== '') {
                    isAnyInputFilled = true;
                    return false;
                }
            });

            if (isAnyInputFilled) {
                $('.btn-search').prop('disabled', false);
            } else {
                $('.btn-search').prop('disabled', true);
            }
        }

        var selectedValue = $('.province-select').val();

        function checkProvinceValue() {
            if (selectedValue !== 0 && selectedValue !== null) {

                $('.btn-search').prop('disabled', false);
            } else {
                $('.btn-search').prop('disabled', true);
            }
        }
        checkProvinceValue();
        $('.province-select').on('change', function() {
            selectedValue = $(this).val();
            checkProvinceValue();
        });

    });
</script>