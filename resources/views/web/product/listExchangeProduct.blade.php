@foreach($exchangeProducts as $product)
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
            <p class="product-brand pt-2 line-clamp-1">Phân loại: <span>{{ $product->brand->name ?? "" }}</span></p>
            <p class="price product-price color-B10000 pt-2 line-clamp-1">{{ format_price($product->price) }}</p>
            <div class="user-product-wrap d-flex align-items-center">
                @if (isset($product->shop))
                <img class="mini-avatar mr-2" src="{{getImage($product->shop->logo)}}" alt="">
                <div class="user-product ">
                    <p class="line-clamp-1">{{$product->shop->name}} &nbsp;<img src="{{asset('/img/icon/doc-top.png')}}" alt="">&nbsp; {{$product->shop->user->defaultAddress?->province->province_name}}</p>
                </div>
                @else
                <img src="{{asset("/img/image/logo.png")}}" alt="" class="mini-avatar-admin">
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

@endforeach