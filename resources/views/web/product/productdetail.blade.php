@extends('web.layout.app')
@section('title')
HOME
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('/css/product.css') }}">
<link rel="stylesheet" href="{{ asset('/css/product-detail.css') }}">
<style>
    .column {
        float: left;
        width: 25%;
    }

    /* The Modal (background) */
    .custom-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        padding-top: 100px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: #000000a3;
    }

    /* Modal Content */
    .custom-modal-content {
        position: relative;
        background-color: #fefefe;
        margin: auto;
        padding: 0;
        width: 90%;
        max-width: 400px;
    }

    /* The Close Button */
    .custom-close {
        color: white;
        position: absolute;
        top: 10px;
        right: 25px;
        font-size: 35px;
        font-weight: bold;
    }

    .custom-close:hover,
    .custom-close:focus {
        color: #999;
        text-decoration: none;
        cursor: pointer;
    }

    .custom-mySlides {
        display: none;
    }

    .custom-cursor {
        cursor: pointer;
    }

    /* Next & previous buttons */
    .custom-prev,
    .custom-next {
        cursor: pointer;
        position: absolute;
        top: 50%;
        width: auto;
        padding: 16px;
        margin-top: -50px;
        color: white !important;
        font-weight: bold;
        font-size: 20px;
        transition: 0.6s ease;
        border-radius: 0 3px 3px 0;
        user-select: none;
        -webkit-user-select: none;
    }

    /* Position the "next button" to the right */
    .custom-next {
        right: 0;
        border-radius: 3px 0 0 3px;
    }

    /* On hover, add a black background color with a little bit see-through */
    .custom-prev:hover,
    .custom-next:hover {
        background-color: rgba(0, 0, 0, 0.8);
    }

    /* Number text (1/3 etc) */
    .custom-numbertext {
        color: #f2f2f2;
        font-size: 16px;
        padding: 8px 12px;
        position: absolute;
        top: -26px;
        left: -12px;
    }

    .custom-caption-container {
        text-align: center;
        background-color: black;
        padding: 2px 16px;
        color: white;
    }

    .custom-demo {
        opacity: 0.6;
    }

    .custom-active,
    .custom-demo:hover {
        opacity: 1;
    }

    img.hover-shadow {
        transition: 0.3s;
    }

    .hover-shadow:hover {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }
