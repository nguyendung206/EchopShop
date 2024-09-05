<?php

namespace App\Services;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductUnit;

class ProductService
{
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
            $product->photo = uploadImage($request->file('photo'));
        } else {
            $product->photo = 'noproduct.png';
        }
        if ($request->hasFile('list_photo')) {
            $listPhotos = uploadMultipleImages($request->file('list_photo'));
            $product->list_photo = json_encode($listPhotos);
        }

        $product->save();
        return $product;
    }
    public function createProductUnit(array $data)
    {
        $productUnit = new ProductUnit();
        $productUnit->product_id = $data['product_id'];
        $productUnit->type = $data['type'];
        $productUnit->name = $data['name'];
        $productUnit->quantity = $data['quantity'];

        $productUnit->save();
        return $productUnit;
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
            if ($product->photo && $product->photo !== 'noproduct.png') {
                deleteImage($product->photo, 'upload/product');
            }
            $product->photo = uploadImage($request->file('photo'), 'upload/product', 'noproduct.png');
        }

        $oldPhotos = json_decode($product->list_photo, true) ?: [];
        $photosToKeep = $request->input('photos_to_keep', []);

        foreach ($oldPhotos as $oldPhoto) {
            if (!in_array($oldPhoto, $photosToKeep)) {
                deleteImage($oldPhoto, 'upload/product');
            }
        }

        $photosToDelete = json_decode($request->input('delete_photos', '[]'), true);
        foreach ($photosToDelete as $photoToDelete) {
            if (in_array($photoToDelete, $oldPhotos)) {
                deleteImage($photoToDelete, 'upload/product');
            }
        }

        if ($request->hasFile('list_photo')) {
            $newPhotos = uploadMultipleImages($request->file('list_photo'), 'upload/product');
            $product->list_photo = json_encode(array_merge($photosToKeep, $newPhotos));
        } else {
            $product->list_photo = json_encode($photosToKeep);
        }

        $product->save();
        return $product;
    }

    public function updateProductUnit(array $data, $productId)
    {
        ProductUnit::where('product_id', $productId)->delete();

        foreach ($data as $detail) {
            $productUnit = new ProductUnit();
            $productUnit->product_id = $productId;
            $productUnit->type = $detail['type'];
            $productUnit->name = $detail['name'];
            $productUnit->quantity = $detail['quantity'];

            $productUnit->save();
        }

        return true;
    }

    public function deleteProduct($id)
    {
        try {
            $product = Product::findOrFail($id);
            if ($product->photo && $product->photo != 'noproduct.png') {
                deleteImage($product->photo);
            }

            $product->delete();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
