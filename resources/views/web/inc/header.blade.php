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
                            <li class=" ml-3">
                                <a class="" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false" href="#">Danh mục sản phẩm<i
                                        class="fa-solid fa-caret-down pl-2"></i></a>
                                <div class="dropdown-menu dropdown-menu-category dropright" aria-labelledby="dropdownMenuButton">
                                    @foreach ($categories as $category)
                                    <a class=" dropdown dropdown-item category-{{$category->slug}}" type="button" data-toggle="dropdown" 
                                        aria-haspopup="true" aria-expanded="false" href="#"  data-category-id="{{$category->id}}" data-target="#dropdownMenu{{$category->slug}}">
                                        <div class="row align-items-center">
                                            <img src="{{ getImage('upload/product/', $category->photo) }}" alt="" class="dropdown-img">
                                            
                                            <p class="dropdown-title">{{$category->name}}</p>
                                        </div>
                                        <i class="fa-solid fa-caret-right"></i>
                                    </a>
                                    @endforeach
                                    <div class="dropdown-menu sub-menu" id="dropdownMenu{{$category->slug}}" aria-labelledby="dropdownMenuButton{{$category->slug}}">
                                        
                                    </div>

                                    <a class="dropdown-item-custom" type="button"  href="#">
                                        <div class="row align-items-center">
                                            <img src="{{ asset('/img/icon/khac.png') }}" alt="" class="dropdown-img">
                                            <p class="dropdown-title">Khác</p>

                                        </div>
                                        <i class="fa-solid fa-caret-right"></i>
                                    </a>
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
                            <div class="search">
                                <a href="#"><i class="color-750000 fa-solid fa-magnifying-glass"></i></a>
                            </div>

                            <!-- Nếu người dùng chưa đăng nhập -->
                            @guest
                            <div class="btn-post px-2">
                                <a href="{{ route('web.register') }}">
                                    <i class="fa-solid fa-user-plus mr-2"></i>
                                    <span>Đăng ký</span>
                                </a>
                            </div>
                            @else
                            <!-- Nếu người dùng đã đăng nhập -->
                            <div class="btn-post px-2">
                                <a href="#">
                                    <i class="fa-regular fa-file-lines mr-2"></i>
                                    <span>Đăng bài</span>
                                </a>
                            </div>
                            <div class="dropdown">
                                <a href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img class="avt" src="{{ getImage('upload/users/', optional(Auth::user())->avatar) }}" alt="">
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                    <a class="drop-user-item" href="">
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('.dropdown-item').click(function(e) {

            e.preventDefault();
            $('.sub-menu').html('');
            $('.sub-menu').append('<a class="dropdown-item" href="#">Đang tải</a>');
            var categoryId = $(this).data('category-id');
            var target = $(this).data('target');

            $.ajax({
                url: "{{ route('web.getBrand') }}",
                type: "GET",
                data: { category_id: categoryId },
                success: function(response) {
                    $('.sub-menu').html('');
                    response.brands.forEach(function(brand) {
                        $('.sub-menu').append('<a class="dropdown-item" href="#">' + brand.name + '<i class="fa-solid fa-caret-right"></i></a>');
                    });


                    
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>
</header>