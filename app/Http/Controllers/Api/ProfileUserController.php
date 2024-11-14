<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IdentificationRequest;
use App\Http\Requests\ProfileUserRequest;

class ProfileUserController extends Controller
{
    public function updateProfile(ProfileUserRequest $request)
    {
        try {
            $user = $request->user();

            $user->email = $request->email;
            $user->name = $request->name;
            $user->phone_number = $request->phone_number;

            if ($request->hasFile('avatar')) {
                if ($user->avatar && $user->avatar !== 'nophoto.png') {
                    deleteImage($user->avatar, 'upload/users');
                }
                $user->avatar = uploadImage($request->file('avatar'), 'upload/users/');
            }

            $user->save();

            return response()->json([
                'status' => 200,
                'message' => 'Profile updated successfully',
                'data' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to update profile',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateIdentification(IdentificationRequest $request)
    {
        try {
            $user = $request->user();

            $user->citizen_identification_number = $request->citizen_identification_number;
            $user->date_of_issue = $request->date_of_issue;
            $user->place_of_issue = $request->place_of_issue;
            $user->gender = $request->gender;
            $user->date_of_birth = $request->date_of_birth;

            if ($request->hasFile('identification_image')) {
                if ($user->identification_image && $user->identification_image !== 'nophoto.png') {
                    deleteImage($user->identification_image, 'upload/users');
                }
                $user->identification_image = uploadImage($request->file('identification_image'), 'upload/users/');
            }

            $user->save();

            return response()->json([
                'status' => 200,
                'message' => 'Identification updated successfully',
                'data' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to update identification',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
