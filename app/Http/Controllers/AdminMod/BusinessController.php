<?php

namespace App\Http\Controllers\AdminMod;

use App\Http\Controllers\Controller;
use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\CustomQueryFunctions\QueryFunctions;

class BusinessController extends Controller
{
    private $businesses;

    public function __construct()
    {
        $this->businesses = new QueryFunctions();
    }

    public function createBusiness()
    {
        return view('admin-mod.business.create-business');
    }

    public function postCreateBusiness(Request $request)
    {
        $request->validate([
            "name" => "required|unique:businesses,name",
        ]);

        $business = Business::create([
            "name" => $request->name,
            "slug" => Str::slug(uniqid() . $request->name),
        ]);

        if (!$business) {
            return redirect('/business/create')->with("error", "Something went wrong!");
        }
        return redirect()->back()->with('success', "$business->name has been created!");
    }

    public function viewBusiness(Request $request)
    {
        $paginatedData = $this->businesses->filterPaginate($request, "business");
        if (!$paginatedData) {
            return redirect("/")->with("error", "Something went wrong!");
        }
        $businesses = $paginatedData["queryData"];

        return view('admin-mod.business.view-business', compact('businesses'));
    }
    
    public function editBusiness($slug)
    {
        $business = Business::where("slug", $slug)->first();
        if (!$business) {
            return redirect()->back()->with('error', "Someting went wrong!");
        }
        return view('admin-mod.business.edit-business', compact('business'));
    }

    public function postEditBusiness(Request $request, $slug)
    {
        $business = Business::where('slug', $slug)->first();
        if (!$business) {
            return redirect()->back()->with("error", "Something went wrong!");
        }
        $request->validate([
            "name" => "required|unique:businesses,name,$business->id",
        ]);
        if ($business->name == $request->name) {
            return redirect()->back()->withErrors(["name" => "Please write a new name!"]);
        }
        $business->name = $request->name;
        $business->save();
        return redirect()->back()->with("success", "A new name has been saved!");
    }
}
