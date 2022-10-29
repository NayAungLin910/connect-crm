<?php

namespace App\Http\Controllers\AdminMod\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\CustomQueryFunctions\QueryFunctions;
use App\Models\Activity;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ActivityController extends Controller
{
    private $queryFunctions;

    public function __construct()
    {
        $this->queryFunctions = new QueryFunctions();
    }

    public function getActivity(Request $request)
    {
        $paginatedData = $this->queryFunctions->filterPaginate($request, "activity");
        if (!$paginatedData) {
            return response()->json([
                "success" => false,
                "status" => 500,
                "data" => "Unable to get data!",
            ]);
        }

        $activities = $paginatedData["queryData"];

        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => [
                "activities" => $activities,
            ]
        ]);
    }

    public function doneActivity(Request $request)
    {
        $v = Validator::make($request->all(), [
            "activity_slug" => "required",
        ]);
        if ($v->fails()) {
            return response()->json([
                "success" => false,
                "status" => 500,
                "data" => $v->errors(),
            ]);
        }

        $activity = Activity::where('slug', $request->activity_slug)->first();
        if (!$activity) {
            return response()->json([
                "success" => false,
                "status" => 500,
                "data" => "Something went wrong!",
            ]);
        }
        if ($activity->done == "yes") {
            $activity->done = "no";
        } else {
            $activity->done = "yes";
        }
        $activity->save();
        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => null,
        ]);
    }

    public function deleteActivity(Request $request)
    {
        $v = Validator::make($request->all(), [
            "activity_slug" => "required",
        ]);
        if ($v->fails()) {
            return response()->json([
                "success" => false,
                "status" => 500,
                "data" => $v->errors(),
            ]);
        }

        $activity = Activity::where('slug', $request->activity_slug)->first();
        if (!$activity) {
            return response()->json([
                "success" => false,
                "status" => 500,
                "data" => "Something went wrong!",
            ]);
        }
        // delete file of activity
        if (File::exists(public_path('/storage/files/' . $activity->file))) {
            File::delete(public_path('/storage/files/' . $activity->file));
        }
        $activity->delete();
        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => null,
        ]);
    }
}
