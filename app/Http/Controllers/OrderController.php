<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Order_status;
use DB;
class OrderController extends Controller
{
    public function all_order_list()
    {
    	try{
          $order = User::with(['orders' => function ($query) {
        $query->select('amount','orders.uuid','user_id','order_status_id','products->quantity as quantity','order_statuses.title')->join('order_statuses', 'orders.order_status_id', '=', 'order_statuses.id');
                  }])->get();
          
          
          return response()->json(['status'=>'success',
                                    'order'=>$order]);
    	}catch(Exception $e){
    		dd($e);
    	}
    }
    public function shipment_locator()
    {
    	try{
        $puuid=[];
             $order = User::with(['orders' => function ($query) {
        $query->select('orders.uuid','user_id','products->product as puuid','products->quantity as quantity','order_status_id');
                  }])->get();
             foreach ($order as $key => $value) {
              foreach ($value['orders'] as $key1 => $value1) {
                $puuid[]=$value1->puuid;
              }
                
             }
             $category=DB::table('products')->select('categories.title','products.uuid')
                             ->join('categories','products.category_id','=','categories.id')->whereIn('products.uuid',$puuid)->get();
                               
                               foreach ($order as $key3 => $value4) {
                                 foreach ($value4['orders'] as $key5 => $value5) {
                                    foreach ($category as $key2 => $value2) {

                                       if($value5->puuid==$value2->uuid){
                                        //dd($value5->puuid);
                                        $value4['orders'][$key3]['title']=$value2->title;
                                       }
                                }     
                               }
                             }
             return response()->json(['status'=>'success',
                                    'order'=>$order]);
    	}catch(Exception $e){

    	}
    }
    public function dashboard_order()
    {
    	try{
    	 $order = User::with(['orders' => function ($query) {
        $query->select('amount','orders.uuid','user_id','order_status_id','products->quantity as quantity','order_statuses.title')->join('order_statuses', 'orders.order_status_id', '=', 'order_statuses.id');
                  }])->get();
          
          return response()->json(['status'=>'success',
                                    'order'=>$order]);
    	}catch(Exception $e){
    		dd($e);
    	}
    }

    public function create_order(Request $request)
    {
    	try{
           $uuid = Str::uuid(10)->toString();
           $rules = ['address'=>'required',
                      'city'=>'required',
                        'state'=>'required',
                        'zip'=>'required',
                         'country'=>'required',
                        'amount'=>'required'];
                $validator = Validator::make($request->all(), $rules);
               if ($validator->fails()) {
                   return response()->json(['status'=>false,'error'=>$validator->errors()], 200);
               }
                 $address_arr = ['address'=>$request->address,'city'=>$request->city,'state'=>$request->state,'zip'=>$request->zip,'country'=>$request->country];        
    		$address=json_encode($address_arr);
        $products= json_encode($product);
    		       $order=Order_status::where('title','pending_payment')->first();
            $order= Order::create(['user_id'=>Auth::user()->id,
                                     'uuid'=>$uuid,
                                   'order_status_id'=>$order->id,
                                    'payment_uuid'=>$request->payment_uuid,
                                    'products'=>$products,
                                    'address'=>$address,
                                    'amount'=>$request->amount]);
    	}catch(Exception $e){
    		dd($e);
    	}
    }


    public function edit_order(Request $request,$uuid){
      try{
       $uuid = Str::uuid(10)->toString();
           $rules = ['address'=>'required',
                      'city'=>'required',
                        'state'=>'required',
                        'zip'=>'required',
                         'country'=>'required',
                        'amount'=>'required'];
                $validator = Validator::make($request->all(), $rules);
               if ($validator->fails()) {
                   return response()->json(['status'=>false,'error'=>$validator->errors()], 200);
               }
                 $address_arr = ['address'=>$request->address,'city'=>$request->city,'state'=>$request->state,'zip'=>$request->zip,'country'=>$request->country];        
        $address=json_encode($address_arr);
        $products= json_encode($product);
               $order=Order_status::where('title','pending_payment')->first();
            $order= Order::where('uuid',$uuid)->update([
                                    'user_id'=>Auth::user()->id,
                                     'uuid'=>$uuid,
                                   'order_status_id'=>$order->id,
                                    'payment_uuid'=>$request->payment_uuid,
                                    'products'=>$products,
                                    'address'=>$address,
                                    'amount'=>$request->amount]);
          }catch(Exception $e){
            dd($e);
          }
    }
    public function show_order($uuid){
      try{
           $order = Order::where('uuid',$uuid)->first();
           $products = json_decode($order->products);
           $prod_uuid = [];
           foreach ($products as $key => $value) {
             $prod_uuid[]=$value->products;
           }
           $products_ar = DB::table('products')
                           ->select('products.title','products.description','products.metadata','products.price','categories.title','brands.title','files.path')
                            ->join('categories','products.category_id','=','categories.id')
                            ->join('brands','products.metadata->brand','=','brands.uuid')
                            ->join('files','products.metadata->image','=','files.uuid')
                            ->whereIn('uuid',$prod_uuid)
                            ->get();
                    $order['products']=>$products_ar;        
            return response()->json(['status'=>'success','order'=>$order]);
      }catch(Exception $e){
        dd($e);
      }
    }

    public function delete_order($uuid)
    {
      try{
           $order=Order::where('uuid',$uuid)->delete();
           return response()->json(['status'=>'success',
                                    'order'=>'rder deleted succefully'])
      }catch(Exception $e){
        dd($e);
      }
    }
}
