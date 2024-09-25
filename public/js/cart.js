$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('click', '#btn-cart', function (event) {
        event.preventDefault();
        var productId = $(this).data('id');
        var urlAddToCart = $(this).data('url-add-to-cart');

        $.ajax({
            url: urlAddToCart,
            method: 'POST',
            data: {
                productId: productId
            },
            success: function (response) {
                if (response.status === 'success') {
                    toastr.success(response.message, null, { positionClass: 'toast-bottom-left' });
                } else {
                    toastr.error(response.message, null, { positionClass: 'toast-bottom-left' });
                }
            },
        });
    });
});
