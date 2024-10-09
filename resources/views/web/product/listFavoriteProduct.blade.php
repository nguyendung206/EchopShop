@foreach($favorites as $favorite)
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
        <td class="align-middle">{{str_replace('hàng', '',  $product->type->label())}}</td>
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
@endforeach
