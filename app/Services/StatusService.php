<?php

namespace App\Services;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Model;

class StatusService
{
    public function changeStatus(Model $model)
    {
        if ($model->status->value === Status::ACTIVE->value) {
            $model->status = Status::INACTIVE->value;
        } else {
            $model->status = Status::ACTIVE->value;
        }

        $model->save();

        return $model;
    }

    public function pauseStatus(Model $model)
    {
        if ($model->status->value === Status::ACTIVE->value) {
            $model->status = Status::PAUSE->value;
        } else {
            $model->status = Status::ACTIVE->value;
        }

        $model->save();

        return $model;
    }
}
