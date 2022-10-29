<?php

namespace App\Http\Controllers\AdminMod;

use App\Http\Controllers\Controller;
use App\Models\Source;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\CustomQueryFunctions\QueryFunctions;

class SourceController extends Controller
{
    private $sources;

    public function __construct()
    {
        $this->sources = new QueryFunctions();
    }

    public function createSource()
    {
        return view('admin-mod.source.create-source');
    }

    public function postCreateSource(Request $request)
    {
        $request->validate([
            "name" => "required|unique:sources,name",
        ]);
        // create a new sources
        $source = Source::create([
            "name" => $request->name,
            "slug" => Str::slug(uniqid() . $request->name),
        ]);
        if (!$source) {
            return redirect("/source/create")->with("error", "Something went wrong!");
        }
        return redirect("/source/create")->with("success", "A new source, $source->name has been created!");
    }

    public function viewSource(Request $request)
    {
        return view('admin-mod.source.view-source');
    }

    public function editSource($slug)
    {
        $source = Source::where("slug", $slug)->first();
        if (!$source) {
            return redirect('/source/view')->with('error', "Someting went wrong!");
        }
        return view('admin-mod.source.edit-source', compact('source'));
    }

    public function postEditSource(Request $request,)
    {
        $request->validate([
            "source_id" => "required",
            "name" => "required|unique:sources,name,$request->source_id",
        ]);

        $source = Source::where('id', $request->source_id)->first();
        if (!$source) {
            return redirect()->back()->with("error", "Something went wrong!");
        }
        if ($source->name == $request->name) {
            return redirect()->back()->withErrors(["name" => "Please write a new name!"]);
        }
        $source->name = $request->name;
        $source->save();
        return redirect()->back()->with("success", "A new name has been saved!");
    }
}
