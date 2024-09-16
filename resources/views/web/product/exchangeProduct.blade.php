@extends('web.layout.app')
@section('title')
    Trao đổi hàng hoá
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/product.css') }}">
@endsection

@section('content')
    <div class="title-line">
        <div class="title-text">Trao đổi hàng hoá</div>
    </div>

    <div class="content container">
        <div class="row">
            @include('web.inc.web_slideProduct')
            <div class="col-lg-9 col-12">
                <div class="row list-product">
                    @forelse($products as $product)
                        <div class="col-lg-4 product-item col-6 text-center py-3">
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
                </div>
            </div>
        </div>
    </div>

@section('script')
<script src="{{ asset('/js/favorite.js')}}"></script>
@endsection

@endsection



