@extends('web.layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/profile.css') }}">
@endsection

@section('content')
<div class="profile-slider">
    <h1 class="profile-heading text-center">Đơn hàng trao đổi</h1>
</div>

@include('web.profile.sidebarMobile')

<div class="container">
    <div class="row">
        @include('web.profile.sidebar')
        <div class="col-lg-9 col-sm-12 col-12 mt-4">
            <table class="table table-borderless text-center">
                <thead>
                    <tr>
                        <th>Đơn hàng</th>
                        <th>Tên sản phẩm</th>
                        <th>Ngày</th>
                        <th>Trạng thái</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="exchange-list">
                    @forelse($exchanges as $exchange)
                    <tr class="post-item">
                        <td class="align-middle">
                            <img style="height: 90px;" class="profile-user-img img-responsive img-bordered" src="{{ getImage($exchange->product->photo) }}">
                        </td>
                        <td class="align-middle">{{ $exchange->product->name }}</td>
                        <td class="align-middle">{{ $exchange->created_at->format('d/m/Y') }}</td>
                        <td class="align-middle">{{ $exchange->status->label() }}</td>
                        <td class="align-middle">
                            <a href="{{ route('exchange.show', $exchange->id) }}"
                                class="btn btn-sm btn-product btn-exchange" title="Chi tiết">
                                <i class="fa-solid fa-bars"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">Không có đơn hàng nào.</td>
                    </tr>
                    @endforelse
                </tbody>

                <tr id="no-post-message" style="display: none; text-align: center;">
                    <td colspan="6">Không có đơn hàng nào.</td>
                </tr>

                <tr id="search-loading" style="display:none;">
                    <td colspan="6">
                        <i class="fa fa-spinner fa-spin"></i> Đang tải...
                    </td>
                </tr>
            </table>
            @if($exchanges->hasMorePages())
            <div class="text-center py-5 divMoreFavorite">
                <a id="btnMoreExchange" class="all color-B10000" href="#" data-url="{{ route('exchange.index') }}">
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
        // Tải thêm đơn hàng
        $('#btnMoreExchange').click(function(event) {
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
                    $('#exchange-list').append(response.exchanges);

                    if (!response.hasMorePage) {
                        $('#btnMoreExchange').hide();
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Lỗi khi tải thêm đơn hàng:', error);
                }
            });
        })
    });
</script>
@endsection