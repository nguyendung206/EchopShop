@extends('web.layout.app')
@section('title')
HOME
@endsection
@section('content')

<div id="carouselExampleIndicators" class="carousel slide container" data-ride="carousel">
    <ol class="carousel-indicators">
        {{-- <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li> --}}
        @foreach ($banners as $index => $banner)
        <li data-target="#carouselExampleIndicators" data-slide-to="{{ $index }}"
            class="{{ $index === 0 ? 'active' : '' }}"></li>
        @endforeach
    </ol>

    <div class="carousel-inner ">
        @foreach ($banners as $index => $banner)
        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
            <div class="slideshow">
                <img src="{{ getImage($banner->photo) }}" alt="">
                <div class="slideshow-content">
                    <h1 class="slideshow-heading"><span class="color-B10000">{{ $banner->title }} </span></h1>
                    <h5 class="slideshow-subheading">{{ strip_tags($banner->description) }}</h5>
                    <button class="c-1-button" style="border: none;background-color:transparent">
                        <a href="http://127.0.0.1:8000/{{ $banner->link }}">Đi đến liên kết</a>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @if ($banners->count() != 0)
    <a class="carousel-control-prev icon-hover" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <i class="icon fa-solid fa-arrow-left" aria-hidden="true"></i>
    </a>
    <a class="carousel-control-next icon-hover" href="#carouselExampleIndicators" role="button" data-slide="next">
        <i class="icon fa-solid fa-arrow-right" aria-hidden="true"></i>
    </a>
    @endif
</div>


