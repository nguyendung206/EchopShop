    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('click', '.product-heart', function(event) {
        event.preventDefault();
        var productId = $(this).data('productid');
        var $this = $(this);
        var urlDestroy = $this.data('url-destroy');
        var urlStore = $this.data('url-store');
        var $icon = $this.find('i');
        
        if ($this.hasClass('favorite-active')) {
            $.ajax({
                url: urlDestroy,
                method: "DELETE",
                success: function(response) {
                    $this.toggleClass('favorite-active');
                    $icon.removeClass('fa-solid').addClass('fa-regular');
                }
            })
        } else {
            $.ajax({
                url: urlStore,
                method: 'POST',
                data: {
                    productId: productId,
                },
                success: function(response) {
                    $this.toggleClass('favorite-active');
                    $icon.removeClass('fa-regular').addClass('fa-solid');
                    
                }
            });
        }
    });