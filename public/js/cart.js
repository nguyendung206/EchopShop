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
        var urlAddToCart = $(this).data('url-add-to-cart');

        // Kiểm tra loại sản phẩm
        $.ajax({
            url: urlCheck,
            method: 'POST',
            data: { productId: productId },
            success: function (response) {
                if (response.status === 200 && response.type === 'direct_add') {
                    addToCart(urlAddToCart, productId, 1);
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

    function addToCart(url, productId, type) {
        $.ajax({
            url: url,
            method: 'POST',
            data: {
                productId: productId,
                type: type
            },
            success: function (storeResponse) {
                if (storeResponse.status === 200) {
                    toastr.success(storeResponse.message, null, { positionClass: 'toast-bottom-left' });
                    $('#cart-count').text(storeResponse.cartCount);
                    $('#cart-count').show();
                } else {
                    toastr.error(storeResponse.message, null, { positionClass: 'toast-bottom-left' });
                }
            },
            error: function () {
                toastr.error('Đã có lỗi xảy ra khi thêm vào giỏ.', null, { positionClass: 'toast-bottom-left' });
            }
        });
    }

    // Hiện modal xác nhận và thiết lập dữ liệu
    function showConfirmationModal(productId, units) {
        $('#confirmationModal').modal('show');
        $('#modalProductId').val(productId);
        var unitTableBody = $('#unitTableBody');
        unitTableBody.empty();

        // Đưa dữ liệu units vào bảng
        units.forEach(function (unit) {
            unitTableBody.append(`
                <tr>
                    <td>${unit.color}</td>
                    <td>${unit.size}</td>
                    <td>${unit.quantity}</td>
                </tr>
            `);
        });

        // Ghi nhận dữ liệu units để sử dụng khi thêm mới
        window.unitsData = units;
        setupSelectOptions(units);
    }

    // Thiết lập các tùy chọn cho select
    function setupSelectOptions(units) {
        $('.color-select').empty().append('<option value="">Màu sắc</option>');
        $('.size-select').empty().append('<option value="">Kích cỡ</option>');

        units.forEach(function (unit) {
            $('.color-select').append(new Option(unit.color, unit.color));
            $('.size-select').append(new Option(unit.size, unit.size));
        });
    }

    // Thêm unit mới
    $(document).on('click', '.btn-add', function () {
        var firstUnit = $('.input-unit').first();
        var newInputUnit = `
            <div class="input-group mb-3 input-unit">
                <select class="form-control color-select">
                    ${firstUnit.find('.color-select').html()}
                </select>
                <select class="form-control size-select">
                    ${firstUnit.find('.size-select').html()}
                </select>
                <input type="number" class="form-control quantity-input" placeholder="Số lượng" min="1">
                <button type="button" class="btn btn-danger btn-remove" style="margin-left: 5px;">&times;</button>
            </div>
        `;
        $('#inputContainer').append(newInputUnit);
    });

    // Xóa input-unit
    $(document).on('click', '.btn-remove', function () {
        if ($('.input-unit').length > 1) {
            $(this).closest('.input-unit').remove();
        } else {
            toastr.warning('Phải có ít nhất một mục nhập.', null, { positionClass: 'toast-bottom-left' });
        }
    });

    // Lưu thông tin vào giỏ hàng
    $(document).on('click', '#saveUnits', function () {
        var units = [];
        var urlAddToCart = $(this).data('add-to-cart');

        $('.input-unit').each(function () {
            var color = $(this).find('.color-select').val();
            var size = $(this).find('.size-select').val();
            var quantity = $(this).find('.quantity-input').val();
            console.log("Color:", color, "Size:", size, "Quantity:", quantity); // Thêm dòng này

            units.push({
                color: color,
                size: size,
                quantity: parseInt(quantity)
            });
        });
        console.log("Units:", units);
        // Kiểm tra nếu có ít nhất một unit
        if (units.length > 0) {
            $.ajax({
                url: urlAddToCart,
                method: 'POST',
                data: {
                    productId: $('#modalProductId').val(),
                    units: units,
                    type: 2 // Đảm bảo đây là kiểu đúng
                },
                success: function (response) {
                    if (response.status === 200) {
                        toastr.success(response.message || 'Thêm vào giỏ hàng thành công', null, { positionClass: 'toast-bottom-left' });
                        $('#confirmationModal').modal('hide');
                    } else {
                        toastr.error(response.message || 'Có lỗi xảy ra', null, { positionClass: 'toast-bottom-left' });
                    }
                },
                error: function () {
                    toastr.error('Đã có lỗi xảy ra khi lưu vào giỏ hàng.', null, { positionClass: 'toast-bottom-left' });
                }
            });
        } else {
            toastr.warning('Phải có ít nhất một mục nhập với đầy đủ thông tin.', null, { positionClass: 'toast-bottom-left' });
        }
    });


    // Thông báo lỗi
    function showError(message) {
        toastr.error(message, null, { positionClass: 'toast-bottom-left' });
    }
});
