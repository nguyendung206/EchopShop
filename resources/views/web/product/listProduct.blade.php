@php
$url = Str::lower(request()->url());
$search = null;
$provinceQuery = null;
if (request()->filled('search')) {
$search = request()->get('search');
}
if (request()->filled('province')) {
$provinceQuery = request()->get('province');
}
$case = 0;
$dataUrl = route('listProducts');
if(request()->query('type') == 3){
$case = '3';
$dataUrl = route('listProducts', ['type' => TypeProductEnums::GIVEAWAY]);
}

if (request()->query('type') == 2) {
$case = '2';
$dataUrl = route('listProducts', ['type' => TypeProductEnums::SECONDHAND]);
}
if (request()->query('type') == 1) {
$case = '1';
$dataUrl = route('listProducts', ['type' => TypeProductEnums::EXCHANGE]);
}
@endphp

@if ($case != TypeProductEnums::GIVEAWAY->value && $case != 0)
@forelse($products as $product)
<div class="col-lg-4 col-6 text-center product-item">
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
                <a href="{{ route('web.login') }}" class="product-heart"><i class="fa-regular fa-heart fa-heart-home"></i></a>
                @endauth
            </div>
            <p class="product-name pt-2 line-clamp-2">{{ $product->name }}</p>
            <p class="product-brand pt-2 line-clamp-1">Phân loại: <span>{{ $product->brand->name ?? ""}}</span></p>
            <p class="price product-price color-B10000 pt-2 line-clamp-1">
                {{ format_price($product->price) }}
            </p>
            <div class="user-product-wrap d-flex align-items-center">
                @if (isset($product->shop))
                <img class="mini-avatar mr-2" src="{{ getImage($product->shop->logo) }}"
                    alt="">
                <div class="user-product ">
                    <p class="line-clamp-1">{{ $product->shop->name }} &nbsp;<img
                            src="{{ asset('/img/icon/doc-top.png') }}"
                            alt="">&nbsp;
                        {{ $product->shop->province?->province_name ?? 'Chưa có địa chỉ'}}
                    </p>
                </div>
                @else
                <img src="{{ asset('/img/image/logo.png') }}" alt=""
                    class="mini-avatar-admin mr-2">
                <div class="user-product " style="width: 77%">
                    <p class="line-clamp-1">Sản phẩm của echop</p>
                </div>
                @endif
            </div>
        </a>
        <br>
        @switch($case)
        @case(TypeProductEnums::EXCHANGE->value)
        <div class="buy-wrap-exchange">
            @auth
            <a class="btn-chat-exchange" href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}"><i class="fa-regular fa-comment-dots"></i> Chat</a>
            <button class="btn-buy-exchange exchange"
                data-href="{{ route('user.exchangeProducts') }}"
                data-id="{{ $product->id }}"
                data-owner-id="{{ $product->user_id }}"
                data-user-id="{{ optional(Auth::user())->id }}">
                Đổi hàng
            </button>
            @else
            <a class="btn-chat-exchange" href="{{ route('web.login') }}"><i class="fa-regular fa-comment-dots"></i> Chat</a>
            <a class="btn-buy-exchange" href="{{ route('web.login') }}">Đổi hàng</a>
            @endauth
        </div>
        @break

        @case(TypeProductEnums::SECONDHAND->value)
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

        @default
        @endswitch
    </div>
</div>
@empty
<div class="text-center w-100 py-5">
    <span class="" style="color:rgb(177,0,0);">Không có sản phẩm nào để hiển thị.</span>
</div>
@endforelse
@endif
@if ($case == TypeProductEnums::GIVEAWAY->value && $case != 0)
@forelse($products as $product)
<div class="gift-item m-2 col-lg-4 col-6"
    style="margin-left: 0px !important;margin-right: 0px !important">
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
                <a href="{{ route('web.login') }}" class="product-heart"><i class="fa-regular fa-heart fa-heart-home"></i></a>
                @endauth
            </div>
            <p class="product-name pt-2 line-clamp-2">{{ $product->name }}</p>
            <p class="product-brand pt-2 line-clamp-1">Phân loại: <span>{{ $product->brand->name ?? ""}}</span></p>
            <p class="price product-price color-B10000 pt-2 line-clamp-1">{{ format_price($product->price) }}</p>
            <div class="user-product-wrap d-flex align-items-center">
                @if (isset($product->shop))
                <img class="mini-avatar mr-2" src="{{getImage($product->shop->logo)}}" alt="">
                <div class="user-product ">
                    <p class="line-clamp-1">{{$product->shop->name}} &nbsp;<img src="{{asset('/img/icon/doc-top.png')}}" alt="">&nbsp; {{$product->shop->province?->province_name ?? 'Chưa có địa chỉ'}}</p>
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
@endif

@if ($case == 0)
@forelse($products as $product)
<div class="col-lg-4 product-item col-6 text-center py-3  ">
    <div class="product-wrap product-item-category" style="padding-bottom: 10px;">
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
                <a href="{{ route('web.login') }}" class="product-heart"><i class="fa-regular fa-heart fa-heart-home"></i></a>
                @endauth
            </div>
            <p class="product-name pt-2">{{ $product->name }}</p>
            <p class="price color-B10000 pt-2">{{format_price($product->price)}}</p>
        </a>
        <div class="user-product-wrap my-1 d-flex align-items-center">
            @if (isset($product->shop))
            <img class="mini-avatar mr-2" src="{{ getImage($product->shop->logo) }}"
                alt="">
            <div class="user-product ">
                <p class="line-clamp-1">{{ $product->shop->name }} &nbsp;<img
                        src="{{ asset('/img/icon/doc-top.png') }}"
                        alt="">&nbsp;
                    {{ $product->shop->province?->province_name ?? 'Chưa có địa chỉ'}}
                </p>
            </div>
            @else
            <img src="{{ asset('/img/image/logo.png') }}" alt=""
                class="mini-avatar-admin mr-2">
            <div class="user-product " style="width: 77%">
                <p class="line-clamp-1">Sản phẩm của echop</p>
            </div>
            @endif
        </div>
        <div class="product-actions">
            @if ($product->type->value == TypeProductEnums::EXCHANGE->value)
            <a class="btn-chat-exchange" href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}"><i class="fa-regular fa-comment-dots"></i> Chat</a>
            <button class="btn-buy-exchange exchange"
                data-href="{{ route('user.exchangeProducts') }}"
                data-id="{{ $product->id }}"
                data-owner-id="{{ $product->user_id }}"
                data-user-id="{{ optional(Auth::user())->id }}">
                Đổi hàng
            </button>
            @elseif($product->type->value == TypeProductEnums::SECONDHAND->value || $product->type->value == TypeProductEnums::SALE->value)
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
            @elseif($product->type->value == TypeProductEnums::GIVEAWAY->value)
            <div class="gift-btn-wrap">
                <a href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}"
                    class="gift-btn">
                    <i class="fa-solid fa-gift"></i> Nhận quà tặng
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@empty
<div class="text-center w-100 py-5">
    <span style="color: rgb(177, 0, 0);">Không có sản phẩm nào để hiển thị.</span>
</div>
@endforelse
@endif