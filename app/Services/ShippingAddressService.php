<?php

namespace App\Services;

use App\Models\ShippingAddress;
use Illuminate\Support\Facades\Auth;

class ShippingAddressService
{
    public function changeAddress($request)
    {
        try {
            $address = ShippingAddress::findorfail($request['shipping_address_id']);
            if (empty($request['is_default'])) {
                $request['is_default'] = false;
            } else {
                ShippingAddress::where('user_id', Auth::id())
                    ->where('is_default', true)
                    ->update(['is_default' => false]);
                $request['is_default'] = true;
            }
            $updateData = [
                'phone' => $request['phone'],
                'province_id' => $request['province_id'],
                'district_id' => $request['district_id'],
                'ward_id' => $request['ward_id'],
                'street' => $request['street'],
                'user_name' => $request['user_name'],
                'type_address' => $request['type_address'],
                'is_default' => $request['is_default'],
            ];
            $result = $address->update($updateData);

            return $result;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function addAddress($request)
    {
        try {
            if (empty($request['is_default'])) {
                $request['is_default'] = false;
            } else {
                ShippingAddress::where('user_id', Auth::id())
                    ->where('is_default', true)
                    ->update(['is_default' => false]);
                $request['is_default'] = true;
            }
            $addressData = [
                'phone' => $request['phone'],
                'province_id' => $request['province_id'],
                'district_id' => $request['district_id'],
                'ward_id' => $request['ward_id'],
                'street' => $request['street'],
                'user_name' => $request['user_name'],
                'type_address' => $request['type_address'],
                'is_default' => $request['is_default'],
                'user_id' => Auth::id(),
            ];
            $address = ShippingAddress::create($addressData);

            $existingAddressesCount = ShippingAddress::where('user_id', Auth::id())->count();
            if ($existingAddressesCount == 1) {
                $address->is_default = true;
                $address->save();
            }

            return $address;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function updateDefault($id)
    {
        try {
            $shippingAddress = ShippingAddress::findOrFail($id);
            ShippingAddress::where('user_id', Auth::id())
                ->where('is_default', true)
                ->update(['is_default' => false]);
            $shippingAddress->is_default = true;
            $shippingAddress->save();

            return $shippingAddress;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
