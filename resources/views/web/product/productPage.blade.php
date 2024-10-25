@extends('web.layout.app')

@php
$url = Str::lower(request()->url());
$search = null;
$provinceQuery = null;
if (request()->filled('search')) {
$search = request()->get('search');
}
if (request()->filled('province')) {
$provinceQuery = request()->get('province');
}
$case = 0;
$dataUrl = route('listProducts');
if(request()->query('type') == TypeProductEnums::GIVEAWAY->value){
$case = TypeProductEnums::GIVEAWAY->value;
$dataUrl = route('listProducts', ['type' => TypeProductEnums::GIVEAWAY->value]);
}

if (request()->query('type') == TypeProductEnums::SECONDHAND->value) {
$case = TypeProductEnums::SECONDHAND->value;
$dataUrl = route('listProducts', ['type' => TypeProductEnums::SECONDHAND->value]);
}
if (request()->query('type') == TypeProductEnums::EXCHANGE->value) {
$case = TypeProductEnums::EXCHANGE->value;
$dataUrl = route('listProducts', ['type' => TypeProductEnums::EXCHANGE->value]);
}
if (request()->query('type') == TypeProductEnums::SALE->value) {
$case = TypeProductEnums::SALE->value;
$dataUrl = route('listProducts', ['type' => TypeProductEnums::SALE->value]);
}
@endphp
@section('title')
@if ($case == TypeProductEnums::EXCHANGE->value)
Trao đổi hàng hoá
@elseif ($case == TypeProductEnums::SECONDHAND->value)
Mua bán đồ SECONDHAND
@elseif ($case == TypeProductEnums::GIVEAWAY->value)
Hàng cũ đem tặng
@elseif ($case == TypeProductEnums::SALE->value)
Hàng được bày bán
@elseif (request()->has('province') )
Danh sách sản phẩm theo địa điểm.
@else
Danh sách sản phẩm theo danh mục
@endif
@endsection


@section('css')
<link rel="stylesheet" href="{{ asset('/css/product.css') }}">
@endsection

@section('content')
<div class="title-line">
    <div class="title-text">
        @if ($case == TypeProductEnums::EXCHANGE->value)
        Trao đổi hàng hoá
        @elseif ($case == TypeProductEnums::SECONDHAND->value)
        Mua bán đồ SECONDHAND
        @elseif ($case == TypeProductEnums::GIVEAWAY->value)
        Hàng cũ đem tặng
        @elseif ($case == TypeProductEnums::SALE->value)
        Hàng được bày bán
        @elseif (request()->has('province') )
        Danh sách sản phẩm theo địa điểm.
        @else
        Danh sách sản phẩm theo danh mục
        @endif
    </div>
</div>

