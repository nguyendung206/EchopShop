<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class CategoryExport implements FromCollection
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
}
