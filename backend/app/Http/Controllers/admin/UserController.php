<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /***
     *
     * Display all users
     *
     */

    public function index()
    {
        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }




    /***
     *
     * Delete user
     */

    public function destroy(User $user)
    {
        //check if the image exists and delete it
        $path = 'images/users/' . $user->profile_image;
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }
}
