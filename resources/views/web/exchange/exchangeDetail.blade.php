@extends('web.layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/profile.css') }}">
@endsection

@section('content')
<div class="profile-slider">
    <h1 class="profile-heading text-center">Chi tiết đơn hàng trao đổi</h1>
</div>
<div class="container mw-1200">
    <div class="row">
        <div class="col-6 mx-auto">
            <div class="card">
                @if($exchange->user_id === Auth::id())
                <div class="card-header">
                    <h5 class="mb-0 h6">Chi tiết sản phẩm trao đổi</h5>
                </div>
                @else
                <div class="card-header">
                    <h5 class="mb-0 h6">Chi tiết sản phẩm của bạn</h5>
                </div>
                @endif
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <strong class="col-5" style="font-size: 1rem;">Tên sản phẩm:</strong>
                        <div class="col-7">
                            <p class="" style="font-size: 1rem;">{{ $exchange->product->name ?? ""}}</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-4">
                        <strong class="col-5" style="font-size: 1rem;">Giá:</strong>
                        <div class="col-7">
                            <p class="" style="font-size: 1rem;">{{ format_price($exchange->product->price) ?? ""}}</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-4">
                        <strong class="col-5" style="font-size: 1rem;">Mô tả:</strong>
                        <div class="col-7">
                            <p class="" style="font-size: 1rem;">{{strip_tags($exchange->product->description) ?? ""}}</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-4">
                        <strong class="col-5" style="font-size: 1rem;">Loại sản phẩm:</strong>
                        <div class="col-7">
                            <p class="" style="font-size: 1rem;">{{ $exchange->product->category->name ?? ""}}</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-4">
                        <strong class="col-5" style="font-size: 1rem;">Thương hiệu sản phẩm:</strong>
                        <div class="col-7">
                            <p class="" style="font-size: 1rem;">{{ $exchange->product->brand->name ?? ""}}</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-4">
                        <strong class="col-5" style="font-size: 1rem;">Tình trạng sản phẩm:</strong>
                        <div class="col-7">
                            <p class="" style="font-size: 1rem;">{{ $exchange->product->quality}}/100%</p>
                        </div>
                    </div>

                    <div class="d-flex mb-2">
                        <strong class="col-5" style="font-size: 1rem;">Ảnh:</strong>
                        <div class="col-7">
                            <img src="{{ $exchange->product->photo ? getImage($exchange->product->photo) : asset('storage/upload/product/noproduct.png') }}" class="img img-bordered w-100" style="height:auto; max-height: 350px; object-fit: cover;" />
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-6 mx-auto">
            <div class="card">
                @if($exchange->user_id === Auth::id())
                <div class="card-header">
                    <h5 class="mb-0 h6">Chi tiết sản phẩm của bạn</h5>
                </div>
                @else
                <div class="card-header">
                    <h5 class="mb-0 h6">Chi tiết sản phẩm trao đổi</h5>
                </div>
                @endif
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <strong class="col-5" style="font-size: 1rem;">Tên sản phẩm:</strong>
                        <div class="col-7">
                            <p class="" style="font-size: 1rem;">{{ $exchange->exchangeProduct->name ?? ""}}</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-4">
                        <strong class="col-5" style="font-size: 1rem;">Giá:</strong>
                        <div class="col-7">
                            <p class="" style="font-size: 1rem;">{{ format_price($exchange->exchangeProduct->price) ?? ""}}</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-4">
                        <strong class="col-5" style="font-size: 1rem;">Mô tả:</strong>
                        <div class="col-7">
                            <p class="" style="font-size: 1rem;">{{strip_tags($exchange->exchangeProduct->description) ?? ""}}</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-4">
                        <strong class="col-5" style="font-size: 1rem;">Loại sản phẩm:</strong>
                        <div class="col-7">
                            <p class="" style="font-size: 1rem;">{{ $exchange->exchangeProduct->category->name ?? ""}}</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-4">
                        <strong class="col-5" style="font-size: 1rem;">Thương hiệu sản phẩm:</strong>
                        <div class="col-7">
                            <p class="" style="font-size: 1rem;">{{ $exchange->exchangeProduct->brand->name ?? ""}}</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-4">
                        <strong class="col-5" style="font-size: 1rem;">Tình trạng sản phẩm:</strong>
                        <div class="col-7">
                            <p class="" style="font-size: 1rem;">{{ $exchange->exchangeProduct->quality}}/100%</p>
                        </div>
                    </div>

                    <div class="d-flex mb-2">
                        <strong class="col-5" style="font-size: 1rem;">Ảnh:</strong>
                        <div class="col-7">
                            <img src="{{ $exchange->exchangeProduct->photo ? getImage($exchange->exchangeProduct->photo) : asset('storage/upload/exchangeProduct/noexchangeProduct.png') }}" class="img img-bordered w-100" style="height:auto; max-height: 350px; object-fit: cover;" />
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-12 text-right mt-3">
            <a href="{{ route('exchange.index') }}" class="btn btn-secondary mr-2">
                <i class="fa-solid fa-circle-arrow-left"></i> Quay về
            </a>
            @if($exchange->status->value === 1)
            <a href="javascript:void(0);" class="btn btn-danger text-white mr-2 wait" title="Từ chối"
                onclick="showConfirmationModal('{{ route('exchange.reject', $exchange->id) }}', 'Từ chối đơn hàng', 'danger')">
                <i class="fa-regular fa-circle-xmark"></i> Từ chối
            </a>
            <a href="javascript:void(0);" class="btn btn-success text-white mr-2 wait" title="Đồng ý"
                onclick="showConfirmationModal('{{ route('exchange.accept', $exchange->id) }}', 'Đồng ý đơn hàng', 'success')">
                <i class="fa-regular fa-circle-check"></i> Đồng ý
            </a>
            @endif
        </div>
    </div>
</div>
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="confirmationMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <a id="confirmBtn" class="btn" href="#">Xác nhận</a>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
<script>
    function showConfirmationModal(url, action, type) {
        document.getElementById('confirmationModalLabel').textContent = `Xác nhận ${action} trao đổi`;
        document.getElementById('confirmationMessage').textContent = `Bạn có chắc chắn muốn ${action} trao đổi này không?`;

        const confirmBtn = document.getElementById('confirmBtn');
        confirmBtn.setAttribute('href', url);
        confirmBtn.className = `btn btn-${type}`;

        $('#confirmationModal').modal('show');
    }
</script>
@endsection