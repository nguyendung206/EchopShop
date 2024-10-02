@extends('web.layout.app')
@section('title')
HOME
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('/css/product.css') }}">
<link rel="stylesheet" href="{{ asset('/css/product-detail.css') }}">
@endsection
@section('content')
@php
$items = [
[
'label' => 'Echop',
'href' => route('home')
],
[
'label' => $product->type->label(),
'href' => ''
],
[
'label' => $product->name,
]
];

$user = Auth::user();
$cart = $user ? $user->carts : collect();

$totalQuantity = 0;

@endphp
@include('components.breadcrumb', ['items' => $items])
<div class="content">
    <div class="row">
        <div class="col-md-7">
            <div class="row w-100">
                <div class="slider-nav col-md-3">
                    <div>
                        <img src="{{ getImage($product->photo) }}" alt="" class="thumbnail" onclick="changeMainImage('{{ getImage($product->photo) }}')" />
                    </div>
                    @if ($product->list_photo)
                    @foreach (json_decode($product->list_photo) as $index => $photo)
                    <div>
                        <img src="{{ getImage($photo) }}" alt="" class="thumbnail" onclick="changeMainImage('{{ getImage($photo) }}')" />
                    </div>
                    @endforeach
                    @endif
                </div>
                <div class="slider-for col-md-9">
                    <img class="" style="object-fit: cover;" id="main-image" src="{{ getImage($product->photo) }}" alt="Main Product Image" />
                </div>
            </div>
        </div>

        <div class="information-product col-md-5">
            <div class="wrap-heart">
                @auth
                <a href="#" class='product-heart {{auth()->user()->load('favorites')->favorites->contains('product_id', $product->id) ? 'favorite-active' : ''}} ' data-url-destroy="{{ route("favorite.destroy", $product->id) }}" data-url-store="{{ route("favorite.store") }}" data-productId="{{$product->id}}">
                    <i class="fa-{{auth()->user()->load('favorites')->favorites->contains('product_id', $product->id) ? 'solid' : 'regular'}} fa-heart fa-heart-home " style="position: relative; bottom:0; right:0; font-size:24px;"></i>
                </a>
                @else
                <a href="{{route('web.login')}}"><i class="fa-regular fa-heart fa-heart-home"></i></a>
                @endauth
            </div>
            <div class="name-product">
                {{$product->name}}
            </div>
            
            <div class="price-product">{{format_price($product->price)}}</div>
            <div class="detail-product">
                <p>{!! $product->description !!}</p>
            </div>
            <div class="product-unit">
                @if ($product->productUnits[0]->type != TypeProductUnitEnums::ONLYQUANTITY->value)
                <table class="table table-unit">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Màu</th>
                        <th scope="col">SIZE</th>
                        <th scope="col">Còn lại</th>
                      </tr>
                    </thead>
                    <tbody>
                        @forelse ( $product->productUnits as $unit)
                        @php
                            $totalQuantity += $unit->quantity
                        @endphp
                        <tr>

                            <td>{!! $unit->quantity > 0 ? '<input type="radio" name="radio-unit" value="'.$unit->id.'" data-total-product="'.$unit->quantity.'">' : '' !!}</td>
                            <td>{{$unit->color}}</td>
                            <td>{{$unit->size}}</td>
                            <td>{!!$unit->quantity > 0 ? $unit->quantity : '<p class="text-danger"> Hết hàng </p>' !!}</td>
                        </tr>
                        @empty
                            <tr>Chưa có thông tin chi tiết</th>
                            <tr>...</tr>
                            <tr>...</tr>
                            <tr>...</tr>
                        @endforelse
                    </tbody>
                  </table>
                @error('productUnitId')
                    <div class="text-danger py-2">Vui lòng chọn loại hàng.</div>

                @enderror
                @endif
                <div style="display: {{ $product->productUnits[0]->type != typeProductUnitEnums::ONLYQUANTITY->value ? 'none' : 'block' }};" id="divQuantity"><span>Số Lượng</span> 
                    <div class="number-input">
                        <button class="minus">-</button>
                        <input class="quantity" type="number" value="1" min="1" max="100">
                        <button class="plus">+</button>
                    </div>
                    <div class="my-2">
                        <span id="totalProduct">
                            {{ $product->productUnits[0]->type != typeProductUnitEnums::ONLYQUANTITY->value ? $totalQuantity : $product->productUnits[0]->quantity}} Sản phẩm sẵn có 
                        </span>
                        <span id="totalCartProduct"></span>
                    </div>
                        
                </div>
                </div>
            <div class="product-button">
                @if($product->type->value == 1)
                <button>Trao đổi</button>
                @elseif($product->type->value == 2)
                <form action="{{route("cart.store")}}" method="POST" class="d-inline">
                    <input type="hidden" name="productId" value="{{$product->id}}">
                    <input type="hidden" name="productUnitId" id="productUnitId" value="{{$product->productUnits[0]->type != typeProductUnitEnums::ONLYQUANTITY->value ? '' : $product->productUnits[0]->id}}">
                    <input type="hidden" name="quantity" id="quantityValue" value="1">
                    @csrf
                    <button class="text-white">Mua hàng</button>
                </form>
                @auth
                <a id="btn-cart" href="#" class="btn-cart-product" data-url-add-to-cart="{{ route('cart.store') }}" data-id="{{ $product->id }}">
                    Thêm hàng vào giỏ
                </a>
                @else
                <a href="{{ route('web.login') }}" class="btn-cart-product">
                    Thêm hàng vào giỏ
                </a>
                @endauth
                @elseif($product->type->value == 3)
                <button>Nhận quà tặng</button>
                @endif
            </div>

            <div class="product-share">
                <div>Chia sẻ</div>
                <div class="icon-wrap">
                    <div><img src="{{asset('/img/image/logos_facebook.png')}}" alt="" /></div>
                    <div><img src="{{asset('/img/image/logos_instagram.png')}}" alt="" /></div>
                    <div><img src="{{asset('/img/image/logos_twitter.png')}}" alt="" /></div>
                    <div><img src="{{asset('/img/image/logos_messenger.png')}}" alt="" /></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content-2">
    <div class="content-2-wrap container">
        <div class="row w-100">
            <div class="col-12 col-lg-6 content-2-1">
                <div class="content-2-1-avatar">
                    <img src="{{asset('/img/image/avatar-1.png')}}" alt="" />
                </div>
                <div class="content-2-1-wrap">
                    <div class="name-shop">Chillwipes</div>
                    <div class="address-shop">
                        <img src="{{asset('/img/icon/location-product.png')}}" alt="" /> An Cựu,
                        Huế, Thừa Thiên Huế
                    </div>
                    <div>
                        <button>
                            <img src="{{asset('/img/icon/chat-product.png')}}" alt="" /> Chat ngay
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6 content-2-2">
                <div class="content-2-2-wrap">
                    <div class="reviews">
                        Đánh giá
                        <div class="star-wrap">
                            <img src="{{asset('/img/icon/solid-star.png')}}" alt="" />
                            <img src="{{asset('/img/icon/solid-star.png')}}" alt="" />
                            <img src="{{asset('/img/icon/solid-star.png')}}" alt="" />
                            <img src="{{asset('/img/icon/solid-star.png')}}" alt="" />
                            <img src="{{asset('/img/image/thin-star.png')}}" alt="" />
                        </div>
                    </div>
                    <div class="content-2-total">Sản phẩm <b>10</b></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content-3">
    <div class="content-3-title">Mô tả sản phẩm</div>
    <div class="content-3-wrap container">
        <p>{!! $product->description !!}</p>
    </div>
