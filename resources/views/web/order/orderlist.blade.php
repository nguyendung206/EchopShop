@extends('web.layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/profile.css') }}">
@endsection
@section('title')
ORDER
@endsection
@section('content')
<div class="profile-slider">
    <h1 class="profile-heading text-center">Đơn hàng của tôi</h1>
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
                        <th>Hình thức</th>
                        <th>Trạng thái</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="order-list">
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
                    @empty
                    <tr>
                        <td colspan="5">Không có bài viết nào.</td>
                    </tr>
                    @endforelse
                </tbody>

                <tr id="no-post-message" style="display: none; text-align: center;">
                    <td colspan="5">Không có bài viết nào.</td>
                </tr>

                <tr id="search-loading" style="display:none;">
                    <td colspan="5">
                        <i class="fa fa-spinner fa-spin"></i> Đang tải...
                    </td>
                </tr>
            </table>
            @if($datas->hasMorePages())
            <div class="text-center py-5 divMoreFavorite">
                <a id="btnMoreOrder" class="all color-B10000" href="#" data-url="{{route('order.show')}}">
                    Xem thêm <i class="fa-solid fa-angles-down"></i>
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
<!-- Modal đánh giá -->
<div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="height: auto; max-width: 700px;">
        <div class="modal-content">
            <div class="modal-header" style="border: none;">
                <h5 class="modal-title mt-4 ml-4" id="reviewModalLabel"
                    style="font-size: 20px; font-weight: 500; line-height: 28px; color: #222222;">
                    Đánh giá sản phẩm
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body px-5 pb-4">
                <form action="{{ route('rating.store') }}" method="post" id="reviewForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ auth()->check() ? auth()->user()->id : '' }}">
                    <input type="hidden" name="product_id" value="">

                    <div class="form-group text-center">
                        <h1 style="font-size: 28px; font-weight: 400; line-height: 28px; color: #222222;">
                            Để lại đánh giá của bạn
                        </h1>
                        <p class="my-4" style="font-weight: 400; line-height: 28px; color: #222222;">
                            Nhấp vào các ngôi sao để đánh giá chúng tôi
                        </p>
                        <div class="item-rating row align-items-center my-2 justify-content-center">
                            <span class="mx-2 list-star" style="font-size: 50px;">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa fa-star" data-key="{{ $i }}" style="cursor: pointer;"></i>
                                    @endfor
                            </span>
                            <input class="number-rating" type="hidden" name="star" value="{{ old('star') }}">
                        </div>
                    </div>
                    @error('star')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror

                    <div class="form-group mt-4 d-flex flex-column align-items-center my-2 justify-content-center">
                        <div class="d-flex">
                            <div class="mr-4" id="photoImageContainer">
                                <label for="photoImageInput">
                                    <img src="{{ asset('/img/image/upload.png') }}" alt="Ảnh sản phẩm"
                                        class="upload-img" style="cursor: pointer; object-fit: cover; margin: 0;">
                                </label>
                                <input type="file" id="photoImageInput" name="photos[]" multiple
                                    style="display: none;" accept="image/*"
                                    onchange="previewImages(event, 'photoPreviewList')">
                                @error('photos.*')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div id="videoContainer">
                                <label for="videoInput">
                                    <img src="{{ asset('/img/image/video.png') }}" alt="Video sản phẩm"
                                        class="upload-img" style="cursor: pointer; object-fit: cover; margin: 0;">
                                </label>
                                <input type="file" id="videoInput" name="videos[]" multiple
                                    style="display: none;" accept="video/*"
                                    onchange="previewVideos(event, 'videoPreviewList')">
                                @error('videos.*')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <h5 class="text-center mb-2" id="photoTitle" style="display: none;">Ảnh đã chọn:</h5>
                            <div id="photoPreviewList" class="d-flex flex-wrap justify-content-center align-items-center"></div>

                            <h5 class="mt-3 text-center mb-2" id="videoTitle" style="display: none;">Video đã chọn:</h5>
                            <div id="videoPreviewList" class="d-flex flex-wrap justify-content-center align-items-center"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="reviewContent">Viết đánh giá</label>
                        <textarea name="content" class="form-control @error('content') is-invalid @enderror"
                            id="reviewContent" rows="4" style="border-radius: 5px;">{{ old('content') }}</textarea>
                        @error('content')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="modal-footer form-btn" style="border: none; padding: 0;">
                        <button type="submit" form="reviewForm" class="form-btn-save">Đánh Giá</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

<script>
    var currentPage = 1;

    $(document).ready(function() {
        $('#btnMoreOrder').click(function(event) {
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
                    $('#order-list').append(response.orders);

                    if (!response.hasMorePage) {
                        $('#btnMoreOrder').hide();
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Lỗi khi tải thêm đơn hàng:', error);
                }
            });
        });
    });
