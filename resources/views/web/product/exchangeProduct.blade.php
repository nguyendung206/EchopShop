@extends('web.layout.app')
@section('title')
    HOME
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('/css/product.css') }}">
@endsection
@section('content')
    <div class="title-line">
        <div class="title-text">MUA BÁN ĐỒ SECONDHAND</div>
    </div>

    <div class="content container">
        <div class="row">
            <div class="col-lg-3 col-12 category-title-wrap-1">
                <div class="category-title-wrap">
                    <div class="category-title">Danh mục sản phẩm</div>
                    <div class="open-icon"><i class="fa-solid fa-arrow-down"></i></div>
                </div>
                @include('web.inc.web_slideProduct')
            </div>
            <div class="col-lg-9 col-12">
                <div class="row list-product">
                    @forelse($products as $product)
                        <div class="col-lg-4 product-item col-6">
                            <div class="product-content">
                                <div class="img-product">

                                    <img src="{{ getImage($product->photo) }}" alt="p1"
                                        style="width: 100%; height: 330px" />
                                    <img src="{{ asset('/img/icon/heart-icon.png') }}" alt="h" />
                                </div>
                                <span class="name-item">{{$product->name}}</span>
                                <span class="price-item">{{$product->price}} đ</span>
                                <div>
                                    <button>Mua ngay</button>
                                </div>
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
@endsection


