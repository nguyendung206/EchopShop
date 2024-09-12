@foreach($secondhandProducts as $product)
<div class="col-sm-4 col-md-4 col-lg-3 text-center col-6 py-3 product-item">
    <a href="{{ route('web.productdetail.index', ['id' => $product->id]) }}">
        <img class="product-img" src="{{ getImage($product->photo) }} " alt="">
        <i class="fa-regular fa-heart fa-heart-home"></i>
        <p class="product-name pt-2">{{$product->name}}</p>
        <p class="price color-B10000 pt-2">{{$product->price}} đ</p>
    </a>
    <br>
    <a href="#" class="buy">Mua ngay</a>
</div>
@endforeach