</style>
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
        <div class="col-lg-7 col-md-12">
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

        <div class="information-product col-lg-5 col-md-12">
            <div class="responsive-width">
                <div class="wrap-heart mb-4">
                    @auth
                    <a style="top: 4px;" href="#" class='product-heart {{auth()->user()->load('favorites')->favorites->contains('product_id', $product->id) ? 'favorite-active' : ''}} ' data-url-destroy="{{ route("favorite.destroy", $product->id) }}" data-url-store="{{ route("favorite.store") }}" data-productId="{{$product->id}}">
                        <i class="fa-{{auth()->user()->load('favorites')->favorites->contains('product_id', $product->id) ? 'solid' : 'regular'}} fa-heart fa-heart-home " style="position: relative; bottom:0; right:0; font-size:24px;"></i>
                    </a>
                    @else
                    <a style="top: 4px;" href="{{route('web.login')}}" class="product-heart"><i class="fa-regular fa-heart fa-heart-home" style="position: relative; bottom:0; right:0; font-size:24px;"></i></a>
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
                    @if (empty($product->getProductUnitTypeOne()))
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
                            @foreach ( $product->productUnits as $unit)
                            @php
                            $totalQuantity += $unit->quantity
                            @endphp
                            <tr>
                                <td>{!! $unit->quantity > 0 ? '<input type="radio" name="radio-unit" value="'.$unit->id.'" data-total-product="'.$unit->quantity.'" data-size="'.$unit->size.'" data-color="'.$unit->color.'">' : '' !!}</td>
                                <td>{{$unit->color}}</td>
                                <td>{{$unit->size}}</td>
                                <td>{!!$unit->quantity > 0 ? $unit->quantity : '<p class="text-danger"> Hết hàng </p>' !!}</td>
                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                    @error('productUnitId')
                    <div class="text-danger py-2">Vui lòng chọn loại hàng.</div>

                    @enderror
                    @endif
                    <div style="display: {{ empty($product->getProductUnitTypeOne()) ? 'none' : 'block' }};" id="divQuantity"><span>Số Lượng</span>
                        <div class="number-input">
                            <button class="minus">-</button>
                            <input class="quantity" type="number" value="1" min="1" max="100">
                            <button class="plus">+</button>
                        </div>
                        <div class="my-2">
                            <span id="totalProduct">
                                {{ empty($product->getProductUnitTypeOne()) ? $totalQuantity : $product->getProductUnitTypeOne()->quantity}} Sản phẩm sẵn có
                            </span>
                            <span id="totalCartProduct"></span>
                        </div>

                    </div>
                </div>
                <div class="product-button">
                    @if($product->type->value == 1)
                    <button class="btn-buy-exchange exchange"
                        data-href="{{ route('user.exchangeProducts') }}"
                        data-id="{{ $product->id }}"
                        data-owner-id="{{ $product->user_id }}"
                        data-user-id="{{ optional(Auth::user())->id }}">
                        Đổi hàng
                    </button>
                    @elseif($product->type->value == TypeProductEnums::SECONDHAND->value || $product->type->value == TypeProductEnums::SALE->value)
                    @auth
                    <form action="{{ route('cart.store') }}" method="POST" class="d-inline" id="cartForm">
                        @csrf
                        <input type="hidden" name="productId" id="modalProductId" value="{{ $product->id }}">
                        <input type="hidden" name="type" value="{{ $product->type }}">
                        <input type="hidden" name="productUnitId" id="productUnitId"
                            value="{{ optional($product->getProductUnitTypeOne())->id }}">
                        <input type="hidden" name="quantity" id="quantityInput" value="1">

                        <button type="button" id="saveSelectedUnit"
                            data-add-to-cart="{{ route('cart.store') }}"
                            class="text-white">Thêm hàng vào giỏ hàng</button>
                    </form>
                    @else
                    <a href="{{ route('web.login') }}" class="btn-cart-product mr-2" style="padding: 11px 54px;">
                        Thêm hàng vào giỏ
                    </a>
                    @endauth
                    <a href="#" class="btn-cart-product" style="padding: 11px 54px;" data-url-add-to-cart="{{ route('cart.store') }}" data-id="{{ $product->id }}" data-url-check="{{ route('cart.check') }}">
                        Mua hàng
                    </a>
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
    <div class="content-4-title mb-4">Đánh giá sản phẩm</div>
    <div class="container">
        <div class="rating d-flex align-items-center" style="border: 1px solid #dedede; border-radius: 5px;">
            <div class="rating-avg" style="width: 20%; position: relative;">
                <span class="fa fa-star mx-auto text-center" style="font-size: 100px; color: #FCC500; display: block;"></span>
                <b class="text-white" style="font-size: 20px; position: absolute; top: 50%; left:50%; transform: translateX(-50%) translateY(-50%);">{{round($product->ratings()->avg('star'), 1);}}</b>
            </div>
            <div class="rating-list p-3" style="width: 60%">
                @php
                $ratings = $product->ratings;
                $totalRatings = $ratings->count();
                $ratingCount = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];

                foreach ($ratings as $rating) {
                $ratingCount[$rating->star]++;
                }
                @endphp

                @for($i = 1; $i <= 5; $i++)
                    @php
                    $percentage=$totalRatings> 0 ? ($ratingCount[$i] / $totalRatings) * 100 : 0;
                    @endphp

                    <div class="item-rating d-flex align-items-center my-2">
                        <div style="width: 5%; font-size: 16px;">
                            {{$i}} <span class="fa fa-star" style="color: #FCC500;"></span>
                        </div>
                        <div class="mx-3" style="width: 75%;">
                            <span class="w-100" style="height: 8px; display: block; border: 1px solid #dedede;border-radius: 5px; background-color: #dedede;">
                                <b style="width: {{ $percentage }}%; background-color: #FCC500; height: 100%; display: block; border-radius: 5px;"></b>
                            </span>
                        </div>
                        <div style="width: 20%;">
                            <span>{{ $ratingCount[$i] }} đánh giá</span>
                        </div>
                    </div>
                    @endfor
            </div>
            @if($isPurchased && !$isShopOwner)
            @if($hasRated)
            <div style="width: 20%;">
                <span style="padding: 8px 20px; background: #fff; color: #000; border-radius: 5px; border: 1px solid #000;">
                    Bạn đã Đánh giá rồi!
                </span>
            </div>
            @else
            <div style="width: 20%;">
                <a style="padding: 8px 20px; background: #b10000; color: #fff; border-radius: 5px;" href="#" data-toggle="modal" data-target="#reviewModal">
                    Gửi đánh giá của bạn
                </a>
            </div>
            @endif
            @endif
        </div>
    </div>

    <div class="content-4-wrap container">
        <div class="row main-content-4 slider multiple-items-1">
            @foreach($ratings as $rating)
            <div class="reviewr-content" style="height: 270px;">
                <div class="row-1">
                    <div class="row-1-wrap align-items-center">
                        <div class="row-1-avatar">
                            <img src="{{getImage($rating->user->avatar)}}" style="border-radius: 50%; width:70px; height: 70px; object-fit: cover;" alt="" />
                        </div>
                        <div class="row-1-content ml-2">
                            <span class="name-reviewer">{{$rating->user->name}}</span>
                            <span class="product-boght my-2">
                                Tên sản phẩm: <b>{{$rating->product->name}}</b></span>
                            <span class="dob-reviewer">{{$rating->created_at}}</span>
                        </div>
                    </div>
                    <div class="row-1-wrap-star">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <=$rating->star)
                            <img src="{{ asset('/img/icon/solid-star.png') }}" class="star-icon" alt="" />
                            @else
                            <img src="{{ asset('/img/image/thin-star.png') }}" class="star-icon" alt="" />
                            @endif
                            @endfor
                    </div>
                </div>
                <div class="row-2">
                    {{$rating->content}}
                </div>
                <div class="row align-items-center">
                    @if(isset($rating->media) && !empty($rating->media))
                    @php
                    $mediaItems = json_decode($rating->media, true);
                    $visibleItems = array_slice($mediaItems, 0, 4);
                    $hiddenCount = count($mediaItems) - count($visibleItems);
                    @endphp
                    @foreach ($visibleItems as $index => $media)
                    <div class="media-item m-2" data-index="{{ $index }}" style="cursor: pointer; position: relative;"
                        onclick="openModal({{ json_encode($mediaItems) }}, {{ $index + 1 }})">
                        @if (strpos($media, '.mp4') !== false || strpos($media, '.avi') !== false || strpos($media, '.mov') !== false || strpos($media, '.wmv') !== false)
                        <video width="120" height="120" controls>
                            <source src="{{ getVideo($media) }}" type="video/mp4">
                        </video>
                        @else
                        <img src="{{ getImage($media) }}" class="img-fluid"
                            style="width: 120px; height: 120px; object-fit: cover;" alt="Rating Photo" />
                        @endif

                        @if ($index === count($visibleItems) - 1 && $hiddenCount > 0)
                        <div class="d-flex justify-content-center align-items-center"
                            style="position: absolute; top: 0; bottom: 0; left: 0; right: 0; background-color: #3a3a3a80;">
                            <span class="text-white" style="font-size: 24px;">+ {{ $hiddenCount }}</span>
                        </div>
                        @endif
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<div class="content-5">
    <div class="content-5-title">Xem thêm sản phẩm</div>
    <div class="content-5-wrap container">
        <div class="main-content-5 responsive slider multiple-items-2">
            @foreach ($relatedProducts as $relatedProduct)
            <div class="product-wrap product-item-category mx-2">
                <a href="{{ route('web.productdetail.index', ['slug' => $relatedProduct->slug]) }}">
                    <div style="position: relative;">
                        <img class="product-img" src="{{ getImage($relatedProduct->photo) }} " alt="">
                        @auth
                        <a href="#"
                            class='product-heart {{ auth()->user()->load('favorites')->favorites->contains('product_id', $relatedProduct->id)? 'favorite-active': '' }} '
                            data-url-destroy="{{ route('favorite.destroy', $relatedProduct->id) }}"
                            data-url-store="{{ route('favorite.store') }}" data-productId="{{ $relatedProduct->id }}"><i
                                class="fa-{{ auth()->user()->load('favorites')->favorites->contains('product_id', $relatedProduct->id)? 'solid': 'regular' }} fa-heart fa-heart-home"></i></a>
                        @else
                        <a href="{{ route('web.login') }}" class="product-heart"><i class="fa-regular fa-heart fa-heart-home"></i></a>
                        @endauth
                    </div>
                    <p class="product-name pt-2 line-clamp-2 text-center">{{ $relatedProduct->name }}</p>
                    <p class="product-brand pt-2 line-clamp-1">Phân loại: <span>{{ $relatedProduct->brand->name ?? '' }}</span></p>
                    <p class="price product-price color-B10000 pt-2 line-clamp-1">{{ format_price($relatedProduct->price) }}</p>

                    <div class="user-product-wrap d-flex align-items-center">
                        @if (isset($relatedProduct->shop))
                        <img class="mini-avatar mr-2" src="{{ getImage($relatedProduct->shop->logo) }}" alt="">
                        <div class="user-product">
                            <p class="line-clamp-1">{{ $relatedProduct->shop->name }} &nbsp;
                                <img src="{{ asset('/img/icon/doc-top.png') }}" alt="" style="position: relative;">
                                &nbsp; {{ $relatedProduct->shop->province?->province_name }}
                            </p>
                        </div>
                        @else
                        <img src="{{ asset('/img/image/logo.png') }}" alt="" class="mini-avatar-admin mr-2">
                        <div class="user-product" style="width: 77%">
                            <p class="line-clamp-1">Sản phẩm của echop</p>
                        </div>
                        @endif
                    </div>
                </a>

                <br>
                @if($relatedProduct->type->value == TypeProductEnums::SECONDHAND->value )
                <div class="buy-wrap">
                    <a href="#" class="btn-chat-product text-center"><i class="fa-regular fa-comment-dots"></i></a>
                    @auth
                    <a id="btn-cart" href="#" class="btn-cart-product btn-cart text-center"
                        data-url-add-to-cart="{{ route('cart.store') }}"
                        data-id="{{ $relatedProduct->id }}"
                        data-productunitid="{{ !empty($relatedProduct->getProductUnitTypeOne()) ? $relatedProduct->getProductUnitTypeOne()->id : 0 }}"
                        data-url-check="{{ route('cart.check') }}">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </a>
                    @else
                    <a href="{{ route('web.login') }}" class="btn-cart-product text-center">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </a>
                    @endauth

                    <a class="btn-buy-product" href="{{ route('web.productdetail.index', ['slug' => $relatedProduct->slug]) }}">
                        Mua ngay
                    </a>
                </div>
                @elseif($relatedProduct->type->value == TypeProductEnums::EXCHANGE->value)
                <div class="buy-wrap-exchange">
                    @auth
                    <a class="btn-chat-exchange" href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}"><i class="fa-regular fa-comment-dots"></i> Chat</a>
                    <button class="btn-buy-exchange exchange"
                        data-href="{{ route('user.exchangeProducts') }}"
                        data-id="{{ $product->id }}"
                        data-owner-id="{{ $product->user_id }}"
                        data-user-id="{{ optional(Auth::user())->id }}">
                        Đổi hàng
                    </button>
                    @else
                    <a class="btn-chat-exchange" href="{{ route('web.login') }}"><i class="fa-regular fa-comment-dots"></i> Chat</a>
                    <a class="btn-buy-exchange" href="{{ route('web.login') }}">Đổi hàng</a>
                    @endauth
                </div>
                @endif
            </div>
            @endforeach

        </div>
    </div>