</div>
<div class="content-4">
    <div class="content-4-title">Đánh giá chủ shop</div>
    <div class="content-4-wrap container">
        <div class="row main-content-4 slider responsive multiple-items-1">
            <div class="col-lg-6 reviewr-content">
                <div class="row-1">
                    <div class="row-1-wrap">
                        <div class="row-1-avatar">
                            <img src="{{asset('/img/image/avatar-2.png')}}" alt="" />
                        </div>
                        <div class="row-1-content">
                            <span class="name-reviewer my-1">Ngọc huyền</span>
                            <span class="dob-reviewer my-1">12/10/2023</span>
                            <span class="product-boght my-1"><img src="{{asset('/img/icon/checked.png')}}" alt="" /> Sản phẩm đã
                                mua: <b>Son 3ce</b>,<b>Tẩy trang</b>,<b>sửa rửa mặt</b></span>
                        </div>
                    </div>
                    <div class="row-1-wrap-star">
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/image/thin-star.png')}}" class="star-icon" alt="" />
                    </div>
                </div>
                <div class="row-2">
                    Lorem Ipsum is simply dummy text of the printing and typesetting
                    industry. Lorem Ipsum has been the industry's standard dummy text
                    ever since the 1500s, when an unknown printer took a galley of
                    type and scrambled it to make a type specimen book. It has
                    survived
                </div>
                <div class="row-3">
                    <div class="row-3-wrap">
                        <img src="{{asset('/img/icon/like.png')}}" alt="" />
                        <span>Hữu ích</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 reviewr-content">
                <div class="row-1">
                    <div class="row-1-wrap">
                        <div class="row-1-avatar">
                            <img src="{{asset('/img/image/avatar-2.png')}}" alt="" />
                        </div>
                        <div class="row-1-content">
                            <span class="name-reviewer my-1">Ngọc huyền</span>
                            <span class="dob-reviewer my-1">12/10/2023</span>
                            <span class="product-boght my-1"><img src="{{asset('/img/icon/checked.png')}}" alt="" /> Sản phẩm đã
                                mua: <b>Son 3ce</b>,<b>Tẩy trang</b>,<b>sửa rửa mặt</b></span>
                        </div>
                    </div>
                    <div class="row-1-wrap-star">
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/image/thin-star.png')}}" class="star-icon" alt="" />
                    </div>
                </div>
                <div class="row-2">
                    Lorem Ipsum is simply dummy text of the printing and typesetting
                    industry. Lorem Ipsum has been the industry's standard dummy text
                    ever since the 1500s, when an unknown printer took a galley of
                    type and scrambled it to make a type specimen book. It has
                    survived
                </div>
                <div class="row-3">
                    <div class="row-3-wrap">
                        <img src="{{asset('/img/icon/like.png')}}" alt="" />
                        <span>Hữu ích</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 reviewr-content">
                <div class="row-1">
                    <div class="row-1-wrap">
                        <div class="row-1-avatar">
                            <img src="{{asset('/img/image/avatar-2.png')}}" alt="" />
                        </div>
                        <div class="row-1-content">
                            <span class="name-reviewer my-1">Ngọc huyền</span>
                            <span class="dob-reviewer my-1">12/10/2023</span>
                            <span class="product-boght my-1"><img src="{{asset('/img/icon/checked.png')}}" alt="" /> Sản phẩm đã
                                mua: <b>Son 3ce</b>,<b>Tẩy trang</b>,<b>sửa rửa mặt</b></span>
                        </div>
                    </div>
                    <div class="row-1-wrap-star">
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/image/thin-star.png')}}" class="star-icon" alt="" />
                    </div>
                </div>
                <div class="row-2">
                    Lorem Ipsum is simply dummy text of the printing and typesetting
                    industry. Lorem Ipsum has been the industry's standard dummy text
                    ever since the 1500s, when an unknown printer took a galley of
                    type and scrambled it to make a type specimen book. It has
                    survived
                </div>
                <div class="row-3">
                    <div class="row-3-wrap">
                        <img src="{{asset('/img/icon/like.png')}}" alt="" />
                        <span>Hữu ích</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 reviewr-content">
                <div class="row-1">
                    <div class="row-1-wrap">
                        <div class="row-1-avatar">
                            <img src="{{asset('/img/image/avatar-2.png')}}" alt="" />
                        </div>
                        <div class="row-1-content">
                            <span class="name-reviewer my-1">Ngọc huyền</span>
                            <span class="dob-reviewer my-1">12/10/2023</span>
                            <span class="product-boght my-1"><img src="{{asset('/img/icon/checked.png')}}" alt="" /> Sản phẩm đã
                                mua: <b>Son 3ce</b>,<b>Tẩy trang</b>,<b>sửa rửa mặt</b></span>
                        </div>
                    </div>
                    <div class="row-1-wrap-star">
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/image/thin-star.png')}}" class="star-icon" alt="" />
                    </div>
                </div>
                <div class="row-2">
                    Lorem Ipsum is simply dummy text of the printing and typesetting
                    industry. Lorem Ipsum has been the industry's standard dummy text
                    ever since the 1500s, when an unknown printer took a galley of
                    type and scrambled it to make a type specimen book. It has
                    survived
                </div>
                <div class="row-3">
                    <div class="row-3-wrap">
                        <img src="{{asset('/img/icon/like.png')}}" alt="" />
                        <span>Hữu ích</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 reviewr-content">
                <div class="row-1">
                    <div class="row-1-wrap">
                        <div class="row-1-avatar">
                            <img src="{{asset('/img/image/avatar-2.png')}}" alt="" />
                        </div>
                        <div class="row-1-content">
                            <span class="name-reviewer my-1">Ngọc huyền</span>
                            <span class="dob-reviewer my-1">12/10/2023</span>
                            <span class="product-boght my-1"><img src="{{asset('/img/icon/checked.png')}}" alt="" /> Sản phẩm đã
                                mua: <b>Son 3ce</b>,<b>Tẩy trang</b>,<b>sửa rửa mặt</b></span>
                        </div>
                    </div>
                    <div class="row-1-wrap-star">
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/image/thin-star.png')}}" class="star-icon" alt="" />
                    </div>
                </div>
                <div class="row-2">
                    Lorem Ipsum is simply dummy text of the printing and typesetting
                    industry. Lorem Ipsum has been the industry's standard dummy text
                    ever since the 1500s, when an unknown printer took a galley of
                    type and scrambled it to make a type specimen book. It has
                    survived
                </div>
                <div class="row-3">
                    <div class="row-3-wrap">
                        <img src="{{asset('/img/icon/like.png')}}" alt="" />
                        <span>Hữu ích</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 reviewr-content">
                <div class="row-1">
                    <div class="row-1-wrap">
                        <div class="row-1-avatar">
                            <img src="{{asset('/img/image/avatar-2.png')}}" alt="" />
                        </div>
                        <div class="row-1-content">
                            <span class="name-reviewer my-1">Ngọc huyền</span>
                            <span class="dob-reviewer my-1">12/10/2023</span>
                            <span class="product-boght my-1"><img src="{{asset('/img/icon/checked.png')}}" alt="" /> Sản phẩm đã
                                mua: <b>Son 3ce</b>,<b>Tẩy trang</b>,<b>sửa rửa mặt</b></span>
                        </div>
                    </div>
                    <div class="row-1-wrap-star">
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/image/thin-star.png')}}" class="star-icon" alt="" />
                    </div>
                </div>
                <div class="row-2">
                    Lorem Ipsum is simply dummy text of the printing and typesetting
                    industry. Lorem Ipsum has been the industry's standard dummy text
                    ever since the 1500s, when an unknown printer took a galley of
                    type and scrambled it to make a type specimen book. It has
                    survived
                </div>
                <div class="row-3">
                    <div class="row-3-wrap">
                        <img src="{{asset('/img/icon/like.png')}}" alt="" />
                        <span>Hữu ích</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 reviewr-content">
                <div class="row-1">
                    <div class="row-1-wrap">
                        <div class="row-1-avatar">
                            <img src="{{asset('/img/image/avatar-2.png')}}" alt="" />
                        </div>
                        <div class="row-1-content">
                            <span class="name-reviewer my-1">Ngọc huyền</span>
                            <span class="dob-reviewer my-1">12/10/2023</span>
                            <span class="product-boght my-1"><img src="{{asset('/img/icon/checked.png')}}" alt="" /> Sản phẩm đã
                                mua: <b>Son 3ce</b>,<b>Tẩy trang</b>,<b>sửa rửa mặt</b></span>
                        </div>
                    </div>
                    <div class="row-1-wrap-star">
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/image/thin-star.png')}}" class="star-icon" alt="" />
                    </div>
                </div>
                <div class="row-2">
                    Lorem Ipsum is simply dummy text of the printing and typesetting
                    industry. Lorem Ipsum has been the industry's standard dummy text
                    ever since the 1500s, when an unknown printer took a galley of
                    type and scrambled it to make a type specimen book. It has
                    survived
                </div>
                <div class="row-3">
                    <div class="row-3-wrap">
                        <img src="{{asset('/img/icon/like.png')}}" alt="" />
                        <span>Hữu ích</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 reviewr-content">
                <div class="row-1">
                    <div class="row-1-wrap">
                        <div class="row-1-avatar">
                            <img src="{{asset('/img/image/avatar-2.png')}}" alt="" />
                        </div>
                        <div class="row-1-content">
                            <span class="name-reviewer my-1">Ngọc huyền</span>
                            <span class="dob-reviewer my-1">12/10/2023</span>
                            <span class="product-boght my-1"><img src="{{asset('/img/icon/checked.png')}}" alt="" /> Sản phẩm đã
                                mua: <b>Son 3ce</b>,<b>Tẩy trang</b>,<b>sửa rửa mặt</b></span>
                        </div>
                    </div>
                    <div class="row-1-wrap-star">
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/image/thin-star.png')}}" class="star-icon" alt="" />
                    </div>
                </div>
                <div class="row-2">
                    Lorem Ipsum is simply dummy text of the printing and typesetting
                    industry. Lorem Ipsum has been the industry's standard dummy text
                    ever since the 1500s, when an unknown printer took a galley of
                    type and scrambled it to make a type specimen book. It has
                    survived
                </div>
                <div class="row-3">
                    <div class="row-3-wrap">
                        <img src="{{asset('/img/icon/like.png')}}" alt="" />
                        <span>Hữu ích</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 reviewr-content">
                <div class="row-1">
                    <div class="row-1-wrap">
                        <div class="row-1-avatar">
                            <img src="{{asset('/img/image/avatar-2.png')}}" alt="" />
                        </div>
                        <div class="row-1-content">
                            <span class="name-reviewer my-1">Ngọc huyền</span>
                            <span class="dob-reviewer my-1">12/10/2023</span>
                            <span class="product-boght my-1"><img src="{{asset('/img/icon/checked.png')}}" alt="" /> Sản phẩm đã
                                mua: <b>Son 3ce</b>,<b>Tẩy trang</b>,<b>sửa rửa mặt</b></span>
                        </div>
                    </div>
                    <div class="row-1-wrap-star">
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/image/thin-star.png')}}" class="star-icon" alt="" />
                    </div>
                </div>
                <div class="row-2">
                    Lorem Ipsum is simply dummy text of the printing and typesetting
                    industry. Lorem Ipsum has been the industry's standard dummy text
                    ever since the 1500s, when an unknown printer took a galley of
                    type and scrambled it to make a type specimen book. It has
                    survived
                </div>
                <div class="row-3">
                    <div class="row-3-wrap">
                        <img src="{{asset('/img/icon/like.png')}}" alt="" />
                        <span>Hữu ích</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 reviewr-content">
                <div class="row-1">
                    <div class="row-1-wrap">
                        <div class="row-1-avatar">
                            <img src="{{asset('/img/image/avatar-2.png')}}" alt="" />
                        </div>
                        <div class="row-1-content">
                            <span class="name-reviewer my-1">Ngọc huyền</span>
                            <span class="dob-reviewer my-1">12/10/2023</span>
                            <span class="product-boght my-1"><img src="{{asset('/img/icon/checked.png')}}" alt="" /> Sản phẩm đã
                                mua: <b>Son 3ce</b>,<b>Tẩy trang</b>,<b>sửa rửa mặt</b></span>
                        </div>
                    </div>
                    <div class="row-1-wrap-star">
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/image/thin-star.png')}}" class="star-icon" alt="" />
                    </div>
                </div>
                <div class="row-2">
                    Lorem Ipsum is simply dummy text of the printing and typesetting
                    industry. Lorem Ipsum has been the industry's standard dummy text
                    ever since the 1500s, when an unknown printer took a galley of
                    type and scrambled it to make a type specimen book. It has
                    survived
                </div>
                <div class="row-3">
                    <div class="row-3-wrap">
                        <img src="{{asset('/img/icon/like.png')}}" alt="" />
                        <span>Hữu ích</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 reviewr-content">
                <div class="row-1">
                    <div class="row-1-wrap">
                        <div class="row-1-avatar">
                            <img src="{{asset('/img/image/avatar-2.png')}}" alt="" />
                        </div>
                        <div class="row-1-content">
                            <span class="name-reviewer my-1">Ngọc huyền</span>
                            <span class="dob-reviewer my-1">12/10/2023</span>
                            <span class="product-boght my-1"><img src="{{asset('/img/icon/checked.png')}}" alt="" /> Sản phẩm đã
                                mua: <b>Son 3ce</b>,<b>Tẩy trang</b>,<b>sửa rửa mặt</b></span>
                        </div>
                    </div>
                    <div class="row-1-wrap-star">
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/image/thin-star.png')}}" class="star-icon" alt="" />
                    </div>
                </div>
                <div class="row-2">
                    Lorem Ipsum is simply dummy text of the printing and typesetting
                    industry. Lorem Ipsum has been the industry's standard dummy text
                    ever since the 1500s, when an unknown printer took a galley of
                    type and scrambled it to make a type specimen book. It has
                    survived
                </div>
                <div class="row-3">
                    <div class="row-3-wrap">
                        <img src="{{asset('/img/icon/like.png')}}" alt="" />
                        <span>Hữu ích</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 reviewr-content">
                <div class="row-1">
                    <div class="row-1-wrap">
                        <div class="row-1-avatar">
                            <img src="{{asset('/img/image/avatar-2.png')}}" alt="" />
                        </div>
                        <div class="row-1-content">
                            <span class="name-reviewer my-1">Ngọc huyền</span>
                            <span class="dob-reviewer my-1">12/10/2023</span>
                            <span class="product-boght my-1"><img src="{{asset('/img/icon/checked.png')}}" alt="" /> Sản phẩm đã
                                mua: <b>Son 3ce</b>,<b>Tẩy trang</b>,<b>sửa rửa mặt</b></span>
                        </div>
                    </div>
                    <div class="row-1-wrap-star">
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/image/thin-star.png')}}" class="star-icon" alt="" />
                    </div>
                </div>
                <div class="row-2">
                    Lorem Ipsum is simply dummy text of the printing and typesetting
                    industry. Lorem Ipsum has been the industry's standard dummy text
                    ever since the 1500s, when an unknown printer took a galley of
                    type and scrambled it to make a type specimen book. It has
                    survived
                </div>
                <div class="row-3">
                    <div class="row-3-wrap">
                        <img src="{{asset('/img/icon/like.png')}}" alt="" />
                        <span>Hữu ích</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="pagination-1">
          <img src="{{asset('/img/image/pagination.png')}}" alt="" />
        </div> -->
    </div>
