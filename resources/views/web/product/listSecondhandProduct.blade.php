@foreach($secondhandProducts as $product)
                        <div class="col-custom text-center  product-item">
                            <div class="product-wrap">
                                <a href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}">
                                    <img class="product-img" src="{{ getImage($product->photo) }} " alt="">
                                    @auth
                                        <a href="#"
                                            class='product-heart {{ auth()->user()->load('favorites')->favorites->contains('product_id', $product->id)? 'favorite-active': '' }} '
                                            data-url-destroy="{{ route('favorite.destroy', $product->id) }}"
                                            data-url-store="{{ route('favorite.store') }}" data-productId="{{ $product->id }}"><i
                                                class="fa-{{ auth()->user()->load('favorites')->favorites->contains('product_id', $product->id)? 'solid': 'regular' }} fa-heart fa-heart-home"></i></a>
                                    @else
                                        <a href="{{ route('web.login') }}"><i class="fa-regular fa-heart fa-heart-home"></i></a>
                                    @endauth
                                    <p class="product-name pt-2 line-clamp-2">{{ $product->name }}</p>
                                    <p class="product-brand pt-2 line-clamp-1">Phân loại: <span>brand</span></p>
                                    <p class="price product-price color-B10000 pt-2 line-clamp-1">{{ format_price($product->price) }}</p>
                                    <div class="user-product-wrap">
                                        <img class="mini-avatar" src="{{asset('/img/image/mini-avt.png')}}" alt="">
                                        <div class="user-product "><p class="line-clamp-1">Trần thị Diễm My &nbsp;<img src="{{asset('/img/icon/doc-top.png')}}" alt=""> &nbsp; 1 giờ trước &nbsp;<img src="{{asset('/img/icon/doc-top.png')}}" alt="">&nbsp; Thành Phố huế</p></div>
                                    </div>
                                </a>
                                <br>
                                <div class="buy-wrap">
                                    <a href="#" class="btn-chat-product"><i class="fa-regular fa-comment-dots"></i></a>
                                    <a href="#" class="btn-cart-product"><i class="fa-solid fa-cart-shopping"></i></a>
                                    <a class="btn-buy-product" href="{{ route('web.productdetail.index', ['slug' => $product->slug]) }}">Mua
                                        ngay</a>
                                </div>
                            </div>
                        </div>
                    @endforeach