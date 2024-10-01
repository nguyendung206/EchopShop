<div style="display: block; height: auto; padding: 20px; font-family: Arial, sans-serif;">
    <h1 style="color: #333;">{{ $isActive ? 'Sản phẩm của bạn đã hoạt động!' : 'Sản phẩm của bạn không hoạt động' }}</h1>
    <p>{{ $body }}</p>

    <p><strong>Thông tin sản phẩm:</strong></p>
    <ul style="list-style-type: none; padding-left: 0;">
        <li style="margin: 16px 0;"><strong>Tên sản phẩm:</strong> {{ $product->name }}</li>
        <li style="margin: 16px 0;"><strong>Giá:</strong> {{ format_price($product->price) }}</li>
        <li style="margin: 16px 0;"><strong>Hình thức:</strong> {{ $product->type->label() ?? 'Không xác định' }}</li>
        <li style="margin: 16px 0;"><strong>Trạng thái:</strong> {{ $isActive ? 'Hoạt động' : 'Không hoạt động' }}</li>
        <li style="margin: 16px 0;"><strong>Loại sản phẩm:</strong> {{ $product->category->name ?? 'Không xác định' }}</li>
        <li style="margin: 16px 0;"><strong>Hãng sản phẩm:</strong> {{ $product->brand->name ?? 'Không xác định' }}</li>
        <li style="margin: 16px 0;"><strong>Mô tả:</strong> {{ strip_tags($product->description) }}</li>
        <li style="margin: 16px 0;">
            <strong>Ảnh sản phẩm:</strong>
            <img src="https://blog.dktcdn.net/files/kinh-nghiem-kinh-doanh-quan-ao.jpg" alt="Ảnh sản phẩm" style="max-width: 500px; height: auto; margin:16px 0; display: block;" />
        </li>
        <li style="margin: 16px 0;"><strong>Số lượng:</strong>
            <table class="table table-bordered" style="max-width: 500px; font-size: 1rem; width: 100%; border-collapse: collapse; border: 1px solid #dee2e6; margin:16px 0;">
                <thead>
                    <tr>
                        <th style="text-align: left; padding: 8px; border: 1px solid #dee2e6; background-color: #f8f9fa; font-weight: bold;">@lang('Màu sắc')</th>
                        <th style="text-align: left; padding: 8px; border: 1px solid #dee2e6; background-color: #f8f9fa; font-weight: bold;">@lang('Kích cở')</th>
                        <th style="text-align: left; padding: 8px; border: 1px solid #dee2e6; background-color: #f8f9fa; font-weight: bold;">@lang('Số lượng')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($product->productUnits as $unit)
                    <tr>
                        <td style="text-align: left; padding: 8px; border: 1px solid #dee2e6;">{{ $unit->color }}</td>
                        <td style="text-align: left; padding: 8px; border: 1px solid #dee2e6;">{{ $unit->size }}</td>
                        <td style="text-align: left; padding: 8px; border: 1px solid #dee2e6;">{{ $unit->quantity }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </li>
    </ul>

    <p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!</p>
</div>