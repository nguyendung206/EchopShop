@forelse($products as $product)
<div class="col-lg-4 product-item col-6">
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