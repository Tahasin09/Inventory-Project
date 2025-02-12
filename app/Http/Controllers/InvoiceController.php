<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    function invoiceCreate(Request $request){
        DB::beginTransaction(); //when database operation will run on multiple database use this and try catch
        try{

            $user_id= $request->header('id');
            $total = $request->input('total');
            $vat = $request->input('vat');
            $discount = $request->input('discount');
            $payable = $request->input('payable');
            $customer_id = $request->input('customer_id');

            $invoice = Invoice::create([
                'total'=>$total,
                'vat'=>$vat,
                'discount'=>$discount,
                'payable'=>$payable,
                'user_id'=>$user_id,
                'customer_id'=>$customer_id
            ]);

            $invoice_id= $invoice->id;
            $products= $request->input('products');

            foreach ($products as $product) {
                InvoiceProduct::create([
                    'invoice_id'=>$invoice_id,
                    'product_id'=>$product['product_id'],
                    'quantity'=>$product['quantity'],
                    'sale_price'=>$product['sale_price']
                ]);
            }

            DB::commit();
            return 1;

        }catch (Exception $e){
            DB::rollBack();
            return 0;
        }
    }
    function invoiceSelect(Request $request){
        $user_id = $request->header('id');
        return Invoice::where('user_id',$user_id)->with('customer')->get();
    }
    function invoiceDetails(Request $request){

    }
    function invoiceDelete(Request $request){

        DB::beginTransaction();
        try{
            $user_id = $request->header('id');
            InvoiceProduct::where('invoice_id',$request->input('invoice_id'))->where('user_id',$user_id)->delete();
            Invoice::where('id',$request->input('invoice_id'))->delete();

            DB::commit();
            return 1;

        }catch(Exception $e){
            DB::rollBack();
            return 0;
        }

    }

    function invoiceDetail(Request $request){
        $user_id = $request->header('id');
        $customer_details= Customer::where('user_id',$user_id)
            ->where('id',$request->input('customer_id'))->first();

        $invoice_total = Invoice::where('user_id',$user_id)
            ->where('customer_id',$request->input('invoice_id'))->first();
        $invoice_product = InvoiceProduct::where('invoice_id',$request->input('invoice_id'))
                ->where('user_id',$user_id)
                ->with('product')-get();


        return array(
            'customer'=>$customer_details,
            'invoice'=>$invoice_total,
            'products'=>$invoice_product
        );
    }


}
