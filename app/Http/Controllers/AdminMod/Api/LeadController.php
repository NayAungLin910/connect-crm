<?php

namespace App\Http\Controllers\AdminMod\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\CustomQueryFunctions\QueryFunctions;
use App\Models\Activity;
use App\Models\Lead;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    private $queryFunctions;

    public function __construct()
    {
        $this->queryFunctions = new QueryFunctions();
    }

    public function getLead(Request $request)
    {
        $paginatedData = $this->queryFunctions->filterPaginate($request, "lead");
        if (!$paginatedData) {
            return response()->json([
                "success" => false,
                "status" => 500,
                "data" => "Unable to get data!",
            ]);
        }

        $leads = $paginatedData["queryData"];

        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => [
                "leads" => $leads,
            ]
        ]);
    }

    public function deleteLead(Request $request)
    {
        $v = Validator::make($request->all(), [
            "lead_slug" => "required",
        ]);

        if ($v->fails()) {
            return response()->json([
                "success" => false,
                "status" => 500,
                "data" => $v->errors()->first(),
            ]);
        }

        $lead = Lead::where('slug', $request->lead_slug)->first();
        if (!$lead) {
            return response()->json([
                "success" => false,
                "status" => 500,
                "data" => "Lead not found!",
            ]);
        }

        // delete all activities of the lead
        $activities = Activity::where('lead_id', $lead->id)->get();
        foreach ($activities as $a) {
            // delete file of activity
            if (File::exists(public_path('/storage/files/' . $a->file))) {
                File::delete(public_path('/storage/files/' . $a->file));
            }
            $a->delete();
        }

        $l_name = $lead->name;
        $lead->delete();
        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => "$l_name has been deleted!",
        ]);
    }

    public function deleteLeadMultiple(Request $request)
    {
        $v = Validator::make($request->all(), [
            "lead_slugs" => "required",
        ]);

        if ($v->fails()) {
            return response()->json([
                "success" => false,
                "status" => 500,
                "data" => $v->errors()->first(),
            ]);
        }

        $lead_slugs = json_decode($request->lead_slugs);
        foreach ($lead_slugs as $slug) {
            $lead = Lead::where('slug', $slug)->first();
            if (!$lead) {
                return response()->json([
                    "success" => false,
                    "status" => 500,
                    "data" => "Lead not found!",
                ]);
            }

            // delete all activities of the lead
            $activities = Activity::where('lead_id', $lead->id)->get();
            foreach ($activities as $a) {
                // delete file of activity
                if (File::exists(public_path('/storage/files/' . $a->file))) {
                    File::delete(public_path('/storage/files/' . $a->file));
                }
                $a->delete();
            }
            
            $lead->delete();
        }
        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => "The selected leads has been deleted!",
        ]);
    }
}
