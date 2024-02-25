<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // index
    public function index()
    {
        $products = Product::orderBy("id","desc")->paginate(10);
        return view("pages.products.index", compact("products"));
    }

    // create
    public function create()
    {
        $categories = DB::table("categories")->get();
        return view("pages.products.create", compact("categories"));

    }

    // store
    public function store(Request $request){
        $this->validate($request, [
            "name"=> "required",
            "description"=> "required",
            "price"=> "required|numeric",
            "category_id"=> "required",
            "stock"=> "required|numeric",
            "status"=> "required|boolean",
            "isFavorite"=> "required|boolean",
            ]);
            
            // store the request
            $product = new Product;
            $product->name = $request->name;
            $product->price = $request->price;
            $product->description = $request->description;
            $product->category_id = $request->category_id;
            $product->stock = $request->stock;
            $product->status = $request->status;
            $product->isFavorite = $request->isFavorite;
            
            $product->save();

            // save image
            if($request->hasFile("image")){  
                $image = $request->file("image");
                $image->storeAs('public/products',$product->id . '.' . $image->getClientOriginalExtension());
                $product->image = 'storage/products/' . $product->id . '.' . $image->getClientOriginalExtension();
                $product->save();
            }

            return redirect()->route("products.index")->with("success","Product created successfully");
    }

    // show
    public function show($id)
    {
        $product = Product::find($id);
        return view("pages.products.show", compact("product"));
    }
    
    // edit
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = DB::table("categories")->get();
        return view("pages.products.edit", compact("product","categories"));
    }

    // update
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            "name"=> "required",
            "description"=> "required",
            "price"=> "required|numeric",
            "stock"=> "required|numeric",
            "category_id"=> "required",
            "status"=> "required|boolean",
            "isFavorite"=> "required|boolean",
            ]);

            $product = Product::find($id); 
            $product->name = $request->name;   
            $product->description = $request->description;
            $product->price = $request->price;
            $product->stock = $request->stock;
            $product->category_id = $request->category_id;
            $product->status = $request->status;
            $product->isFavorite = $request->isFavorite;
            $product->save();

            // save image
            if($request->hasFile("image")){  
                $image = $request->file("image");
                $image->storeAs('public/products',$product->id . '.' . $image->getClientOriginalExtension());
                $product->image = 'storage/products/' . $product->id . '.' . $image->getClientOriginalExtension();
                $product->save();
            }

            return redirect()->route("products.index")->with("success","Product update successfully!");
    }

    // destroy
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect()->route("products.index")->with("success","Product delete successfully!");
    }
}
