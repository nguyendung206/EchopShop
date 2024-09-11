@forelse($favorites as $favorite)
        @php
            $product = $favorite->product; // Truy cập đối tượng product liên quan
        @endphp
    <div class="col-sm-4 col-md-4 col-lg-3 text-center col-6 py-3 product-item">
        <img class="product-img" src="{{ getImage($product->photo) }} " alt="">
        <a href="#" class='product-heart favorite-active' data-url-destroy="{{ route("favorite.destroy", $product->id) }}" data-url-store="{{ route("favorite.store") }}" data-productId="{{$product->id}}"><i class="fa-solid fa-heart fa-heart-home"></i></a>
        <p class="product-name pt-2">{{$product->name}}</p>
        <p class="price color-B10000 pt-2">{{$product->price}} đ</p>
        <br>
        <a href="#" class="buy">Mua ngay</a>
    </div>
    @empty 
        <div class="text-center w-100 py-5">
            <span class="" style="color:rgb(177,0,0);">Không có sản phẩm nào để hiển thị.</span>
    </div>
@endforelse