</div>

<!-- Modal đánh giá -->
<div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="height: auto; max-width: 700px;">
        <div class="modal-content">
            <div class="modal-header" style="border: none;">
                <h5 class="modal-title mt-4 ml-4" id="reviewModalLabel"
                    style="font-size: 20px; font-weight: 500; line-height: 28px; color: #222222;">
                    Đánh giá sản phẩm
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body px-5 pb-4">
                <form action="{{ route('rating.store') }}" method="post" id="reviewForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="user_id" value="{{ auth()->check() ? auth()->user()->id : '' }}">

                    <div class="form-group text-center">
                        <h1 style="font-size: 28px; font-weight: 400; line-height: 28px; color: #222222;">
                            Để lại đánh giá của bạn
                        </h1>
                        <p class="my-4" style="font-weight: 400; line-height: 28px; color: #222222;">
                            Nhấp vào các ngôi sao để đánh giá chúng tôi
                        </p>
                        <div class="item-rating row align-items-center my-2 justify-content-center">
                            <span class="mx-2 list-star" style="font-size: 50px;">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa fa-star" data-key="{{ $i }}" style="cursor: pointer;"></i>
                                    @endfor
                            </span>
                            <input class="number-rating" type="hidden" name="star" value="{{ old('star') }}">
                        </div>
                        @error('star')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mt-4 d-flex flex-column align-items-center my-2 justify-content-center">
                        <div class="d-flex">
                            <div class="mr-4" id="photoImageContainer">
                                <label for="photoImageInput">
                                    <img src="{{ asset('/img/image/upload.png') }}" alt="Ảnh sản phẩm"
                                        class="upload-img" style="cursor: pointer; object-fit: cover; margin: 0;">
                                </label>
                                <input type="file" id="photoImageInput" name="photos[]" multiple
                                    style="display: none;" accept="image/*"
                                    onchange="previewImages(event, 'photoPreviewList')">
                            </div>

                            <div id="videoContainer">
                                <label for="videoInput">
                                    <img src="{{ asset('/img/image/video.png') }}" alt="Video sản phẩm"
                                        class="upload-img" style="cursor: pointer; object-fit: cover; margin: 0;">
                                </label>
                                <input type="file" id="videoInput" name="videos[]" multiple
                                    style="display: none;" accept="video/*"
                                    onchange="previewVideos(event, 'videoPreviewList')">
                            </div>
                        </div>
                        @error('photos.*')
                        <div class="invalid-feedback d-block text-center">{{ $message }}</div>
                        @enderror
                        @error('videos.*')
                        <div class="invalid-feedback d-block text-center">{{ $message }}</div>
                        @enderror

                        <div class="mt-4">
                            <h5 class="text-center mb-2" id="photoTitle" style="display: none;">Ảnh đã chọn:</h5>
                            <div id="photoPreviewList" class="d-flex flex-wrap justify-content-center align-items-center"></div>

                            <h5 class="mt-3 text-center mb-2" id="videoTitle" style="display: none;">Video đã chọn:</h5>
                            <div id="videoPreviewList" class="d-flex flex-wrap justify-content-center align-items-center"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="reviewContent">Viết đánh giá</label>
                        <textarea name="content" class="form-control @error('content') is-invalid @enderror"
                            id="reviewContent" rows="4" style="border-radius: 5px;">{{ old('content') }}</textarea>
                        @error('content')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="modal-footer form-btn" style="border: none; padding: 0;">
                        <button type="submit" form="reviewForm" class="form-btn-save">Đánh Giá</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal phóng to ảnh -->