<div class="content container">
    @if ($case != 0)

    <div class="row product-title-line">
        <div class="col-lg-3"></div>
        <div class="col-lg-9 button-page-wrap">
            <a href="{{ route('listProducts', ['search'=> $search, 'province' => $provinceQuery, 'type' => TypeProductEnums::SECONDHAND])}}" class="{{ $case == TypeProductEnums::SECONDHAND->value ? 'active' : '' }}">Secondhand</a>
            <a href="{{ route('listProducts', ['search'=> $search, 'province' => $provinceQuery, 'type' => TypeProductEnums::EXCHANGE]) }}" class="{{ $case == TypeProductEnums::EXCHANGE->value ? 'active' : '' }}">Trao đổi</a>
            <a href="{{ route('listProducts', ['search'=> $search, 'province' => $provinceQuery, 'type' => TypeProductEnums::GIVEAWAY]) }}" class="{{ $case == TypeProductEnums::GIVEAWAY->value ? 'active' : '' }}">Hàng tặng</a>
            <a href="{{ route('listProducts', ['search'=> $search, 'province' => $provinceQuery, 'type' => TypeProductEnums::SALE]) }}" class="{{ $case == TypeProductEnums::SALE->value ? 'active' : '' }}">Hàng bán</a>
        </div>
    </div>
    @endif

    <div class="row">
        @include('web.inc.web_slideProduct')
        <div class="col-lg-9 col-12">
            @if ($search != null)
            <div style="font-size: 16px; color: #B10000;padding: 10px 0px">
                Kết quả tìm kiếm của: {{$search}}
            </div>
            @endif
            <div class="loading-UI product-show-loading" style="margin: 70px auto"></div>
            <div class="row list-product">
                @if ($case != TypeProductEnums::GIVEAWAY->value && $case != 0)
                @forelse($products as $product)
                <div class="col-lg-4 col-6 text-center  product-item ">
                    <div class="product-wrap">
                        <a href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}">
                            <div style="position: relative;">
                                <img class="product-img" src="{{ getImage($product->photo) }} " alt="">
                                @auth
                                <a href="#"
                                    class='product-heart {{ auth()->user()->load('favorites')->favorites->contains('product_id', $product->id)? 'favorite-active': '' }} '
                                    data-url-destroy="{{ route('favorite.destroy', $product->id) }}"
                                    data-url-store="{{ route('favorite.store') }}" data-productId="{{ $product->id }}"><i
                                        class="fa-{{ auth()->user()->load('favorites')->favorites->contains('product_id', $product->id)? 'solid': 'regular' }} fa-heart fa-heart-home"></i></a>
                                @else
                                <a href="{{ route('web.login') }}" class="product-heart"><i class="fa-regular fa-heart fa-heart-home"></i></a>
                                @endauth
                            </div>
                            <p class="product-name pt-2 line-clamp-2">{{ $product->name }}</p>
                            <p class="product-brand pt-2 line-clamp-1">Phân loại: <span>{{ $product->brand->name ?? "" }}</span></p>
                            <p class="price product-price color-B10000 pt-2 line-clamp-1">
                                {{ format_price($product->price) }}
                            </p>
                            <div class="user-product-wrap d-flex align-items-center">
                                @if (isset($product->shop))
                                <img class="mini-avatar mr-2" src="{{ getImage($product->shop->logo) }}"
                                    alt="">
                                <div class="user-product ">
                                    <p class="line-clamp-1">{{ $product->shop->name }} &nbsp;<img
                                            src="{{ asset('/img/icon/doc-top.png') }}"
                                            alt="">&nbsp;
                                        {{ $product->shop->province?->province_name ?? 'Chưa có địa chỉ'}}
                                    </p>
                                </div>
                                @else
                                <img src="{{ asset('/img/image/logo.png') }}" alt=""
                                    class="mini-avatar-admin">
                                <div class="user-product " style="width: 77%">
                                    <p class="line-clamp-1">Sản phẩm của echop</p>
                                </div>
                                @endif
                            </div>
                        </a>
                        <br>
                        @switch($case)
                        @case(TypeProductEnums::EXCHANGE->value)
                        <div class="buy-wrap-exchange">
                            <a class="btn-chat-exchange"
                                href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}"><i
                                    class="fa-regular fa-comment-dots"></i> Chat</a>
                            <a class="btn-buy-exchange"
                                href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}">Đổi
                                hàng</a>
                        </div>
                        @break

                        @case(TypeProductEnums::SECONDHAND->value || TypeProductEnums::SALE->value)
                        <div class="buy-wrap">
                            <a href="#" class="btn-chat-product"><i class="fa-regular fa-comment-dots"></i></a>
                            @auth
                            <a id="btn-cart" href="#" class="btn-cart-product btn-cart" data-url-add-to-cart="{{ route('cart.store') }}" data-id="{{ $product->id }}" data-productunitid="{{!empty($product->getProductUnitTypeOne()) ? $product->getProductUnitTypeOne()->id : 0}}" data-url-check="{{ route('cart.check') }}">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </a>
                            @else
                            <a href="{{ route('web.login') }}" class="btn-cart-product">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </a>
                            @endauth

                            <a class="btn-buy-product" href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}">
                                Mua ngay
                            </a>
                        </div>
                        @break
                        
                        @default
                        @endswitch
                    </div>
                </div>
                @empty
                <div class="text-center w-100 py-5">
                    <span class="" style="color:rgb(177,0,0);">Không có sản phẩm nào để hiển thị.</span>
                </div>
                @endforelse
                @endif
                @if ($case == TypeProductEnums::GIVEAWAY->value && $case != 0)
                @forelse($products as $product)
                <div class="gift-item m-2 col-lg-4 col-6"
                    style="margin-left: 0px !important;margin-right: 0px !important">
                    <div style="position: relative;">
                        <img class="product-img" src="{{ getImage($product->photo) }} " alt="">
                        @auth
                        <a href="#"
                            class='product-heart {{ auth()->user()->load('favorites')->favorites->contains('product_id', $product->id)? 'favorite-active': '' }} '
                            data-url-destroy="{{ route('favorite.destroy', $product->id) }}"
                            data-url-store="{{ route('favorite.store') }}" data-productId="{{ $product->id }}"><i
                                class="fa-{{ auth()->user()->load('favorites')->favorites->contains('product_id', $product->id)? 'solid': 'regular' }} fa-heart fa-heart-home"></i></a>
                        @else
                        <a href="{{ route('web.login') }}" class="product-heart"><i class="fa-regular fa-heart fa-heart-home"></i></a>
                        @endauth
                    </div>
                    <div class="gift-name line-clamp-2">
                        {{ $product->name }}
                    </div>
                    <div class="gift-btn-wrap">
                        <a href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}"
                            class="gift-btn">
                            <i class="fa-solid fa-gift"></i> Nhận quà tặng
                        </a>
                    </div>
                </div>
                @empty
                <div class="text-center w-100 py-5">
                    <span class="" style="color:rgb(177,0,0);">Không có sản phẩm nào để hiển thị.</span>
                </div>
                @endforelse
                @endif

                @if ($case == 0)
                @forelse($products as $product)
                <div class="col-lg-4 product-item col-6 text-center py-3  ">
                    <div class="product-wrap product-item-category" style="padding-bottom: 10px;">
                        <a href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}" >
                            <div style="position: relative;" >
                                <img class="product-img" src="{{ getImage($product->photo) }} " alt="">
                                @auth
                                <a href="#"
                                    class='product-heart {{ auth()->user()->load('favorites')->favorites->contains('product_id', $product->id)? 'favorite-active': '' }} '
                                    data-url-destroy="{{ route('favorite.destroy', $product->id) }}"
                                    data-url-store="{{ route('favorite.store') }}" data-productId="{{ $product->id }}"><i
                                        class="fa-{{ auth()->user()->load('favorites')->favorites->contains('product_id', $product->id)? 'solid': 'regular' }} fa-heart fa-heart-home"></i></a>
                                @else
                                <a href="{{ route('web.login') }}" class="product-heart"><i class="fa-regular fa-heart fa-heart-home"></i></a>
                                @endauth
                            </div>
                            <p class="product-name pt-2">{{ $product->name }}</p>
                            <p class="price color-B10000 pt-2">{{format_price($product->price)}}</p>
                        </a>
                        <div class="user-product-wrap my-1 d-flex align-items-center">
                            @if (isset($product->shop))
                            <img class="mini-avatar mr-2" src="{{ getImage($product->shop->logo) }}"
                                alt="">
                            <div class="user-product ">
                                <p class="line-clamp-1">{{ $product->shop->name }} &nbsp;<img
                                        src="{{ asset('/img/icon/doc-top.png') }}"
                                        alt="">&nbsp;
                                    {{ $product->shop->province?->province_name ?? 'Chưa có địa chỉ'}}
                                </p>
                            </div>
                            @else
                            <img src="{{ asset('/img/image/logo.png') }}" alt=""
                                class="mini-avatar-admin mr-2">
                            <div class="user-product " style="width: 77%">
                                <p class="line-clamp-1">Sản phẩm của echop</p>
                            </div>
                            @endif
                        </div>
                        <div class="product-actions" >
                            @if ($product->type->value == TypeProductEnums::EXCHANGE->value)
                            <a class="btn-chat-exchange" href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}"><i class="fa-regular fa-comment-dots"></i> Chat</a>
                            <a class="btn-buy-exchange" href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}">Đổi hàng</a>
                            @elseif($product->type->value == TypeProductEnums::SECONDHAND->value || $product->type->value == TypeProductEnums::SALE->value)
                            <div class="buy-wrap">
                                <a href="#" class="btn-chat-product"><i class="fa-regular fa-comment-dots"></i></a>
                                @auth
                                <a id="btn-cart" href="#" class="btn-cart-product btn-cart" data-url-add-to-cart="{{ route('cart.store') }}" data-id="{{ $product->id }}" data-productunitid="{{!empty($product->getProductUnitTypeOne()) ? $product->getProductUnitTypeOne()->id : 0}}" data-url-check="{{ route('cart.check') }}">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </a>
                                @else
                                <a href="{{ route('web.login') }}" class="btn-cart-product">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </a>
                                @endauth

                                <a class="btn-buy-product" href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}">
                                    Mua ngay
                                </a>
                            </div>
                            @elseif($product->type->value == TypeProductEnums::GIVEAWAY->value)
                            <div class="gift-btn-wrap">
                                <a href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}"
                                    class="gift-btn">
                                    <i class="fa-solid fa-gift"></i> Nhận quà tặng
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center w-100 py-5">
                    <span style="color: rgb(177, 0, 0);">Không có sản phẩm nào để hiển thị.</span>
                </div>
                @endforelse
                @endif

            </div>
            <div class="text-center more-wrap">
                <button id="btn-more" style="display: {{$products->hasMorePages() ? 'block' : 'none'}};">
                    Xem thêm
                </button>
            </div>
            <div class="loading-UI btn-more-loading" style="margin: 70px auto"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="max-width: 700px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Chi tiết sản phẩm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="modalProductId">

                <div id="unitContainer" class="mb-3">
                    <!-- Các đơn vị sản phẩm sẽ được thêm từ JavaScript -->
                </div>

                <div class="d-flex align-items-center">
                    <label for="quantityInput" class="mr-3"><strong>Số lượng:</strong></label>
                    <div class="number-input d-flex">
                        <button class="minus btn btn-outline-secondary">-</button>
                        <input id="quantityInput" class="form-control mx-2 text-center" type="number" value="1" min="1" style="width: 80px;">
                        <button class="plus btn btn-outline-secondary">+</button>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="saveSelectedUnit" data-add-to-cart="{{ route('cart.store') }}">
                    Lưu vào giỏ hàng
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

