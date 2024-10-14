<div class="col-lg-3 col-12 category-title-wrap-1">
    <div class="category-title-wrap">
        <div class="category-title">Danh mục sản phẩm</div>
        <div class="open-icon"><i class="fa-solid fa-arrow-down"></i></div>
    </div>
    <div class="category-wrap">
        <div class="category-1">
            @forelse($categories as $category)
            <div class="category-item">
                <input type="checkbox" class="category-checkbox" data-categoryid="{{ $category->id }}" />
                <label>{{ $category->name }}</label>
                <img src="{{ asset('/img/icon/extend.png') }}" alt="" class="toggle-brands" />

                <div class="category-item-wrap" style="display: none;">
                    @forelse($category->activeBrands as $brand)
                    <div style="margin-bottom: 0;">
                        <input type="checkbox" class="brand-checkbox" data-brandid="{{ $brand->id }}" />
                        <label>{{ $brand->name }}</label>
                    </div>
                    @empty
                    <div>Không có thương hiệu nào.</div>
                    @endforelse
                </div>
            </div>
            @empty
            <div class="text-center w-100 py-5">
                <span style="color:rgb(177,0,0);">Không có danh mục sản phẩm nào.</span>
            </div>
            @endforelse
        </div>

        <div class="category-title mt-4">Khu vực</div>
        <div class="category-2">
            @forelse($provinces as $province)
            <div class="category-2-item" data-provinceid="{{ $province->id }}">
                <input type="checkbox" class="province-checkbox" />
                <span>{{ $province->province_name }}</span>
            </div>
            @empty
            <div class="category-2-item" style="color:rgb(177,0,0);">
                Không có thông tin
            </div>
            @endforelse
        </div>

        <div class="category-title mt-4">Mức giá</div>
        <div class="category-3">
            <div class="box">
                <div class="slider">
                    <input type="range" id="rangeInput" min="0" max="2000000" value="0" />
                    <input type="range" id="rangeInput2" min="1000000" max="5000000" value="2000000" />
                </div>
                <div class="value">
                    <div id="value1">0</div>
                    <div id="value2" style="margin-left: 4px">- 2000000</div>
                </div>
            </div>
        </div>

        <div class="group-button-category-4 mt-4">
            <button id="destroy-filter-button">Huỷ</button>
            <button id="filter-button">Lọc</button>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {
        var selectedCategories = [];
        var selectedBrands = [];
        var selectedProvinces = [];
        var rangeInputMin = 0;
        var rangeInputMax = 2000000;

        // Toggle brand visibility when clicking on the extend icon
        $('.toggle-brands').on('click', function() {
            $(this).siblings('.category-item-wrap').slideToggle(); // Show or hide the brands
        });

        // Ensure only one category can be selected at a time
        $('.category-checkbox').on('change', function() {
            var categoryId = $(this).data('categoryid');
            if ($(this).is(':checked')) {
                $('.category-checkbox').not(this).prop('checked', false); // Deselect other categories
                selectedCategories = [categoryId]; // Replace with new selected category
            } else {
                selectedCategories = [];
            }
            console.log(selectedCategories);
        });

        // Brand checkbox click
        $('.brand-checkbox').on('change', function() {
            var brandId = $(this).data('brandid');
            if ($(this).is(':checked')) {
                selectedBrands.push(brandId);
            } else {
                selectedBrands = selectedBrands.filter(id => id !== brandId);
            }
            console.log(selectedBrands);
        });

        // Province checkbox click
        $('.province-checkbox').on('change', function() {
            var provinceId = $(this).closest('.category-2-item').data('provinceid');
            if ($(this).is(':checked')) {
                selectedProvinces.push(provinceId);
            } else {
                selectedProvinces = selectedProvinces.filter(id => id !== provinceId);
            }
            console.log(selectedProvinces);
        });

        // Adjust price range input
        $('#rangeInput').on('input', function() {
            rangeInputMin = $(this).val();
            $('#value1').text(rangeInputMin); // Update display value
        });

        $('#rangeInput2').on('input', function() {
            rangeInputMax = $(this).val();
            $('#value2').text(rangeInputMax); // Update display value
        });

        // Apply filter
        $('#filter-button').on('click', function() {
            console.log("123");
            
            $.ajax({
                url: '{{ route("filterProducts") }}',
                method: 'GET',
                data: {
                    categories: selectedCategories,
                    brands: selectedBrands,
                    provinces: selectedProvinces,
                    rangeInputMin: rangeInputMin,
                    rangeInputMax: rangeInputMax,
                },
                success: function(response) {
                    $('.list-product').html(response.productHtml);
                    var categoryNames = response.categoryNames.join(', ');
                    var brandNames = response.brandNames.join(', ');
                    var titleText = '';

                    if (categoryNames && brandNames) {
                        titleText = categoryNames + ' - ' + brandNames;
                    } else if (categoryNames) {
                        titleText = categoryNames;
                    } else if (brandNames) {
                        titleText = brandNames;
                    } else {
                        titleText = 'Sản phẩm';
                    }
                    $('.title-text').text(titleText);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        });

        // Clear filter
        $('#destroy-filter-button').on('click', function() {
            selectedCategories = [];
            selectedBrands = [];
            selectedProvinces = [];
            rangeInputMin = 0;
            rangeInputMax = 2000000;
            $('.category-checkbox, .brand-checkbox, .province-checkbox').prop('checked', false);
            $('#value1').text(rangeInputMin); // Reset displayed min value
            $('#value2').text(rangeInputMax); // Reset displayed max value

            $.ajax({
                url: '{{ route("filterProducts") }}',
                method: 'GET',
                data: {},
                success: function(response) {
                    $('.list-product').html(response.productHtml);
                    $('.title-text').text('Sản phẩm');
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>