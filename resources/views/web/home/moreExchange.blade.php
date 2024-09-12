@foreach($exchangeProducts as $product)
<div class="col-sm-4 col-md-4 col-lg-3 text-center col-6 py-3 product-item">
    <a href="{{ route('web.productdetail.index', ['id' => $product->id]) }}">
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
@endforeach