@section('script')
<script src="{{ asset('/js/favorite.js') }}"></script>
<script src="{{ asset('/js/cart.js') }}"></script>

<script>
    $(document).ready(function() {
        var currentPage = 1;
        var rangeInput = null;
        var rangeInput2 = null;
        var option = null;

        $('#filter-button').on('click', function() {
            currentPage = 1;
        })
        $('#btn-more').click(function(event) {



            var selectedBrands = [];
            var selectedCategories = [];
            $('.category-1-item.checked-text').each(function() {
                var brandId = $(this).data('brandid');
                selectedBrands.push(brandId);
            });

            $('.custom-checkbox-category.checked-text').each(function() {
                var categoryId = $(this).data('categoryid');
                selectedCategories.push(categoryId);
            });

            var selectedProvinces = [];
            $('.category-2-item.checked-text').each(function() {
                var provinceId = $(this).data('provinceid');
                selectedProvinces.push(provinceId);
            });

            $('.custom-radio').each(function() {
                if ($(this).find('label').hasClass('checked-text')) {
                    option = $(this).find('input').val();
                }
            });

            var rangeInput = $('#min').val();
            var rangeInput2 = $('#max').val();


            event.preventDefault();
            currentPage++;


            $.ajax({
                url: @json($dataUrl),
                method: 'GET',
                beforeSend: function(xhr, setting) {

                    $('.loading-UI.btn-more-loading').fadeIn();
                    $('.more-wrap').hide();
                },
                data: {
                    brandIds: selectedBrands,
                    categoryIds: selectedCategories,
                    provinceIds: selectedProvinces,
                    rangeInputMin: rangeInput,
                    rangeInputMax: rangeInput2,
                    option: option,
                    provinceIds: selectedProvinces,
                    province: @json(request() -> get('province')),
                    search: @json($search = request() -> get('search')),
                    page: currentPage
                },
                success: function(response) {

                    $('.list-product').append(response.productHtml);

                    if (response.hasMorePages) {
                        if ($('.more-wrap').children().length === 0) {
                            $('.more-wrap').append(
                                `<button id="btn-more">Xem thêm</button>`)
                        }
                    } else {
                        $('#btn-more').hide();
                    }
                },
                complete: function(data) {
                    $('.loading-UI').fadeOut();
                    $('.more-wrap').show();
                },
                error: function(xhr, status, error) {

                }
            });
        });
    })
</script>
@endsection

@endsection