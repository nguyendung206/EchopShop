@extends('web.layout.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('/css/profile.css') }}">
@endsection
@section('title')
FAVORITES
@endsection
@section('content')
    <div class="profile-slider">
        <h1 class="profile-heading text-center">Sản phẩm đã thích</h1>
    </div>
    @include('web.profile.sidebarMobile')
    <div class="container">
        <div class="row">
            @include('web.profile.sidebar')
            <div class="col-lg-9 col-sm-12 col-12 mt-4">
                <table class="table table-borderless text-center ">
                    <thead>
                        <tr>
                            <th></th>
                            <th class="res-none">Đơn hàng</th>
                            <th>Tên sản phẩm</th>
                            <th>Hình thức</th>
                            <th>Trạng thái</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="favorite-list">
                        @forelse($favorites as $favorite)
                            @php
                                $product = $favorite->product;
                            @endphp
                            <tr class="post-item" id="product-{{ $product->id }}">
                                <td class="align-middle">
                                    <a href="#" class='product-trash favorite-active'
                                        data-url-destroy="{{ route('favorite.destroy', $product->id) }}"
                                        data-productId="{{ $product->id }}"><i class="fa-regular fa-trash-can"
                                            style="color: #A0A0A0;font-size: 1.25rem"></i></a>
                                </td>
                                <td class="align-middle res-none">
                                    <img style="height: 90px;width: 90px;" class="profile-user-img img-responsive img-bordered"
                                        src="{{ getImage($product->photo) }}">
                                </td>
                                <td class="align-middle">{{ $product->name }}</td>
                                <td class="align-middle">{{str_replace('Hàng', '',  $product->type->label())}}</td>
                                <td class="align-middle {{ $product->productUnits->count() > 0 && $product->hasQuantityProduct() ? 'text-success' : 'text-danger' }}">
                                    {{ $product->productUnits->count() > 0 && $product->hasQuantityProduct() ? 'Còn hàng' : 'Hết hàng' }}</td>
                                <td class="align-middle">
                                    @switch($product->type)
                                        @case(TypeProductEnums::EXCHANGE)
                                            <a class="buy buy-favorite {{$product->productUnits->count() > 0 && $product->hasQuantityProduct() ? '' : 'disable-buy' }}"
                                                href="{{ $product->productUnits->count() > 0 && $product->hasQuantityProduct() ? route('web.productdetail.index', ['slug' => $product->slug]) : 'javascript:void(0)' }}">
                                                Trao đổi ngay
                                            </a>
                                        @break

                                        @case(TypeProductEnums::SECONDHAND)
                                            <a class="buy buy-favorite {{$product->productUnits->count() > 0 && $product->hasQuantityProduct() ? '' : 'disable-buy' }}"
                                                href="{{ $product->productUnits->count() > 0 && $product->hasQuantityProduct() ? route('web.productdetail.index', ['slug' => $product->slug]) : 'javascript:void(0)' }}">
                                                Mua ngay
                                            </a>
                                        @break

                                        @case(TypeProductEnums::GIVEAWAY)
                                            <a class="buy buy-favorite {{$product->productUnits->count() > 0 && $product->hasQuantityProduct() ? '' : 'disable-buy' }}"
                                                href="{{ $product->productUnits->count() > 0 && $product->hasQuantityProduct() ? route('web.productdetail.index', ['slug' => $product->slug]) : 'javascript:void(0)' }}">
                                                Nhận quà ngay
                                            </a>
                                        @break

                                        @default
                                            <span class="badge badge-warning">Unknown Type</span>
                                    @endswitch

                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="6">Không có bài viết nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @if ($favorites->hasMorePages())
                        <div class="text-center py-5 divMoreFavorite">
                            @if ($favorites->count() >= 8)
                                <a id="btnMoreFavorite" class="all color-B10000" data-url={{ route('favoriteProduct') }}
                                    href="#">Xem thêm <i class="fa-solid fa-angles-down"></i></a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
        </div>
        @section('script')
            <script>
                var currentPage = 1;
                $('#btnMoreFavorite').click(function(event) {
                    var url = $(this).data('url');
                    console.log(url);

                    event.preventDefault();
                    currentPage++;

                    $.ajax({
                        url: url,
                        method: 'GET',
                        data: {
                            page: currentPage
                        },
                        success: function(response) {
                            $('#favorite-list').append(response.productHtml);
                            console.log(response);

                            if (!response.hasMorePages) {
                                $('.divMoreFavorite').hide();
                            }
                        },
                        error: function(xhr, status, error) {

                        }
                    });
                });
            </script>

            <script>
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $(document).on('click', '.product-trash', function(event) {
                    event.preventDefault();
                    var productId = $(this).data('productid');
                    var $this = $(this);
                    var urlDestroy = $this.data('url-destroy');
                    var urlStore = $this.data('url-store');
                    var $icon = $this.find('i');
                    console.log("alo");

                    $.ajax({
                        url: urlDestroy,
                        method: "DELETE",
                        success: function(response) {

                            if (response.status === 200) {
                                $('#product-' + productId).remove();
                                toastr.success(response.message, null, {
                                    positionClass: 'toast-bottom-left'
                                });

                            } else {
                                toastr.error(response.message, null, {
                                    positionClass: 'toast-bottom-left'
                                });
                            }
                        }
                    })
                });
            </script>
        @endsection

    @endsection
