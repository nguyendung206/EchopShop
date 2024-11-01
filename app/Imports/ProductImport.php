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
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductImport implements ToModel, WithHeadingRow, WithValidation
{
    public function rules(): array
    {
        return [
            'ten' => 'nullable|string|max:255',
            'gia' => 'nullable|numeric|min:0',
            'hinh_thuc' => ['nullable', function ($attribute, $value, $fail) {
                if (! $this->isValidEnumLabel(TypeProduct::class, $value)) {
                    $fail("Cột Hình thức không hợp lệ, giá trị bắt buộc phải 1 trong các trường hợp 'Hàng bán', 'Hàng secondhand', 'Hàng trao đổi', 'Hàng trao tặng'.");
                }
            }],
            'trang_thai' => ['nullable', function ($attribute, $value, $fail) {
                if (! $this->isValidEnumLabel(Status::class, $value)) {
                    $fail("Cột Trạng thái không hợp lệ, giá trị bắt buộc phải 1 trong các trường hợp 'Không hoạt động', 'Hoạt động', 'Tạm dừng'.");
                }
            }],
            'mo_ta' => 'nullable|string|max:1000',
            'chat_luong' => 'nullable|numeric|min:0|max:100',
            'ten_shop' => ['nullable', function ($attribute, $value, $fail) {
                if (! $this->isValidModelName(Shop::class, $value)) {
                    $fail('Tên shop "'.$value.'"  không tồn tại.');
                }
            }],
            'ten_thuong_hieu' => ['nullable', function ($attribute, $value, $fail) {
                if (! $this->isValidModelName(Brand::class, $value)) {
                    $fail('Tên thương hiệu "'.$value.'" không tồn tại.');
                }
            }],
            'ten_danh_muc' => ['nullable', function ($attribute, $value, $fail) {
                if (! $this->isValidModelName(Category::class, $value)) {
                    $fail('Tên danh mục "'.$value.'" không tồn tại.');
                }
            }],
        ];
    }

    private function isValidEnumLabel($enumClass, $label): bool
    {
        $validLabels = array_map(fn ($enum) => mb_strtolower($enum->label(), 'UTF-8'), $enumClass::cases());

        return in_array(mb_strtolower($label, 'UTF-8'), $validLabels);
    }

    private function isValidModelName($modelClass, $name): bool
    {
        return $modelClass::where('name', 'LIKE', $name)->exists();
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

        $productId = null;

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
            $productId = $newProduct->id;
        } else {
            $product = Product::latest()->orderBy('id', 'desc')->first();
            $productId = $product ? $product->id : null;
        }

        if (isset($row['mau']) || isset($row['size']) || isset($row['so_luong'])) {
            if ($productId) {
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

        return $newProduct ?? $product;
    }

    private function getEnumValue($enumClass, $label)
    {
        return collect($enumClass::cases())->first(fn ($enum) => mb_strtolower($enum->label(), 'UTF-8') === mb_strtolower($label, 'UTF-8'));
    }

    private function getModelId($modelClass, $name)
    {
        return optional($modelClass::where('name', 'LIKE', $name)->first())->id;
    }

    public function customValidationMessages()
    {
        return [
            'ten.string' => 'Cột tên phải là chuỗi ký tự.',
            'ten.max' => 'Cột tên không được vượt quá 255 ký tự.',
            'gia.numeric' => 'Cột giá phải là một số.',
            'gia.min' => 'Cột giá phải lớn hơn 0.',
            'chat_luong.numeric' => 'Cột chất lượng phải là một số.',
            'chat_luong.min' => 'Cột chất lượng phải lớn hơn 0.',
            'chat_luong.max' => 'Cột chất lượng phải bé hơn hoặc bằng 100.',
            'mo_ta.string' => 'Cột mô tả phải là chuỗi ký tự.',
            'mo_ta.max' => 'Cột mô tả không được vượt quá 1000 ký tự.',
        ];
    }
}
