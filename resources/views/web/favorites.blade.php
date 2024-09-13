<div class="container py-5">
    <div class="category pt-2">
        <div class="container">
            <br>
            <h1>Sản phẩm yêu thích của bạn</h1>
            <div class="test"></div>
            <hr>
        </div>
    </div>
    <div class="row favorite-list">
        @forelse($favorites as $favorite)
            @php
                $product = $favorite->product; // Truy cập đối tượng product liên quan
            @endphp
        <div class="col-sm-4 col-md-4 col-lg-3 text-center col-6 py-3 product-item">
            <img class="product-img" src="{{ getImage($product->photo) }} " alt="">
            <a href="#" class='product-heart favorite-active' data-url-destroy="{{ route("favorite.destroy", $product->id) }}" data-url-store="{{ route("favorite.store") }}" data-productId="{{$product->id}}"><i class="fa-solid fa-heart fa-heart-home"></i></a>
            <p class="product-name pt-2">{{$product->name}}</p>
            <p class="price color-B10000 pt-2">{{format_price($product->price)}}</p>
            <br>
            <a href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}" class="buy">Mua ngay</a>
        </div>
        @empty 
            <div class="text-center w-100 py-5">
                <span class="" style="color:rgb(177,0,0);">Không có sản phẩm nào để hiển thị.</span>
            </div>
        @endforelse
    </div>
    @if(auth()->user()->load('favorites')->favorites->isNotEmpty())
    <div class="text-center py-5 divMoreFavorite">
        @if(auth()->user()->load('favorites')->favorites->count() > 8)
        <a id="btnMoreFavorite" class="all color-B10000" href="#" data-url ='{{route('web.profile.index', Session::get('user')->id)}}' >Xem thêm <i class="fa-solid fa-angles-down"></i></a>
        @endif
        <a class="all color-B10000" href="{{ route('favoriteProduct')}}" >Xem tất cả <i class="fa-solid fa-angles-right"></i></a>
    </div>
    @endif
</div>
@section('script')

<script src="{{ asset('/js/favorite.js') }}"></script>

<script>
            var currentPage = 1;
            $('#btnMoreFavorite').click(function(event) {
                var url = $(this).data('url');
                event.preventDefault();
                currentPage++;
                
                $.ajax({
                    url: url,
                    method: 'GET',
                    data: {
                        page: currentPage
                    },
                    success: function(response) {
                        var productsHtml = '';
                        
                        $('.favorite-list').append(response.products); 
                        if (response.hasMorePage) {
                            $('#btnMoreFavorite').hide(); 
                            $('.end-of-products-Favorite').show(); 
                        }
                    },
                    error: function(xhr, status, error) {
                        
                }
                });
            });
</script>
@endsection
