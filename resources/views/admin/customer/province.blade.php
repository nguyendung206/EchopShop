 <script>
     var provinceIdUser = 0;
     var districtIdUser = 0;
     var wardIdUser = 0;
     @if(isset($user -> province_id) && isset($user -> district_id) && isset($user -> ward_id))
     provinceIdUser = "{{ $user->province_id }}";
     districtIdUser = "{{ $user->district_id }}";
     wardIdUser = "{{ $user->ward_id }}";
     @endif
     @if(old('province_id') !== null && old('district_id') !== null && old('ward_id') !== null)
     provinceIdUser = "{{ old('province_id') }}";
     districtIdUser = "{{ old('district_id') }}";
     wardIdUser = "{{ old('ward_id') }}";
     @endif
     $(document).ready(function() {
         $('#district_select').on('change', function() {

             var districtId = $(this).val(); // Lấy giá trị được chọn
             $.ajax({
                 url: '{{ route("web.ward") }}',
                 method: 'POST',
                 data: {
                     _token: '{{ csrf_token() }}',
                     districtId: districtId
                 },
                 success: function(response) {
                     $('#ward_select').empty().append('<option value="0" disabled>Phường/Thị xã *</option>');

                     $.each(response.wards, function(index, ward) {
                         $('#ward_select').append('<option value="' + ward.id + '">' + ward.ward_name + '</option>');
                     });

                     @if(isset($user -> ward_id))
                     if (districtId == districtIdUser) {
                         $('#ward_select').val(wardIdUser).trigger('change');
                     }
                     @endif
                 },
                 error: function(xhr) {
                     console.error(xhr.responseText);
                 }
             });
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
                 $('#district_select').empty().append('<option value="0" disabled>Quận/Huyện *</option>');

                 $.each(response.districts, function(index, district) {

                     $('#district_select').append('<option value="' + district.id + '" >' + district.district_name + '</option>');
                 });
                 @if(isset($user -> district_id))
                 if (provinceId == provinceIdUser) {
                     $('#district_select').val(districtIdUser).trigger('change');
                 }
                 $('#ward_select').empty().append('<option value="0" disabled>Phường/Thị xã *</option>');
                 $('#ward_select').append('<option value="0" disabled>Vui lòng chọn quận huyện trước</option>');
                 @else
                 $('#ward_select').empty().append('<option value="0" disabled>Phường/Thị xã *</option>');
                 $('#ward_select').append('<option value="0" disabled>Vui lòng chọn quận huyện trước</option>');
                 @endif
             },
             error: function(xhr) {
                 console.error(xhr.responseText);
             }
         });
     });

     @if(isset($user -> province_id))

     $('#province_select').val(provinceIdUser).trigger('change');
     @endif
 </script>