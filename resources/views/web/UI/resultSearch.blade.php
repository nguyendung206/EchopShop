<ul class="list-group list-product-result">
    <li class="list-group-item active">Sản phẩm </li>
    @forelse ($products as $product)
        <li class="list-group-item"><a href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}">{{$product->name}}</a></li>
    @empty
        <li class="list-group-item">Không có kết quả tương ứng</li>
    @endforelse
  </ul>
  <ul class="list-group list-brand-result">
    <li class="list-group-item active">Thương hiệu</li>
    @forelse ($brands as $brand)
        <li class="list-group-item"><a href="#">{{$brand->name}}</a></li>
    @empty
        <li class="list-group-item">Không có kết quả tương ứng</li>
    @endforelse
  </ul>