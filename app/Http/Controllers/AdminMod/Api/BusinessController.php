<?php

namespace App\Http\Controllers\AdminMod\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\CustomQueryFunctions\QueryFunctions;
use App\Models\Business;
use Illuminate\Support\Facades\Validator;

class BusinessController extends Controller
{
    private $queryFunctions;

    public function __construct()
    {
        $this->queryFunctions = new QueryFunctions();
    }

    public function getBusiness(Request $request)
    {
        $paginatedData = $this->queryFunctions->filterPaginate($request, "business");
        if (!$paginatedData) {
            return response()->json([
                "success" => false,
                "status" => 500,
                "data" => "Unable to get data!",
            ]);
        }

        $businesses = $paginatedData["queryData"];

        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => [
                "businesses" => $businesses,
            ]
        ]);
    }

    public function deleteBusiness(Request $request)
    {
        $v = Validator::make($request->all(), [
            "business_slug" => "required",
        ]);

        if ($v->fails()) {
            return response()->json([
                "success" => false,
                "status" => 500,
                "data" => $v->errors(),
            ]);
        }

        $business_slug = $request->business_slug;
        $business = Business::where("slug", $business_slug)->first();
        if (!$business) {
            return response()->json([
                "success" => false,
                "status" => 500,
                "data" => "Business not found!",
            ]);
        }
        $business_name = $business->name;
        $business->delete();
        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => "$business_name has been deleted!",
        ]);
    }

    public function deleteBusinessMultiple(Request $request)
    {
        $v = Validator::make($request->all(), [
            "business_slugs" => "required",
        ]);

        if ($v->fails()) {
            return response()->json([
                "success" => false,
                "status" => 500,
                "data" => $v->errors(),
            ]);
        }

        $business_slugs = json_decode($request->business_slugs);

        foreach ($business_slugs as $slug) {
            $business = Business::where("slug", $slug)->first();
            if (!$business) {
                return response()->json([
                    "success" => false,
                    "status" => 500,
                    "data" => "Business not found!",
                ]);
            }
            $business->delete();
        }
        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => "The selected businesses has been deleted!",
        ]);
    }
}
