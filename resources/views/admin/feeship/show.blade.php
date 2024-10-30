@extends('admin.layout.app')
@section('title')
@lang('Phí vận chuyển')
@endsection
@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="align-items-center">
        <h1 class="h3">
            <strong>
                @lang('Phí vận chuyển:') {{ optional($districts->first()->province)->province_name }}
            </strong>
        </h1>
    </div>
</div>
<div class="card mx-auto" style="max-width: 700px;">
    <div class="custom-overflow repon">
        <table class="table aiz-table mb-0 table_repon">
            <thead>
                <tr class="text-center">
                    <th class="w-60 font-weight-800">STT</th>
                    <th class="">@lang('Quận/Huyện')</th>
                    <th class="w-150">Chi tiết / Bổ sung</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($districts as $key => $district)
                <tr class="text-center">
                    <td class="font-weight-bold align-middle">
                        {{ $key + 1 }}
                    </td>
                    <td class="font-weight-400 align-middle text-overflow">{{$district->district_name ?? ""}}</td>
                    <td class="text-center">
                        <a class="btn mb-1 btn-soft-primary btn-icon btn-circle btn-sm open-modal-feeship" href="#"
                            data-id="{{ $district->id }}" data-name="{{ $district->district_name }}" title="@lang('Show')">
                            <i class="las la-bars"></i>
                        </a>
                        <a class="btn mb-1 btn-soft-success btn-icon btn-circle btn-sm open-modal" href="#"
                            data-id="{{ $district->id }}" data-name="{{ $district->district_name }}" title="@lang('Bổ sung')">
                            <i class="las la-plus"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="100%" class="text-center">@lang('Không có dữ liệu')</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@include('admin.feeship.modalfeeship')
