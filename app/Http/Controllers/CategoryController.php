<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    //index
    public function index()
    {
        $categories = Category::orderBy("id","desc")->paginate(5);
        return view("pages.categories.index", compact("categories"));
    }

    public function create()
    {
        return view("pages.categories.create");
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            "name"=> "required",
            "description"=> "required",
            ]);
          
            $category = new Category;
            $category->name = $request->name;
            $category->description = $request->description;

            $category->save();

            // save image
            if($request->hasFile("image")){  
                $image = $request->file("image");
                $image->storeAs('public/categories',$category->id . '.' . $image->getClientOriginalExtension());
                $category->image = 'storage/categories/' . $category->id . '.' . $image->getClientOriginalExtension();
                $category->save();
            }

            return redirect()->route("categories.index")->with("success","Category created successfully");
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view("pages.categories.edit", compact("category"));
    }

    public function update(Request $request, $id)  
    {
        $this->validate($request, [
            "name"=> "required",
            "description"=> "required",
            ]);
            
            $category = Category::find($id); 
            $category->name = $request->name;   
            $category->description = $request->description;

            $category->save();

            // save image
            if($request->hasFile("image")){  
                $image = $request->file("image");
                $image->storeAs('public/categories',$category->id . '.' . $image->getClientOriginalExtension());
                $category->image = 'storage/categories/' . $category->id . '.' . $image->getClientOriginalExtension();
                $category->save();
            }

            return redirect()->route("categories.index")->with("success","Category update successfully");
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return redirect()->route("categories.index")->with("success","Category delete successfully");
    }
}
