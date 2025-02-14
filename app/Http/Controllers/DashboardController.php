<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    function showSummary(Request $request){
        $user_id = $request->header('id');
        $products= Product::where('user_id',$user_id)->count();
        $categories = Category::where('user_id',$user_id)->count();
        $customers= Customer::where('user_id',$user_id)->count();
        $invoices= Invoice::where('user_id',$user_id)->count();
        $total=Invoice::where('user_id',$user_id)->sum('total');
        $vat=Invoice::where('user_id',$user_id)->sum('vat');
        $discount=Invoice::where('user_id',$user_id)->sum('discount');
        $payable=Invoice::where('user_id',$user_id)->sum('payable');
//        $invoiceProducts =Invoice::where('user_id',$user_id)->get();

        return [
            'product' => $products,
            'category' => $categories,
            'customer' => $customers,
            'invoice' => $invoices,
            'total' => round($total, 2),
            'payable' => round($payable, 2),
            'vat' => round($vat, 2),
            'discount' => round($discount, 2),
        ];
    }

}
