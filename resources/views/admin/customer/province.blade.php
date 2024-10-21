 <script>
     var provinceIdUser = 0;
     var districtIdUser = 0;
     var wardIdUser = 0;
     var firstChange = true;

     var user = @json($user ?? null);
     if(user != null) {
     provinceIdUser = user.province_id;
     districtIdUser = user.district_id;
     wardIdUser = user.ward_id;
    }
    
    // ưu tiên old
     if(@json(old('province_id')) !== null){ // province != null
        provinceIdUser = @json(old('province_id'));
        if(@json(old('district_id')) !== null) {    // district / ward chưa chắc != null
            districtIdUser = @json(old('district_id'));
        }
        if(@json(old('ward_id')) !== null) {
            
            wardIdUser = @json(old('ward_id'));
        }
    }
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
                     $('#ward_select').empty().append('<option value="0"  selected>Phường/Thị xã *</option>');  // get ward
                     $.each(response.wards, function(index, ward) {
                         $('#ward_select').append('<option value="' + ward.id + '">' + ward.ward_name + '</option>');
                     });

                    if((wardIdUser !== 0 || @json(old('ward_id')) !== null) && firstChange) {
                         $('#ward_select').val(wardIdUser).trigger('change');
                         firstChange = false;
                    }
                            
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
                 $('#district_select').empty().append('<option value="0"  selected>Quận/Huyện *</option>'); // get lại district
                 $.each(response.districts, function(index, district) {
                     $('#district_select').append('<option value="' + district.id + '" >' + district.district_name + '</option>');
                 });
 
                 $('#ward_select').empty().append('<option value="0"  selected>Phường/Thị xã *</option>'); // set lại ward
                $('#ward_select').append('<option value="0" >Vui lòng chọn quận huyện trước</option>');

                    
                    if((districtIdUser != 0 || @json(old('province_id')) !== null) && firstChange){ // nếu có district id
                        $('#district_select').val(districtIdUser).trigger('change');
                    }else {
                        firstChange = false;
                    }
                    if((wardIdUser == 0 && @json(old('ward_id')) == null) && firstChange) { // nếu không có ward id
                        $('#ward_select').empty().append('<option value="0"  selected>Phường/Thị xã *</option>');
                        $('#ward_select').append('<option value="0" >Vui lòng chọn quận huyện trước</option>');
                        firstChange = false;
                    }

                 
             },
             error: function(xhr) {
                 console.error(xhr.responseText);
             }
         });
     });

     if(user != null || @json(old('province_id')) !== null) {
         $('#province_select').val(provinceIdUser).trigger('change');
     }
     
 </script>