<div id="myCustomModal" class="custom-modal">
    <span class="custom-close custom-cursor" onclick="closeModal()">&times;</span>
    <div class="custom-modal-content" id="modalContent">
    </div>
</div>
@include('web/Modal/exchange')
@include('web/Modal/add-exchange-product')
@section('script')
<!-- <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="{{asset('/slick/slick.min.js')}}"></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
<script>
    let slideIndex = 1;

    function openModal(mediaItems, startIndex) {
        const modalContent = document.getElementById('modalContent');
        modalContent.innerHTML = '';

        mediaItems.forEach((media, index) => {
            const slide = document.createElement('div');
            slide.classList.add('custom-mySlides'); // Cập nhật tên class
            slide.style.display = 'none';

            const numberText = document.createElement('div');
            numberText.classList.add('custom-numbertext'); // Cập nhật tên class
            numberText.innerText = `${index + 1} / ${mediaItems.length}`;
            slide.appendChild(numberText);

            if (/\.(mp4|avi|mov|wmv)$/i.test(media)) {
                const video = document.createElement('video');
                video.width = '400';
                video.controls = true;

                const source = document.createElement('source');
                source.src = `/storage/${media}`;
                source.type = 'video/mp4';
                video.appendChild(source);

                video.innerHTML += 'Your browser does not support the video tag.';
                slide.appendChild(video);
            } else {
                const img = document.createElement('img');
                img.src = `/storage/${media}`;
                img.style.width = '100%';
                img.style.maxHeight = '534px';
                img.style.objectFit = 'cover';
                img.style.marginBottom = '-4px';
                slide.appendChild(img);
            }

            modalContent.appendChild(slide);
        });

        // Tạo nút prev
        const prev = document.createElement('a');
        prev.classList.add('custom-prev'); // Cập nhật tên class
        prev.innerHTML = '&#10094;';
        prev.onclick = () => plusSlides(-1);
        modalContent.appendChild(prev);

        // Tạo nút next
        const next = document.createElement('a');
        next.classList.add('custom-next'); // Cập nhật tên class
        next.innerHTML = '&#10095;';
        next.onclick = () => plusSlides(1);
        modalContent.appendChild(next);

        slideIndex = startIndex;
        showSlides(slideIndex);

        document.getElementById("myCustomModal").style.display = "block"; // Cập nhật ID
    }

    function closeModal() {
        document.getElementById("myCustomModal").style.display = "none"; // Cập nhật ID
    }

    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    function currentSlide(n) {
        showSlides(slideIndex = n);
    }

    function showSlides(n) {
        const slides = document.getElementsByClassName("custom-mySlides");
        if (n > slides.length) slideIndex = 1;
        if (n < 1) slideIndex = slides.length;

        for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }

        slides[slideIndex - 1].style.display = "block";
    }
