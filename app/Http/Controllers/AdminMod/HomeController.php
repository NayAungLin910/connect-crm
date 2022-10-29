<?php

namespace App\Http\Controllers\AdminMod;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        return view('admin-mod.home');
    }
}
