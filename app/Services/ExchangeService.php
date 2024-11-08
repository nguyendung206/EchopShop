<?php

namespace App\Services;

use App\Enums\StatusExchange;
use App\Models\Exchange;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExchangeService
{
    public function store(Request $request)
    {
        $exchange = new Exchange;
        $exchange->product_id = $request->original_product_id;
        $exchange->exchange_product_id = $request->selected_product_id;
        $exchange->user_id = $request->user_id;
        $exchange->receiver_id = $request->receiver_id;

        $exchange->save();

        return $exchange;
    }

    public function getList($perPage)
    {
        if (! Auth::check()) {
            return [];
        }

        return Exchange::where('user_id', Auth::id())
            ->orWhere('receiver_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return [];
    }

    public function accept(Model $model)
    {
        $model->status = StatusExchange::APPROVED->value;
        $model->save();

        return $model;
    }

    public function reject(Model $model)
    {
        $model->status = StatusExchange::REJECTED->value;
        $model->save();

        return $model;
    }
}
