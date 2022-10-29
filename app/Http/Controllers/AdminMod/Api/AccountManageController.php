<?php

namespace App\Http\Controllers\AdminMod\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\CustomQueryFunctions\QueryFunctions;
use App\Models\Moderator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class AccountManageController extends Controller
{
    private $queryFunctions;

    public function __construct()
    {
        $this->queryFunctions = new QueryFunctions();
    }

    public function getDatatAccount(Request $request)
    {
        $paginatedData = $this->queryFunctions->filterPaginate($request, "account-manage");
        if (!$paginatedData) {
            return response()->json([
                "success" => false,
                "status" => 500,
                "data" => "Unable to get data!",
            ]);
        }
        $accounts = $paginatedData["queryData"];

        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => ["accounts" => $accounts],
        ]);
    }

    public function postDeleteAccount(Request $request)
    {
        $v = Validator::make($request->all(), [
            "account_id" => "required",
        ]);
        if ($v->fails()) {
            return response()->json([
                "success" => false,
                "status" => 500,
                "data" => $v->errors()->first(),
            ]);
        }

        $mod = Moderator::where('id', $request->account_id)->first();
        // delete contact image
        if (File::exists(public_path('/storage/images/' . $mod->image))) {
            File::delete(public_path('/storage/images/' . $mod->image));
        }
        $mod_name = $mod->name;
        $mod->delete();
        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => "$mod_name has been successfully deleted!",
        ]);
    }

    public function postDeleteAccountMultiple(Request $request)
    {
        $v = Validator::make($request->all(), [
            "account_ids" => "required",
        ]);
        if ($v->fails()) {
            return response()->json([
                "success" => false,
                "status" => 500,
                "data" => $v->errors()->first(),
            ]);
        }

        $account_ids = json_decode($request->account_ids);
        foreach ($account_ids as $aid) {
            $mod = Moderator::where('id', $aid)->first();
            if (!$mod) {
                return response()->json([
                    "success" => false,
                    "status" => 500,
                    "data" => "Moderator not found!",
                ]);
            }
            // delete contact image
            if (File::exists(public_path('/storage/images/' . $mod->image))) {
                File::delete(public_path('/storage/images/' . $mod->image));
            }
            $mod->delete();
        }
        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => "The selected accounts has been deleted!",
        ]);
    }
}
