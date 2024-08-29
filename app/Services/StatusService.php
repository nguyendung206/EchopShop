<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class StatusService
{
    public function changeStatus(Model $model)
    {

        if ($model->status->value == 2) {
            $model->status = 1;
        } else {
            $model->status = 2;
        }

        $model->save();
        return $model;
    }
}
