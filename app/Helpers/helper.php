<?php

//highlights the selected navigation on admin panel

use App\Enums\DiscountType;
use App\Enums\FoodTypeCombo;
use App\Enums\LocationBanner;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PositionBanner;
use App\Enums\StatusType;
use App\Enums\TypeNotification;
use App\Models\Cart;
use App\Models\ComboPublicDate;
use App\Models\Food;
use App\Models\Material;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;


if (! function_exists('getImage')) {
    function getImage($path = null)
    {

        if (!$path) {
            return asset('img/image/nophoto.png');
        }
        if (strpos($path, 'upload') !== false) {
            return Storage::url($path);
        }
        return asset('img/image/' . $path);
    }
}

if (! function_exists('uploadImage')) {
    function uploadImage($file, $path = 'upload/product', $defaultImage = 'noproduct.png')
    {
        if ($file) {
            $fileName = time() . '-' . $file->getClientOriginalName();
            $file->storeAs($path, $fileName, 'public');
            return $path . $fileName;
        }

        return $defaultImage;
    }
}

if (! function_exists('deleteImage')) {
    function deleteImage($path = 'upload/product')
    {
        $filePath = storage_path('app/public/' . $path);
        if (file_exists($filePath) && strpos($path, 'upload') !== false) {
            unlink($filePath);
        }
    }
}

if (! function_exists('uploadMultipleImages')) {
    function uploadMultipleImages($files, $path = 'upload/product')
    {
        $fileNames = [];
        if ($files && is_array($files)) {
            foreach ($files as $file) {
                $fileName = uploadImage($file, $path);
                $fileNames[] = $fileName;
            }
        }
        return $fileNames;
    }
}

if (! function_exists('deleteMultipleImages')) {
    function deleteMultipleImages($fileNames, $path = 'upload/product', $defaultImage = 'noproduct.png')
    {
        if ($fileNames && is_array($fileNames)) {
            foreach ($fileNames as $fileName) {
                deleteImage($fileName, $path, $defaultImage);
            }
        }
    }
}

if (! function_exists('uploadImage')) {
    function uploadImage($file, $path = 'upload/product', $defaultImage = 'noproduct.png')
    {
        if ($file) {
            $fileName = time() . '-' . $file->getClientOriginalName();
            $file->storeAs($path, $fileName, 'public');

            return $fileName;
        }

        return $defaultImage;
    }
}

if (! function_exists('deleteImage')) {
    function deleteImage($fileName, $path = 'upload/product', $defaultImage = 'noproduct.png')
    {
        $filePath = storage_path('app/' . $path . '/' . $fileName);
        if (file_exists($filePath) && $fileName !== $defaultImage) {
            unlink($filePath);
        }
    }
}

if (! function_exists('uploadMultipleImages')) {
    function uploadMultipleImages($files, $path = 'upload/product')
    {
        $fileNames = [];
        if ($files && is_array($files)) {
            foreach ($files as $file) {
                $fileName = uploadImage($file, $path);
                $fileNames[] = $fileName;
            }
        }
        return $fileNames;
    }
}

if (! function_exists('deleteMultipleImages')) {
    function deleteMultipleImages($fileNames, $path = 'upload/product', $defaultImage = 'noproduct.png')
    {
        if ($fileNames && is_array($fileNames)) {
            foreach ($fileNames as $fileName) {
                deleteImage($fileName, $path, $defaultImage);
            }
        }
    }
}

if (! function_exists('text_order_status')) {
    function text_order_status($status)
    {
        switch ($status) {
            case 0:
                return 'CHỜ XÁC NHẬN';
            case 1:
                return 'ĐANG XỬ LÝ';
            case 2:
                return 'ĐANG GIAO';
            case 3:
                return 'ĐÃ GIAO';
            case 4:
                return 'HOÀN THÀNH';
            case 5:
                return 'ĐÃ HỦY';
            default:
                return 'CHỜ XÁC NHẬN';
        }
    }
}

if (! function_exists('apply_type')) {
    function apply_type($apply_type)
    {
        switch ($apply_type) {
            case 1:
                return 'Món ăn';
            case 2:
                return 'Combo';
            case 3:
                return 'Nhóm món ăn';
            default:
                return 'Tất cả đơn hàng';
        }
    }
}

