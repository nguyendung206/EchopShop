@foreach($exchangeProducts as $product)
<div class="col-sm-4 col-md-4 col-lg-3 text-center col-6 py-3 product-item">
    <img class="product-img" src="{{ getImage($product->photo) }}" alt="">
    <i class="fa-regular fa-heart fa-heart-home icon-change"></i>
    <p class="product-name pt-2">{{$product->name}}</p>
    <br>
    <a href="#" class="buy chat"><i class="fa-regular fa-comment-dots pr-2"></i>Chat</a>
    <a href="#" class="buy">Trao đổi</a>
</div>
@endforeach