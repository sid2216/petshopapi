<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
class OrderController extends Controller
{
    public function all_order_list()
    {
    	try{
          $order = Order::with(['user:id,first_name,last_name','order_status:title'])->get();
          //product code
          return response()->json(['status'=>'success',
                                    'order'=>$order]);
    	}catch(Exception $e){
    		dd($e);
    	}
    }
    public function shipment_locator()
    {
    	try{
             $order = Order::with(['order_status' => function ($query) {
                          $query->where('title','shiped');
                                 },'user:id,first_name,last_name'])->get();
             //product code
    	}catch(Exception $e){

    	}
    }
    public function dashboard_order(Request $request)
    {
    	try{
    		$range=json_decode($request->dateRange);
    		$fixRange=$request->fixRange;
          //$order = Order::with(['user:id,first_name,last_name','order_status:created_at'])->where()->get();
          //product code
          return response()->json(['status'=>'success',
                                    'order'=>$order]);
    	}catch(Exception $e){
    		dd($e);
    	}
    }

    public function create_order(Request $request)
    {
    	try{
    		$products=json_encode($request->products);
    		$address=json_encode($request->address);
            $order= Order::create(['user_id'=>Auth::user()->id,
                                   'order_status_uuid'=>$request->order_status_uuid,
                                     'payment_uuid'=>$request->payment_uuid,
                                       'products'=>$products,
                                       'address'=>$address,
                                          'amount'=>$request->amount])
    	}catch(Exception $e){
    		dd($e);
    	}
    }
}
