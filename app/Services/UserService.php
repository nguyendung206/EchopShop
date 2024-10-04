<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function filter($filters)
    {

        $query = User::query();
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
                'province_id' => $request['province_id'],
                'district_id' => $request['district_id'],
                'ward_id' => $request['ward_id'],
                'address' => $request['address'],
                'gender' => $request['gender'],
                'status' => $request['status'],
                'avatar' => uploadImage($request['uploadFile'], 'upload/users/', 'nophoto.png'),
            ];

            $user = User::create($userData);

            return $user;
        } catch (\Exception $e) {
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
            'province_id' => $request['province_id'],
            'district_id' => $request['district_id'],
            'ward_id' => $request['ward_id'],
            'address' => $request['address'],
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
                'address' => $request['address'],
                'province_id' => $request['province_id'],
                'district_id' => $request['district_id'],
                'ward_id' => $request['ward_id'],
                'avatar' => uploadImage($request['uploadFile'], 'upload/users/', 'nophoto.png'),
            ];

            return User::create($userData);
        } catch (Exception $th) {
            return false;
        }
    }

    public function changeAddress($request)
    {
        try {
            $user = Auth::user();
            $updateData = [
                'phone_number' => $request['phone_number'],
                'province_id' => $request['province_id'],
                'district_id' => $request['district_id'],
                'ward_id' => $request['ward_id'],
                'address' => $request['address'],
            ];
            $result = $user->update($updateData);

            return $result;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
