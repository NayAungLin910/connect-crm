<?php

namespace App\Http\Controllers\AdminMod;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Admin;
use App\Models\Lead;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ActivityController extends Controller
{
    public function viewActivity(Request $request)
    {
        $by = "anyone";
        if ($request->by) {
            $by = $request->by;
        }
        return view('admin-mod.lead.activity.view-activity', compact('by'));
    }

    public function createActivity(Request $request, $slug)
    {
        $lead = Lead::where('slug', $slug)->first();
        if (!$lead) {
            return redirect()->back()->with("error", "Something went wrong!");
        }

        return view('admin-mod.lead.activity.create-activity', compact('lead'));
    }

    public function postCreateActivity(Request $request)
    {
        $request->validate([
            "lead_id" => "required",
            "name" => "required",
            "description" => "required",
            "type" => "required|in:meeting,call,vc,other",
            "file" => "required|max:100000",
            "start_date" => "required",
            "end_date" => "required",
        ]);

        $lead = Lead::where("id", $request->lead_id)->first();
        if (!$lead) {
            return redirect()->back()->with("error", "Something went wrong!");
        }

        // validate the dates
        $start_date = new Carbon($request->start_date);
        $end_date = new Carbon($request->end_date);
        $now = Carbon::now()->timezone('Asia/Yangon');
        if (strtotime($now) >= strtotime($start_date)) {
            return redirect()->back()->withErrors(["start_date" => "Please choose the future date!"]);
        }
        if (strtotime($start_date) >= strtotime($end_date)) {
            return redirect()->back()->withErrors(["end_date" => "Please choose the date ahead of the start date!"]);
        }

        // moving file
        $file = $request->file('file');
        $file_name = uniqid() . $file->getClientOriginalName();
        $file_front_name = $file->getClientOriginalName();
        $file->move(public_path('/storage/files'), $file_name);

        $moderator_id = 0;
        $admin_id = 0;
        if (Auth::guard('moderator')->check()) {
            $moderator_id = Auth::guard('moderator')->user()->id;
        }
        if (Auth::guard('admin')->check()) {
            $admin_id = Auth::guard('admin')->user()->id;
        }

        // creating activity
        $activity = Activity::create([
            "name" => $request->name,
            "slug" => Str::slug(uniqid() . $request->name),
            "lead_id" => $lead->id,
            "moderator_id" => $moderator_id,
            "admin_id" => $admin_id,
            "description" => $request->description,
            "type" => $request->type,
            "file" => $file_name,
            "file_name" => $file_front_name,
            "start_date" => $request->start_date,
            "end_date" => $request->end_date,
            "done" => "no",
        ]);
        if (!$activity) {
            return redirect()->back()->with("error", "Something went wrong!");
        }
        return redirect()->back()->with("success", "$activity->name has been created!");
    }

    public function editActivity(Request $request, $slug)
    {
        $activity = Activity::where('slug', $slug)->with('lead')->first();
        if (!$activity) {
            return redirect()->back()->with("error", "Something went wrong!");
        }
        return view('admin-mod.lead.activity.edit-activity', compact('activity'));
    }

    public function postEditActivity(Request $request, $slug)
    {
        $request->validate([
            "name" => "required",
            "description" => "required",
            "type" => "required|in:meeting,call,vc,other",
            "file" => "max:100000",
            "start_date" => "required",
            "end_date" => "required",
        ]);

        $activity = Activity::where('slug', $slug)->first();
        if (!$activity) {
            return redirect()->back()->with("error", "Something went Wrong!");
        }

        // validate the dates
        $start_date = new Carbon($request->start_date);
        $end_date = new Carbon($request->end_date);
        $now = Carbon::now()->timezone('Asia/Yangon');
        if (strtotime($now) >= strtotime($start_date)) {
            return redirect()->back()->withErrors(["start_date" => "Please choose the future date!"]);
        }
        if (strtotime($start_date) >= strtotime($end_date)) {
            return redirect()->back()->withErrors(["end_date" => "Please choose the date ahead of the start date!"]);
        }

        $file_name = $activity->file;
        $file_front_name = $activity->file_name;
        if ($request->file) {
            // delete the old file
            if (File::exists(public_path('/storage/files/' . $activity->file))) {
                File::delete(public_path('/storage/files/' . $activity->file));
            }
            // moving file
            $file = $request->file('file');
            $file_name = uniqid() . $file->getClientOriginalName();
            $file_front_name = $file->getClientOriginalName();
            $file->move(public_path('/storage/files'), $file_name);
        }

        $activity->name = $request->name;
        $activity->slug = Str::slug(uniqid() . $request->name);
        $activity->description = $request->description;
        $activity->type = $request->type;
        $activity->file = $file_name;
        $activity->file_name = $file_front_name;
        $activity->start_date = $request->start_date;
        $activity->end_date = $request->end_date;
        $activity->save();

        return redirect("/activity/edit/$activity->slug")->with("success", "$activity->name has been updated!");
    }
}
