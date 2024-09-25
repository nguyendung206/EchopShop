<div style="display: block; height: 200px;">
    <h2 style="margin: 15px 0; color: rgba(117,0,0,1)">{{$body}}</h2>
    <p>Tên sản phẩm: {{ $product->name }}</p>
    <p>Giá sản phẩm: {{format_price($product->price)}}</p>
</div>