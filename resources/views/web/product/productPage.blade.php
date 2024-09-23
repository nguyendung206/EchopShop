@extends('web.layout.app')

@php
    $url = Str::lower(request()->url());
    $case = 'giveaway';

    if (Str::contains($url, 'secondhand')) {
        $case = 'secondhand';
    }
    if (Str::contains($url, 'exchange')) {
        $case = 'exchange';
    }
@endphp



@section('css')
    <link rel="stylesheet" href="{{ asset('/css/product.css') }}">
@endsection

@section('content')
    <div class="title-line">
        <div class="title-text">
            @if ($case == 'exchange')
    Trao đổi hàng hoá
    @elseif ($case == 'secondhand')
    Mua bán đồ SECONDHAND
    @else
    Hàng cũ đem tặng
    @endif
        </div>
    </div>

    <div class="content container">

        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-9 button-page-wrap">
                <a href="{{route('secondhandProduct')}}" class="{{$case == "secondhand" ? 'active' : ''}}">Mua bán</a>
                <a href="{{route('exchangeProduct')}}"  class="{{$case == "exchange" ? 'active' : ''}}">Trao đổi</a>
                <a href="{{route('giveawayProduct')}}" class="{{$case == "giveaway" ? 'active' : ''}}">Hàng tặng</a>
            </div>

        </div>
        <div class="row">
            @include('web.inc.web_slideProduct')
            <div class="col-lg-9 col-12">
                <div class="row list-product">
                    @if ($case != 'giveaway')
                        @forelse($products as $product)
                            <div class="col-lg-4 col-6 text-center  product-item">
                                <div class="product-wrap">
                                    <a href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}">
                                        <img class="product-img" src="{{ getImage($product->photo) }} " alt="">
                                        @auth
                                            <a href="#"
                                                class='product-heart {{ auth()->user()->load('favorites')->favorites->contains('product_id', $product->id)? 'favorite-active': '' }} '
                                                data-url-destroy="{{ route('favorite.destroy', $product->id) }} heart-exchange"
                                                data-url-store="{{ route('favorite.store') }}"
                                                data-productId="{{ $product->id }}"><i
                                                    class="fa-{{ auth()->user()->load('favorites')->favorites->contains('product_id', $product->id)? 'solid': 'regular' }} fa-heart fa-heart-home"></i></a>
                                        @else
                                            <a href="{{ route('web.login') }}"><i
                                                    class="fa-regular fa-heart fa-heart-home heart-exchange"></i></a>
                                        @endauth
                                        <p class="product-name pt-2 line-clamp-2">{{ $product->name }}</p>
                                        <p class="product-brand pt-2 line-clamp-1">Phân loại: <span>brand</span></p>
                                        <p class="price product-price color-B10000 pt-2 line-clamp-1">
                                            {{ format_price($product->price) }}</p>
                                            <div class="user-product-wrap">
                                                @if (isset($product->shop))
                                        <img class="mini-avatar" src="{{getImage($product->shop->logo)}}" alt="">
                                        <div class="user-product "><p class="line-clamp-1">{{$product->shop->name}}  &nbsp;<img src="{{asset('/img/icon/doc-top.png')}}" alt="">&nbsp; {{$product->shop->user->province->province_name}}</p></div>
                                        @else
                                        <img src="{{asset("/img/image/logo.png")}}" alt="" class="mini-avatar-admin">
                                        <div class="user-product " style="width: 77%"><p class="line-clamp-1">Sản phẩm của echop</p></div>
                                        @endif
                                            </div>
                                    </a>
                                    <br>
                                    @switch($case)
                                        @case('exchange')
                                            <div class="buy-wrap-exchange">
                                                <a class="btn-chat-exchange"
                                                    href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}"><i
                                                        class="fa-regular fa-comment-dots"></i> Chat</a>
                                                <a class="btn-buy-exchange"
                                                    href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}">Đổi
                                                    hàng</a>
                                            </div>
                                        @break

                                        @case('secondhand')
                                            <div class="buy-wrap">
                                                <a href="#" class="btn-chat-product"><i
                                                        class="fa-regular fa-comment-dots"></i></a>
                                                <a href="#" class="btn-cart-product"><i
                                                        class="fa-solid fa-cart-shopping"></i></a>
                                                <a class="btn-buy-product"
                                                    href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}">Mua
                                                    ngay</a>
                                            </div>

                                            @default
                                        @endswitch
                                    </div>
                                </div>
                                @empty
                                    <div class="text-center w-100 py-5">
                                        <span class="" style="color:rgb(177,0,0);">Không có sản phẩm nào để hiển thị.</span>
                                    </div>
                                @endforelse
                            @else
                                @forelse($products as $product)
                                    <div class="gift-item m-2 col-lg-4 col-6" style="margin-left: 0px !important;margin-right: 0px !important">
                                        <img src="{{ getImage($product->photo) }}" alt="" class="gift-img">
                                        <div class="layer">
                                            <img src="{{ asset('/img/image/layer.png') }}" alt="" class="layer">
                                            <p>Free</p>
                                        </div>
                                        @auth
                                            <a href="#"
                                                class='product-heart {{ auth()->user()->load('favorites')->favorites->contains('product_id', $product->id)? 'favorite-active': '' }} '
                                                data-url-destroy="{{ route('favorite.destroy', $product->id) }}"
                                                data-url-store="{{ route('favorite.store') }}" data-productId="{{ $product->id }}"><i
                                                    class="fa-{{ auth()->user()->load('favorites')->favorites->contains('product_id', $product->id)? 'solid': 'regular' }} fa-heart fa-heart-home icon-change-2"></i></a>
                                        @else
                                            <a href="{{ route('web.login') }}"><i
                                                    class="fa-regular fa-heart fa-heart-home icon-change-2"></i></a>
                                        @endauth
                                        <div class="gift-name line-clamp-2">
                                            {{ $product->name }}
                                        </div>
                                        <div class="gift-btn-wrap">
                                            <a href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}"
                                                class="gift-btn">
                                                <i class="fa-solid fa-gift"></i> Nhận quà tặng
                                            </a>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center w-100 py-5">
                                        <span class="" style="color:rgb(177,0,0);">Không có sản phẩm nào để hiển thị.</span>
                                    </div>
                                @endforelse
                            @endif

                        </div>
                    </div>
                </div>
            </div>

            @section('script')
                <script src="{{ asset('/js/favorite.js') }}"></script>
            @endsection

        @endsection