<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller {
    function categoryList(Request $request)
    {
        $user_id = $request->header('id');
        return Category::where('user_id',$user_id)->get();
    }
    function categoryCreate(Request $request){
        $user_id = $request->header('id');
        return Category::create([
            'name'=>$request->input('name'),
            'user_id'=>$user_id
        ]);
    }
    function categoryDelete(Request $request){
        $user_id = $request->header('id');
        $category_id= $request->input('id');

        return Category::where('id',$category_id)->where('user_id',$user_id)->delete();
    }
    function categoryUpdate(Request $request){
        $user_id = $request->header('id');
        $category_id= $request->input('id');

        return Category::where('id',$category_id)->where('user_id',$user_id)->update([
            'name'=> $request->input('name')
        ]);
    }
    function categoryByID(Request $request){
        $user_id = $request->header('id');
        $category_id= $request->input('id');

        return Category::where('id',$category_id)->where('user_id',$user_id)->first();
    }
}
