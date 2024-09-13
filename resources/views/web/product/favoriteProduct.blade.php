@extends('web.layout.app')
@section('title')
    Hàng yêu thích
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/product.css') }}">
@endsection

@section('content')
    <div class="title-line">
        <div class="title-text">Hàng yêu thích của bạn</div>
    </div>

    <div class="content container">
        <div class="row">
            @include('web.inc.web_slideProduct')
            <div class="col-lg-9 col-12">
                <div class="row list-product">
                    @forelse($products as $favorite)
                        @php
                            $product = $favorite->product;
                        @endphp
                    <div class="col-sm-4 col-md-4 col-lg-3 text-center col-6 py-3 product-item">
                        <img class="product-img" src="{{ getImage($product->photo) }} " alt="">
                        <a href="#" class='product-heart favorite-active' data-url-destroy="{{ route("favorite.destroy", $product->id) }}" data-url-store="{{ route("favorite.store") }}" data-productId="{{$product->id}}"><i class="fa-solid fa-heart fa-heart-home"></i></a>
                        <p class="product-name pt-2">{{$product->name}}</p>
                        <p class="price color-B10000 pt-2">{{$product->price}} đ</p>
                        <br>
                        <a href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}" class="buy">Mua ngay</a>
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