</script>

<script>
    $(document).on('click', '[data-target="#reviewModal"]', function() {
        var product_id = $(this).data('rating-product-id');
        $('#reviewForm input[name="product_id"]').val(product_id);
    });

    $(document).ready(function() {
        $('#reviewForm').on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        // Hiện thông báo thành công
                        toastr.success(response.message, null, {
                            positionClass: 'toast-bottom-left'
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        // Hiện thông báo lỗi
                        toastr.error(response.message, null, {
                            positionClass: 'toast-bottom-left'
                        });
                    }
                },
                error: function(xhr) {
                    // Nếu có lỗi validation, hiển thị lỗi
                    let errors = xhr.responseJSON.errors;
                    $('.invalid-feedback').remove(); // Xóa tất cả thông báo lỗi cũ
                    $.each(errors, function(key, value) {
                        // Tìm trường tương ứng và hiển thị lỗi
                        let inputField = $('[name="' + key + '"]');
                        if (inputField.length) {
                            inputField.addClass('is-invalid');
                            inputField.after('<div class="invalid-feedback d-block">' + value[0] + '</div>');
                        }
                    });
                }
            });
        });
    });

    $(function() {
        let listStar = $(".list-star .fa");
        listStar.mouseover(function() {
            let $this = $(this);
            let number = $this.attr('data-key');
            $(".number-rating").val(number);
            listStar.removeClass('rating-active');
            $.each(listStar, function(key) {
                if (key + 1 <= number) {
                    $(this).addClass('rating-active');
                }
            });
        });
    });

    function updateFileList(inputElement, updatedFiles) {
        const dataTransfer = new DataTransfer();
        updatedFiles.forEach(file => dataTransfer.items.add(file));
        inputElement.files = dataTransfer.files;
    }

    function previewImages(event, previewContainerId) {
        const files = Array.from(event.target.files);
        const inputElement = event.target;
        const previewContainer = document.getElementById(previewContainerId);
        const photoTitle = document.getElementById('photoTitle');

        previewContainer.innerHTML = '';
        photoTitle.style.display = files.length > 0 ? 'block' : 'none';

        files.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const wrapper = document.createElement('div');
                wrapper.classList.add('position-relative', 'm-2');
                wrapper.style.width = '150px';
                wrapper.style.height = '150px';

                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = '100%';
                img.style.height = '100%';
                img.style.objectFit = 'cover';
                img.style.borderRadius = '5px';

                const deleteBtn = document.createElement('button');
                deleteBtn.innerText = 'X';
                deleteBtn.classList.add('btn', 'btn-danger', 'btn-sm', 'position-absolute');
                deleteBtn.style.top = '0';
                deleteBtn.style.right = '0';

                deleteBtn.onclick = () => {
                    files.splice(index, 1);
                    updateFileList(inputElement, files);
                    wrapper.remove();
                    if (files.length === 0) photoTitle.style.display = 'none';
                };

                wrapper.appendChild(img);
                wrapper.appendChild(deleteBtn);
                previewContainer.appendChild(wrapper);
            };
            reader.readAsDataURL(file);
        });
    }

    function previewVideos(event, previewContainerId) {
        const files = Array.from(event.target.files);
        const inputElement = event.target;
        const previewContainer = document.getElementById(previewContainerId);
        const videoTitle = document.getElementById('videoTitle');

        previewContainer.innerHTML = '';
        videoTitle.style.display = files.length > 0 ? 'block' : 'none';

        files.forEach((file, index) => {
            const wrapper = document.createElement('div');
            wrapper.classList.add('position-relative', 'm-2');
            wrapper.style.width = '150px';
            wrapper.style.height = '150px';

            const video = document.createElement('video');
            video.src = URL.createObjectURL(file);
            video.controls = true;
            video.style.width = '100%';
            video.style.height = '100%';
            video.style.objectFit = 'cover';
            video.style.borderRadius = '5px';

            const deleteBtn = document.createElement('button');
            deleteBtn.innerText = 'X';
            deleteBtn.classList.add('btn', 'btn-danger', 'btn-sm', 'position-absolute');
            deleteBtn.style.top = '0';
            deleteBtn.style.right = '0';

            deleteBtn.onclick = () => {
                files.splice(index, 1);
                updateFileList(inputElement, files);
                wrapper.remove();
                if (files.length === 0) videoTitle.style.display = 'none';
            };

            wrapper.appendChild(video);
            wrapper.appendChild(deleteBtn);
            previewContainer.appendChild(wrapper);
        });
    }
</script>
@endsection