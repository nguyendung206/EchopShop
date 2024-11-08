@foreach($exchanges as $exchange)
<tr class="post-item">
    <td class="align-middle">
        <img style="height: 90px;" class="profile-user-img img-responsive img-bordered" src="{{ getImage($exchange->product->photo) }}">
    </td>
    <td class="align-middle">{{ $exchange->product->name }}</td>
    <td class="align-middle">{{ $exchange->created_at->format('d/m/Y') }}</td>
    <td class="align-middle">{{ $exchange->status->label() }}</td>
    <td class="align-middle">
        <a href="javascript:void(0);"
            class="btn btn-sm btn-product btn-exchange" title="Chi tiết"
            data-href="{{ route('exchange.detail') }}"
            data-id="{{ $exchange->id }}">
            <i class="fa-solid fa-bars"></i>
        </a>
    </td>
</tr>
@endforeach