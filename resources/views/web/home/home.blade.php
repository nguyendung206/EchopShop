@extends('web.layout.app')
@section('title')
    HOME
@endsection
@section('content')

<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        {{-- <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li> --}}
        @foreach ($banners as $index => $banner)
        <li data-target="#carouselExampleIndicators" data-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"></li>
        @endforeach
    </ol>

    <div class="carousel-inner">
        @foreach($banners as $index => $banner)
        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
            <div class="slideshow">
                <img src="{{ getImage('upload/banners/' , $banner->photo) }}" alt="">
                @if($banner->has_content)
                <div class="container">
                    <div class="slideshow-content">
                        <h1 class="slideshow-heading"><span class="color-B10000">{{ $banner->title }} </span></h1>
                        <h5 class="slideshow-subheading">{{ $banner->description }}</h5>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    <a class="carousel-control-prev icon-hover" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <i class="icon fa-solid fa-arrow-left" aria-hidden="true"></i>
    </a>
    <a class="carousel-control-next icon-hover" href="#carouselExampleIndicators" role="button" data-slide="next">
        <i class="icon fa-solid fa-arrow-right" aria-hidden="true"></i>
    </a>
</div>

    <div class="category pt-2">
        <div class="container">
            <br>
            <h1>Danh mục sản phẩm</h1>
            <div class="test"></div>
            <hr>
        </div>
        <div class="list-category mb-5">
            <div class="container">
                <div class="responsive slider">
                    <div class="">
                        <img class="category-img" src="{{ asset('/img/image/aoquan.jpeg') }}" alt="">
                        <p class="category-name">Áo quần</p>
                    </div>
                    <div class="">
                        <img class="category-img" src="{{ asset('/img/image/giaydep.jpeg') }}" alt="">
                        <p class="category-name">Giày dép</p>
                    </div>
                    <div class="">
                        <img class="category-img" src="{{ asset('/img/image/phukien.jpeg') }}" alt="">
                        <p class="category-name">Phụ kiện</p>
                    </div>
                    <div class="">
                        <img class="category-img" src="{{ asset('/img/image/sachvo.jpeg') }}" alt="">
                        <p class="category-name">Sách vở</p>
                    </div>
                    <div class="">
                        <img class="category-img" src="{{ asset('/img/image/mypham.jpeg') }}" alt="">
                        <p class="category-name">Mỹ phẩm</p>
                    </div>
                    <div class="">
                        <img class="category-img" src="{{ asset('/img/image/nuochoa.jpeg') }}" alt="">
                        <p class="category-name">Nước hoa</p>
                    </div>
                    <div class="">
                        <img class="category-img" src="{{ asset('/img/image/nuochoa.jpeg') }}" alt="">
                        <p class="category-name">Nước hoa</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="secondhand">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="category pt-2">
                    <div class="container">
                        <br>
                        <h1>Mua bán đồ secondhand</h1>
                        <div class="test"></div>
                        <hr>
                    </div>
                </div>
                <div class="icon-test">
                    <i class="fa-solid fa-arrow-left color-B10000"></i>
                    <i class="fa-solid fa-arrow-right color-fff"></i>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-4 col-md-4 col-lg-3 text-center col-6 py-3 product-item">
                    <img class="product-img" src="{{ asset('/img/image/secondhand1.jpeg') }} " alt="">
                    <i class="fa-regular fa-heart fa-heart-home"></i>
                    <p class="product-name pt-2">Chân váy dài</p>
                    <p class="price color-B10000 pt-2">150.000 đ</p>
                    <br>
                    <a href="#" class="buy">Mua ngay</a>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-3 text-center col-6 py-3 product-item">
                    <img class="product-img" src="{{ asset('/img/image/secondhand2.jpeg') }}" alt="">
                    <i class="fa-regular fa-heart fa-heart-home"></i>
                    <p class="product-name pt-2">Bộ mỹ phẩm</p>
                    <p class="price color-B10000 pt-2">150.000 đ</p>
                    <br>
                    <a href="#" class="buy">Mua ngay</a>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-3 text-center col-6 py-3 product-item">
                    <img class="product-img" src="{{ asset('/img/image/secondhand3.jpeg') }}" alt="">
                    <i class="fa-regular fa-heart fa-heart-home"></i>
                    <p class="product-name pt-2">Nước hoa Dior</p>
                    <p class="price color-B10000 pt-2">150.000 đ</p>
                    <br>
                    <a href="#" class="buy">Mua ngay</a>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-3 text-center col-6 py-3 product-item">
                    <img class="product-img" src="{{ asset('/img/image/secondhand4.jpeg') }}" alt="">
                    <i class="fa-regular fa-heart fa-heart-home"></i>
                    <p class="product-name pt-2">Điện thoại Xiaomi</p>
                    <p class="price color-B10000 pt-2">150.000 đ</p>
                    <br>
                    <a href="#" class="buy">Mua ngay</a>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-3 text-center col-6 py-3 product-item">
                    <img class="product-img" src="{{ asset('/img/image/secondhand5.jpeg') }}" alt="">
                    <i class="fa-regular fa-heart fa-heart-home"></i>
                    <p class="product-name pt-2">Giày AF1</p>
                    <p class="price color-B10000 pt-2">150.000 đ</p>
                    <br>
                    <a href="#" class="buy">Mua ngay</a>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-3 text-center col-6 py-3 product-item">
                    <img class="product-img" src="{{ asset('/img/image/secondhand6.jpeg') }}" alt="">
                    <i class="fa-regular fa-heart fa-heart-home"></i>
                    <p class="product-name pt-2">Hoodie</p>
                    <p class="price color-B10000 pt-2">150.000 đ</p>
                    <br>
                    <a href="#" class="buy">Mua ngay</a>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-3 text-center col-6 py-3 product-item">
                    <img class="product-img" src="{{ asset('/img/image/secondhand7.jpeg') }}" alt="">
                    <i class="fa-regular fa-heart fa-heart-home"></i>
                    <p class="product-name pt-2">Giày cao gót nữ</p>
                    <p class="price color-B10000 pt-2">150.000 đ</p>
                    <br>
                    <a href="#" class="buy">Mua ngay</a>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-3 text-center col-6 py-3 product-item">
                    <img class="product-img" src="{{ asset('/img/image/secondhand8.jpeg') }}" alt="">
                    <i class="fa-regular fa-heart fa-heart-home"></i>
                    <p class="product-name pt-2">Điện thoại IP 14 Pro Max</p>
                    <p class="price color-B10000 pt-2">150.000 đ</p>
                    <br>
                    <a href="#" class="buy">Mua ngay</a>
                </div>
            </div>
            <div class="text-center py-5">
                <a class="all color-B10000" href="#">Xem tất cả <i class="fa-solid fa-angles-right"></i></a>
            </div>
        </div>
    </div>
    <div class="brand">
        <div class="container">
            <div class="list-brand slider">
                <div class="brand-item p-5">
                    <img src="{{ asset('/img/image/brand1.png') }}" alt="" class="brand-img">
                </div>
                <div class="brand-item p-5">
                    <img src="{{ asset('/img/image/brand2.png') }}" alt="" class="brand-img">
                </div>
                <div class="brand-item p-5">
                    <img src="{{ asset('/img/image/brand3.png') }}" alt="" class="brand-img">
                </div>
                <div class="brand-item p-5">
                    <img src="{{ asset('/img/image/brand4.png') }}" alt="" class="brand-img">
                </div>
                <div class="brand-item p-5">
                    <img src="{{ asset('/img/image/brand5.jpeg') }}" alt="" class="brand-img">
                </div>
                <div class="brand-item p-5">
                    <img src="{{ asset('/img/image/brand5.jpeg') }}" alt="" class="brand-img">
                </div>
                <div class="brand-item p-5">
                    <img src="{{ asset('/img/image/brand5.jpeg') }}" alt="" class="brand-img">
                </div>
                <div class="brand-item p-5">
                    <img src="{{ asset('/img/image/brand5.jpeg') }}" alt="" class="brand-img">
                </div>
            </div>
        </div>
    </div>
    <div class="secondhand">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="category pt-2">
                    <div class="container">
                        <br>
                        <h1>Trao đổi hàng hóa</h1>
                        <div class="test"></div>
                        <hr>
                    </div>
                </div>
                <div class="icon-test">
                    <i class="fa-solid fa-arrow-left color-B10000"></i>
                    <i class="fa-solid fa-arrow-right color-fff"></i>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-4 col-md-4 col-lg-3 text-center col-6 py-3 product-item">
                    <img class="product-img" src="{{ asset('/img/image/secondhand1.jpeg') }}" alt="">
                    <i class="fa-regular fa-heart fa-heart-home icon-change"></i>
                    <p class="product-name pt-2">Chân váy dài</p>
                    <br>
                    <a href="#" class="buy chat"><i class="fa-regular fa-comment-dots pr-2"></i>Chat</a>
                    <a href="#" class="buy">Trao đổi</a>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-3 text-center col-6 py-3 product-item">
                    <img class="product-img" src="{{ asset('/img/image/secondhand2.jpeg') }}" alt="">
                    <i class="fa-regular fa-heart fa-heart-home icon-change"></i>
                    <p class="product-name pt-2">Bộ mỹ phẩm</p>
                    <br>
                    <a href="#" class="buy chat"><i class="fa-regular fa-comment-dots pr-2"></i>Chat</a>
                    <a href="#" class="buy">Trao đổi</a>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-3 text-center col-6 py-3 product-item">
                    <img class="product-img" src="{{ asset('/img/image/secondhand3.jpeg') }}" alt="">
                    <i class="fa-regular fa-heart fa-heart-home icon-change"></i>
                    <p class="product-name pt-2">Nước hoa Dior</p>
                    <br>
                    <a href="#" class="buy chat"><i class="fa-regular fa-comment-dots pr-2"></i>Chat</a>
                    <a href="#" class="buy">Trao đổi</a>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-3 text-center col-6 py-3 product-item">
                    <img class="product-img" src="{{ asset('/img/image/secondhand4.jpeg') }}" alt="">
                    <i class="fa-regular fa-heart fa-heart-home icon-change"></i>
                    <p class="product-name pt-2">Điện thoại Xiaomi</p>
                    <br>
                    <a href="#" class="buy chat"><i class="fa-regular fa-comment-dots pr-2"></i>Chat</a>
                    <a href="#" class="buy">Trao đổi</a>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-3 text-center col-6 py-3 product-item">
                    <img class="product-img" src="{{ asset('/img/image/secondhand5.jpeg') }}" alt="">
                    <i class="fa-regular fa-heart fa-heart-home icon-change"></i>
                    <p class="product-name pt-2">Giày AF1</p>
                    <br>
                    <a href="#" class="buy chat"><i class="fa-regular fa-comment-dots pr-2"></i>Chat</a>
                    <a href="#" class="buy">Trao đổi</a>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-3 text-center col-6 py-3 product-item">
                    <img class="product-img" src="{{ asset('/img/image/secondhand6.jpeg') }}" alt="">
                    <i class="fa-regular fa-heart fa-heart-home icon-change"></i>
                    <p class="product-name pt-2">Hoodie</p>
                    <br>
                    <a href="#" class="buy chat"><i class="fa-regular fa-comment-dots pr-2"></i>Chat</a>
                    <a href="#" class="buy">Trao đổi</a>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-3 text-center col-6 py-3 product-item">
                    <img class="product-img" src="{{ asset('/img/image/secondhand7.jpeg') }}" alt="">
                    <i class="fa-regular fa-heart fa-heart-home icon-change"></i>
                    <p class="product-name pt-2">Giày cao gót nữ</p>
                    <br>
                    <a href="#" class="buy chat"><i class="fa-regular fa-comment-dots pr-2"></i>Chat</a>
                    <a href="#" class="buy">Trao đổi</a>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-3 text-center col-6 py-3 product-item">
                    <img class="product-img" src="{{ asset('/img/image/secondhand8.jpeg') }}" alt="">
                    <i class="fa-regular fa-heart fa-heart-home icon-change"></i>
                    <p class="product-name pt-2">Điện thoại IP 14 Pro Max</p>
                    <br>
                    <a href="#" class="buy chat"><i class="fa-regular fa-comment-dots pr-2"></i>Chat</a>
                    <a href="#" class="buy">Trao đổi</a>
                </div>
            </div>
            <div class="text-center py-5">
                <a class="all color-B10000" href="#">Xem tất cả <i class="fa-solid fa-angles-right"></i></a>
            </div>
        </div>
    </div>
    <div class="app">
        <img src=" {{ asset('/img/image/app.jpg') }}" alt="" class="w-100">
        <div class="container">
            <div class="test-3">
                <div class="row">
                    <img src=" {{ asset('/img/image/ip1.png') }}" alt="" class="ip1 col-sm-3 col-3">
                    <img src=" {{ asset('/img/image/ip2.png') }}" alt="" class="ip2 col-sm-3 col-3">
                    <div class="col-sm-6 col-6">
                        <div class="row">
                            <div class="col-sm-12">
                                <h1 class="app-heading text-justify mt-4 w-100">
                                    “ECHOP NỀN TẢNG MUA BÁN TRAO ĐỔI HÀNG HOÁ ĐÃ QUA SỬ DỤNG”
                                </h1>
                                <p class="app-content text-justify w-100">
                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                    Ipsum has
                                    been
                                    the
                                    industry's standard dummy text ever since the 1500s, when an unknown printer took a
                                    galley
                                    of
                                    type and
                                    scrambled it to make a type specimen book. It has survived not
                                    only five centuries
                                </p>
                            </div>
                            <div class="col-sm-12">
                                <a href="#" class="app-btn color-B10000">TẢI ỨNG DỤNG NGAY <i
                                        class="fa-solid fa-angles-right"></i></a>
                                <img src="{{ asset('/img/image/appstpre.png') }}" alt="" class="appstore">
                                <img src="{{ asset('/img/image/ggplay.png') }}" alt="" class="ggplay">
                            </div>
                        </div>


                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="gift">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="category pt-2">
                    <div class="container">
                        <br>
                        <h1>Hàng cũ đem tặng</h1>
                        <div class="test"></div>
                        <hr>
                    </div>
                </div>
                <div class="icon-test">
                    <i class="fa-solid fa-arrow-left color-B10000 slick-prev"></i>
                    <i class="fa-solid fa-arrow-right color-fff slick-next"></i>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="gift-list slider">
                <div class="gift-item m-2">
                    <img src="{{ asset('/img/image/aoquan.jpeg') }}" alt="" class="gift-img">
                    <div class="layer">
                        <img src="{{ asset('/img/image/layer.png') }}" alt="" class="layer">
                        <p>Free</p>
                    </div>
                    <i class="fa-regular fa-heart fa-heart-home icon-change-2"></i>
                    <div class="gift-hover">
                        <div class="layout"></div>
                        <a href="#" class="gift-btn">
                            <i class="fa-solid fa-gift"></i> Nhận quà tặng
                        </a>
                    </div>
                </div>
                <div class="gift-item m-2">
                    <img src="{{ asset('/img/image/mypham.jpeg') }}" alt="" class="gift-img">
                    <div class="layer">
                        <img src="{{ asset('/img/image/layer.png') }}" alt="" class="layer">
                        <p>Free</p>
                    </div>
                    <i class="fa-regular fa-heart fa-heart-home icon-change-2"></i>
                    <div class="gift-hover">
                        <div class="layout"></div>
                        <a href="#" class="gift-btn">
                            <i class="fa-solid fa-gift"></i> Nhận quà tặng
                        </a>
                    </div>
                </div>
                <div class="gift-item m-2">
                    <img src="{{ asset('/img/image/nuochoa.jpeg') }}" alt="" class="gift-img">
                    <div class="layer">
                        <img src="{{ asset('/img/image/layer.png') }}" alt="" class="layer">
                        <p>Free</p>
                    </div>
                    <i class="fa-regular fa-heart fa-heart-home icon-change-2"></i>
                    <div class="gift-hover">
                        <div class="layout"></div>
                        <a href="#" class="gift-btn">
                            <i class="fa-solid fa-gift"></i> Nhận quà tặng
                        </a>
                    </div>
                </div>
                <div class="gift-item m-2">
                    <img src="{{ asset('/img/image/nuochoa.jpeg') }}" alt="" class="gift-img">
                    <div class="layer">
                        <img src="{{ asset('/img/image/layer.png') }}" alt="" class="layer">
                        <p>Free</p>
                    </div>
                    <i class="fa-regular fa-heart fa-heart-home icon-change-2"></i>
                    <div class="gift-hover">
                        <div class="layout"></div>
                        <a href="#" class="gift-btn">
                            <i class="fa-solid fa-gift"></i> Nhận quà tặng
                        </a>
                    </div>
                </div>
                <div class="gift-item m-2">
                    <img src="{{ asset('/img/image/nuochoa.jpeg') }}" alt="" class="gift-img">
                    <div class="layer">
                        <img src="{{ asset('/img/image/layer.png') }}" alt="" class="layer">
                        <p>Free</p>
                    </div>
                    <i class="fa-regular fa-heart fa-heart-home icon-change-2"></i>
                    <div class="gift-hover">
                        <div class="layout"></div>
                        <a href="#" class="gift-btn">
                            <i class="fa-solid fa-gift"></i> Nhận quà tặng
                        </a>
                    </div>
                </div>
                <div class="gift-item m-2">
                    <img src="{{ asset('/img/image/phukien.jpeg') }}" alt="" class="gift-img">
                    <div class="layer">
                        <img src="{{ asset('/img/image/layer.png') }}" alt="" class="layer">
                        <p>Free</p>
                    </div>
                    <i class="fa-regular fa-heart fa-heart-home icon-change-2"></i>
                    <div class="gift-hover">
                        <div class="layout"></div>
                        <a href="#" class="gift-btn">
                            <i class="fa-solid fa-gift"></i> Nhận quà tặng
                        </a>
                    </div>
                </div>
                <div class="gift-item m-2">
                    <img src="{{ asset('/img/image/giaydep.jpeg') }}" alt="" class="gift-img">
                    <div class="layer">
                        <img src="{{ asset('/img/image/layer.png') }}" alt="" class="layer">
                        <p>Free</p>
                    </div>
                    <i class="fa-regular fa-heart fa-heart-home icon-change-2"></i>
                    <div class="gift-hover">
                        <div class="layout"></div>
                        <a href="#" class="gift-btn">
                            <i class="fa-solid fa-gift"></i> Nhận quà tặng
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <hr>

@section('script')
    <script src="{{ asset('/js/text.js') }}"></script>
@endsection
@endsection
   
  
