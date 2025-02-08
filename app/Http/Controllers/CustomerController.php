<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{


    function customerCreate(Request $request){
        $user_id = $request->header('id');
        return Customer::create([
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'mobile'=>$request->input('mobile'),
            'user_id'=>$user_id
        ]);
        }

    function customerList(Request $request){
        $user_id = $request->header('id');
        return Customer::where('user_id',$user_id)->get();
    }
    function customerUpdate(Request $request){
        $user_id = $request->header('id');
        $customer_id= $request->input('id');
        return Customer::where('id',$customer_id)->where('user_id',$user_id)->update([
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'mobile'=>$request->input('mobile')
        ]);
    }
    function customerDelete(Request $request){
        $user_id = $request->header('id');
        $customer_id= $request->input('id');
        return Customer::where('id',$customer_id)->where('user_id',$user_id)->delete();
    }
    function customerByID(Request $request){
        $user_id = $request->header('id');
        $customer_id= $request->input('id');
        return Customer::where('id',$customer_id)->where('user_id',$user_id)->first();
    }
}
