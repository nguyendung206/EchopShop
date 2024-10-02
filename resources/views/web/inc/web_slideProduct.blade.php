@php
    $currentUrl = url()->current();
    $route = '';

    switch (true) {
        case strpos($currentUrl, 'secondhand') !== false:
            $route = route('secondhandProduct');
            break;
        case strpos($currentUrl, 'exchange') !== false:
            $route = route('exchangeProduct');
            break;
            case strpos($currentUrl, 'giveaway') !== false:
            $route = route('giveawayProduct');
            break;
        default:
            $route = '#'; // Giá trị mặc định nếu không khớp với bất kỳ trường hợp nào
            break;
    }
@endphp

<div class="col-lg-3 col-12 category-title-wrap-1">
<div class="category-title-wrap">
    <div class="category-title">Danh mục sản phẩm</div>
    <div class="open-icon"><i class="fa-solid fa-arrow-down"></i></div>
</div>
<div class="category-wrap">
    <div class="category-1">
        @forelse($categories as $category)
        <div class="category-item">
            <div class="custom-checkbox-category" data-categoryid="{{$category->id}}"></div><label>{{$category->name}}</label><img src="{{ asset('/img/icon/extend.png') }}" alt="" />
            <div class="category-item-wrap">
                @forelse($category->activeBrands as $brand)
                <div class="category-1-item" data-brandid="{{ $brand->id }}">
                    <div class="custom-checkbox"></div>
                    <span>{{$brand->name}}</span>
                </div>
                @empty
                @endforelse
            </div>
        </div>
        @empty
            <div class="text-center w-100 py-5">
                <span class="" style="color:rgb(177,0,0);">Không có sản phẩm nào để hiển thị.</span>
            </div>
        @endforelse
    </div>
    <div class="category-title mt-4">Khu vực</div>
    <div class="category-2" >
        @forelse($provinces as $province)
        <div class="category-2-item" data-provinceid="{{ $province->id }}">
            <div class="custom-checkbox"></div>
            <span >{{$province->province_name}}</span>
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
            <div class="min-max-slider" data-legendnum="3">
                    <input id="min" class="min" name="min" type="range" step="1" min="0" max="{{ config('app.max_price_filter') }}" />
                    <input id="max" class="max" name="max" type="range" step="1" min="0" max="{{ config('app.max_price_filter') }}" />
            </div>
        </div>
    </div>

    <div class="category-4">
        <div class="category-title mt-4">Tình trạng sản phẩm</div>
        <div class="category-4">
            <div class="custom-radio css-radio">
                <input type="radio" id="option1" name="option" value="1" checked />
                <label for="option1" class="checked-text">Mới&nbsp; <b>80 - 100%</b></label>
            </div>
            <div class="custom-radio css-radio">
                <input type="radio" id="option2" name="option" value="2" />
                <label for="option2">Mới &nbsp; <b>50 - 70%</b></label>
            </div>
            <div class="custom-radio css-radio">
                <input type="radio" id="option3" name="option" value="3" />
                <label for="option3">Dưới &nbsp; <b>50%</b></label>
            </div>

            <div class="group-button-category-4">
                <button id="destroy-filter-button" data-url="{{ $route }}">Huỷ</button>
                <button id="filter-button" data-url="{{ $route }}">Lọc</button>
            </div>
        </div>
    </div>
</div>
</div>




