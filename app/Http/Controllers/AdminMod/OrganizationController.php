<?php

namespace App\Http\Controllers\AdminMod;

use App\Http\Controllers\Controller;
use App\Models\Org;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\CustomQueryFunctions\QueryFunctions;

class OrganizationController extends Controller
{
    private $orgs;

    public function __construct()
    {
        $this->orgs = new QueryFunctions();
    }

    public function createOrg()
    {
        return view('admin-mod.org.create-org');
    }

    public function postCreateOrg(Request $request)
    {
        $request->validate([
            "name" => "required|unique:orgs,name",
        ]);

        $org = Org::create([
            "name" => $request->name,
            "slug" => Str::slug(uniqid() . $request->name),
        ]);

        if (!$org) {
            return redirect('/org/create')->with("error", "Something went wrong!");
        }
        return redirect('/org/create')->with('success', "$org->name has been created!");
    }

    public function viewOrg(Request $request)
    {
        return view('admin-mod.org.view-org');
    }

    public function editOrg($slug)
    {
        $org = Org::where("slug", $slug)->first();
        if (!$org) {
            return redirect('/org/view')->with('error', "Someting went wrong!");
        }
        return view('admin-mod.org.edit-org', compact('org'));
    }

    public function postEditOrg(Request $request)
    {
        $request->validate([
            "org_id" => "required",
            "name" => "required|unique:orgs,name,$request->org_id",
        ]);

        $org = Org::where('id', $request->org_id)->first();
        if (!$org) {
            return redirect()->back()->with("error", "Something went wrong!");
        }
        if ($org->name == $request->name) {
            return redirect()->back()->withErrors(["name" => "Please write a new name!"]);
        }
        $org->name = $request->name;
        $org->save();
        return redirect()->back()->with("success", "A new name has been saved!");
    }
}
