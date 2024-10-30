<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class BrandExport implements FromCollection
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
}
