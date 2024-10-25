$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.choose').on('change', function () {
        let action = $(this).attr('id');
        let id = $(this).val(); 
        let result = '';

        if (action === 'province') {
            result = 'district';
        } else if (action === 'district') {
            result = 'ward';
        }

        if (result) {
            $.ajax({
                url: '/admin/select-feeship',
                method: 'POST',
                data: {
                    action: action,
                    id: id,
                },
                success: function (data) {
                    if (result === 'district') {
                        $('#' + result).empty().append('<option value="">--Chọn Quận/Huyện--</option>');

                        data.forEach(function (item) {
                            $('#' + result).append('<option value="' + item.id + '">' + item.district_name + '</option>');
                        });
                    } else {
                        $('#' + result).empty().append('<option value="">--Chọn Phường/Thị xã--</option>');

                        data.forEach(function (item) {
                            $('#' + result).append('<option value="' + item.id + '">' + item.ward_name + '</option>');
                        });
                    }
                },
                error: function (xhr) {
                    console.error('Lỗi khi tải dữ liệu:', xhr.responseText);
                }
            });
        } else {
            console.warn('Không có kết quả hợp lệ cho action:', action);
        }
    });
});
