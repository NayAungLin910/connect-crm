<?php

namespace App\Http\Controllers\AdminMod\Api;

use App\Http\Controllers\Controller;
use App\Http\CustomQueryFunctions\QueryFunctions;
use App\Models\Source;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SourceController extends Controller
{
    private $sources;

    public function __construct()
    {
        $this->sources = new QueryFunctions();
    }

    public function getSource(Request $request)
    {
        $paginatedData = $this->sources->filterPaginate($request, "source");
        if (!$paginatedData) {
            return response()->json([
                "success" => false,
                "status" => 500,
                "data" => "Unable to get data!",
            ]);
        }

        $sources = $paginatedData["queryData"];

        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => [
                "sources" => $sources,
            ]
        ]);
    }

    public function deleteSource(Request $request)
    {
        $v = Validator::make($request->all(), [
            "source_slug" => "required",
        ]);

        if ($v->fails()) {
            return response()->json([
                "success" => false,
                "status" => 500,
                "data" => $v->errors(),
            ]);
        }

        $source_slug = $request->source_slug;
        $source = Source::where("slug", $source_slug)->first();
        if (!$source) {
            return response()->json([
                "success" => false,
                "status" => 500,
                "data" => "Source not found!",
            ]);
        }
        $source_name = $source->name;
        $source->delete();
        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => "$source_name has been deleted!",
        ]);
    }

    public function deleteSourceMultiple(Request $request)
    {
        $v = Validator::make($request->all(), [
            "source_slugs" => "required",
        ]);

        if ($v->fails()) {
            return response()->json([
                "success" => false,
                "status" => 500,
                "data" => $v->errors(),
            ]);
        }

        $source_slugs = json_decode($request->source_slugs);

        foreach ($source_slugs  as $slug) {
            $source = Source::where("slug", $slug)->first();
            if (!$source) {
                return response()->json([
                    "success" => false,
                    "status" => 500,
                    "data" => "Source not found!",
                ]);
            }
            $source->delete();
        }

        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => "The selected sources has been deleted!",
        ]);
    }
}
