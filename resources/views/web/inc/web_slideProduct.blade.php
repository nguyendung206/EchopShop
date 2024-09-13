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
            <label>{{$category->name}}</label><img src="{{ asset('/img/icon/extend.png') }}" alt="" />
            <div class="category-item-wrap">
                @forelse($category->activeBrands as $brand)
                <div><a href="#" id="brandFilter" data-url="{{ $route }}" data-brandid="{{$brand->id}}">{{$brand->name}}</a></div>
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
            <div class="slider">
                <input type="range" id="rangeInput" min="0" max="1000000" value="100000" />
                <input type="range" id="rangeInput2" min="1000000" max="2000000" value="1000000" />
            </div>
            <div class="value">
                <div id="value1"></div>
                <div id="value2" style="margin-left: 4px">&nbsp; - 500000</div>
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




<script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        const rangeInput = document.getElementById("rangeInput");
        const rangeInput2 = document.getElementById("rangeInput2");

        function updateRangeInput() {
            const value =
                ((rangeInput.value - rangeInput.min) /
                    (rangeInput.max - rangeInput.min)) *
                100;
            rangeInput.style.background = `linear-gradient(to right, #ddd ${value}%, rgb(177,0,0,1) ${value}%)`;
            document.getElementById("value1").textContent = `Giá: ${
          Math.floor(rangeInput.value / 100000) * 100000
        }`;
        }

        function updateRangeInput2() {
            const value =
                ((rangeInput2.value - rangeInput2.min) /
                    (rangeInput2.max - rangeInput2.min)) *
                100;
            rangeInput2.style.background = `linear-gradient(to right, rgb(177,0,0,1) ${value}%, #ddd ${value}%)`;
            document.getElementById("value2").textContent = `- ${
          Math.floor(rangeInput2.value / 100000) * 100000
        } VNĐ`;
        }

        rangeInput.addEventListener("input", updateRangeInput);
        rangeInput2.addEventListener("input", updateRangeInput2);
        updateRangeInput();
        updateRangeInput2();
    </script>

    
    <script>
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
        });
    </script>
    <script>
        const check = document.querySelectorAll(".category-2-item");
        check.forEach((item) =>
            item.addEventListener("click", function() {
                const inputcheck = item.querySelector(".custom-checkbox");
                inputcheck.classList.toggle("checked");
                item.classList.toggle("checked-text");
            })
        );
    </script>
    <script>
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
    <script>
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

    <script>
         $(document).ready(function() {
            var brandId= null;
            var provinceIds= null;
            var rangeInput= null;
            var rangeInput2= null;
            var option= null;
            
            $(document).on('click', '#brandFilter', function(event) {
                event.preventDefault();
                brandId = $(this).data('brandid');
                let url = $(this).data('url');
                $.ajax({
                    url: url,
                    method: 'GET',
                    data: {
                        brandId: brandId,
                    },
                    success: function(response) {
                        $('.list-product').html(response.productHtml);
                        
                        console.log(response);
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            });


            $('#filter-button').on('click', function() {
                let url = $(this).data('url');
                $('.custom-radio').each(function() {
                    if ($(this).find('label').hasClass('checked-text')) {
                        option = $(this).find('input').val();
                    }
                });

                var rangeInput = $('#rangeInput').val();
                var rangeInput2 = $('#rangeInput2').val();
                
                var provinceIds = [];
                $('.category-2-item.checked-text').each(function() {
                    var provinceId = $(this).data('provinceid');
                    provinceIds.push(provinceId);
                });
                console.log(rangeInput);
                
                $.ajax({
                    url: url,
                    method: 'GET',
                    data: {
                        brandId: brandId,
                        provinceIds: provinceIds,
                        rangeInputMin: rangeInput,
                        rangeInputMax: rangeInput2,
                        option: option,
                    },
                    success: function(response) {
                        $('.list-product').html(response.productHtml);
                        
                        console.log(response);
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
                        brandId: null,
                        provinceIds: null,
                        rangeInputMin: null,
                        rangeInputMax: null,
                        option: null,
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