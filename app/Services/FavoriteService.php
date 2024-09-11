<?php

namespace App\Services;

use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class FavoriteService
{   
    public function getProduct($perPage)
    {
        try {
            if(!Auth::check()) return [];
            $user = Auth::user();
            $favorites = Favorite::query()->where('user_id', Auth::id())->with('product')->paginate($perPage);
            return $favorites;
        }catch (\Exception $e) {
            return [];
        }
    }

    public function store($request)
    {   
        try {
            if(Auth::check()) {
                $newFavorite = Favorite::create([
                    'user_id' => Auth::id(),
                    'product_id' => $request->productId
                ]);

                return $newFavorite;
                
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    public function destroy($productId) 
    {   
        try {
            if(Auth::check()) {
                $favorite = Favorite::where('product_id', $productId)
                            ->where('user_id', Auth::id())
                            ->firstOrFail();
                $result = $favorite->delete();
                return $result;
            }else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }
}