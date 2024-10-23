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
                                    {{ format_price($product->price) }}
                                </p>
                                <div class="user-product-wrap">
                                    @if (isset($product->shop))
                                    <img class="mini-avatar" src="{{ getImage($product->shop->logo) }}"
                                        alt="">
                                    <div class="user-product ">
                                        <p class="line-clamp-1">{{ $product->shop->name }} &nbsp;<img
                                                src="{{ asset('/img/icon/doc-top.png') }}"
                                                alt="">&nbsp;
                                            {{ $product->shop->user->defaultAddress?->province->province_name }}
                                        </p>
                                    </div>
                                    @else
                                    <img src="{{ asset('/img/image/logo.png') }}" alt=""
                                        class="mini-avatar-admin">
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
                                <a class="btn-chat-exchange"
                                    href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}"><i
                                        class="fa-regular fa-comment-dots"></i> Chat</a>
                                <a class="btn-buy-exchange"
                                    href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}">Đổi
                                    hàng</a>
                            </div>
                            @break

                            @case(TypeProductEnums::SECONDHAND->value)
                            <div class="buy-wrap">
                                <a href="#" class="btn-chat-product"><i
                                        class="fa-regular fa-comment-dots"></i></a>
                                @auth
                                <a id="btn-cart" href="#" class="btn-cart-product" data-url-add-to-cart="{{ route('cart.store') }}" data-id="{{ $product->id }}">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </a>
                                @else
                                <a href="{{ route('web.login') }}" class="btn-cart-product">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </a>
                                @endauth
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
                @endif
                @if ($case == TypeProductEnums::GIVEAWAY->value && $case != 0)
                @forelse($products as $product)
                <div class="gift-item m-2 col-lg-4 col-6"
                    style="margin-left: 0px !important;margin-right: 0px !important">
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

                @if ($case == 0)
                    @forelse($products as $product)
                    <div class="col-lg-4 product-item col-6 text-center py-3">
                        <a href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}">
                            <img class="product-img" src="{{ getImage($product->photo) }}" alt="{{ $product->name }}">
                            @auth
                            <a href="#" class="product-heart {{ auth()->user()->load('favorites')->favorites->contains('product_id', $product->id) ? 'favorite-active' : '' }}"
                                data-url-destroy="{{ route('favorite.destroy', $product->id) }}"
                                data-url-store="{{ route('favorite.store') }}"
                                data-productId="{{ $product->id }}">
                                <i class="fa-{{ auth()->user()->load('favorites')->favorites->contains('product_id', $product->id) ? 'solid' : 'regular' }} fa-heart fa-heart-home"></i>
                            </a>
                            @else
                            <a href="{{ route('web.login') }}"><i class="fa-regular fa-heart fa-heart-home"></i></a>
                            @endauth
                            <p class="product-name pt-2">{{ $product->name }}</p>
                            <p class="price color-B10000 pt-2">{{format_price($product->price)}}</p>
                        </a>
                        <div class="user-product-wrap my-1">
                            @if (isset($product->shop))
                            <img class="mini-avatar" src="{{ getImage($product->shop->logo) }}"
                                alt="">
                            <div class="user-product ">
                                <p class="line-clamp-1">{{ $product->shop->name }} &nbsp;<img
                                        src="{{ asset('/img/icon/doc-top.png') }}"
                                        alt="">&nbsp;
                                    {{ $product->shop->user->defaultAddress?->province->province_name }}
                                </p>
                            </div>
                            @else
                            <img src="{{ asset('/img/image/logo.png') }}" alt=""
                                class="mini-avatar-admin">
                            <div class="user-product " style="width: 77%">
                                <p class="line-clamp-1">Sản phẩm của echop</p>
                            </div>
                            @endif
                        </div>
                        <div class="product-actions" style="display: block; margin-top: 16px;">
                            @if ($product->type->value == TypeProductEnums::EXCHANGE->value)
                            <a href="#" class="buy chat"><i class="fa-regular fa-comment-dots pr-2"></i>Chat</a>
                            <a href="#" class="buy">Trao đổi</a>
                            @elseif($product->type->value == TypeProductEnums::SECONDHAND->value || $product->type->value == TypeProductEnums::SALE->value)
                            <a class="buy" href="{{route('web.productdetail.index', ['slug' => $product->slug])}}">Mua ngay</a>
                            @elseif($product->type->value == TypeProductEnums::GIVEAWAY->value)
                            <a class="buy" href="{{route('web.productdetail.index', ['slug' => $product->slug])}}">Nhận quà tặng</a>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center w-100 py-5">
                        <span style="color: rgb(177, 0, 0);">Không có sản phẩm nào để hiển thị.</span>
                    </div>
                    @endforelse
                @endif