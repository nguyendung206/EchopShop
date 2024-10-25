@extends('admin.layout.app')
@section('title')
@lang('Phí vận chuyển')
@endsection
@section('content')
<style>
    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: normal;
        height: 54px;
    }
</style>
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
                @if (!empty($districts) && count($districts))
                @foreach ($districts as $key => $district)
                <tr class="text-center">
                    <td class="font-weight-800 align-middle">{{ ($key + 1) + ($districts->currentPage() - 1) * $districts->perPage() }}</td>
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
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
<div class="pagination-us">
    <div class="aiz-pagination">
        {{ $districts->appends(request()->input())->links("pagination::bootstrap-4") }}
    </div>
</div>
<!-- Modal thêm-->
<div class="modal fade" id="wardModal" tabindex="-1" role="dialog" aria-labelledby="wardModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="wardModalLabel">@lang('Cập nhật thông tin ') {{$districts->first()->province_id}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="wardForm" action="{{route('admin.feeship.store')}}" method="post">
                    @csrf
                    <input type="hidden" name="province_id" value="{{$districts->first()->province_id}}">
                    <input type="hidden" name="district_id" id="district_id">
                    <div class="form-group">
                        <label for="ward-select">@lang('Chọn Phường/Xã')</label>
                        <select class="form-control" id="ward-select" name="ward_id">
                            <option value="">@lang('--Chọn Phường/Xã--')</option>
                            <!-- Danh sách từ ajax -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">@lang('Tên')</label>
                        <input type="text" class="form-control" id="name" name="feename" placeholder="@lang('Nhập tên')">
                    </div>
                    <div class="form-group">
                        <label for="price">@lang('Giá')</label>
                        <input type="number" class="form-control" id="price" name="feeship" placeholder="@lang('Nhập giá')">
                    </div>
                    <div class="form-group">
                        <label for="description">@lang('Mô tả')</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="@lang('Nhập mô tả')"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary float-right">@lang('Lưu')</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Feeship -->
<div class="modal fade" id="feeshipModal" tabindex="-1" role="dialog" aria-labelledby="feeshipModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document" style="max-width: 700px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="feeshipModalLabel">@lang('Thông tin phí vận chuyển')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>@lang('Phường/Xã')</th>
                            <th>@lang('Tên')</th>
                            <th>@lang('Giá')</th>
                            <th style="width: 200px;">@lang('Mô tả')</th>
                        </tr>
                    </thead>
                    <tbody id="feeship-data">
                        <!-- Dữ liệu sẽ được thêm vào đây -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    function showModal(districtId, districtName) {
        $.ajax({
            url: '/admin/get-wards',
            method: 'GET',
            data: {
                district_id: districtId
            },
            success: function(response) {
                const {
                    wards,
                    feeships
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
                console.error('Lỗi khi tải dữ liệu:', xhr.responseText);
                alert('Có lỗi xảy ra, vui lòng thử lại!');
            }
        });
    }

    $(document).on('click', '.open-modal', function() {
        var districtId = $(this).data('id');
        var districtName = $(this).data('name');
        showModal(districtId, districtName);
    });

    function showModalFeeship(districtId, districtName) {
        $.ajax({
            url: '/admin/get-wards',
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
                        <td>${ward.ward_name}</td>
                        <td>${feeship.feename || ''}</td>
                        <td ${feeship.id ? 'contenteditable="true"' : ''} 
                            data-id="${feeship.id || ''}" 
                            data-district_id="${districtId}" 
                            data-name="${districtName}" 
                            class="feeship-edit">
                            ${feeship.feeship || ''}
                        </td>
                        <td class="text-truncate-2">
                            ${feeship.description || ''}
                        </td>
                    </tr>
                `);
                });

                $('#feeshipModal').modal('show');
            },
            error: function(xhr) {
                console.error('Lỗi khi tải dữ liệu:', xhr.responseText);
                alert('Có lỗi xảy ra, vui lòng thử lại!');
            }
        });
    }

    $(document).on('click', '.open-modal-feeship', function() {
        const districtId = $(this).data('id');
        const districtName = $(this).data('name');
        showModalFeeship(districtId, districtName);
    });

    $(document).on('blur', '.feeship-edit', function() {
        const id = $(this).data('id');
        const value = $(this).text().trim();
        const districtId = $(this).data('district_id');
        const districtName = $(this).data('name');

        if (!id) {
            console.warn('Không tìm thấy ID phí ship để cập nhật!');
            return;
        }

        $.ajax({
            url: '/admin/update-feeship',
            method: 'POST',
            data: {
                id: id,
                value: value,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                showModalFeeship(districtId, districtName);
            },
            error: function(xhr) {
                console.error('Lỗi khi cập nhật:', xhr.responseText);
                alert('Có lỗi xảy ra, vui lòng thử lại!');
            }
        });
    });
</script>
@endsection