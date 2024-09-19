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
        <td class="align-middle">
            <img style="height: 90px;" class="profile-user-img img-responsive img-bordered"
                src="{{ getImage($product->photo) }}">
        </td>
        <td class="align-middle">{{ $product->name }}</td>
        <td class="align-middle">{{ $product->type->label() }}</td>
        <td class="align-middle">{{ $product->status->label() }}</td>
        <td class="align-middle">
            @switch($product->type)
                @case(TypeProductEnums::EXCHANGE)
                    <a class="buy" href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}" style="color: white;">Trao đổi ngay</a>
                @break

                @case(TypeProductEnums::SECONDHAND)
                    <a class="buy" href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}" style="color: white;">Mua ngay</a>
                @break

                @case(TypeProductEnums::GIVEAWAY)
                    <a class="buy" href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}" style="color: white;">Nhận quà ngay</a>
                @break

                @default
                    <!-- Nội dung mặc định nếu không khớp với các case trên -->
                    <span class="badge badge-warning">Unknown Type</span>
            @endswitch

        </td>
    </tr>
@endforeach
