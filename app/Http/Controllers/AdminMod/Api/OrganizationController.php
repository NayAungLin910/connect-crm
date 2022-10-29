<?php

namespace App\Http\Controllers\AdminMod\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\CustomQueryFunctions\QueryFunctions;
use App\Models\Org;
use Illuminate\Support\Facades\Validator;

class OrganizationController extends Controller
{
    private $queryFunctions;

    public function __construct()
    {
        $this->queryFunctions = new QueryFunctions();
    }

    public function getOrg(Request $request)
    {
        $paginatedData = $this->queryFunctions->filterPaginate($request, "org");
        if (!$paginatedData) {
            return response()->json([
                "success" => false,
                "status" => 500,
                "data" => "Unable to get data!",
            ]);
        }

        $orgs = $paginatedData["queryData"];

        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => [
                "orgs" => $orgs,
            ]
        ]);
    }

    public function deleteOrg(Request $request)
    {
        $v = Validator::make($request->all(), [
            "org_slug" => "required",
        ]);

        if ($v->fails()) {
            return response()->json([
                "success" => false,
                "status" => 500,
                "data" => $v->errors(),
            ]);
        }

        $org_slug = $request->org_slug;
        $org = Org::where("slug", $org_slug)->first();
        if (!$org) {
            return response()->json([
                "success" => false,
                "status" => 500,
                "data" => "Organization not found!",
            ]);
        }
        $org_name = $org->name;
        $org->delete();
        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => "$org_name has been deleted!",
        ]);
    }

    public function deleteOrgMultiple(Request $request)
    {
        $v = Validator::make($request->all(), [
            "org_slugs" => "required",
        ]);

        if ($v->fails()) {
            return response()->json([
                "success" => false,
                "status" => 500,
                "data" => $v->errors(),
            ]);
        }

        $org_slugs = json_decode($request->org_slugs);

        foreach ($org_slugs  as $slug) {
            $org = Org::where("slug", $slug)->first();
            if (!$org) {
                return response()->json([
                    "success" => false,
                    "status" => 500,
                    "data" => "Organization not found!",
                ]);
            }
            $org->delete();
        }

        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => "The selected organizations has been deleted!",
        ]);
    }
}
