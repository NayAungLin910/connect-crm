<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Moderator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function adminLogin()
    {
        return view('auth.admin.login-admin');
    }

    public function postAdminLogin(Request $request)
    {
        $request->validate([
            "email" => "required|email|exists:admins,email",
            "password" => "required",
        ], [
            "email.exists" => "Email not found!",
        ]);

        $remember = false;
        if ($request->remember) {
            $remember = true;
        }

        $admin = Admin::where('email', $request->email)->first();
        if (!$admin) {
            return redirect('/login-admin')->withErrors(["email" => "Email not found!"]);
        }
        $cre = ["email" => $request->email, "password" => $request->password];
        if (Auth::guard('admin')->attempt($cre, $remember)) {
            return redirect('/')->with("success", "Welcome " . $admin->name . "!");
        } else {
            return redirect('/login-admin')->withErrors(["password" => "Email or password is wrong!"]);
        }
    }

    public function adminRegister()
    {
        return view('auth.admin.register-admin');
    }

    public function postAdminRegister(Request $request)
    {
        $request->validate([
            "name" => "required|string|min:4|max:100",
            "email" => "required|email|unique:admins,email",
            "password" => 'required|min:8|string',
            "image" => "required|image|max:5000",
        ], [
            "image.image" => "Profile must be an image",
        ]);

        // moving image
        $image = $request->file('image');
        $image_name = uniqid() . $image->getClientOriginalName();
        $image->move(public_path('/storage/images'), $image_name);

        $admin = Admin::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "image" => $image_name,
        ]);

        if (!$admin) {
            return redirect('/register-admin')->with("error", "Something went wrong!");
        }

        Auth::guard('admin')->login($admin, true);
        return redirect('/')->with("success", "Welcome " . $request->name . "!");
    }

    public function moderatorLogin()
    {
        return view('auth.moderator.login-moderator');
    }

    public function postModeratorLogin(Request $request)
    {
        $request->validate([
            "email" => "required|email|exists:moderators,email",
            "password" => "required",
        ], [
            "email.exists" => "Email not found!",
        ]);

        $remember = false;
        if ($request->remember) {
            $remember = true;
        }

        $moderator = Moderator::where('email', $request->email)->first();
        if (!$moderator) {
            return redirect('/login-moderator')->withErrors(["email" => "Email not found!"]);
        }
        $cre = ["email" => $request->email, "password" => $request->password];
        if (Auth::guard('moderator')->attempt($cre, $remember)) {
            return redirect('/')->with("success", "Welcome " . $moderator->name . "!");
        } else {
            return redirect('/login-moderator')->withErrors(["password" => "Email or password is wrong!"]);
        }
    }

    public function moderatorRegister()
    {
        return view('auth.moderator.register-moderator');
    }

    public function postModeratorRegister(Request $request)
    {
        $request->validate([
            "name" => "required|string|min:4|max:100",
            "email" => "required|email|unique:moderators,email",
            "password" => 'required|min:8|string',
            "image" => "required|image|max:5000",
        ], [
            "image.image" => "Profile must be an image",
        ]);

        // moving image
        $image = $request->file('image');
        $image_name = uniqid() . $image->getClientOriginalName();
        $image->move(public_path('/storage/images'), $image_name);

        $moderator = Moderator::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "image" => $image_name,
        ]);

        if (!$moderator) {
            return redirect('/register-moderator')->with("error", "Something went wrong!");
        }

        Auth::guard('moderator')->login($moderator, true);
        return redirect('/')->with("success", "Welcome " . $request->name . "!");
    }

    public function logout(Request $request)
    {
        $role = "";
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
            $role = "admin";
        } elseif (Auth::guard('moderator')->check()) {
            Auth::guard('moderator')->logout();
            $role = "moderator";
        }

        return redirect('/login-' . $role)->with("info", "Please login again!");
    }
}
