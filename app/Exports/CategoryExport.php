<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CategoryExport implements FromCollection, WithHeadings, WithMapping
{
    protected $categories;

    public function __construct($categories = null)
    {
        $this->categories = $categories;
    }

    public function collection()
    {
        return $this->categories;
    }

    public function map($category): array
    {
        return [
            $category->slug,
            $category->name,
            $category->description,
            $category->photo,
            $category->status->label(),
        ];
    }

    public function headings(): array
    {
        return [
            'slug',
            'name',
            'description',
            'photo',
            'status',
        ];
    }
}
