<?php

namespace App\Imports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;

class CategoryImport implements ToModel
{
    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Category([
            'slug' => $row[1],
            'name' => $row[2],
            'description' => $row[3],
            'photo' => $row[4],
            'status' => $row[5],
            'created_at' => $row[6],
            'updated_at' => $row[7],
        ]);
    }
}
