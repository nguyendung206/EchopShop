<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BrandExport implements FromCollection, WithHeadings, WithMapping
{
    protected $brand;

    public function __construct($brand = null)
    {
        $this->brand = $brand;
    }

    public function collection()
    {
        return $this->brand;
    }

    public function map($brand): array
    {
        return [
            $brand->slug,
            $brand->name,
            $brand->description,
            $brand->photo,
            $brand->status->label(),
            $brand->category->name,
        ];
    }

    public function headings(): array
    {
        return [
            'slug',
            'Tên thương hiệu',
            'Mô tả',
            'Ảnh',
            'Trạng thái',
            'Tên danh mục',
        ];
    }
}
