@extends('web.layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/profile.css') }}">
@endsection

@section('content')
<div class="profile-slider">
    <h1 class="profile-heading text-center">Bài viết của tôi</h1>
</div>

@include('web.profile.sidebarMobile')

<div class="container">
    <div class="row">
        @include('web.profile.sidebar')
        <div class="col-lg-9 col-sm-12 col-12 mt-4">
            <div class="float-right mb-4">
                <form action="{{ route('post.index') }}" method="GET" id="searchForm">
                    <div class="input-group">
                        <input type="text" class="form-control" name="searchpost" placeholder="Nhập tên sản phẩm..." aria-label="Tìm kiếm bài viết" aria-describedby="basic-addon2" style="border-top-left-radius: 10px;border-bottom-left-radius: 10px;">
                        <div class="input-group-append">
                            <button class="input-group-text search-post" id="basic-addon2">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <table class="table table-borderless text-center">
                <thead>
                    <tr>
                        <th>Bài viết</th>
                        <th>Tên sản phẩm</th>
                        <th>Hình thức</th>
                        <th>Ngày đăng</th>
                        <th>Trạng thái</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="post-list">
                    @forelse($datas as $data)
                    <tr class="post-item">
                        <td class="align-middle">
                            <img style="height: 90px;" class="profile-user-img img-responsive img-bordered" src="{{ getImage($data->photo) }}">
                        </td>
                        <td class="align-middle">{{ $data->name }}</td>
                        <td class="align-middle">{{ $data->type->label() }}</td>
                        <td class="align-middle">{{ $data->created_at->format('d/m/Y') }}</td>
                        <td class="align-middle">{{ $data->status->label() }}</td>
                        <td class="align-middle">
                            @if ($data->status->value == 1)
                            <a class="btn btn-soft-danger btn-icon btn-circle btn-sm btn_status changeStatus"
                                data-id="{{ $data->id }}"
                                data-href="{{ route('post.status', $data->id) }}"
                                data-status="{{$data->status}}"
                                title="Tạm dừng">
                                <i class="fa-solid fa-ban"></i>
                            </a>
                            @elseif ($data->status->value == 0)
                            <a class="btn btn-soft-success btn-icon btn-circle btn-sm btn_status changeStatus"
                                data-id="{{ $data->id }}"
                                data-href="{{ route('post.status', $data->id) }}"
                                data-status="{{$data->status}}"
                                title="Kích hoạt">
                                <i class="fa-regular fa-circle-check"></i>
                            </a>
                            @endif
                            <a href="{{ route('post.edit', $data->id) }}" class="btn btn-sm btn-product">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-product btn-delete" data-id="{{ $data->id }}">
                                <i class="fa-regular fa-trash-can"></i>
                            </a>
                            <form id="delete-form-{{ $data->id }}" action="{{ route('post.destroy', $data->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">Không có bài viết nào.</td>
                    </tr>
                    @endforelse
                </tbody>

                <tr id="no-post-message" style="display: none; text-align: center;">
                    <td colspan="6">Không có bài viết nào.</td>
                </tr>

                <tr id="search-loading" style="display:none;">
                    <td colspan="6">
                        <i class="fa fa-spinner fa-spin"></i> Đang tải...
                    </td>
                </tr>
            </table>


            @if($datas->hasMorePages())
            <div class="text-center py-5 divMoreFavorite">
                <a id="btnMorePost" class="all color-B10000" href="#" data-url="{{ route('post.index') }}">
                    Xem thêm <i class="fa-solid fa-angles-down"></i>
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Xác nhận xóa -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Xác nhận xóa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa bài viết này?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <button type="button" id="confirmDeleteBtn" class="btn btn-danger">Xóa</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Xác Nhận -->
<div class="modal fade" id="confirmStatusChange" tabindex="-1" role="dialog" aria-labelledby="confirmStatusChangeLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmStatusChangeLabel">Xác Nhận Thay Đổi Trạng Thái</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn thay đổi trạng thái của bài viết này không?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" id="confirmChangeStatus">Đồng ý</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

<script>
    var currentPage = 1;

    $(document).ready(function() {
        // Tải thêm bài viết
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
                    $('#post-list').append(response.posts);

                    if (!response.hasMorePage) {
                        $('#btnMorePost').hide();
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Lỗi khi tải thêm bài viết:', error);
                }
            });
        });

        // Xác nhận xóa bài viết
        $(document).on('click', '.btn-delete', function(event) {
            event.preventDefault();
            var postId = $(this).data('id');
            $('#confirmDeleteModal').modal('show');

            $('#confirmDeleteBtn').off('click').on('click', function() {
                $('#delete-form-' + postId).submit();
            });
        });


        // Tìm kiếm bài viết
        $('#searchForm').on('submit', function(event) {
            event.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            var formData = form.serialize();

            $.ajax({
                url: url,
                method: 'GET',
                data: formData,
                beforeSend: function() {
                    $('#search-loading').show();
                    $('#post-list').empty();
                    $('#no-post-message').hide();
                },
                success: function(response) {
                    if (response.posts.length > 0) {
                        $('#post-list').html(response.posts);
                        $('#no-post-message').hide();
                        if (response.hasMorePage) {
                            $('#btnMorePost').show();
                            currentPage = 1;
                        } else {
                            $('#btnMorePost').hide();
                        }
                    } else {
                        $('#no-post-message').show();
                        $('#btnMorePost').hide();
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Lỗi khi tìm kiếm bài viết:', error);
                },
                complete: function() {
                    $('#search-loading').hide();
                }
            });
        });
    });

    $(document).ready(function() {
        var changeStatusUrl;

        $(document).on('click', '.changeStatus', function(event) {
            event.preventDefault();
            changeStatusUrl = $(this).data('href');
            $('#confirmStatusChange').modal('show');
        });

        $('#confirmChangeStatus').on('click', function() {
            $.ajax({
                url: changeStatusUrl,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    toastr.success(response.message, null, {
                        positionClass: 'toast-bottom-left'
                    });

                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                },
                error: function(xhr, status, error) {
                    var errorMessage = xhr.responseJSON.message || 'Có lỗi xảy ra.';
                    toastr.error(errorMessage, null, {
                        positionClass: 'toast-bottom-left'
                    });
                }
            });
            $('#confirmStatusChange').modal('hide');
        });
    });
</script>
@endsection