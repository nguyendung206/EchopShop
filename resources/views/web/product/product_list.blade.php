@forelse($products as $product)
<div class="col-lg-4 col-md-6 col-sm-12 product-item text-center py-3">
    <a href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}" class="product-link">
        <div class="product-img-wrapper">
            <img class="product-img" src="{{ getImage($product->photo) }}" alt="{{ $product->name }}">
        </div>
        <p class="product-name pt-2">{{ $product->name }}</p>
        <p class="price color-B10000 pt-2">{{format_price($product->price)}}</p>
    </a>

    @auth
    <a href="#" class="product-heart {{ auth()->user()->favorites->contains('product_id', $product->id) ? 'favorite-active' : '' }}"
        data-url-destroy="{{ route('favorite.destroy', $product->id) }}"
        data-url-store="{{ route('favorite.store') }}"
        data-productId="{{ $product->id }}">
        <i class="fa-{{ auth()->user()->favorites->contains('product_id', $product->id) ? 'solid' : 'regular' }} fa-heart fa-heart-home"></i>
    </a>
    @else
    <a href="{{ route('web.login') }}"><i class="fa-regular fa-heart fa-heart-home"></i></a>
    @endauth

    <div class="product-actions" style="display: block; margin-top: 16px;">
        @if ($product->type->value == 1)
        <a href="#" class="buy chat"><i class="fa-regular fa-comment-dots pr-2"></i>Chat</a>
        <a href="#" class="buy">Trao đổi</a>
        @elseif($product->type->value == 2)
        <a class="buy" href="{{route('web.productdetail.index', ['slug' => $product->slug])}}">Mua ngay</a>
        @endif
    </div>
</div>
@empty
<div class="text-center w-100 py-5">
    <span style="color: rgb(177, 0, 0);">Không có sản phẩm nào để hiển thị.</span>
</div>
@endforelse