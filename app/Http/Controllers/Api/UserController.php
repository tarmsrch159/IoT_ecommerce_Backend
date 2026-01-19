<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AuthUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Services\SupabaseStorageService;

class UserController extends Controller
{
    //
    public function profile(Request $request)
    {
        return UserResource::make($request->user());
    }

    public function store(StoreUserRequest $request, SupabaseStorageService $storage)
    {
        //
        $validated = $request->validated();
        if ($request->hasFile('profile_image')) {
            $validated['profile_image'] = $storage->upload(
                $request->file('profile_image'),
                'users',
                'images/users'
            );
        }
        User::create($validated);
        return response()->json(['message' => 'สมัครสมาชิกสำเร็จ'], 201);
    }

    public function auth(AuthUserRequest $request)
    {
        //
        if ($request->validated()) {
            $user = User::where('email', $request->validated('email'))->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    "error" => "อีเมลหรือรหัสผ่านไม่ถูกต้อง"
                ]);
            } else {
                return response()->json([
                    "messege" => "เข้าสู่ระบบสำเร็จ",
                    "user" => UserResource::make($user),
                    "access_token" => $user->createToken("new_user")->plainTextToken
                ]);
            }
        }
    }

    /***
     * Update user infos
     */
    public function UpdateUserProfile(Request $request)
    {
        $request->validate([
            'profile_image' => 'image|mimes:png,jpg,jpeg,webp|max:2048'
        ]);

        if ($request->has('profile_image')) {
            //check if the old image exists and remove it
            if (File::exists(public_path($request->user()->profile_image))) {
                File::delete(public_path($request->user()->profile_image));
            }
            //store the user profile image 
            $file = $request->file('profile_image');
            $profile_image_name = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('images/users', $profile_image_name, 'public');
            //update the user profile image
            $request->user()->update([
                'profile_image' => 'storage/images/users/' . $profile_image_name
            ]);
            //return the response
            return response()->json([
                'user' => UserResource::make($request->user()),
                'message' => 'Profile image has been updated successfully'
            ]);
        } else {
            $request->user()->update([
                'country' => $request->country,
                'city' => $request->city,
                'address' => $request->address,
                'province_id' => $request->province_id, // Frontend sends ID in 'province' field or we update frontend to send 'province_id'
                'zip_code' => $request->zip_code,
                'phone_number' => $request->phone_number,
                'profile_completed' => 1
            ]);
            //return the response
            return response()->json([
                'user' => UserResource::make($request->user()),
                'message' => 'Profile updated successfully'
            ]);
        }
    }

    /**
     * Upload and save product images
     */
    public function saveImage($file)
    {
        $image_name = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('images/users/profile', $image_name, 'public');
        return 'storage/images/users/profile/' . $image_name;
    }

    /**
     * Remove old images from storage
     */
    public function removeProductImageFromStorage($file)
    {
        $path = public_path($file);
        if (File::exists($path)) {
            File::delete($path);
        }
    }
}
