@extends('web.layout.app')
@section('title')
    Hàng cũ đem tặng
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/product.css') }}">
@endsection

@section('content')
    <div class="title-line">
        <div class="title-text">Hàng cũ đem tặng</div>
    </div>

    <div class="content container">
        <div class="row">
            @include('web.inc.web_slideProduct')
            <div class="col-lg-9 col-12">
                <div class="row list-product">
                    @forelse($products as $product)
                    <div class="gift-item m-2">
                    <img src="{{ getImage($product->photo) }}" alt="" class="gift-img">
                    <div class="layer">
                        <img src="{{ asset('/img/image/layer.png') }}" alt="" class="layer">
                        <p>Free</p>
                    </div>
                    @auth
                    <a href="#" class='product-heart {{auth()->user()->load('favorites')->favorites->contains('product_id', $product->id) ? 'favorite-active' : ''}} ' data-url-destroy="{{ route("favorite.destroy", $product->id) }}" data-url-store="{{ route("favorite.store") }}" data-productId="{{$product->id}}"><i class="fa-{{auth()->user()->load('favorites')->favorites->contains('product_id', $product->id) ? 'solid' : 'regular'}} fa-heart fa-heart-home icon-change-2"></i></a>
                    @else
                    <a href="{{route('web.login')}}"><i class="fa-regular fa-heart fa-heart-home icon-change-2"></i></a>
                    @endauth
                    <div class="gift-hover">
                        <div class="layout"></div>
                        <a href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}" class="gift-btn">
                            <i class="fa-solid fa-gift"></i> Nhận quà tặng
                        </a>
                    </div>
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