<div class=" pt-2">
    <div class="container">
        <br>
        <h1 class="title-secondhand">Danh mục sản phẩm</h1>
    </div>
    <div class="list-category mb-5">
        <div class="container">
            <div class="row">
                @forelse ($brands as $brand)
                <div class="col-lg-2 col-md-2 col-sm-3 col-4">
                    <img class="category-img" src="{{ getImage($brand->photo) }}" alt="">
                    <p class="category-name">{{$brand->name}}</p>
                </div>
                @empty
                <div class="text-center w-100 py-5">
                    <span class="" style="color:rgb(177,0,0);">Không có danh mục nào để hiển thị.</span>
                </div>
                @endforelse
                @if ($brands->count() > 0)
                <div class="col-12 text-center my-4">
                    <a href="{{route('listProducts')}}" class="all btn-more">Xem tất cả <i class="fa-solid fa-angles-right"></i></a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div>
        <img src="{{asset("/img/image/banner-home-1.png")}}" alt="" style="width: 100%">
    </div>

    <div class="secondhand background-exchange">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="container pt-2">
                    <div class="container">
                        <br>
                        <h1 class="title-secondhand">Trao đổi hàng hóa</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row exchange-list">
                @forelse($exchangeProducts as $product)
                <div class="col-custom text-center  product-item">
                    <div class="product-wrap">
                        <a href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}">
                            <div style="position: relative;">
                                <img class="product-img" src="{{ getImage($product->photo) }} " alt="">
                                @auth
                                <a href="#"
                                    class='product-heart {{ auth()->user()->load('favorites')->favorites->contains('product_id', $product->id)? 'favorite-active': '' }} '
                                    data-url-destroy="{{ route('favorite.destroy', $product->id) }}"
                                    data-url-store="{{ route('favorite.store') }}" data-productId="{{ $product->id }}"><i
                                        class="fa-{{ auth()->user()->load('favorites')->favorites->contains('product_id', $product->id)? 'solid': 'regular' }} fa-heart fa-heart-home"></i></a>
                                @else
                                <a href="{{ route('web.login') }}"><i class="fa-regular fa-heart fa-heart-home"></i></a>
                                @endauth
                            </div>
                            <p class="product-name pt-2 line-clamp-2">{{ $product->name }}</p>
                            <p class="product-brand pt-2 line-clamp-1">Phân loại: <span>{{ $product->brand->name ?? ""}}</span></p>
                            <p class="price product-price color-B10000 pt-2 line-clamp-1">{{ format_price($product->price) }}</p>
                            <div class="user-product-wrap d-flex align-items-center">
                                @if (isset($product->shop))
                                <img class="mini-avatar mr-2" src="{{getImage($product->shop->logo)}}" alt="">
                                <div class="user-product ">
                                    <p class="line-clamp-1">{{$product->shop->name}} &nbsp;<img src="{{asset('/img/icon/doc-top.png')}}" alt="">&nbsp; {{$product->shop->user->province->province_name}}</p>
                                </div>
                                @else
                                <img src="{{asset("/img/image/logo.png")}}" alt="" class="mini-avatar-admin mr-2">
                                <div class="user-product " style="width: 77%">
                                    <p class="line-clamp-1">Sản phẩm của echop</p>
                                </div>
                                @endif
                            </div>
                        </a>
                        <br>
                        <div class="buy-wrap-exchange">
                            <a class="btn-chat-exchange" href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}"><i class="fa-regular fa-comment-dots"></i> Chat</a>
                            <a class="btn-buy-exchange" href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}">Đổi hàng</a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center w-100 py-5">
                    <span class="" style="color:rgb(177,0,0);">Không có sản phẩm nào để hiển thị.</span>
                </div>
                @endforelse
            </div>
            @if ($exchangeProducts->isNotEmpty())
            <div class="text-center py-5 divMoreExchange btn-more-wrap">
                @if ($exchangeProducts->count() >= 8 && $exchangeProducts->hasMorePages())
                <a id="btnMoreExchange" class="all color-B10000 btn-more" href="#">Xem thêm sản phẩm<i
                        class="fa-solid fa-angles-down"></i></a>
                @endif
                <a class="all color-B10000 btn-more" href="{{ route('listProducts', ['type' => TypeProductEnums::EXCHANGE]) }}">Xem tất cả <i
                        class="fa-solid fa-angles-right"></i></a>
            </div>
            @endif

        </div>
    </div>
    <div class="secondhand">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class=" pt-2">
                    <div class="container">
                        <br>
                        <h1 class="title-secondhand">Mua bán đồ secondhand</h1>
                    </div>
                </div>

            </div>

        </div>
        <div class="container">
            <div class="row secondhand-list">
                @forelse($secondhandProducts as $product)
                <div class="col-custom text-center product-item">
                    <div class="product-wrap">
                        <a href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}">
                            <div style="position: relative;">
                                <img class="product-img" src="{{ getImage($product->photo) }} " alt="">
                                @auth
                                <a href="#"
                                    class='product-heart {{ auth()->user()->load('favorites')->favorites->contains('product_id', $product->id)? 'favorite-active': '' }} '
                                    data-url-destroy="{{ route('favorite.destroy', $product->id) }}"
                                    data-url-store="{{ route('favorite.store') }}" data-productId="{{ $product->id }}"><i
                                        class="fa-{{ auth()->user()->load('favorites')->favorites->contains('product_id', $product->id)? 'solid': 'regular' }} fa-heart fa-heart-home"></i></a>
                                @else
                                <a href="{{ route('web.login') }}"><i class="fa-regular fa-heart fa-heart-home"></i></a>
                                @endauth
                            </div>
                            <p class="product-name pt-2 line-clamp-2">{{ $product->name }}</p>
                            <p class="product-brand pt-2 line-clamp-1">Phân loại: <span>{{ $product->brand->name ?? ""}}</span></p>
                            <p class="price product-price color-B10000 pt-2 line-clamp-1">{{ format_price($product->price) }}</p>
                            <div class="user-product-wrap d-flex align-items-center">
                                @if (isset($product->shop))
                                <img class="mini-avatar mr-2" src="{{getImage($product->shop->logo)}}" alt="">
                                <div class="user-product ">
                                    <p class="line-clamp-1">{{$product->shop->name}} &nbsp;<img src="{{asset('/img/icon/doc-top.png')}}" alt="">&nbsp; {{$product->shop->user->province->province_name}}</p>
                                </div>
                                @else
                                <img src="{{asset("/img/image/logo.png")}}" alt="" class="mini-avatar-admin mr-2">
                                <div class="user-product " style="width: 77%">
                                    <p class="line-clamp-1">Sản phẩm của echop</p>
                                </div>
                                @endif
                            </div>
                        </a>
                        <br>
                        <div class="buy-wrap">
                            <a href="#" class="btn-chat-product"><i class="fa-regular fa-comment-dots"></i></a>
                            @auth
                            <a id="btn-cart" href="#" class="btn-cart-product btn-cart" data-url-add-to-cart="{{ route('cart.store') }}" data-id="{{ $product->id }}" data-productunitid="{{!empty($product->getProductUnitTypeOne()) ? $product->getProductUnitTypeOne()->id : 0}}" data-url-check="{{ route('cart.check') }}">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </a>
                            @else
                            <a href="{{ route('web.login') }}" class="btn-cart-product">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </a>
                            @endauth

                            <a class="btn-buy-product" href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}">
                                Mua ngay
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center w-100 py-5">
                    <span class="" style="color:rgb(177,0,0);">Không có sản phẩm nào để hiển thị.</span>
                </div>
                @endforelse
            </div>
            @if ($secondhandProducts->isNotEmpty())
            <div class="text-center py-5 divMoreSecondhand btn-more-wrap">
                @if ($secondhandProducts->count() >= 8 && $secondhandProducts->hasMorePages())
                <a id="btnMoreSecondhand" class="all color-B10000 btn-more" href="#">Xem thêm sản phẩm mới<i
                        class="fa-solid fa-angles-right"></i></a>
                @endif
                <a class="all color-B10000 btn-more" href="{{ route('listProducts', ['type' => TypeProductEnums::SECONDHAND]) }}">Xem tất cả <i
                        class="fa-solid fa-angles-right"></i></a>
            </div>
            @endif
        </div>
    </div>
    <div class="app">
        <img src=" {{ asset('/img/image/app.jpg') }}" alt="" class="w-100">
        <div class="container">
            <div class="test-3">
                <div class="row margin-responsive">
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
        <div class="row justify-content-between align-items-center" style="position: relative">
            <div class="container pt-2">
                <div class="container">
                    <br>
                    <h1 class="title-secondhand">Hàng cũ đem tặng</h1>
                </div>
            </div>
            <div class="">
                <i class="fa-solid fa-arrow-left color-B10000 slick-prev-gift"></i>
                <i class="fa-solid fa-arrow-right color-fff slick-next-gift"></i>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="gift-list slider">
            @forelse($giveawayProducts as $product)
            <div class="col-custom text-center  product-item">
                <div class="product-wrap">
                    <a href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}">
                        <div style="position: relative;">
                            <img class="product-img" src="{{ getImage($product->photo) }} " alt="">
                            @auth
                            <a href="#"
                                class='product-heart {{ auth()->user()->load('favorites')->favorites->contains('product_id', $product->id)? 'favorite-active': '' }} '
                                data-url-destroy="{{ route('favorite.destroy', $product->id) }}"
                                data-url-store="{{ route('favorite.store') }}" data-productId="{{ $product->id }}"><i
                                    class="fa-{{ auth()->user()->load('favorites')->favorites->contains('product_id', $product->id)? 'solid': 'regular' }} fa-heart fa-heart-home"></i></a>
                            @else
                            <a href="{{ route('web.login') }}"><i class="fa-regular fa-heart fa-heart-home"></i></a>
                            @endauth
                        </div>
                        <p class="product-name pt-2 line-clamp-2">{{ $product->name }}</p>
                        <p class="product-brand pt-2 line-clamp-1">Phân loại: <span>{{ $product->brand->name ?? ""}}</span></p>
                        <p class="price product-price color-B10000 pt-2 line-clamp-1">{{ format_price($product->price) }}</p>
                        <div class="user-product-wrap d-flex align-items-center">
                            @if (isset($product->shop))
                            <img class="mini-avatar mr-2" src="{{getImage($product->shop->logo)}}" alt="">
                            <div class="user-product ">
                                <p class="line-clamp-1">{{$product->shop->name}} &nbsp;<img src="{{asset('/img/icon/doc-top.png')}}" alt="">&nbsp; {{$product->shop->user->province->province_name}}</p>
                            </div>
                            @else
                            <img src="{{asset("/img/image/logo.png")}}" alt="" class="mini-avatar-admin mr-2">
                            <div class="user-product " style="width: 77%">
                                <p class="line-clamp-1">Sản phẩm của echop</p>
                            </div>
                            @endif
                        </div>
                    </a>
                    <br>
                    <div class="gift-btn-wrap">
                        <a href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}"
                            class="gift-btn">
                            <i class="fa-solid fa-gift"></i> Nhận quà tặng
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center w-100 py-5">
                <span class="" style="color:rgb(177,0,0);">Không có sản phẩm nào để hiển thị.</span>
            </div>
            @endforelse
        </div>
        @if ($giveawayProducts->count() > 0)
        <div class="text-center  my-5">
            <a class="all color-B10000 btn-more" href="{{ route('listProducts', ['type' => TypeProductEnums::GIVEAWAY]) }}">Xem tất cả <i
                    class="fa-solid fa-angles-right"></i></a>
        </div>

        @endif
    </div>
</div>

<div>
    <img src="{{asset("/img/image/banner-home-2.png")}}" alt="" style="width: 100%">
</div>
<!-- Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="max-width: 700px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Chi tiết sản phẩm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="modalProductId">

                <div id="unitContainer" class="mb-3">
                    <!-- Các đơn vị sản phẩm sẽ được thêm từ JavaScript -->
                </div>

                <div class="d-flex align-items-center">
                    <label for="quantityInput" class="mr-3"><strong>Số lượng:</strong></label>
                    <div class="number-input d-flex">
                        <button class="minus btn btn-outline-secondary">-</button>
                        <input id="quantityInput" class="form-control mx-2 text-center" type="number" value="1" min="1" style="width: 80px;">
                        <button class="plus btn btn-outline-secondary">+</button>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="saveSelectedUnit" data-add-to-cart="{{ route('cart.store') }}">
                    Lưu vào giỏ hàng
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>


@section('script')
<script src="{{ asset('/js/favorite.js') }}"></script>
<script src="{{ asset('/js/cart.js') }}"></script>
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
                    }
                },
                error: function(xhr, status, error) {

                }
            });
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