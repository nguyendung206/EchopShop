<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductExport implements FromCollection, WithHeadings, WithMapping
{
    protected $products;

    public function __construct($products = null)
    {
        $this->products = $products;
    }

    public function collection()
    {
        return $this->products;
    }

    public function map($product): array
    {
        $mappedRows = [];

        if ($product->productUnits->isEmpty()) {
            return [
                $product->slug ?? '',
                $product->name ?? '',
                $product->price ?? '',
                $product->type->label() ?? '',
                $product->photo ?? '',
                $product->list_photo ?? '',
                $product->status->label() ?? '',
                strip_tags($product->description ?? ''),
                $product->quality ?? '',
                $product->shop->name ?? '',
                $product->brand->name ?? '',
                $product->category->name ?? '',
                '',
                '',
                '',
            ];
        }

        foreach ($product->productUnits as $unit) {
            $mappedRows[] = [
                $product->slug ?? '',
                $product->name ?? '',
                $product->price ?? '',
                $product->type->label() ?? '',
                $product->photo ?? '',
                $product->list_photo ?? '',
                $product->status->label() ?? '',
                strip_tags($product->description ?? ''),
                $product->quality ?? '',
                $product->shop->name ?? '',
                $product->brand->name ?? '',
                $product->category->name ?? '',
                $unit->color ?? '',
                $unit->size ?? '',
                $unit->quantity ?? '',
            ];
        }

        return $mappedRows;
    }

    public function headings(): array
    {
        return [
            'Từ khoá',
            'Tên',
            'Giá',
            'Hình thức',
            'Ảnh đại diện',
            'Danh sách ảnh',
            'Trạng thái',
            'Mô tả',
            'Chất lượng',
            'Tên shop',
            'Tên thương hiệu',
            'Tên danh mục',
            'Màu',
            'Size',
            'Số lượng',
        ];
    }
}
