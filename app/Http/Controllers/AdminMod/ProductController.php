<?php

namespace App\Http\Controllers\AdminMod;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\CustomQueryFunctions\QueryFunctions;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    private $products;

    public function __construct()
    {
        $this->products = new QueryFunctions();
    }

    public function createProduct()
    {
        return view('admin-mod.product.create-product');
    }

    public function postCreateProduct(Request $request)
    {
        $request->validate([
            "name" => "required|unique:products,name",
            "sku" => "required|unique:products,sku",
            "price" => "required|numeric",
            "description" => "required",
            "image" => "required|image",
        ]);
        //move image
        $image = $request->file('image');
        $image_name = uniqid() . $image->getClientOriginalName();
        $image->move(public_path('/storage/images'), $image_name);
        // create a new product
        $product = Product::create([
            "name" => $request->name,
            "sku" => $request->sku,
            "slug" => Str::slug(uniqid() . $request->name),
            "price" => $request->price,
            "description" => $request->description,
            "image" => $image_name,
        ]);
        if (!$product) {
            return redirect("/product/create")->with("error", "Something went wrong!");
        }
        return redirect("/product/create")->with("success", "A new product, $product->name has been created!");
    }

    public function viewProduct(Request $request)
    {
        $paginatedData = $this->products->filterPaginate($request, "product");
        if (!$paginatedData) {
            return redirect("/")->with("error", "Something went wrong!");
        }
        $products = $paginatedData["queryData"];

        return view('admin-mod.product.view-product', compact('products'));
    }

    public function editProdcut($slug)
    {
        $product = Product::where('slug', $slug)->first();
        if (!$product) {
            return redirect()->back()->with("error", "Something went wrong!");
        }
        return view('admin-mod.product.edit-product', compact('product'));
    }

    public function postEditProdcut(Request $request, $slug)
    {
        $product = Product::where("slug", $slug)->first();
        if (!$product) {
            return redirect()->back()->with("error", "Something went wrong!");
        }
        $request->validate([
            "name" => "required|unique:products,name,$product->id",
            "sku" => "required|unique:products,sku,$product->id",
            "price" => "required|numeric",
            "description" => "required",
            "image" => "image",
        ]);
        // Handle image
        $image_name = $product->image;
        if ($request->image) {
            // delete the old image
            if (File::exists(public_path('/storage/images/' . $product->image))) {
                File::delete(public_path('/storage/images/' . $product->image));
            }
            // upload new image
            $image = $request->file('image');
            $image_name = uniqid() . $image->getClientOriginalName();
            $image->move(public_path('/storage/images'), $image_name);
        }
        // Update product information
        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->image = $image_name;
        $product->save();
        return redirect("/product/edit/$product->slug")->with("success", "$product->name has been updated!");
    }

    public function searchAccount(Request $request)
    {
        return view('admin-mod.search-account');
    }
}