if (! function_exists('areActiveRoutes')) {
    function areActiveRoutes(array $routes, $output = 'active')
    {
        foreach ($routes as $route) {
            if (Route::currentRouteName() == $route) {
                return $output;
            }
        }
    }
}

if (! function_exists('routeNameActive')) {
    function routeNameActive(string $name, $output = 'active')
    {
        if (Route::is("$name.*") || Route::is($name)) {
            return $output;
        }

        return '';
    }
}

//highlights the selected navigation on frontend
if (! function_exists('areActiveRoutesHome')) {
    function areActiveRoutesHome(array $routes, $output = 'active')
    {
        foreach ($routes as $route) {
            if (Route::currentRouteName() == $route) {
                return $output;
            }
        }
    }
}

//highlights the selected navigation on frontend
if (! function_exists('default_language')) {
    function default_language()
    {
        return env('DEFAULT_LANGUAGE');
    }
}

//formats currency
if (! function_exists('format_price')) {
    function format_price($price)
    {
        $fomated_price = number_format($price, 0, '', ',');

        return $fomated_price . ' VNĐ';
    }
}
//format no VNĐ
if (! function_exists('format_price_no_vnd')) {
    function format_price_no_vnd($price)
    {
        $fomated_price = number_format($price, 0, '', ',');

        return $fomated_price;
    }
}

if (! function_exists('renderStarRating')) {
    function renderStarRating($rating, $maxRating = 5)
    {
        $fullStar = "<i class = 'las la-star active'></i>";
        $halfStar = "<i class = 'las la-star half'></i>";
        $emptyStar = "<i class = 'las la-star'></i>";
        $rating = $rating <= $maxRating ? $rating : $maxRating;

        $fullStarCount = (int) $rating;
        $halfStarCount = ceil($rating) - $fullStarCount;
        $emptyStarCount = $maxRating - $fullStarCount - $halfStarCount;

        $html = str_repeat($fullStar, $fullStarCount);
        $html .= str_repeat($halfStar, $halfStarCount);
        $html .= str_repeat($emptyStar, $emptyStarCount);
        echo $html;
    }
}
function paginateAjax($items, $paginate, $url, $page = null)
{
    $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
    $items = $items instanceof Collection ? $items : Collection::make($items);
    $custom = new LengthAwarePaginator($items->forPage($page, $paginate), $items->count(), $paginate, $page, ['path' => '/admin/statistical-reports/sell']);

    return $custom;
}

function translate($key, $lang = null)
{
    return $key;
}

function remove_invalid_charcaters($str)
{
    $str = str_ireplace(['\\'], '', $str);

    return str_ireplace(['"'], '\"', $str);
}

function timezones()
{
    return Timezones::timezonesToArray();
}

if (! function_exists('app_timezone')) {
    function app_timezone()
    {
        return config('app.timezone');
    }
}

