<?php

namespace App\Http\Controllers\AdminMod;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Moderator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function profile()
    {
        $user = "";
        if (Auth::guard('admin')->check()) {
            $user = Admin::where('id', Auth::guard('admin')->user()->id)->withCount('lead', 'activity')->first();
        }
        if (Auth::guard('moderator')->check()) {
            $user = Moderator::where('id', Auth::guard('moderator')->user()->id)->withCount('lead', 'activity')->first();
        }

        return view('admin-mod.profile', compact('user'));
    }

    public function editProfile()
    {
        $user = "";
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();
        }
        if (Auth::guard('moderator')->check()) {
            $user = Auth::guard('moderator')->user();
        }

        return view('admin-mod.edit-profile', compact('user'));
    }

    public function postEditProfile(Request $request)
    {
        $user = "";
        $table = "";
        if (Auth::guard('admin')->check()) {
            $user = Admin::where('id', Auth::guard('admin')->user()->id)->first();
            $table = "admins";
        }
        if (Auth::guard('moderator')->check()) {
            $user = Moderator::where('id', Auth::guard('moderator')->user()->id)->first();
            $table = "moderators";
        }
        $request->validate([
            "name" => "required|string|min:4|max:100",
            "email" => "required|email|unique:$table,email,$user->id",
            "image" => "image|max:5000",
        ]);
        $image_name = $user->image;
        if ($request->image) {
            // delete the old image
            if (File::exists(public_path('/storage/images/' . $user->image))) {
                File::delete(public_path('/storage/images/' . $user->image));
            }
            // upload new image
            $image = $request->file('image');
            $image_name = uniqid() . $image->getClientOriginalName();
            $image->storeAs('images', $image_name, 'public');
        }
        // updating the user information
        $user->name = $request->name;
        $user->email = $request->email;
        $user->image = $image_name;
        $user->save();

        return redirect()->back()->with("success", "Profile successfully updated!");
    }

    public function changePassword()
    {
        $user = "";
        if (Auth::guard('admin')->check()) {
            $user = Admin::where('id', Auth::guard('admin')->user()->id)->first();
        }
        if (Auth::guard('moderator')->check()) {
            $user = Moderator::where('id', Auth::guard('moderator')->user()->id)->first();
        }

        return view('admin-mod.change-password', compact('user'));
    }

    public function postChangePassword(Request $request)
    {
        $request->validate([
            "new_password" => "required|min:8|string|same:confirm_password|different:old_password",
            "old_password" => "required|min:8|string",
            "confirm_password" => "required|min:8|string",
        ]);

        $user = "";
        if (Auth::guard('admin')->check()) {
            $user = Admin::where('id', Auth::guard('admin')->user()->id)->first();
        }
        if (Auth::guard('moderator')->check()) {
            $user = Moderator::where('id', Auth::guard('moderator')->user()->id)->first();
        }
        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->withErrors(["old_password" => "Wrong password!"]);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();
        return redirect()->back()->with("success", "A new password has been saved!");
    }
}
