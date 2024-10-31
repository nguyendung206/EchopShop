<?php

namespace App\Imports;

use App\Enums\Status;
use App\Enums\TypeProduct;
use App\Enums\TypeProductUnit;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductUnit;
use App\Models\Shop;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductImport implements ToModel, WithHeadingRow, WithValidation
{
    public function rules(): array
    {
        Validator::extend('type_valid', function ($attribute, $value, $parameters, $validator) {
            $input = mb_strtolower($value, 'UTF-8');
            $validTypes = array_map(fn ($type) => mb_strtolower($type->label(), 'UTF-8'), TypeProduct::cases());

            return in_array($input, $validTypes);
        });

        Validator::extend('status_valid', function ($attribute, $value, $parameters, $validator) {
            $input = mb_strtolower($value, 'UTF-8');
            $validStatuses = array_map(fn ($status) => mb_strtolower($status->label(), 'UTF-8'), Status::cases());

            return in_array($input, $validStatuses);
        });

        Validator::extend('shop_valid', function ($attribute, $value, $parameters, $validator) {
            $input = mb_strtolower($value, 'UTF-8');
            $shops = Shop::all();
            $validShops = $shops->pluck('name')->map(fn ($name) => mb_strtolower($name, 'UTF-8'))->toArray();

            return in_array($input, $validShops);
        });

        Validator::extend('brand_valid', function ($attribute, $value, $parameters, $validator) {
            $input = mb_strtolower($value, 'UTF-8');
            $brands = Brand::all();
            $validBrands = $brands->pluck('name')->map(fn ($name) => mb_strtolower($name, 'UTF-8'))->toArray();

            return in_array($input, $validBrands);
        });

        Validator::extend('category_valid', function ($attribute, $value, $parameters, $validator) {
            $input = mb_strtolower($value, 'UTF-8');
            $categories = Category::all();
            $validCategories = $categories->pluck('name')->map(fn ($name) => mb_strtolower($name, 'UTF-8'))->toArray();

            return in_array($input, $validCategories);
        });

        return [
            'ten' => 'nullable|string|max:255',
            'gia' => 'nullable|numeric|min:0',
            'hinh_thuc' => ['nullable', 'type_valid'],
            'trang_thai' => ['nullable', 'status_valid'],
            'mo_ta' => 'nullable|string|max:1000',
            'chat_luong' => 'nullable|numeric|min:0|max:100',
            'ten_shop' => ['nullable', 'shop_valid'],
            'ten_thuong_hieu' => ['nullable', 'brand_valid'],
            'ten_danh_muc' => ['nullable', 'category_valid'],
        ];
    }

    public function model(array $row)
    {
        $statusValue = collect(Status::cases())->first(fn ($status) => mb_strtolower($status->label(), 'UTF-8') === mb_strtolower($row['trang_thai'], 'UTF-8'));
        $typeValue = collect(TypeProduct::cases())->first(fn ($type) => mb_strtolower($type->label(), 'UTF-8') === mb_strtolower($row['hinh_thuc'], 'UTF-8'));
        $typeUnitValue = collect(TypeProductUnit::cases())->first(fn ($typeUnit) => mb_strtolower($typeUnit->label(), 'UTF-8') === mb_strtolower($row['kieu_chi_tiet'], 'UTF-8'));

        $category = Category::where('name', 'LIKE', $row['ten_danh_muc'])->first();
        $categoryId = $category ? $category->id : null;

        $brand = Brand::where('name', 'LIKE', $row['ten_thuong_hieu'])->first();
        $brandId = $brand ? $brand->id : null;

        $shop = Shop::where('name', 'LIKE', $row['ten_shop'])->first();
        $shopId = $shop ? $shop->id : null;

        $productId = null; // Khởi tạo biến productId

        if (! empty($row['ten'])) {
            $newProduct = new Product([
                'name' => $row['ten'],
                'price' => $row['gia'],
                'type' => $typeValue,
                'photo' => $row['anh_dai_dien'],
                'list_photo' => $row['danh_sach_anh'],
                'status' => $statusValue,
                'description' => $row['mo_ta'],
                'quality' => $row['chat_luong'],
                'shop_id' => $shopId,
                'brand_id' => $brandId,
                'category_id' => $categoryId,
            ]);

            $newProduct->save();
            $productId = $newProduct->id; // Lưu ID của sản phẩm mới
        } else {
            // Nếu trường name là null, kiểm tra sản phẩm trước đó
            $product = Product::latest()->orderBy('id', 'desc')->first(); // Lấy sản phẩm mới nhất nếu tên là null
            $productId = $product ? $product->id : null; // Lưu ID của sản phẩm nếu có
        }

        // Tạo đơn vị sản phẩm nếu có thông tin về màu, size, hoặc số lượng
        if (isset($row['mau']) || isset($row['size']) || isset($row['so_luong'])) {
            if ($productId) { // Kiểm tra xem $productId có hợp lệ không
                $productUnit = new ProductUnit([
                    'product_id' => $productId,
                    'type' => $typeUnitValue,
                    'color' => $row['mau'],
                    'size' => $row['size'],
                    'quantity' => $row['so_luong'],
                ]);
                $productUnit->save();
            }
        }

        return $newProduct ?? $product; // Trả về sản phẩm mới hoặc sản phẩm đã tồn tại
    }

    public function customValidationMessages()
    {
        return [
            'ten.required' => 'Cột tên là bắt buộc.',
            'ten.string' => 'Cột tên phải là chuỗi ký tự.',
            'ten.max' => 'Cột tên không được vượt quá 255 ký tự.',
            'gia.required' => 'Cột giá là bắt buộc.',
            'gia.numeric' => 'Cột giá phải là một số.',
            'gia.min' => 'Cột giá phải lớn hơn 0.',
            'chat_luong.required' => 'Cột chất lượng là bắt buộc.',
            'chat_luong.numeric' => 'Cột chất lượng phải là một số.',
            'chat_luong.min' => 'Cột chất lượng phải lớn hơn 0.',
            'chat_luong.max' => 'Cột chất lượng phải bé hơn hoặc bằng 100.',
            'mo_ta.required' => 'Cột mô tả là bắt buộc.',
            'mo_ta.string' => 'Cột mô tả phải là chuỗi ký tự.',
            'mo_ta.max' => 'Cột mô tả không được vượt quá 1000 ký tự.',
            'trang_thai.required' => 'Cột trạng thái là bắt buộc.',
            'trang_thai.status_valid' => ':input Cột trạng thái không hợp lệ, giá trị bắt buộc phải 1 trong các trường hợp "Không hoạt động", "Hoạt động", "Tạm dừng".',
            'ten_danh_muc.category_valid' => ':input Tên danh mục không khớp với bất cứ danh mục nào hiện có.',
            'ten_thuong_hieu.brand_valid' => ':input Tên thương hiệu không khớp với bất cứ thương hiệu nào hiện có.',
            'ten_shop.shop_valid' => ':input Tên shop không khớp với bất cứ shop nào hiện có.',
        ];
    }
}
