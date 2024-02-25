<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    //index api
    public function index()
    {
        $products = Product::orderBy("id","desc")->paginate(10);
        return response()->json([
            'status' => 'success',
            'products'=> $products
        ],200);
    }
}
