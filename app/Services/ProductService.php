<?php

namespace App\Services;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductUnit;
use App\Models\WaitProduct;
use App\Models\WaitProductUnit;
use Illuminate\Http\Request;
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

    public function getPosts($perPage, $searchpost = null)
    {
        try {
            if (! Auth::check()) {
                return [];
            }

            $user = Auth::user();
            if ($user->shop) {
                $query = Product::where('shop_id', $user->shop->id)->orderBy('created_at', 'desc');

                if ($searchpost) {
                    $query->where('name', 'like', '%'.$searchpost.'%');
                }

                return $query->paginate($perPage);
            }

            return [];
        } catch (\Exception $e) {
            return [];
        }
    }

    public function getWaitProducts(array $request)
    {
        $query = WaitProduct::query();

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

    public function createProduct(ProductRequest $request)
    {
        $product = new Product;
        $product->user_id = $request->user_id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->status = $request->status;
        $product->price = $request->price;
        $product->shop_id = $request->shop_id;
        $product->type = $request->type;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->quality = $request->quality;

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

    public function createwaitProduct(ProductRequest $request)
    {
        $product = new WaitProduct;
        $product->product_id = $request->product_id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->status = $request->status;
        $product->price = $request->price;
        $product->shop_id = $request->shop_id;
        $product->type = $request->type;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->quality = $request->quality;

        $photoToKeep = $request->input('photo_to_keep', 'noproduct.png');

        if ($request->hasFile('photo')) {
            if ($product->photo && $product->photo !== 'noproduct.png') {
                deleteImage($product->photo, 'upload/product/');
            }
            $product->photo = uploadImage($request->file('photo'), 'upload/product/');
        } else {
            $product->photo = $photoToKeep;
        }

        $oldPhotos = json_decode($product->list_photo, true) ?: [];
        $photosToKeep = $request->input('photos_to_keep', []);

        foreach ($oldPhotos as $oldPhoto) {
            if (! in_array($oldPhoto, $photosToKeep)) {
                deleteImage($oldPhoto, 'upload/product/');
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

    public function createWaitProductUnit(array $data)
    {
        $productUnit = new WaitProductUnit;
        $productUnit->type = $data['type'];
        $productUnit->color = $data['color'];
        $productUnit->size = $data['size'];
        $productUnit->quantity = $data['quantity'];
        $productUnit->wait_product_id = $data['wait_product_id'];

        $productUnit->save();

        return $productUnit;
    }

    public function updateProduct(ProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->user_id = $request->user_id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->status = $request->status;
        $product->price = $request->price;
        $product->type = $request->type;
        $product->shop_id = $request->shop_id;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->quality = $request->quality;

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

    public function updateWaitProduct(ProductRequest $request, $id)
    {
        $product = WaitProduct::where('product_id', $id)->first();
        $product->product_id = $id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->status = $request->status;
        $product->price = $request->price;
        $product->type = $request->type;
        $product->shop_id = $request->shop_id;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->quality = $request->quality;

        if ($request->hasFile('photo')) {
            if ($product->photo && $product->photo !== 'noproduct.png') {
                deleteImage($product->photo, 'upload/product/');
            }
            $product->photo = uploadImage($request->file('photo'), 'upload/product/');
        }

        $oldPhotos = json_decode($product->list_photo, true) ?: [];
        $photosToKeep = $request->input('photos_to_keep', []);

        foreach ($oldPhotos as $oldPhoto) {
            if (! in_array($oldPhoto, $photosToKeep)) {
                deleteImage($oldPhoto, 'upload/product/');
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

    public function updateWaitProductUnit(array $data, $productId)
    {
        WaitProductUnit::where('wait_product_id', $productId)->delete();

        foreach ($data as $detail) {
            $productUnit = new WaitProductUnit;
            $productUnit->wait_product_id = $productId;
            $productUnit->type = $detail['type'];
            $productUnit->color = $detail['color'];
            $productUnit->size = $detail['size'];
            $productUnit->quantity = $detail['quantity'];

            $productUnit->save();
        }

        return true;
    }

    public function updateUserProduct(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $waitProduct = WaitProduct::findOrFail($request->id);

        $waitProductUnits = WaitProductUnit::where('wait_product_id', $waitProduct->id)->get();

        $product->name = $waitProduct->name;
        $product->price = $waitProduct->price;
        $product->type = $waitProduct->type;
        $product->photo = $waitProduct->photo;
        $product->list_photo = $waitProduct->list_photo;
        $product->status = $waitProduct->status;
        $product->description = $waitProduct->description;
        $product->shop_id = $waitProduct->shop_id;
        $product->category_id = $waitProduct->category_id;
        $product->brand_id = $waitProduct->brand_id;
        $product->quality = $waitProduct->quality;

        $product->save();

        ProductUnit::where('product_id', $product->id)->delete();

        foreach ($waitProductUnits as $detail) {
            $productUnit = new ProductUnit;
            $productUnit->product_id = $product->id;
            $productUnit->type = $detail->type;
            $productUnit->color = $detail->color;
            $productUnit->size = $detail->size;
            $productUnit->quantity = $detail->quantity;

            $productUnit->save();
        }
    }

    public function deleteProduct($id)
    {
        try {
            $product = Product::findOrFail($id);
            if ($product->photo && $product->photo != 'noproduct.png') {
                deleteImage($product->photo);
            }
            $product->slug = 'delete-'.$product->slug;
            $product->save();
            $product->delete();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
