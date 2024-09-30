<?php

namespace App\Services;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductUnit;
use Illuminate\Support\Facades\Auth;

class ProductService
{
    public function getProducts(array $request)
    {
        $query = Product::query();

        if (! empty($request['search'])) {
            $searchTerm = $request['search'];
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%'.$searchTerm.'%')
                    ->orWhere('description', 'like', '%'.$searchTerm.'%');
            });
        }

        if (! empty($request['status'])) {
            $query->where('status', $request['status']);
        }

        if (! empty($request['type'])) {
            $query->where('type', $request['type']);
        }

        return $query->paginate(10);
    }

    public function getProductsUser(array $requestData)
    {
        $query = Product::query()->whereNotNull('shop_id');

        if (! empty($requestData['search'])) {
            $searchTerm = $requestData['search'];
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%'.$searchTerm.'%')
                    ->orWhere('description', 'like', '%'.$searchTerm.'%');
            });
        }

        if (! empty($requestData['status'])) {
            $query->where('status', $requestData['status']);
        }

        if (! empty($requestData['type'])) {
            $query->where('type', $requestData['type']);
        }

        return $query->paginate(10);
    }

    public function getPosts($perPage)
    {
        try {
            if (! Auth::check()) {
                return [];
            }

            $user = Auth::user();
            if ($user->shop) {
                return Product::where('shop_id', $user->shop->id)->paginate($perPage);
            }

            return [];
        } catch (\Exception $e) {
            return [];
        }
    }

    public function createProduct(ProductRequest $request)
    {
        $product = new Product;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->status = $request->status;
        $product->price = $request->price;
        $product->shop_id = $request->shop_id;
        $product->type = $request->type;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;

        if ($request->hasFile('photo')) {
            $product->photo = uploadImage($request->file('photo'), 'upload/product/');
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
        $productUnit = new ProductUnit;
        $productUnit->type = $data['type'];
        $productUnit->product_id = $data['product_id'];
        $productUnit->color = $data['color'];
        $productUnit->size = $data['size'];
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
        $product->type = $request->type;
        $product->shop_id = $request->shop_id;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;

        if ($request->hasFile('photo')) {
            if ($product->photo && $product->photo !== 'noproduct.png') {
                deleteImage($product->photo, 'upload/product/');
            }
            $product->photo = uploadImage($request->file('photo'), 'upload/product/', $product->photo);
        }

        $oldPhotos = json_decode($product->list_photo, true) ?: [];
        $photosToKeep = $request->input('photos_to_keep', []);

        foreach ($oldPhotos as $oldPhoto) {
            if (! in_array($oldPhoto, $photosToKeep)) {
                deleteImage($oldPhoto, 'upload/product/');
            }
        }

        $photosToDelete = json_decode($request->input('delete_photos', '[]'), true);
        foreach ($photosToDelete as $photoToDelete) {
            if (in_array($photoToDelete, $oldPhotos)) {
                deleteImage($photoToDelete, 'upload/product/');
            }
        }

        if ($request->hasFile('list_photo')) {
            $newPhotos = uploadMultipleImages($request->file('list_photo'), 'upload/product/');
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
            $productUnit = new ProductUnit;
            $productUnit->product_id = $productId;
            $productUnit->type = $detail['type'];
            $productUnit->color = $detail['color'];
            $productUnit->size = $detail['size'];
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

    public function filterByCategory($categoryId)
    {
        return Product::where('category_id', $categoryId)->get();
    }

    public function filterByCategoryAndBrand($categoryId, $brandId)
    {
        return Product::where('category_id', $categoryId)
            ->where('brand_id', $brandId)
            ->get();
    }

    public function filterProducts($categoryIds = [], $brandIds = [], $provinceIds = [], $minPrice = null, $maxPrice = null, $condition = null)
    {
        $query = Product::query();

        if (! empty($categoryIds)) {
            $query->whereIn('category_id', $categoryIds);
        }

        if (! empty($brandIds)) {
            $query->whereIn('brand_id', $brandIds);
        }

        if (! empty($provinceIds)) {
            $query->whereHas('province', function ($q) use ($provinceIds) {
                $q->whereIn('id', $provinceIds);
            });
        }

        if ($minPrice !== null && $maxPrice !== null) {
            $query->whereBetween('price', [$minPrice, $maxPrice]);
        }

        return $query->get();
    }
}