if (! function_exists('my_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @param  bool|null  $secure
     * @return string
     */
    function my_asset($path, $secure = null)
    {
        if (env('FILESYSTEM_DRIVER') == 's3') {
            return Storage::disk('s3')->url($path);
        } else {
            if (Storage::exists($path)) {
                return app('url')->asset($path, $secure);
            }

            return no_asset();
        }
    }
}

if (! function_exists('static_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @param  bool|null  $secure
     * @return string
     */
    function static_asset($path, $secure = null)
    {
        return app('url')->asset($path, $secure);
    }
}

if (! function_exists('api_asset')) {
    function api_asset($id)
    {
        if (empty($id)) {
            return null;
        }
        if (($asset = \App\Models\Upload::find($id)) != null) {
            return $asset->file_name;
        }

        return '';
    }
}
if (! function_exists('no_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @param  bool|null  $secure
     * @return string
     */
    function no_asset()
    {
        return static_asset('assets/img/default_menu.png');
    }
}

if (! function_exists('isHttps')) {
    function isHttps()
    {
        return ! empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS']);
    }
}

if (! function_exists('getBaseURL')) {
    function getBaseURL()
    {
        // $root = (isHttps() ? "https://" : "https://").$_SERVER['HTTP_HOST'];
        // $root .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

        return config('app.url');
    }
}

if (! function_exists('getFileBaseURL')) {
    function getFileBaseURL()
    {
        if (env('FILESYSTEM_DRIVER') == 's3') {
            return env('AWS_URL') . '/';
        } else {
            return getBaseURL();
        }
    }
}

if (! function_exists('isUnique')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @param  bool|null  $secure
     * @return string
     */
    function isUnique($email)
    {
        $user = \App\Models\User::where('email', $email)->first();

        if ($user == null) {
            return '1'; // $user = null means we did not get any match with the email provided by the user inside the database
        } else {
            return '0';
        }
    }
}

if (! function_exists('get_setting')) {
    function get_setting($key, $default = null)
    {
        $setting = Setting::where('key', $key)->first();

        return $setting == null ? $default : $setting->value;
    }
}

function hex2rgba($color, $opacity = false)
{
    return Colorcodeconverter::convertHexToRgba($color, $opacity);
}

if (! function_exists('isAdmin')) {
    function isAdmin()
    {
        if (Auth::check() && (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff')) {
            return true;
        }

        return false;
    }
}

if (! function_exists('formatBytes')) {
    function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        // Uncomment one of the following alternatives
        $bytes /= pow(1024, $pow);
        // $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}

if (! function_exists('materialStatusText')) {
    function materialStatusText($status)
    {
        if (empty($status)) {
            return trans('base.disabled');
        }
        if ($status == 1) {
            return trans('base.active');
        }

        return trans('base.disabled');
    }
}

if (! function_exists('materialUnitText')) {
    function materialUnitText($unit)
    {
        switch ($unit) {
            case 1:
                return 'Kg';
                break;
            case 2:
                return 'Ea';
                break;
            case 3:
                return trans('materials.pack');
                break;
            default:
                return trans('materials.other');
                break;
        }
    }
}

if (! function_exists('comboTypeText')) {
    function comboTypeText($type)
    {
        switch ($type) {
            case 1:
                return trans('combos.food');
                break;
            case 2:
                return trans('combos.water');
                break;
            case 3:
                return trans('combos.snack');
                break;
            case 4:
                return trans('combos.gift');
                break;
            default:
                return trans('combos.other');
                break;
        }
    }
}

if (! function_exists('comboTypeTotal')) {
    function comboTypeTotal()
    {
        if (($total = \App\Models\Combo::getTotalTypes()) != null) {
            return $total;
        }
    }
}

if (! function_exists('getTotalLocationToBanner')) {
    function getTotalLocationToBanner()
    {
        if (($total = \App\Models\Banner::getTotalLocation()) != null) {
            return $total;
        }
    }
}

if (! function_exists('')) {
    function locationBannerConvert($location)
    {
        switch ($location) {
            case LocationBanner::HOME:
                return trans('banners.loca_home');
                break;
            case LocationBanner::MENU:
                return trans('banners.loca_menu');
                break;
            case LocationBanner::COMBO:
                return trans('banners.loca_combo');
                break;
            case LocationBanner::FOOD:
                return trans('banners.loca_food');
                break;
            default:
                return trans('base.not_found');
                break;
        }
    }
}

if (! function_exists('getTotalPositionToBanner')) {
    function getTotalPositionToBanner()
    {
        if (($total = \App\Models\Banner::getTotalPosition()) != null) {
            return $total;
        }
    }
}

if (! function_exists('')) {
    function positionBannerConvert($position)
    {
        switch ($position) {
            case PositionBanner::NONE:
                return trans('banners.posi_none');
                break;
            case PositionBanner::TOP:
                return trans('banners.posi_top');
                break;
            case PositionBanner::BOTTOM:
                return trans('banners.posi_bottom');
                break;
            case PositionBanner::LEFT:
                return trans('banners.posi_left');
                break;
            case PositionBanner::RIGHT:
                return trans('banners.posi_right');
                break;
            case PositionBanner::MIDDLE:
                return trans('banners.posi_middle');
                break;
            default:
                return trans('base.not_found');
                break;
        }
    }
}

if (! function_exists('materialUnitTotal')) {
    function materialUnitTotal()
    {
        if (($total = \App\Models\Material::getTotalUnit()) != null) {
            return $total;
        }
    }
}

if (! function_exists('statusTrans')) {
    function statusTrans($status)
    {
        if ($status == StatusType::ACTIVE) {
            return __('base.active');
        } else {
            return __('base.in_active');
        }
    }
}
if (! function_exists('paymentStatus')) {
    function paymentStatus($status)
    {
        if ($status == PaymentMethod::PAID) {
            return __('order.paid');
        } else {
            return __('order.not_paid');
        }
    }
}
if (! function_exists('orderStatus')) {
    function orderStatus($status)
    {
        // if($status == OrderStatus::NEW) {
        //     return __('base.new');
        // }
        if ($status == OrderStatus::CONFIRM) {
            return __('base.confirm');
        } elseif ($status == OrderStatus::PROCESS) {
            return __('base.process');
        } elseif ($status == OrderStatus::SHIPPING) {
            return __('base.shipping');
        } elseif ($status == OrderStatus::SHIPPED) {
            return __('base.shipped');
        } elseif ($status == OrderStatus::COMPLETED) {
            return __('base.completed');
        } else {
            return __('base.cancelled');
        }
    }
}
if (! function_exists('discountTrans')) {
    function discountTrans($discount)
    {
        if ($discount == DiscountType::PRICE) {
            return __('base.price');
        } else {
            return __('base.percent');
        }
    }
}

if (! function_exists('typeNotification')) {
    function typeNotification($notify)
    {
        switch ($notify) {
            case TypeNotification::ANNOUNCEMENT:
                return __('base.announce');
                break;
            case TypeNotification::SYSTEM:
                return __('base.system');
                break;
            case TypeNotification::PROMOTION:
                return __('base.promo');
                break;
        }
    }
}
if (! function_exists('isFreeshipping')) {
    function isFreeshipping($varible)
    {
        if ($varible == 1 || $varible == 3) {
            return __('base.yes');
        } else {
            return __('base.no');
        }
    }
}
if (! function_exists('replaceEmailOrPhone')) {
    function replaceEmailOrPhone($email_or_phone)
    {
        $result = [];
        if (filter_var($email_or_phone, FILTER_VALIDATE_EMAIL)) {
            $email = explode('@', $email_or_phone);
            $name = $email[0];
            $last_name = $email[1];
            $chars = preg_split('//', $name, -1, PREG_SPLIT_NO_EMPTY);
            for ($i = 0; $i < count($chars); $i++) {
                if ($i > 4) {
                    $chars[$i] = '*';
                    $result[] = $chars[$i];
                }
                $result[] = $chars[$i];
            }
            $result = implode('', $result) . '@' . $last_name;
        } else {
            $chars = preg_split('//', $email_or_phone, -1, PREG_SPLIT_NO_EMPTY);
            for ($i = 0; $i < count($chars); $i++) {
                if ($i < 8) {
                    $chars[$i] = '*';
                }
            }
            $result = $chars;
            $result = implode('', $result);
        }
        if ($result) {
            return $result;
        }

        return 'Chưa có thông tin';
    }
}

if (! function_exists('phoneNumberFormat')) {
    function phoneNumberFormat($phone)
    {
        if ($phone) {
            $result = [];
            $chars = preg_split('//', $phone, -1, PREG_SPLIT_NO_EMPTY);
            for ($i = 0; $i < count($chars); $i++) {
                if ($i < 1) {
                    $chars[$i] = ' (+84) ';
                }
                $result[] = $chars[$i];
            }

            return implode('', $result);
        }

        return 'Không có số điện thoại';
    }
}

if (! function_exists('paymentAtFormat')) {
    function paymentAtFormat($date)
    {
        if ($date) {
            $date = date('H:i A,  d/m/Y', strtotime($date));

            return str_replace(':', 'h', $date);
        }
    }
}
if (! function_exists('showInfoForTooltip')) {
    function showInfoForTooltip($item)
    {
        $stringInfo = '';
        foreach ($item->combo->foods as $list_food) {
            $weight = $list_food->pivot->quantity * $list_food->weight;
            $stringInfo .= ' ' . $weight . ' ' . optional($list_food->unit)->unit . ' ' . $list_food->name . "<br \>";
        }

        return $stringInfo;
    }
}

if (! function_exists('showInfoForTooltipCombo')) {
    function showInfoForTooltipCombo($combo)
    {
        $stringInfo = '';
        foreach ($combo->foods as $list_food) {
            $weight = $list_food->pivot->quantity * $list_food->weight;
            $stringInfo .= ' ' . $weight . ' ' . optional($list_food->unit)->unit . ' ' . $list_food->name . "<br \>";
        }

        return $stringInfo;
    }
}

if (! function_exists('showFirstTooltipCombo')) {
    function showFirstTooltipCombo($combo)
    {
        $stringInfo = '';
        foreach ($combo->foods as $list_food) {
            if ($list_food == reset($list_food)) {
                $weight = $list_food->pivot->quantity * $list_food->weight;
                $stringInfo = $weight . ' ' . optional($list_food->unit)->unit . ' ' . $list_food->name;

                return $stringInfo;
            }
        }
    }
}

if (! function_exists('getMainFood')) {
    function getMainFood($food)
    {
        if ($food->pivot->food_type == FoodTypeCombo::MAIN) {
            return $food->weight . ' ' . optional($food->unit)->unit . ' ' . $food->name;
        }
    }
}

// if (!function_exists('getSideFood')){
//     function getSideFood($food){
//         if(!empty($food)){
//             if ($food->pivot->food_type == FoodTypeCombo::SIDE){
//                 return $food->weight .' '. optional($food->unit)->unit .' '. $food->name;
//             }
//         }
//         return false;
//     }
// }

// if (!function_exists('getDessertFood')){
//     function getDessertFood($food){
//         if(!empty($food)){
//             if ($food->pivot->food_type == FoodTypeCombo::DESSERT){
//                 return $food->weight .' '. optional($food->unit)->unit .' '. $food->name;
//             }
//         }
//         return false;
//     }
// }

if (! function_exists('calRate')) {
    function calRate($scoreTotal, $star)
    {
        if (empty($star)) {
            return 0;
        }

        return ($star / $scoreTotal) * 100;
    }
}

if (! function_exists('allComboAndFoodTodayInCart')) {
    function allComboAndFoodTodayInCart($cart)
    {
        $date_now = date('Y-m-d');
        $cart = $cart->where(function ($query) use ($date_now) {
            $query->where(function ($subWhere) use ($date_now) {
                $subWhere->whereNotNull('food_id')->whereDate('created_at', '>=', $date_now);
            })->orWhere(function ($subWhere) {
                $subWhere->whereNotNull('combo_id');
            });
        });

        return $cart;
    }
}

if (! function_exists('priceSaleCombo')) {
    function priceSaleCombo($combo)
    {
        return isset($combo->flash_sale->price) ? optional($combo)->flash_sale->price : optional($combo)->price;
    }
}

if (! function_exists('priceSaleFood')) {
    function priceSaleFood($food)
    {
        return isset($food->flash_sale->price) ? optional($food)->flash_sale->price : optional($food)->price;
    }
}

if (! function_exists('handleShowValue')) {
    function handleShowValue($object)
    {
        return ! empty($object->flash_sale) ? optional($object->flash_sale)->price : optional($object)->price;
    }
}

if (! function_exists('getPriceFood')) {
    function getPriceFood($cart)
    {
        return isset($cart->food->flash_sale->price) ? optional($cart->food)->flash_sale->price : optional($cart->food)->price;
    }
}

if (! function_exists('getPriceCombo')) {
    function getPriceCombo($cart)
    {
        return isset($cart->combo->flash_sale->price) ? optional($cart->combo->flash_sale)->price : optional($cart->combo)->price;
    }
}

if (! function_exists('getPriceForOne')) {
    function getPriceForOne($cart)
    {
        if (empty($cart->combo_id)) {
            return isset($cart->food->flash_sale->price) ? optional($cart->food)->flash_sale->price : optional($cart->food)->price;
        } else {
            return isset($cart->combo->flash_sale->price) ? optional($cart->combo->flash_sale)->price : optional($cart->combo)->price;
        }
    }
}

if (! function_exists(('checkFoodOutStock'))) {
    function checkFoodOutStock($food)
    {
        $stock = MenuItem::where('food_id', $food->id)->where('start_date', '>=', today())->max('quantity');
        if (empty($stock)) {
            return true;
        }

        return $stock;
    }
}

if (! function_exists(('checkUrlMenuFood'))) {
    function checkUrlMenuFood($food)
    {
        foreach ($food->menu_active as $key => $menu) {
            $publicDate[] = $menu->public_date;
        }
        if (! empty($publicDate) && count($publicDate) > 1) {
            return 'menu.today';
        }
        if (! empty($publicDate[0]) && $publicDate[0] > today()) {
            return 'menu.tomorrow';
        }

        return 'menu.today';
    }
}

if (! function_exists(('isFavorite'))) {
    function isFavorite($item, $user)
    {
        $like = $item->favorite($user)->first();

        $class = ! empty($like) ? 'favorite-active' : '';
        $img = ! empty($like) ? 'assets/img/icons/heart-active.svg' : 'assets/img/icons/heart-border.svg';
        $imgGray = ! empty($like) ? 'assets/img/icons/heart-active.svg' : 'assets/img/icons/heart-gray.svg';
        $mobiImg = ! empty($like) ? 'assets/img/icons/heart-detail-active.svg' : 'assets/img/icons/heart-detail.svg';

        $data = [
            'class' => $class,
            'img' => $img,
            'gray_heart' => $imgGray,
            'big_heart' => $mobiImg,
        ];

        return $data;
    }
}

if (! function_exists(('checkComboInCart'))) {
    function checkComboInCart($combo, $user)
    {
        $cart = Cart::where('combo_id', $combo->id)->where('user_id', $user->id)->first();
        ! empty($cart) ? $image = 'assets/img/icons/cart-active.svg' : $image = 'assets/img/icons/cart-gray.svg';

        return $image;
    }
}

if (! function_exists(('checkComboInCartSlick'))) {
    function checkComboInCartSlick($combo, $user)
    {
        $cart = Cart::where('combo_id', $combo->id)->where('user_id', $user->id)->first();
        ! empty($cart) ? $image = 'assets/img/icons/cart-active.svg' : $image = 'assets/img/icons/cart-border.svg';

        return $image;
    }
}

if (! function_exists(('checkFoodInCartSlick'))) {
    function checkFoodInCartSlick($food, $user)
    {
        $cart = Cart::where('food_id', $food->id)->where('user_id', $user->id)->first();
        ! empty($cart) ? $image = 'assets/img/icons/cart-active.svg' : $image = 'assets/img/icons/cart-border.svg';

        return $image;
    }
}

if (! function_exists(('checkFoodInCart'))) {
    function checkFoodInCart($food, $user)
    {
        $cart = Cart::where('food_id', $food->id)->where('user_id', $user->id)->first();
        ! empty($cart) ? $image = 'assets/img/icons/cart-active.svg' : $image = 'assets/img/icons/cart-gray.svg';

        return $image;
    }
}

if (! function_exists(('checkFoodActive'))) {
    function checkFoodActive($foods, $combos)
    {
        $arrayFood = $foods->pluck('id')->toArray('id');
        $arrayCombo = $combos->pluck('id')->toArray('id');

        $menu_id = Menu::query()->whereBetween('public_date', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59', strtotime('+1day'))])->Active()->pluck('id')->toArray();
        $foodInMenu = Food::whereHas('menuItems', function ($subQuery) use ($menu_id) {
            $subQuery->where('menu_id', $menu_id)
                ->whereBetween('start_date', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59', strtotime('+1day'))])
                ->where('quantity', '>', 0);
        })->where('status', StatusType::ACTIVE)->pluck('id')->toArray();
        $comboInMenu = ComboPublicDate::whereBetween('public_date', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59', strtotime('+1day'))])->where('quantity', '>', 0)->pluck('combo_id')->toArray();

        if (count(array_intersect($arrayFood, $foodInMenu)) != 0 || count(array_intersect($arrayCombo, $comboInMenu)) != 0) {
            return true;
        } else {
            return false;
        }
    }
}

if (! function_exists('getNameMaterial')) {
    function getNameMaterial($materials)
    {
        if (! empty($materials)) {
            $materials = array_map('intval', explode(',', $materials));
            foreach ($materials as $material) {
                $data[] = Material::findOrFail($material)->name;
            }

            return implode(', ', $data);
        }
    }
}
if (! function_exists('getContent')) {
    function getContent($data)
    {
        return '
        <!DOCTYPE html>
        <html>
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Pukcom</title>
        <style type="text/css">img{max-width:100%!important;width:100%!important;}</style>
        </head>
        <body>
        ' . $data . '
        </body>
        </html>
        ';
    }
}
