@extends('web.layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/profile.css') }}">
<link rel="stylesheet" href="{{ asset('/css/product.css') }}">
@endsection

@section('content')
<div class="title-line">
    <div class="title-text">Thông báo của tôi</div>
</div>

@include('web.profile.sidebarMobile')

<div class="container">
    <div class="row">
        @include('web.profile.sidebar')

        <div class="col-lg-9 col-sm-12 col-12 mt-4">
            <div id="notification-list">
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
            </div>
            @if($datas->hasMorePages())
            <div class="text-center py-5 divMoreFavorite">
                <a id="btnMorePost" class="all color-B10000" href="#" data-url="{{ route('notification.index') }}">
                    Xem thêm <i class="fa-solid fa-angles-down"></i>
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
<script>
    var currentPage = 1;

    $(document).ready(function() {
        $('#btnMorePost').click(function(event) {
            event.preventDefault();
            var url = $(this).data('url');
            currentPage++;

            $.ajax({
                url: url,
                method: 'GET',
                data: {
                    page: currentPage
                },
                success: function(response) {
                    $('#notification-list').append(response.posts);

                    if (response.hasMorePage === false) {
                        $('#btnMorePost').hide();
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Lỗi khi tải thêm bài viết:', error);
                }
            });
        });
    });
</script>
@endsection