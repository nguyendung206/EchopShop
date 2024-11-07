@extends('web.layout.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('/css/profile.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/pay.css') }}" />
@endsection
@section('content')
    <div class="profile-slider">
        <h1 class="profile-heading text-center">Địa chỉ của tôi</h1>
    </div>
    @include('web.profile.sidebarMobile')
    <div class="container">
        <div class="row">
            @include('web.profile.sidebar')
            <div class="col-lg-9 col-sm-12 col-12 mt-4">
                <div class="col-md-12">
                    <h1 class="profile-title d-flex justify-content-between align-items-center">
                        <p>Địa chỉ của tôi</p>
                        <button class="profile-update-btn profile-update-btn-2 text-center " id="btn-add-address"
                            style="font-weight: 400; font-size: 12px; border-radius: 2px;">
                            <i class="fa-regular fa-pen-to-square"></i> Thêm địa chỉ mới
                        </button>
                    </h1>
                </div>
                <div class="col-md-12">
                    @foreach ($addresses as $address)
                        <hr>
                        <div class="my-4 d-flex align-items-center">
                            <div class="col-lg-9 col-6">
                                <p class="mt-1">{{ $address->user_name }}</p>
                                <p class="mt-1" style="color: rgba(0,0,0,0.54)">(+84) {{ $address->phone }}</p>
                                <p class="mt-1" style="color: rgba(0,0,0,0.54)">{{ $address->street }}</p>
                                <p class="mt-1" style="color: rgba(0,0,0,0.54)">{{ $address->ward->ward_name }},
                                    {{ $address->district->district_name }}, {{ $address->province->province_name }}.</p>

                            </div>
                            <div class="text-right col-lg-3 col-6">
                                <p class="my-2 btn-update-address" data-shipping-address-id="{{ $address->id }}"
                                    style="font-size: 12px; color: #B10000; cursor: pointer;">Cập nhật</p>
                                @if ($address->is_default)
                                    <span class="d-inline-block my-2"
                                        style="color: #B10000; padding: 4px 6px; font-size: 12px; border: 1px solid #B10000; border-radius: 2px;">Mặc
                                        định</span>
                                @else
                                    <a href="{{ route('profile.address.updateDefault', $address->id) }}"
                                        style="border: 1px solid rgba(0,0,0,0.54); background-color: transparent; font-size: 12px; padding: 4px 6px; cursor: pointer; border-radius: 2px;color: rgba(0,0,0,0.54);">Thiết
                                        lập mặc định</a>
                                @endif
                                <p class="my-2 btn-delete-address" data-shipping-address-id="{{ $address->id }}"
                                    style="font-size: 12px; color: #B10000; cursor: pointer;">Xoá</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- modal change address --}}
    <div class="address-layer" id="addressLayer">
        <form action="{{ route('order.changeAddress') }}" method="POST" id="changeAddressForm">
            @csrf
            <div class="address-modal row" id="addressModal">
                <h6 class="col-12 mt-3 mb-4">Cập nhật địa chỉ</h6>
                <div class="form-group col-12">
                    <label class="address-label">Tên người nhận<span class="text-vali">&#9913;</span></label>
                    <div class="">
                        <input type="text" placeholder="Nhập tên người nhận" name="user_name" class="form-control"
                            value="">
                    </div>
                </div>
                <div class="form-group col-lg-6 col-12">
                    <label class="address-label">Địa chỉ<span class="text-vali">&#9913;</span></label>
                    <div class="">
                        <input type="text" placeholder="Nhập địa chỉ" id="addressForm" name="street"
                            class="form-control" value="">
                    </div>
                </div>
                <div class="form-group col-lg-6 col-12">
                    <label class="address-label">Số điện thoại<span class="text-vali">&#9913;</span></label>
                    <div class="">
                        <input type="text" placeholder="Nhập số điện thoại" id="phoneNumberForm" name="phone"
                            class="form-control" value="">
                    </div>
                </div>
                <div class="form-group col-12">
                    <label class="address-label">Thành Phố<span class="text-vali">&#9913;</span></label></label>
                    <div class="">
                        <select class="text-center form-control font-weight-500" name="province_id" id="province_select">
                            <option class=" text-center" value="0" disabled>Tỉnh/Thành phố *</option>
                            @foreach ($provinces as $province)
                                <option class=" text-center" value="{{ $province->id }}">
                                    {{ $province->province_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group col-lg-6 col-12">
                    <label class="address-label">Quận/Huyện <span class="text-vali">&#9913;</span></label></label>
                    <div class="">
                        <select class="text-center form-control font-weight-500" name="district_id" id="district_select">
                            <option value="0" class=" text-center" disabled>Quận/Huyện *</option>
                            <option value="0" class=" text-center" disabled>Vui lòng chọn thành phố trước
                            </option>
                        </select>
                    </div>
                </div>

                <div class="form-group col-lg-6 col-12">
                    <label class="address-label">Phường/Thị xã <span class="text-vali">&#9913;</span></label></label>
                    <div class="">
                        <select class="text-center form-control font-weight-500" name="ward_id" id="ward_select">
                            <option value="0" class=" text-center" disabled>Phường/Thị xã *</option>
                            <option value="0" class=" text-center" disabled>Vui lòng chọn quận huyện trước
                            </option>
                        </select>
                    </div>
                </div>

                <div class="form-group col-12">
                    <input type="radio" name="type_address" value="{{ TypeAddressEnums::HOME->value }}" checked> <span
                        class="ml-1" style="color: rgba(0,0,0,0.54);">Nhà riêng</span>
                    <input class="ml-3" type="radio" name="type_address"
                        value="{{ TypeAddressEnums::OFFICE->value }}"> <span class="ml-1"
                        style="color: rgba(0,0,0,0.54);">Văn phòng</span>
                    <input class="ml-3" type="radio" name="type_address"
                        value="{{ TypeAddressEnums::OTHER->value }}"> <span class="ml-1"
                        style="color: rgba(0,0,0,0.54);">Khác</span>
                </div>

                <div class="form-group col-12">
                    <input type="checkbox" name="is_default"> <span class="ml-1" style="color: rgba(0,0,0,0.54);">Đặt
                        làm mặc định</span>
                </div>
                <input type="hidden" name="shipping_address_id" value="">
                <div class="col-12 text-right">
                    <button class="cancel b-radius" id="addressCancel" type="button">Huỷ</button>
                    <button class="buy b-radius" id="submitChangeAddress" type="submit">Thay đổi</button>
                </div>
            </div>
        </form>
    </div>

    <div id="deleteModal" class="modal-delete" style="display: none;">
        <div class="modal-delete-content">
            <div class="modal-delete-header">
                <h4>Xóa địa chỉ này</h4>
                <span class="modal-delete-close">&times;</span>
            </div>
            <div class="modal-delete-body">
                <p>Bạn có muốn xóa địa chỉ này không?</p>
            </div>
            <div class="modal-delete-footer text-right">
                <button id="cancelDelete" class="btn btn-secondary">Không</button>
                <button id="confirmDelete" class="btn btn-danger">Có</button>
            </div>
        </div>
    </div>

@section('script')
    <script>
        $(document).ready(function() {

            $('#btnChangeAddress').on('click', function() {

                $('#addressLayer').fadeIn();

            });

            $('#addressLayer').on('click', function(e) {
                if ($(e.target).is('#addressLayer')) {
                    $('#addressLayer').fadeOut();
                }
            });
            var districtId = 0;
            var wardId = 0;
            $('.btn-update-address').on('click', function(e) {
                $('.error-message').remove();
                var addressId = $(this).data('shipping-address-id');
                var addressSelected = @json($addresses).find(function(address) {
                    return address.id == addressId;
                });
                $('#changeAddressForm input[name="shipping_address_id"]').val(addressId);
                $('#changeAddressForm input[name="user_name"]').val(addressSelected.user_name);
                $('#changeAddressForm input[name="phone"]').val(addressSelected.phone);
                $('#changeAddressForm input[name="street"]').val(addressSelected.street);
                districtId = addressSelected.district_id;
                wardId = addressSelected.ward_id;
                $('#province_select').val(addressSelected.province_id).change();
                $('#changeAddressForm input[name="is_default"]').prop('checked', addressSelected
                .is_default);
                $('#changeAddressForm input[name="type_address"][value="' + addressSelected.type_address +
                    '"]').prop('checked', true);
                $('#changeAddressForm').attr('action', '{{ route('order.changeAddress') }}');
                $('#submitChangeAddress').text('Thay đổi')
                $('#addressLayer').fadeIn();
            });

            $('#btn-add-address').on('click', function(e) {
                $('.error-message').remove();
                $('#changeAddressForm input[name="user_name"]').val('');
                $('#changeAddressForm input[name="phone"]').val('');
                $('#changeAddressForm input[name="street"]').val('');
                $('#changeAddressForm input[name="is_default"]').prop('checked', false);
                $('#changeAddressForm input[name="type_address"][value="' + @json(TypeAddressEnums::HOME->value) +
                    '"]').prop('checked', true);
                $('#province_select').val(0).change();
                $('#district_select').trigger('change');

                $('#changeAddressForm').attr('action', '{{ route('order.addAddress') }}');

                $('#addressShowLayer').fadeOut();
                $('#submitChangeAddress').text('Thêm địa chỉ')
                $('#addressLayer').fadeIn();
            })

            $('#district_select').on('change', function() {
                districtId = $(this).val();

                $.ajax({
                    url: '{{ route('web.ward') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        districtId: districtId
                    },
                    success: function(response) {
                        $('#ward_select').empty().append(
                            '<option value="0"  selected>Phường/Thị xã *</option>'); // get ward
                        $.each(response.wards, function(index, ward) {
                            $('#ward_select').append(
                                `<option value=${ward.id} ${ward.id == wardId ? 'selected' : ''}>${ward.ward_name}</option>`
                                );
                        });
                    }
                });
            });


            $('#province_select').on('change', function() {
                var provinceId = $(this).val(); // Lấy giá trị được chọn
                $.ajax({
                    url: '{{ route('web.district') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        provinceId: provinceId
                    },
                    success: function(response) {
                        $('#district_select').empty().append(
                            '<option value="0"  selected>Quận/Huyện *</option>'
                            ); // get lại district
                        $.each(response.districts, function(index, district) {
                            $('#district_select').append(
                                `<option value=${district.id} ${district.id == districtId ? 'selected' : ''}>${district.district_name}</option>`
                                );
                        });

                        $('#ward_select').empty().append(
                            '<option value="0"  selected>Phường/Thị xã *</option>'
                            ); // set lại ward
                        $('#ward_select').append(
                            '<option value="0" >Vui lòng chọn quận huyện trước</option>');
                        $('#district_select').trigger('change')
                    }
                });
            });

            $('#addressCancel').on('click', function(e) {
                if ($(e.target).is('#addressCancel')) {
                    $('#addressLayer').fadeOut();
                    $('#addressShowLayer').fadeIn();
                }
            });

            let delete_id;
            $('.btn-delete-address').on('click', function() {
                delete_id = $(this).data('shipping-address-id');
                $('#deleteModal').show();

            })

            $('#confirmDelete').on('click', function() {
                $.ajax({
                    type: "DELETE",
                    url: `${@json(route('profile.deleteAddress', ['id' => '__id__']))}`.replace('__id__', delete_id),
                    data: {
                        _token: $('meta[name="csrf-token"]').attr(
                            'content') // Truyền token CSRF vào dữ liệu
                    },
                    success: function(response) {
                        location.reload();
                    },
                    error: function(err) {}
                });
                $('#deleteModal').hide();
            });

            $('#cancelDelete, .modal-delete-close').on('click', function() {
                $('#deleteModal').hide();
            });

            $('#changeAddressForm').submit(function(e) {
                e.preventDefault(); // Ngừng việc gửi form theo cách thông thường

                $('.error-message').remove();

                var isValid = true;
                if ($('input[name="user_name"]').val() == '') {
                    isValid = false;
                    $('input[name="user_name"]').after(
                        '<div class="error-message" style="color: red;font-size: 12px;margin-top: 8px;">Tên người nhận không được để trống.</div>'
                        );
                }

                if ($('input[name="street"]').val() == '') {
                    isValid = false;
                    $('input[name="street"]').after(
                        '<div class="error-message" style="color: red;font-size: 12px;margin-top: 8px;">Địa chỉ không được để trống.</div>'
                        );
                }
                if ($('input[name="phone"]').val() == '') {
                    isValid = false;
                    $('input[name="phone"]').after(
                        '<div class="error-message" style="color: red;font-size: 12px;margin-top: 8px;">Số điện thoại không được để trống.</div>'
                        );
                }
                if ($('select[name="province_id"]').val() == '0' || $('select[name="province_id"]').val() ==
                    null) {

                    isValid = false;
                    $('select[name="province_id"]').after(
                        '<div class="error-message" style="color: red;font-size: 12px;margin-top: 8px;">Vui lòng chọn thành phố.</div>'
                        );
                }

                if ($('select[name="district_id"]').val() == '0') {
                    isValid = false;
                    $('select[name="district_id"]').after(
                        '<div class="error-message" style="color: red;font-size: 12px;margin-top: 8px;">Vui lòng chọn quận huyện.</div>'
                        );
                }

                if ($('select[name="ward_id"]').val() == '0') {
                    isValid = false;
                    $('select[name="ward_id"]').after(
                        '<div class="error-message" style="color: red;font-size: 12px;margin-top: 8px;">Vui lòng chọn phường/thị xã.</div>'
                        );
                }
                if (isValid) {
                    this.submit();
                }
            });

        });
    </script>
@endsection
@endsection