</div>
<div class="content-5">
    <div class="content-5-title">Xem thêm sản phẩm</div>
    <div class="content-5-wrap container">
        <div class="row main-content-5 responsive slider multiple-items-2">
            <div class="col-lg-3 product-item">
                <div class="product-content">
                    <div class="img-product">
                        <img src="{{asset('/img/image/p-more-1.png')}}" alt="p4" />
                        <img src="{{asset('/img/icon/heart-solid.png')}}" alt="h" />
                    </div>
                    <span class="name-item">Giày sneaker AF1 âm dương phat...</span>
                    <span class="price-item">250.000 đ</span>
                    <div>
                        <button>Mua ngay</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 product-item">
                <div class="product-content">
                    <div class="img-product">
                        <img src="{{asset('/img/image/p-more-2.png')}}" alt="p4" />
                        <img src="{{asset('/img/icon/heart-icon.png')}}" alt="h" />
                    </div>
                    <span class="name-item">Áo khoác hoodie croptop dài tay c...</span>
                    <span class="price-item">450.000 đ</span>
                    <div>
                        <button>Mua ngay</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 product-item">
                <div class="product-content">
                    <div class="img-product">
                        <img src="{{asset('/img/image/p-more-3.png')}}" alt="p4" />
                        <img src="{{asset('/img/icon/heart-icon.png')}}" alt="h" />
                    </div>
                    <span class="name-item">Giày cao gót nữ LCC62 gót vuông...</span>
                    <span class="price-item">650.000 đ</span>
                    <div>
                        <button>Mua ngay</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 product-item">
                <div class="product-content">
                    <div class="img-product">
                        <img src="{{asset('/img/image/p-more-4.png')}}" alt="p4" />
                        <img src="{{asset('/img/icon/heart-icon.png')}}" alt="h" />
                    </div>
                    <span class="name-item">Điện thoại IP14 Pro Max màu tím...</span>
                    <span class="price-item">5.450.000 đ</span>
                    <div>
                        <button>Mua ngay</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 product-item">
                <div class="product-content">
                    <div class="img-product">
                        <img src="{{asset('/img/image/p-more-4.png')}}" alt="p4" />
                        <img src="{{asset('/img/icon/heart-icon.png')}}" alt="h" />
                    </div>
                    <span class="name-item">Điện thoại IP14 Pro Max màu tím...</span>
                    <span class="price-item">5.450.000 đ</span>
                    <div>
                        <button>Mua ngay</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 product-item">
                <div class="product-content">
                    <div class="img-product">
                        <img src="{{asset('/img/image/p-more-4.png')}}" alt="p4" />
                        <img src="{{asset('/img/icon/heart-icon.png')}}" alt="h" />
                    </div>
                    <span class="name-item">Điện thoại IP14 Pro Max màu tím...</span>
                    <span class="price-item">5.450.000 đ</span>
                    <div>
                        <button>Mua ngay</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="{{asset('/slick/slick.min.js')}}"></script>

