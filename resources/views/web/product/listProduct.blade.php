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

@if ($case != 'giveaway')

    @forelse($products as $product)
        <div class="col-custom text-center  product-item">
            <div class="product-wrap">
                <a href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}">
                    <img class="product-img" src="{{ getImage($product->photo) }} " alt="">
                    @auth
                        <a href="#"
                            class='product-heart {{ auth()->user()->load('favorites')->favorites->contains('product_id', $product->id)? 'favorite-active': '' }} '
                            data-url-destroy="{{ route('favorite.destroy', $product->id) }} heart-exchange"
                            data-url-store="{{ route('favorite.store') }}" data-productId="{{ $product->id }}"><i
                                class="fa-{{ auth()->user()->load('favorites')->favorites->contains('product_id', $product->id)? 'solid': 'regular' }} fa-heart fa-heart-home"></i></a>
                    @else
                        <a href="{{ route('web.login') }}"><i
                                class="fa-regular fa-heart fa-heart-home heart-exchange"></i></a>
                    @endauth
                    <p class="product-name pt-2 line-clamp-2">{{ $product->name }}</p>
                    @if ($case == 'exchange' || $case == 'secondhand')
                        <p class="product-brand pt-2 line-clamp-1">Phân loại: <span>brand</span></p>
                        <p class="price product-price color-B10000 pt-2 line-clamp-1">
                            {{ format_price($product->price) }}</p>
                        <div class="user-product-wrap">
                            <img class="mini-avatar" src="{{ asset('/img/image/mini-avt.png') }}" alt="">
                            <div class="user-product ">
                                <p class="line-clamp-1">Trần thị Diễm My &nbsp;<img
                                        src="{{ asset('/img/icon/doc-top.png') }}" alt=""> &nbsp; 1 giờ trước
                                    &nbsp;<img src="{{ asset('/img/icon/doc-top.png') }}" alt="">&nbsp; Thành
                                    Phố huế</p>
                            </div>
                        </div>
                    @endif
                </a>
                <br>
                @if($case == 'exchange')
                        <div class="buy-wrap-exchange">
                            <a class="btn-chat-exchange"
                                href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}"><i
                                    class="fa-regular fa-comment-dots"></i> Chat</a>
                            <a class="btn-buy-exchange"
                                href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}">Đổi hàng</a>
                        </div>

                    @else
                        <div class="buy-wrap">
                            <a href="#" class="btn-chat-product"><i class="fa-regular fa-comment-dots"></i></a>
                            <a href="#" class="btn-cart-product"><i class="fa-solid fa-cart-shopping"></i></a>
                            <a class="btn-buy-product"
                                href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}">Mua
                                ngay</a>
                        </div>

                    @endif
                </div>
            </div>
            @empty
                <div class="text-center w-100 py-5">
                    <span class="" style="color:rgb(177,0,0);">Không có sản phẩm nào để hiển thị.</span>
                </div>
            @endforelse
        @else
            @forelse($products as $product)
                <div class="gift-item m-2">
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
                        <a href="{{ route('web.login') }}"><i class="fa-regular fa-heart fa-heart-home icon-change-2"></i></a>
                    @endauth
                    <div class="gift-name line-clamp-2">
                        {{ $product->name }}
                    </div>
                    <div class="gift-btn-wrap">
                        <a href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}" class="gift-btn">
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
