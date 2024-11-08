$(document).ready(function () {
    let originalProductId = null;
    let selectedProductId = null;
    let userId = null;
    let receiverId = null;
    $('.exchange').on('click', function (e) {
        e.preventDefault();
        const url = $(this).data('href');
        originalProductId = $(this).data('id');
        receiverId = $(this).data('owner-id');
        userId = $(this).data('user-id');
        if (userId === receiverId) {
            toastr.error('Bạn không thể đổi sản phẩm của chính mình.', null, { positionClass: 'toast-bottom-left' });
            return;
        }
        $.ajax({
            url: url,
            method: 'GET',
            success: function (response) {
                $('#productList').empty();

                if (response.length === 0) {
                    $('#productList').append(
                        `<div class="col-12 d-flex flex-column align-items-center justify-content-center" style="height: 450px;">
                            <p class="text-center mb-4" style="color: #ACACAC; font-weight: 400; line-height: 18.75px;">Bạn chưa có sản phẩm nào trong danh sách</p>
                            <a class="apply add-exchange-product text-white" style="width: auto; padding:12px 20px;">
                                <span class="mr-2" style="padding: 1px 6px; border: 1px solid #fff; border-radius: 50%; background-color: #fff; color: #B10000;">+</span>
                                Thêm sản phẩm mới
                            </a>
                        </div>`
                    );
                } else {
                    response.forEach(function (product) {
                        $('#productList').append(
                            `<div class="col-custom text-center p-2 mb-2 pick" data-product-id="${product.id}" style="cursor: pointer;">
                                <img src="${product.image_url}" alt="${product.name}" style="width:100%; height: 150px; object-fit:cover;">
                                <p class="mt-2" style="color:#535353; line-height: 18.75px; font-weight: 400;">${product.name}</p>
                            </div>`
                        );
                    });
                }

                $('#exchangeModal').modal('show');
            },
            error: function () {
                toastr.error('Không thể tải danh sách sản phẩm!', null, { positionClass: 'toast-bottom-left' });
            }
        });
    });

    $(document).on('click', '.pick', function () {
        $('.pick').css('border', 'none');
        $(this).css('border', '2px solid #B10000');
        selectedProductId = $(this).data('product-id');
    });


    $('#applyExchange').on('click', function () {
        const storeUrl = $(this).data('store-url');
        if (originalProductId && selectedProductId) {
            $.ajax({
                url: storeUrl,
                method: 'POST',
                data: {
                    original_product_id: originalProductId,
                    selected_product_id: selectedProductId,
                    user_id: userId,
                    receiver_id: receiverId,
                },
                success: function (response) {
                    $('#exchangeModal').modal('hide');
                    originalProductId = null;
                    selectedProductId = null;
                    userId = null;
                    receiverId = null;
                    toastr.success(response.message, null, { positionClass: 'toast-bottom-left' });
                },
                error: function () {
                    toastr.error('Đã có lỗi xảy ra. Vui lòng thử lại!', null, { positionClass: 'toast-bottom-left' });
                }
            });
        } else {
            toastr.error('Vui lòng chọn sản phẩm muốn đổi.', null, { positionClass: 'toast-bottom-left' });
        }
    });

    $(document).on('click', '.add-exchange-product', function (event) {
        event.preventDefault();
        $('#exchangeModal').modal('hide');
        $('#addProductModal').modal('show');
    });
});
