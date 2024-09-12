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
                <img src="{{ getImage($banner->photo) }}" alt="">
                <div class="container">
                    <div class="slideshow-content">
                        <h1 class="slideshow-heading"><span class="color-B10000">{{ $banner->title }} </span></h1>
                        <h5 class="slideshow-subheading">{{ strip_tags($banner->description) }}</h5>
                        <button class="c-1-button" style="border: none;background-color:transparent">
                            <a href="http://127.0.0.1:8000/{{$banner->link}}">Đi đến liên kết</a>
                        </button>
                    </div>
                </div>
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
                @foreach ($categories as $category)
                <div class="">
                    <img class="category-img" src="{{ getImage($category->photo) }}" alt="">
                    <p class="category-name">{{$category->name}}</p>
                </div>
                @endforeach
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

            </div>
            <div class="icon-test">
                <i class="fa-solid fa-arrow-left color-B10000"></i>
                <i class="fa-solid fa-arrow-right color-fff"></i>
            </div>
        </div>
        <div class="container">
            <div class="row secondhand-list">
                @forelse($secondhandProducts as $product)
                <div class="col-sm-4 col-md-4 col-lg-3 text-center col-6 py-3 product-item">
                    <a href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}">
                        <img class="product-img" src="{{ getImage($product->photo) }} " alt="">
                        @auth
                        <a href="#" class='product-heart {{auth()->user()->load('favorites')->favorites->contains('product_id', $product->id) ? 'favorite-active' : ''}} ' data-url-destroy="{{ route("favorite.destroy", $product->id) }}" data-url-store="{{ route("favorite.store") }}" data-productId="{{$product->id}}"><i class="fa-{{auth()->user()->load('favorites')->favorites->contains('product_id', $product->id) ? 'solid' : 'regular'}} fa-heart fa-heart-home"></i></a>
                        @else
                        <a href="{{route('web.login')}}"><i class="fa-regular fa-heart fa-heart-home"></i></a>
                        @endauth
                        <p class="product-name pt-2">{{$product->name}}</p>
                        <p class="price color-B10000 pt-2">{{$product->price}} đ</p>
                    </a>
                    <br>
                    <a href="#" class="buy">Mua ngay</a>
                </div>
                @empty
                <div class="text-center w-100 py-5">
                    <span class="" style="color:rgb(177,0,0);">Không có sản phẩm nào để hiển thị.</span>
                </div>
                @endforelse
            </div>
            @if($secondhandProducts->isNotEmpty())
            <div class="text-center py-5 divMoreSecondhand">
                @if($secondhandProducts->count() >= 8)
                <a id="btnMoreSecondhand" class="all color-B10000" href="#">Xem thêm <i class="fa-solid fa-angles-down"></i></a>
                @endif
                <a class="all color-B10000" href="#">Xem tất cả <i class="fa-solid fa-angles-right"></i></a>
            </div>
            @endif
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
            </div>
        </div>
        <div class="container">
            <div class="row exchange-list">
                @forelse($exchangeProducts as $product)
                <div class="col-sm-4 col-md-4 col-lg-3 text-center col-6 py-3 product-item">
                    <a href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}">
                        <img class="product-img" src="{{ getImage($product->photo) }}" alt="">
                        @auth
                        <a href="#" class='product-heart {{auth()->user()->load('favorites')->favorites->contains('product_id', $product->id) ? 'favorite-active' : ''}} ' data-url-destroy="{{ route("favorite.destroy", $product->id) }}" data-url-store="{{ route("favorite.store") }}" data-productId="{{$product->id}}"><i class="fa-{{auth()->user()->load('favorites')->favorites->contains('product_id', $product->id) ? 'solid' : 'regular'}} fa-heart fa-heart-home"></i></a>
                        @else
                        <a href="{{route('web.login')}}"><i class="fa-regular fa-heart fa-heart-home"></i></a>
                        @endauth
                        <p class="product-name pt-2">{{$product->name}}</p>
                    </a>
                    <br>
                    <a href="#" class="buy chat"><i class="fa-regular fa-comment-dots pr-2"></i>Chat</a>
                    <a href="#" class="buy">Trao đổi</a>
                </div>
                @empty
                <div class="text-center w-100 py-5">
                    <span class="" style="color:rgb(177,0,0);">Không có sản phẩm nào để hiển thị.</span>
                </div>
                @endforelse
            </div>
            @if($exchangeProducts->isNotEmpty())
            <div class="text-center py-5 divMoreExchange">
                @if($exchangeProducts->count() >= 8)
                <a id="btnMoreExchange" class="all color-B10000" href="#">Xem thêm <i class="fa-solid fa-angles-down"></i></a>
                @endif
                <a class="all color-B10000" href="#">Xem tất cả <i class="fa-solid fa-angles-right"></i></a>
            </div>
            @endif

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

<script src="{{ asset('/js/favorite.js')}}"></script>

<script src="{{ asset('/js/text.js') }}"></script>
<script>
    $(document).ready(function() {
                var currentSecondhandPage = 1;
                var currentExchangePage = 1;

                $('#btnMoreSecondhand').click(function(event) {
                    event.preventDefault();
                    currentSecondhandPage++;

                    $.ajax({
                        url: '{{ route("home") }}',
                        method: 'GET',
                        data: {
                            secondhandPage: currentSecondhandPage
                        },
                        success: function(response) {
                            var productsHtml = '';

                            $('.secondhand-list').append(response.products);
                            if (response.hasMorePage) {
                                $('#btnMoreSecondhand').hide();
                                $('.end-of-products-secondhand').show();
                            }
                        },
                        error: function(xhr, status, error) {

                        }
                    });

                    $('#btnMoreExchange').click(function(event) {
                        event.preventDefault();
                        currentExchangePage++;

                        $.ajax({
                            url: '{{ route("home") }}',
                            method: 'GET',
                            data: {
                                exchangePage: currentExchangePage
                            },
                            success: function(response) {
                                var productsHtml = '';

                                $('.exchange-list').append(response.products);
                                if (response.hasMorePage) {
                                    $('#btnMoreExchange').hide();
                                    $('.end-of-products-exchange').show();
                                }
                            },
                            error: function(xhr, status, error) {

                            }
                        });
                    });

                });
</script>
@endsection

@endsection