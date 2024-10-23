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
                <h1 class="profile-title d-flex justify-content-between align-items-center"><p>Địa chỉ của tôi</p>
                    <button class="profile-update-btn profile-update-btn-2 text-center " id="btn-add-address" style="font-weight: 400; font-size: 12px; border-radius: 2px;">
                        <i class="fa-regular fa-pen-to-square" ></i> Thêm địa chỉ mới
                    </button>
                </h1>
            </div>
            <div class="col-md-12">
                @foreach ($addresses as $address)
                <hr>
                <div class="my-4 d-flex align-items-center">
                    <div style="flex-grow: 1">
                        <p class="mt-1">{{$address->user_name}}</p>
                        <p class="mt-1" style="color: rgba(0,0,0,0.54)">(+84) {{$address->phone}}</p>
                        <p class="mt-1" style="color: rgba(0,0,0,0.54)">{{$address->street}}</p>
                        <p class="mt-1" style="color: rgba(0,0,0,0.54)">{{$address->ward->ward_name}}, {{$address->district->district_name}}, {{$address->province->province_name}}.</p>
                        
                    </div>
                    <div class="text-right">
                        <p class="my-2 btn-update-address" data-shipping-address-id="{{$address->id}}" style="font-size: 12px; color: #B10000; cursor: pointer;">Cập nhật</p>
                        @if ($address->is_default)
                            <span class="d-inline-block my-2" style="color: #B10000; padding: 4px 6px; font-size: 12px; border: 1px solid #B10000; border-radius: 2px;">Mặc định</span>
                        @else
                        <a href="{{route("profile.address.updateDefault", $address->id)}}" style="border: 1px solid rgba(0,0,0,0.54); background-color: transparent; font-size: 12px; padding: 4px 6px; cursor: pointer; border-radius: 2px;color: rgba(0,0,0,0.54);">Thiết lập mặc định</a>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- modal change address --}}
<div class="address-layer" id="addressLayer">
    <form action="{{ route('order.changeAddress') }}" method="POST" id="changeAddressForm" >
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
                    <input type="text" placeholder="Nhập địa chỉ" id="addressForm" name="street" class="form-control"
                        value="">
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
                    <select class="text-center form-control font-weight-500" name="province_id"
                        id="province_select">
                        <option class=" text-center" value="0" disabled>Tỉnh/Thành phố *</option>
                        @foreach ($provinces as $province)
                            <option class=" text-center" value="{{ $province->id }}">
                                {{ $province->province_name }}</option>
                        @endforeach
                    </select>
                    @error('province_id')
                        <div style="width: 100%;margin-top: .25rem;font-size: 80%;color: #dc3545;">
                            {{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group col-lg-6 col-12">
                <label class="address-label">Quận/Huyện <span
                        class="text-vali">&#9913;</span></label></label>
                <div class="">
                    <select class="text-center form-control font-weight-500" name="district_id"
                        id="district_select">
                        <option value="0" class=" text-center" disabled>Quận/Huyện *</option>
                        <option value="0" class=" text-center" disabled>Vui lòng chọn thành phố trước
                        </option>
                    </select>
                    @error('district_id')
                        <div style="width: 100%;margin-top: .25rem;font-size: 80%;color: #dc3545;">
                            {{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group col-lg-6 col-12">
                <label class="address-label">Phường/Thị xã <span
                        class="text-vali">&#9913;</span></label></label>
                <div class="">
                    <select class="text-center form-control font-weight-500" name="ward_id"
                        id="ward_select">
                        <option value="0" class=" text-center" disabled>Phường/Thị xã *</option>
                        <option value="0" class=" text-center" disabled>Vui lòng chọn quận huyện trước
                        </option>
                    </select>
                    @error('ward_id')
                        <div style="width: 100%;margin-top: .25rem;font-size: 80%;color: #dc3545;">
                            {{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group col-12">
                <input type="radio" name="type_address" value="{{TypeAddressEnums::HOME->value}}" checked> <span class="ml-1" style="color: rgba(0,0,0,0.54);">Nhà riêng</span>
                <input class="ml-3" type="radio" name="type_address" value="{{TypeAddressEnums::OFFICE->value}}"> <span class="ml-1" style="color: rgba(0,0,0,0.54);">Văn phòng</span>
                <input class="ml-3" type="radio" name="type_address" value="{{TypeAddressEnums::OTHER->value}}"> <span class="ml-1" style="color: rgba(0,0,0,0.54);">Khác</span>
            </div>

            <div class="form-group col-12">
                <input type="checkbox" name="is_default"> <span class="ml-1" style="color: rgba(0,0,0,0.54);">Đặt làm mặc định</span>
            </div>
            <input type="hidden" name="shipping_address_id" value="">
            <div class="col-12 text-right">
                <button class="cancel b-radius" id="addressCancel" type="button">Huỷ</button>
                <button class="buy b-radius" id="submitChangeAddress" type="submit">Thay đổi</button>
            </div>
        </div>
    </form>
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
            $('.btn-update-address').on('click', function (e){
                console.log("alo");
                
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
                $('#changeAddressForm input[name="is_default"]').prop('checked', addressSelected.is_default);
                $('#changeAddressForm input[name="type_address"][value="' + addressSelected.type_address + '"]').prop('checked', true);
                $('#submitChangeAddress').text('Thay đổi')
                $('#addressLayer').fadeIn();
            });

            $('#btn-add-address').on('click', function (e) {
                $('#changeAddressForm input[name="user_name"]').val('');
                $('#changeAddressForm input[name="phone"]').val('');
                $('#changeAddressForm input[name="street"]').val('');
                $('#changeAddressForm input[name="is_default"]').prop('checked', false);
                $('#changeAddressForm input[name="type_address"][value="' + @json(TypeAddressEnums::HOME->value) + '"]').prop('checked', true);
                $('#province_select').val(0).change();
                $('#district_select').trigger('change');

                $('#changeAddressForm').attr('action', '{{ route("order.addAddress") }}');
                
                $('#addressShowLayer').fadeOut();
                $('#submitChangeAddress').text('Thêm địa chỉ')
                $('#addressLayer').fadeIn();
            })

            $('#district_select').on('change', function() {
                districtId = $(this).val();
                
                $.ajax({
                    url: '{{ route("web.ward") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        districtId: districtId
                    },
                    success: function(response) {
                        $('#ward_select').empty().append('<option value="0"  selected>Phường/Thị xã *</option>');  // get ward
                        $.each(response.wards, function(index, ward) {
                            $('#ward_select').append(`<option value=${ward.id} ${ward.id == wardId ? 'selected' : ''}>${ward.ward_name}</option>`);
                        });
                    }
                });
            });


            $('#province_select').on('change', function() {
                var provinceId = $(this).val(); // Lấy giá trị được chọn
                $.ajax({
                url: '{{ route("web.district") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    provinceId: provinceId
                },
                success: function(response) {
                    $('#district_select').empty().append('<option value="0"  selected>Quận/Huyện *</option>'); // get lại district
                    $.each(response.districts, function(index, district) {
                        $('#district_select').append(`<option value=${district.id} ${district.id == districtId ? 'selected' : ''}>${district.district_name}</option>`);
                    });

                    $('#ward_select').empty().append('<option value="0"  selected>Phường/Thị xã *</option>'); // set lại ward
                $('#ward_select').append('<option value="0" >Vui lòng chọn quận huyện trước</option>');
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

        });
    </script>
@endsection
@endsection