<?php

namespace App\Http\Controllers\AdminMod\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\CustomQueryFunctions\QueryFunctions;
use App\Models\Product;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    private $queryFunctions;

    public function __construct()
    {
        $this->queryFunctions = new QueryFunctions();
    }

    public function getProduct(Request $request)
    {
        $paginatedData = $this->queryFunctions->filterPaginate($request, "product");
        if (!$paginatedData) {
            return response()->json([
                "success" => false,
                "status" => 500,
                "data" => "Unable to get data!",
            ]);
        }

        $products = $paginatedData["queryData"];

        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => [
                "products" => $products,
            ]
        ]);
    }

    public function deleteProduct(Request $request)
    {
        $v = Validator::make($request->all(), [
            "product_slug" => "required",
        ]);

        if ($v->fails()) {
            return response()->json([
                "success" => false,
                "status" => 500,
                "data" => $v->errors(),
            ]);
        }

        $product = Product::where('slug', $request->product_slug)->first();
        if (!$product) {
            return response()->json([
                "success" => false,
                "status" => 500,
                "data" => "Product not found!",
            ]);
        }
        // delete image
        if (File::exists(public_path('/storage/images/' . $product->image))) {
            File::delete(public_path('/storage/images/' . $product->image));
        }
        $product_name = $product->name;
        $product->delete();
        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => "$product_name has been deleted!",
        ]);
    }

    public function deleteProductMultiple(Request $request)
    {
        $v = Validator::make($request->all(), [
            "product_slugs" => "required",
        ]);

        if ($v->fails()) {
            return response()->json([
                "success" => false,
                "status" => 500,
                "data" => $v->errors(),
            ]);
        }

        $product_slugs = json_decode($request->product_slugs);

        foreach ($product_slugs as $slug) {
            $product = Product::where('slug', $slug)->first();
            if (!$product) {
                return response()->json([
                    "success" => false,
                    "status" => 500,
                    "data" => "Product not found!",
                ]);
            }
            // delete image
            if (File::exists(public_path('/storage/images/' . $product->image))) {
                File::delete(public_path('/storage/images/' . $product->image));
            }
            $product->delete();
        }

        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => "The selected products has been deleted!",
        ]);
    }
}
