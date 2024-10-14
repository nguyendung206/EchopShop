$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Kiểm tra và thêm sản phẩm vào giỏ hàng
    $(document).on('click', '#btn-cart', function (event) {
        event.preventDefault();
        var productId = $(this).data('id');
        var urlCheck = $(this).data('url-check');
        var productUnitId = $(this).data('productunitid');
        var urlAddToCart = $(this).data('url-add-to-cart');

        // Kiểm tra loại sản phẩm
        $.ajax({
            url: urlCheck,
            method: 'POST',
            data: { productId: productId },
            success: function (response) {
                if (response.status === 200 && response.type === 'direct_add') {
                    addToCart(urlAddToCart, productId, 1, productUnitId);
                } else if (response.status === 200 && response.type === 'modal') {
                    showConfirmationModal(productId, response.units);
                } else {
                    showError(response.message);
                }
            },
            error: function () {
                showError('Đã có lỗi xảy ra khi kiểm tra sản phẩm.');
            }
        });
    });

    function addToCart(url, productId, type, productUnitId) {
        $.ajax({
            url: url,
            method: 'POST',
            data: {
                productId: productId,
                product_unit_id: productUnitId,
                type: type
            },
            success: function (storeResponse) {
                if (storeResponse.status === 200) {
                    toastr.success(storeResponse.message, null, { positionClass: 'toast-bottom-left' });
                    updateCartCount();
                } else {
                    toastr.error(storeResponse.message, null, { positionClass: 'toast-bottom-left' });
                }
            },
            error: function () {
                toastr.error('Đã có lỗi xảy ra khi thêm vào giỏ.', null, { positionClass: 'toast-bottom-left' });
            }
        });
    }
    function updateCartCount() {
        $.ajax({
            url: '/cart/count',
            method: 'GET',
            success: function (response) {
                if (response.status === 200) {
                    $('#cart-count').text(response.cartCount);
                    $('#cart-count').show();
                } else {
                    $('#cart-count').hide();
                }
            },
            error: function () {
                console.error('Không thể cập nhật số lượng giỏ hàng.');
            }
        });
    }
    // Hiện modal xác nhận và thiết lập dữ liệu
    function showConfirmationModal(productId, units) {
        $('#confirmationModal').modal('show');
        $('#modalProductId').val(productId);
        const unitContainer = $('#unitContainer');
        unitContainer.empty();

        // Thêm các đơn vị sản phẩm với radio button
        units.forEach(function (unit, index) {
            unitContainer.append(`
                <div class="product-unit d-flex align-items-center p-2 border mb-2">
                    <input type="radio" name="selectedUnit" value="${unit.id}" ${index === 0 ? 'checked' : ''} class="mr-3 unit-radio">
                    <div>
                        <p><strong>Màu sắc:</strong> ${unit.color}</p>
                        <p><strong>Kích cỡ:</strong> ${unit.size}</p>
                        <p><strong>Số lượng có sẵn:</strong> <span class="available-quantity">${unit.quantity}</span></p>
                    </div>
                </div>
            `);
        });

        // Cập nhật giới hạn số lượng khi radio được chọn
        $('input[name="selectedUnit"]').change(updateMaxQuantity);

        // Thiết lập số lượng ban đầu dựa trên radio đang chọn
        updateMaxQuantity();

        // Xử lý sự kiện tăng số lượng
        $('.plus').click(function () {
            const maxQuantity = getMaxQuantity();
            let currentVal = parseInt($('#quantityInput').val());
            if (currentVal < maxQuantity) {
                $('#quantityInput').val(currentVal + 1);
            }
        });

        // Xử lý sự kiện giảm số lượng
        $('.minus').click(function () {
            let currentVal = parseInt($('#quantityInput').val());
            if (currentVal > 1) {
                $('#quantityInput').val(currentVal - 1);
            }
        });

        // Giới hạn số lượng khi nhập tay
        $('#quantityInput').on('input', function () {
            const maxQuantity = getMaxQuantity();
            let value = parseInt($(this).val());

            if (isNaN(value) || value < 1) {
                $(this).val(1);
            } else if (value > maxQuantity) {
                $(this).val(maxQuantity);
            }
        });

        // Hàm lấy số lượng tối đa từ radio đang chọn
        function getMaxQuantity() {
            const selectedUnitId = $('input[name="selectedUnit"]:checked').val();
            const selectedUnit = units.find(unit => unit.id == selectedUnitId);
            return selectedUnit ? parseInt(selectedUnit.quantity) : 0;
        }

        // Cập nhật số lượng tối đa khi chọn radio khác
        function updateMaxQuantity() {
            const maxQuantity = getMaxQuantity();
            $('#quantityInput').attr('max', maxQuantity).val(1); // Reset về 1 khi chọn đơn vị mới
        }
    }

    // Xử lý sự kiện khi bấm nút "Lưu vào giỏ hàng"
    $('#saveSelectedUnit').on('click', function () {
        const selectedUnitId = $('input[name="selectedUnit"]:checked').val();
        const quantity = $('#quantityInput').val();
        const addToCartUrl = $(this).data('add-to-cart');
        const dataToSend = {
            productId: $('#modalProductId').val(),
            product_unit_id: selectedUnitId,
            quantity: quantity,
            type: 2,
            _token: $('meta[name="csrf-token"]').attr('content')
        };

        console.log('Dữ liệu gửi đi:', dataToSend);
        $.ajax({
            url: addToCartUrl,
            method: 'POST',
            data: dataToSend,
            success: function (response) {
                if (response.status === 200) {
                    toastr.success(response.message, null, { positionClass: 'toast-bottom-left' });

                    updateCartCount();

                    $('#confirmationModal').modal('hide');
                } else {
                    toastr.error(response.message, null, { positionClass: 'toast-bottom-left' });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                toastr.error('Đã có lỗi xảy ra. Vui lòng thử lại!', null, { positionClass: 'toast-bottom-left' });
            }

        });
    });

    // Thông báo lỗi
    function showError(message) {
        toastr.error(message, null, { positionClass: 'toast-bottom-left' });
    }
});