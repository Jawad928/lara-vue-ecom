<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Store user
     */
    public function store(StoreUserRequest $request)
    {
        User::Create($request->validated());
        return response()->json([
            'message' => 'Acount created successfully',
        ]);
    }
    /*
    * login User
    */

    public function auth(AuthUserRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user  || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'error' => 'There credentials do not match any of our records',
            ]);
        } else {
            return response()->json([
                'message' => 'Login successfully',
                'access_token' => $user->createToken('new_user')->plainTextToken,
                'user' => UserResource::make($user),
            ]);
        }
    }

    /**
     * User Logout
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logout successfully',
        ]);
    }
    /**
     * Update User Infos
     */
    public function UpdateUserProfile(Request $request)
    {
        $request->validate([
            'profile_image' => 'image|mimes:png,jpg,jpeg,webp|max:2048',
        ]);
        if ($request->hasFile('profile_image')) {
            //check if the old image exists and delete it

            $path = 'images/users/' . $request->user()->profile_image;

            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            //store the profile image
            $file = $request->file('profile_image');
            $profile_img_Name = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('images/users/', $profile_img_Name, 'public');
            $request->user()->update([
                'profile_image' => $profile_img_Name,
            ]);
            return response()->json([
                'user' =>    UserResource::make($request->user()),
                'message' => 'Profile image has been updated successfully',
            ]);
        } else {
            $request->user()->update([
                'country' => $request->country,
                'city' => $request->city,
                'address' => $request->address,
                'zip_code' => $request->zip_code,
                'phone_number' => $request->phone_number,
                'profile_completed' => 1,
            ]);
            return response()->json([
                'user' =>    UserResource::make($request->user()),
                'message' => 'Profile has been updated successfully',
            ]);
        }
    }
}