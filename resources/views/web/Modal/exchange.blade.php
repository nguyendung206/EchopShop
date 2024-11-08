@section('css')
<link rel="stylesheet" href="{{ asset('/css/profile.css') }}">
<link rel="stylesheet" href="{{ asset('/css/inputRangerQuality.css') }}">
<style>
    .add {
        color: #B10000 !important;
        border: none !important;
        padding: 0 !important;
        cursor: pointer;
    }

    .add:hover {
        background-color: #fff !important;
        color: #B10000 !important;
    }

    .apply {
        padding: 8px 40px;
        border: 1px solid #B10000;
        cursor: pointer;
        border-radius: 10px;
        background-color: #B10000;
        color: #fff;
    }

    .apply:hover {
        background-color: #4f0000;
        color: #fff !important;
    }

    .back {
        color: #B10000;
        background-color: #fff;
    }
</style>
@endsection
<div id="exchangeModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog my-5" role="document" style="max-width: 900px !important; margin: 30px auto !important;">
        <div class="modal-content w-100">
            <div class="modal-header" style="border: none;">
                <h5 class="modal-title">Vui lòng chọn sản phẩm bạn muốn đổi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="exchangeForm">
                @csrf
                <div class="modal-body" style="overflow-y: auto; height: 540px !important;">
                    <div id="productList" class="row align-items-center px-3"></div>
                </div>
                <div class="modal-footer form-btn row align-items-center justify-content-between" style="border: none;">
                    <div class="px-3">
                        <p class="mr-2" style="font-weight: 500; line-height: 18.75px; color: #7c7c7c;">
                            Bạn muốn thêm sản phẩm khác?
                            <span class="add-exchange-product add">Thêm ngay</span>
                        </p>
                    </div>
                    <div class="px-3">
                        <button class="apply back" data-dismiss="modal" aria-label="Close">Huỷ</button>
                        <button type="button" id="applyExchange" class="form-btn-save apply" data-store-url="{{ route('exchange.store') }}">Áp dụng</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>