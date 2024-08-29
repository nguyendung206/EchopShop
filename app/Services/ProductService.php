<?php

namespace App\Services;

use App\Http\Requests\ProductRequest;
use App\Models\Product;

class ProductService
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }
    public function getProducts($request)
    {
        $query = Product::query();

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        return $query->paginate(10);
    }

    public function createProduct(ProductRequest $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->status = $request->status;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;

        if ($request->hasFile('photo')) {
            $product->photo = $this->imageService->uploadImage($request->file('photo'));
        } else {
            $product->photo = 'noproduct.png';
        }
        if ($request->hasFile('list_photo')) { 
            $listPhotos = $this->imageService->uploadMultipleImages($request->file('list_photo'));
            $product->list_photo = json_encode($listPhotos); 
        }

        $product->save();
        return $product;
    }

    public function updateProduct(ProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->status = $request->status;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;

        if ($request->hasFile('photo')) {
            $product->photo = $this->imageService->uploadImage($request->file('photo'), 'upload/product', $product->photo);
        }
        if ($request->hasFile('list_photo')) { 
            $listPhotos = $this->imageService->uploadMultipleImages($request->file('list_photo'));
            $product->list_photo = json_encode($listPhotos); 
        }

        $product->save();
        return $product;
    }

    public function deleteProduct($id)
    {
        try {
            $product = Product::findOrFail($id);
            if ($product->photo && $product->photo != 'noproduct.png') {
                $this->imageService->deleteImage($product->photo);
            }

            $product->delete();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function changeStatus($productId)
    {
        $product = Product::findOrFail($productId);

        if ($product->status->value == 2) {
            $product->status = 1;
        } else {
            $product->status = 2;
        }

        $product->save();
        return $product;
    }
}
