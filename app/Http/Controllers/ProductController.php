<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    function productCreate(Request $request)
    {
        $user_id=$request->header('id');
        return Product::create([
            'name'=>$request->input('name'),
            'price'=> $request->input('price'),
            'unit'=>$request->input('unit'),
            'category_id'=> $request->input('category_id'),
            'user_id'=>$user_id
        ]);

    }
    function productUpdate(Request $request)
    {
        $user_id=$request->header('id');
        $product_id= $request->input('id');

        return Product::where('id',$product_id)->where('user_id',$user_id)->update([
            'name'=>$request->input('name'),
            'price'=> $request->input('price'),
            'unit'=>$request->input('unit'),
            'category_id'=> $request->input('category_id')
        ]);

    }
    function productDelete(Request $request)
    {
        $user_id=$request->header('id');
        $product_id = $request->input('id');

        return Product::where('id',$product_id)->where('user_id',$user_id)->delete();

    }
    function productList(Request $request)
    {
        $user_id=$request->header('id');
        return Product::where('user_id',$user_id)->get();
    }
    function productByID(Request $request)
    {
        $user_id=$request->header('id');
        $product_id = $request->input('id');

        return Product::where('id',$product_id)->where('user_id',$user_id)->first();

    }
}