</script>

<script>
    $(document).ready(function() {
        if ($('.invalid-feedback.d-block').length > 0 || @json($errors -> has('modal_error'))) {
            $('#reviewModal').modal('show');
        }
    });


    $(function() {
        let listStar = $(".list-star .fa");
        listStar.mouseover(function() {
            let $this = $(this);
            let number = $this.attr('data-key');
            $(".number-rating").val(number);
            listStar.removeClass('rating-active');
            $.each(listStar, function(key) {
                if (key + 1 <= number) {
                    $(this).addClass('rating-active');
                }
            });
        });
    });

    function updateFileList(inputElement, updatedFiles) {
        const dataTransfer = new DataTransfer();
        updatedFiles.forEach(file => dataTransfer.items.add(file));
        inputElement.files = dataTransfer.files;
    }

    function previewImages(event, previewContainerId) {
        const files = Array.from(event.target.files);
        const inputElement = event.target;
        const previewContainer = document.getElementById(previewContainerId);
        const photoTitle = document.getElementById('photoTitle');

        previewContainer.innerHTML = '';
        photoTitle.style.display = files.length > 0 ? 'block' : 'none';

        files.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const wrapper = document.createElement('div');
                wrapper.classList.add('position-relative', 'm-2');
                wrapper.style.width = '150px';
                wrapper.style.height = '150px';

                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = '100%';
                img.style.height = '100%';
                img.style.objectFit = 'cover';
                img.style.borderRadius = '5px';

                const deleteBtn = document.createElement('button');
                deleteBtn.innerText = 'X';
                deleteBtn.classList.add('btn', 'btn-danger', 'btn-sm', 'position-absolute');
                deleteBtn.style.top = '0';
                deleteBtn.style.right = '0';

                deleteBtn.onclick = () => {
                    files.splice(index, 1);
                    updateFileList(inputElement, files);
                    wrapper.remove();
                    if (files.length === 0) photoTitle.style.display = 'none';
                };

                wrapper.appendChild(img);
                wrapper.appendChild(deleteBtn);
                previewContainer.appendChild(wrapper);
            };
            reader.readAsDataURL(file);
        });
    }

    function previewVideos(event, previewContainerId) {
        const files = Array.from(event.target.files);
        const inputElement = event.target;
        const previewContainer = document.getElementById(previewContainerId);
        const videoTitle = document.getElementById('videoTitle');

        previewContainer.innerHTML = '';
        videoTitle.style.display = files.length > 0 ? 'block' : 'none';

        files.forEach((file, index) => {
            const wrapper = document.createElement('div');
            wrapper.classList.add('position-relative', 'm-2');
            wrapper.style.width = '150px';
            wrapper.style.height = '150px';

            const video = document.createElement('video');
            video.src = URL.createObjectURL(file);
            video.controls = true;
            video.style.width = '100%';
            video.style.height = '100%';
            video.style.objectFit = 'cover';
            video.style.borderRadius = '5px';

            const deleteBtn = document.createElement('button');
            deleteBtn.innerText = 'X';
            deleteBtn.classList.add('btn', 'btn-danger', 'btn-sm', 'position-absolute');
            deleteBtn.style.top = '0';
            deleteBtn.style.right = '0';

            deleteBtn.onclick = () => {
                files.splice(index, 1);
                updateFileList(inputElement, files);
                wrapper.remove();
                if (files.length === 0) videoTitle.style.display = 'none';
            };

            wrapper.appendChild(video);
            wrapper.appendChild(deleteBtn);
            previewContainer.appendChild(wrapper);
        });
    }
