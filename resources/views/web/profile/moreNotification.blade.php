@foreach ($datas as $data)
<a href="{{ route('notification.isreaded', ['id' => $data->id]) }}">
    <div style="border-radius: 10px;" class="py-notificaition dropdown-item d-flex align-items-center notification {{ !$data->is_read ? 'is_read' : '' }}">
        <div class="mr-3">
            <img style="height: 50px;width: 50px; border-radius: 50%; object-fit: cover;" src="{{ getImage($data->product->photo) }}">
        </div>
        <div class="d-flex align-items-center justify-content-between w-100">
            <div style="max-width: 95%;">
                <strong>{{ $data->title }}</strong>
                <div class="text-muted my-2 text-body">{{ $data->body }}</div>
                <small class="text-muted">{{ $data->created_at->diffForHumans() }}</small>
            </div>
            <div class="ml-auto {{ !$data->is_read ? 'dot' : '' }}"></div>
        </div>
    </div>
</a>
@endforeach