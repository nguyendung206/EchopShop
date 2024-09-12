<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductDetailController extends Controller
{
    public function index($id)
    {
        $product = Product::where('id', $id)->first();

        return view('web.product.productdetail', compact('product'));
    }
}