<script>

    

    $(".multiple-items-1").slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 4,
        infinite: false,
        prevArrow: "<button type='button' class='slick-prev pull-left'><i class='fa-solid fa-angle-left'></i></button>",
        nextArrow: "<button type='button' class='slick-next pull-right'><i class='fa-solid fa-angle-right'></i></button>",
        responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: true,
                },
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                },
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                },
            },
        ],
    });
    $(".multiple-items-2").slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 4,
        infinite: false,
        prevArrow: "<button type='button' class='slick-prev pull-left'><i class='fa-solid fa-angle-left'></i></button>",
        nextArrow: "<button type='button' class='slick-next pull-right'><i class='fa-solid fa-angle-right'></i></button>",
        responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: true,
                },
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                },
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                },
            },
        ],
    });
</script>

<script>
    var totalProduct = 0;
    var quantityCart = 0;
    
    if(@json(isset($product->productUnits[0]) && $product->productUnits[0]->type == typeProductUnitEnums::ONLYQUANTITY->value)){
        totalProduct = @json($product->productUnits[0]->quantity);

        @json($cart).forEach(item => {
            if(@json($product->productUnits[0]-> id) == item.product_unit_id){
                quantityCart = item.quantity;
                $('#totalCartProduct').text(" | " + quantityCart + " sản phẩm đã có trong giỏ.");
            }
        })
        
    }


    $(document).ready(function() {
        $(".slider-nav").slick({
            slidesToShow: 4,
            slidesToScroll: 2,
            vertical: true,
            verticalSwiping: true,
            dots: false,
            focusOnSelect: true,
            infinite: false,
            arrows: false,
        });

        $(".slider-nav").on('wheel', function(e) {
            e.preventDefault();
            if (e.originalEvent.deltaY < 0) {
                $(this).slick('slickPrev');
            } else {
                $(this).slick('slickNext');
            }
        });

        $('.quantity').on('change', function() {
            let quantity = $(this).val();
            
            if(quantity > totalProduct - quantityCart) {
                $(this).val(totalProduct - quantityCart);
            }
            if(quantity < 1) {
                $(this).val(1);
            }
        });

        $(".plus").on("click", function() {
        
            const input = $(this).prev(".quantity")
            let currentValue = parseInt(input.val()) || 0;
            if (currentValue < totalProduct) {
                currentValue += 1;
                if (currentValue > totalProduct - quantityCart) {
                    currentValue = totalProduct - quantityCart;
                }
                input.val(currentValue);
            }
            $('#quantityValue').val(currentValue);
        });

        $(".minus").on("click", function() {
            const input = $(this).next(".quantity");
            let currentValue = parseInt(input.val()) || 0;

            if (currentValue > 1) {
                currentValue -= 1;
                input.val(currentValue);
                $('#quantityValue').val(currentValue);
            }
        });

        $('input[name="radio-unit"]').change(function() {
            $('#divQuantity').fadeIn();
            var selectedUnitId = $(this).val();
            totalProduct = $(this).data('total-product');
            
            if($('.quantity').val() > totalProduct) {
                $('.quantity').val(totalProduct);
            }
            $('#totalProduct').text("Hiện có " + totalProduct + " sản phẩm loại này");

            let carts = @json($cart);

            quantityCart  = null;
            carts.forEach(cart => {
                if (cart.product_unit_id == selectedUnitId) {
                    quantityCart = cart.quantity;  // Lấy ra số lượng sản phẩm đã có trong giỏ
                } 
            });
            
            if(quantityCart) {
                $('#totalCartProduct').text(" | " + quantityCart + " sản phẩm đã có trong giỏ.");
                $('#totalCartProduct').fadeIn();
            } else {
                $('#totalCartProduct').fadeOut();
            }
            $('.quantity').trigger('change');
            
            $('#productUnitId').val(selectedUnitId);
        });
    });

    function changeMainImage(imageSrc) {
        document.getElementById('main-image').src = imageSrc;
    }
</script>
<script src="{{ asset('/js/favorite.js') }}"></script>
<script src="{{ asset('/js/cart.js')}}"></script>
@endsection
@endsection