</script>


<script>
    var totalProduct = 0;
    var quantityCart = 0;

    if (@json($product -> getProductUnitTypeOne()) != null) {
        let unitOnlyQuantity = @json($product -> getProductUnitTypeOne());
        totalProduct = unitOnlyQuantity.quantity;

        @json($cart).forEach(item => {
            if (unitOnlyQuantity.id == item.product_unit_id) {
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

            if (quantity > totalProduct - quantityCart) {
                $(this).val(totalProduct - quantityCart);
            }
            if (quantity < 1) {
                $(this).val(1);
            }

            $('#quantityInput').val(quantity);

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
            $('#quantityInput').val(currentValue);
            $('.quantity').trigger('change');

        });

        $(".minus").on("click", function() {
            const input = $(this).next(".quantity");
            let currentValue = parseInt(input.val()) || 0;

            if (currentValue > 1) {
                currentValue -= 1;
                input.val(currentValue);
                $('#quantityInput').val(currentValue);

            }
            $('.quantity').trigger('change');

        });

        $('input[name="radio-unit"]').change(function() {
            $('#divQuantity').fadeIn();
            var selectedUnitId = $(this).val();
            totalProduct = $(this).data('total-product');
            let color = $(this).data('color');
            let size = $(this).data('size');

            if ($('.quantity').val() > totalProduct) {
                $('.quantity').val(totalProduct);
            }
            $('#totalProduct').text("Hiện có " + totalProduct + " sản phẩm loại này");

            let carts = @json($cart);

            quantityCart = null;
            carts.forEach(cart => {
                if (cart.product_unit_id == selectedUnitId) {
                    quantityCart = cart.quantity;

                }
            });

            if (quantityCart) {
                $('#totalCartProduct').text(" | " + quantityCart + " sản phẩm đã có trong giỏ.");
                $('#totalCartProduct').fadeIn();
            } else {
                $('#totalCartProduct').fadeOut();
            }
            $('.quantity').trigger('change');

            $('#productUnitId').val(selectedUnitId);
            $('#colorValue').val(color);
            $('#sizeValue').val(size);
        });

        $('.quantity').trigger('change');
    });

    function changeMainImage(imageSrc) {
        document.getElementById('main-image').src = imageSrc;
    }
</script>
<script src="{{ asset('/js/favorite.js') }}"></script>
<script src="{{ asset('/js/cart.js')}}"></script>
<script src="{{ asset('/js/exchange.js')}}"></script>
@endsection
@endsection