@endsection
@section('script')
<script>
    function showModal(districtId, districtName) {
        $.ajax({
            url: '{{ route("admin.getWards") }}',
            method: 'GET',
            data: {
                district_id: districtId
            },
            success: function(response) {
                const {
                    wards
                } = response;

                $('#district_id').val(districtId);
                $('#wardModalLabel').text(`@lang('Cập nhật thông tin cho ') ${districtName}`);

                $('#ward-select').empty().append('<option value="">@lang("--Chọn Phường/Xã--")</option>');

                wards.forEach(function(ward) {
                    $('#ward-select').append(`<option value="${ward.id}">${ward.ward_name}</option>`);
                });

                $('#wardModal').modal('show');
            },
            error: function(xhr) {
                toastr.error('Đã có lỗi xảy ra. Vui lòng thử lại!', null, {
                    positionClass: 'toast-bottom-left'
                });
            }
        });
    }

    $('#wardForm').on('submit', function(event) {
        event.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message, null, {
                        positionClass: 'toast-bottom-left'
                    });
                    $('#wardModal').modal('hide');
                }
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;

                $('.invalid-feedback').remove();

                $.each(errors, function(key, message) {
                    $(`[name=${key}]`).addClass('is-invalid');
                    $(`[name=${key}]`).after(`<div class="invalid-feedback">${message}</div>`);
                });

                toastr.error('Có lỗi xảy ra khi thêm chi phí!', null, {
                    positionClass: 'toast-bottom-left'
                });
            }
        });
    });


    $(document).on('click', '.open-modal', function() {
        var districtId = $(this).data('id');
        var districtName = $(this).data('name');
        showModal(districtId, districtName);
    });

    function showModalFeeship(districtId, districtName) {
        $.ajax({
            url: '{{ route("admin.getWards") }}',
            method: 'GET',
            data: {
                district_id: districtId
            },
            success: function(response) {
                const {
                    wards,
                    feeships
                } = response;

                $('#feeshipModalLabel').text('@lang("Thông tin phí vận chuyển của ") ' + districtName);
                $('#feeship-data').empty();

                wards.forEach(ward => {
                    const feeship = feeships[ward.id] || {};

                    $('#feeship-data').append(`
                    <tr class="text-center">
                        <td class="align-middle">${ward.ward_name}</td>
                        <td class="align-middle">${feeship.feename || ''}</td>
                        <td class="align-middle">${feeship.feeship || ''}</td>
                        <td class="align-middle">${feeship.description || ''}</td>
                        <td class="align-middle">
                            ${feeship.id ? `
                                <button class="btn mb-1 btn-soft-primary btn-icon btn-circle btn-sm edit-feeship" 
                                        data-id="${feeship.id}"
                                        data-ward-id="${ward.id}"
                                        data-ward-name="${ward.ward_name}"
                                        data-feename="${feeship.feename || ''}"
                                        data-feeship="${feeship.feeship || ''}"
                                        data-description="${feeship.description || ''}">
                                    <i class="las la-edit"></i>
                                </button>
                                <button class="btn btn-delete btn-soft-danger btn-icon btn-circle btn-sm confirm-delete delete-feeship" 
                                        data-id="${feeship.id}">
                                    <i class="las la-trash"></i>
                                </button>
                            ` : ''}
                        </td>
                    </tr>
                `);
                });
                $('#feeshipModal').modal('show');
            },
            error: function(xhr) {
                toastr.error('Đã có lỗi xảy ra. Vui lòng thử lại!', null, {
                    positionClass: 'toast-bottom-left'
                });
            }
        });
    }

    $(document).on('click', '.open-modal-feeship', function() {
        const districtId = $(this).data('id');
        const districtName = $(this).data('name');
        showModalFeeship(districtId, districtName);
    });


    $(document).on('click', '.edit-feeship', function() {
        const id = $(this).data('id');
        const wardId = $(this).data('ward-id');
        const wardName = $(this).data('ward-name');
        const feename = $(this).data('feename');
        const feeship = $(this).data('feeship');
        const description = $(this).data('description');

        $('#id').val(id);
        $('#wardId').val(wardId);
        $('#wardName').val(wardName);
        $('#feename').val(feename);
        $('#feeship').val(feeship);
        $('#feeshipDescription').val(description);
    });

    // Xử lý sự kiện submit form
    $('#feeshipForm').on('submit', function(e) {
        e.preventDefault();
        const id = $('#id').val();
        const data = {
            feename: $('#feename').val(),
            feeship: $('#feeship').val(),
            description: $('#feeshipDescription').val()
        };
        $.ajax({
            url: `{{ route('admin.feeship.update', ':id') }}`.replace(':id', id),
            method: 'PUT',
            data: data,
            success: function(response) {
                toastr.success(response.message, null, {
                    positionClass: 'toast-bottom-left'
                });
                showModalFeeship(response.feeship.district_id, response.districtName);
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;

                $('.invalid-feedback').remove();

                $.each(errors, function(key, message) {
                    $(`[name=${key}]`).addClass('is-invalid');
                    $(`[name=${key}]`).after(`<div class="invalid-feedback">${message}</div>`);
                });

                toastr.error('Có lỗi xảy ra khi thêm chi phí!', null, {
                    positionClass: 'toast-bottom-left'
                });
            }
        });
    });

    $(document).on('click', '.delete-feeship', function() {
        let delete_id = $(this).attr('data-id');

        Swal.fire({
            title: '@lang("Xóa Chi phí")',
            text: '@lang("Bạn có muốn xóa Chi phí này không ?")',
            icon: 'warning',
            confirmButtonText: '@lang("Có")',
            cancelButtonText: '@lang("Không")',
            showCancelButton: true,
            showCloseButton: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: `{{ route('admin.feeship.destroy', ':id') }}`.replace(':id', delete_id),
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Xóa thành công!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            showModalFeeship(response.districtId, response.districtName);
                        });
                    },
                    error: function(err) {
                        let errorMessage = err.responseJSON?.message || 'Đã xảy ra lỗi!';
                        Swal.fire('Đã xảy ra lỗi!', errorMessage, 'error');
                    }
                });
            }
        });
    });
</script>
@endsection