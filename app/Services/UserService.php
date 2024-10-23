<?php

namespace App\Services;

use App\Models\User;
use App\Models\ShippingAddress;
use App\Enums\TypeAddress;
use Exception;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function filter($filters)
    {

        $query = User::with('defaultAddress');
        if (! empty($filters['search'])) {
            $query->where('name', 'like', '%'.$filters['search'].'%');
        }
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (isset($filters['gender'])) {
            $query->where('gender', $filters['gender']);
        }
        return $query->paginate(5);
    }

    public function store($request)
    {
        try {
            if (! isset($request['uploadFile'])) {
                $request['uploadFile'] = null;
            }
            $userData = [
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
                'phone_number' => $request['phone_number'],
                'citizen_identification_number' => $request['citizen_identification_number'],
                'date_of_issue' => $request['date_of_issue'],
                'place_of_issue' => $request['place_of_issue'],
                'date_of_birth' => $request['date_of_birth'],
                'gender' => $request['gender'],
                'status' => $request['status'],
                'avatar' => uploadImage($request['uploadFile'], 'upload/users/', 'nophoto.png'),
            ];
            
            $user = User::create($userData);
            $shippingAddressData = [
                'province_id' => $request['province_id'],
                'district_id' => $request['district_id'],
                'ward_id' => $request['ward_id'],
                'street' => $request['address'],
                'phone' => $request['phone_number'],
                'user_name' => $request['name'],
                'is_default' => true,
                'type_address' => TypeAddress::HOME->value,
                'user_id' => $user->id
            ];
            $shippingAddress = ShippingAddress::create($shippingAddressData);
            return $user;
        } catch (\Exception $e) {
            dd($e);
            flash('Thêm người dùng thất bại')->error();

            return redirect()->back();
        }
    }

    public function update($request, $id)
    {

        $user = User::findOrFail($id);
        $avatar = $user->avatar;
        if (! isset($request['uploadFile'])) {
            $request['uploadFile'] = null;
        }
        $updateData = [
            'name' => $request['name'],
            'email' => $request['email'],
            'phone_number' => $request['phone_number'],
            'citizen_identification_number' => $request['citizen_identification_number'],
            'date_of_issue' => $request['date_of_issue'],
            'place_of_issue' => $request['place_of_issue'],
            'date_of_birth' => $request['date_of_birth'],
            
            'gender' => $request['gender'],
            'status' => $request['status'],
            'avatar' => uploadImage($request['uploadFile'], 'upload/users/', $avatar),
        ];
        if (! empty($request['password'])) {
            $updateData['password'] = bcrypt($request['password']);
        }

        $user->update($updateData);

        if ($request['uploadFile']) {
            deleteImage($avatar);
        }

        $shippingAddress = ShippingAddress::findOrFail($user->defaultAddress->id);
        $shippingAddressData = [
            'province_id' => $request['province_id'],
            'district_id' => $request['district_id'],
            'ward_id' => $request['ward_id'],
            'street' => $request['address'],
            'phone' => $request['phone_number'],
            'user_name' => $request['name'],
            'is_default' => true,
            'type_address' => TypeAddress::HOME->value,
            'user_id' => $user->id
        ];
        $shippingAddress->update($shippingAddressData);

        return $user;
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $result = $user->delete();
            if ($result) {
                deleteImage($user->avatar);
            }

            return $result;
        } catch (Exception $e) {
            return false;
        }
    }

    public function register($request)
    {
        try {
            if (! isset($request['uploadFile'])) {
                $request['uploadFile'] = null;
            }
            $userData = [
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
                'phone_number' => $request['phone_number'],
                'avatar' => uploadImage($request['uploadFile'], 'upload/users/', 'nophoto.png'),
            ];
            $user = User::create($userData);
            $shippingAddressData = [
                'province_id' => $request['province_id'],
                'district_id' => $request['district_id'],
                'ward_id' => $request['ward_id'],
                'street' => $request['address'],
                'phone' => $request['phone_number'],
                'user_name' => $request['name'],
                'is_default' => true,
                'type_address' => TypeAddress::HOME->value,
                'user_id' => $user->id
            ];
            $shippingAddress = ShippingAddress::create($shippingAddressData);
            return $user;
        } catch (Exception $th) {
            return false;
        }
    }

    
}
