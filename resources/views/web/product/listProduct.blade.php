@forelse($products as $product)
                        <div class="col-lg-4 product-item col-6">
                            <div class="product-content">
                                <div class="img-product">

                                    <img src="{{ getImage($product->photo) }}" alt="p1"
                                        style="width: 100%; height: 330px" />
                                    <img src="{{ asset('/img/icon/heart-icon.png') }}" alt="h" />
                                </div>
                                <span class="name-item">{{$product->name}}</span>
                                <span class="price-item">{{$product->price}} đ</span>
                                <div>
                                    <button>Mua ngay</button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center w-100 py-5">
                            <span class="" style="color:rgb(177,0,0);">Không có sản phẩm nào để hiển thị.</span>
                        </div>
                    @endforelse