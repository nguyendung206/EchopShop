@forelse($datas as $data)
@foreach ($data->orderDetails as $orderDetail)
<tr class="post-item">
    <td class="align-middle">
        <img style="height: 90px;"
            class="profile-user-img img-responsive img-bordered"
            src="{{ getImage($orderDetail->product->photo) }}">
    </td>
    <td class="align-middle">
        {{ $orderDetail->product->name }}
    </td>
    <td class="align-middle">
        {{ $data->created_at->format('d/m/Y') }}
    </td>
    <td class="align-middle">
        {{ $orderDetail->product->type->label() }}
    </td>
    <td class="align-middle">
        {{ $data->status->label() }}
    </td>
    <td class="align-middle">
        @if($data->status->value === \App\Enums\StatusOrder::COMPLETED->value)
        <a style="padding: 8px 20px; background: #b10000; color: #fff; border-radius: 5px;"
            href="#"
            data-toggle="modal"
            data-target="#reviewModal"
            data-rating-product-id="{{ $orderDetail->product->id }}">
            Đánh giá
        </a>
        @else
        <a class="disable-buy"
            style="padding: 8px 20px; background: #ddd; color: #666; border-radius: 5px; cursor: not-allowed;"
            href="javascript:void(0);">
            Đánh giá
        </a>
        @endif
    </td>
</tr>
@endforeach
@endforelse