<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    
    <script>    // đóng mở category
        document.addEventListener("DOMContentLoaded", function() {
            const categoryImages = document.querySelectorAll(".category-item");

            categoryImages.forEach((item) => {
                item?.addEventListener("click", function() {
                    const img = this.querySelector("img");
                    if (img.src.includes("extend.png")) {
                        img.src = "{{ asset('/img/icon/close.png') }}";
                        img.classList.add("close-icon");
                        this.classList.add("active-category");
                    } else if (img.src.includes("close.png")) {
                        img.src = "{{ asset('/img/icon/extend.png') }}";
                        img.classList.remove("close-icon");
                        this.classList.remove("active-category");
                    }
                });
            });
            // ngăn không cho sự kiện click lan đến category-item
            const category1Items = document.querySelectorAll(".category-1-item");
            category1Items.forEach((item) => {
                item?.addEventListener("click", function(event) {
                    event.stopPropagation(); 
                    
                });
            });
        });
    </script>
    <script>    // checkcustom của province
        const check = document.querySelectorAll(".category-2-item");
        check.forEach((item) =>
            item.addEventListener("click", function() {
                const inputcheck = item.querySelector(".custom-checkbox");
                inputcheck.classList.toggle("checked");
                item.classList.toggle("checked-text");
            })
        );
    </script>
    <script>    // checkcustom của category (nằm ở brand)
        const check1 = document.querySelectorAll(".category-1-item");
        check1.forEach((item) =>
            item.addEventListener("click", function() {
                const inputcheck = item.querySelector(".custom-checkbox");
                inputcheck.classList.toggle("checked");
                item.classList.toggle("checked-text");
            })
        );

        const checkCategory = document.querySelectorAll(".custom-checkbox-category");
        
        checkCategory.forEach(item => {
            item.addEventListener("click", function() {
                item.classList.toggle("checked");
                item.classList.toggle("checked-text");
                event.stopPropagation(); 
            });
        });
    </script>
    <script>    // radio
        const radio = document.querySelectorAll(".custom-radio");
        radio.forEach((item) => {
            item.addEventListener("click", function(e) {
                radio.forEach((el) => {
                    el.querySelector("label").classList.remove("checked-text");
                });
                if (item.querySelector("input").checked) {
                    item.querySelector("label").classList.add("checked-text");
                }
            });
        });
    </script>
    <script>    // đóng mở nav responsive
        const category = document.querySelector(".category-title-wrap-1");
        category.querySelector(".open-icon")
            .addEventListener("click", function() {
                if (category.classList.contains('open-category')) {
                    category.classList.remove("open-category")
                } else {
                    category.classList.add("open-category")
                }
            })
    </script>

    <script>    // lọc sản phẩm
         $(document).ready(function() {
            var provinceIds= null;
            var rangeInput= null;
            var rangeInput2= null;
            var option= null;

            $('#filter-button').on('click', function() {
                var selectedBrands = [];
                var selectedCategories = [];
                $('.category-1-item.checked-text').each(function() {
                    var brandId = $(this).data('brandid');
                    selectedBrands.push(brandId);
                });

                $('.custom-checkbox-category.checked-text').each(function() {
                    var categoryId = $(this).data('categoryid');
                    selectedCategories.push(categoryId);
                });


                var selectedProvinces = [];
                $('.category-2-item.checked-text').each(function() {
                    var provinceId = $(this).data('provinceid');
                    selectedProvinces.push(provinceId);
                });


                let url = $(this).data('url');
                $('.custom-radio').each(function() {
                    if ($(this).find('label').hasClass('checked-text')) {
                        option = $(this).find('input').val();
                    }
                });

                var rangeInput = $('#min').val();
                var rangeInput2 = $('#max').val();
                
                $.ajax({
                    url: url,
                    method: 'GET',
                    beforeSend: function (xhr, setting) {
                        $('.list-product').children().not('#loading-UI').css('visibility', 'hidden');
                        $('#loading-UI').fadeIn();  
                    },
                    data: {
                        brandIds: selectedBrands,
                        categoryIds: selectedCategories,
                        provinceIds: selectedProvinces,
                        rangeInputMin: rangeInput,
                        rangeInputMax: rangeInput2,
                        option: option,
                        provinceIds: selectedProvinces,
                        province: @json(request()->get('province')),
                        search: @json($search = request()->get('search')),
                    },
                    success: function(response) {
                        
                        $('.list-product').html(response.productHtml);
                        if(response.hasMorePages) {
                            $('#btn-more').show()
                        } else {
                            $('#btn-more').hide()
                        }
                       
                    },
                    complete: function(data) {
                        $('#loading-UI').fadeOut();
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            });

            $('#destroy-filter-button').on('click', function() {
                let url = $(this).data('url');
                $.ajax({
                    url: url,
                    method: 'GET',
                    data: {
                        brandId: [],
                        provinceIds: null,
                        rangeInputMin: null,
                        rangeInputMax: null,
                        option: null,
                        provinceIds: [],
                        
                    },
                    success: function(response) {
                        $('.list-product').html(response.productHtml);
                        
                        console.log(response);
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            })
        });
    </script>

    <script src="{{asset('/js/inputRange.js')}}"></script>
