<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Order_status;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
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
                 $order=Order::where('order_status_id','4')
                    ->join('users','orders.user_id','=','users.id')
                     ->get();
             foreach ($order as $key => $value) {
                       if(is_array(json_decode($value->products))){
                        foreach (json_decode($value->products) as $key1 => $value1) {
                          $puuid[]=$value1->product;
                        }
                       }
                     }
       
             $category=DB::table('products')->select('categories.title','products.uuid')
                             ->join('categories','products.category_id','=','categories.id')->whereIn('products.uuid',$puuid)->get();
                              
                               foreach ($order as $key2 => $value2) {
                                foreach (json_decode($value2->products) as $key4 => $value4) {
                                  foreach ($category as $key3 => $value3) {
                                    if($value4==$value3->title){
                                      $order[$key2]['category']=$value3->title;
                                    }
                                 }}
                                
                                   
                               }
                               //dd($order);

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
                 $address_arr = array('address'=>$request->address,'city'=>$request->city,'state'=>$request->state,'zip'=>$request->zip,'country'=>$request->country);        
    		$address=json_encode($address_arr);
        $product = array();
      foreach ($request->product as $key=> $value1) {
              $product[]=array('product'=>$value1['product'],'quantity'=>$value1['quantity']); }
        $products= json_encode($product);
        
    		       $order=Order_status::where('title','pending_payment')->first();
             // dd($products);
            $order= Order::create(['user_id'=>Auth::user()->id,
                                     'uuid'=>$uuid,
                                   'order_status_id'=>$order->id,
                                    'products'=>$products,
                                    'address'=>$address,
                                    'amount'=>$request->amount]);

            return response()->json(['status'=>'success',
                                      'message'=>'order created succefully',
                                      'order'=>$order]);
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
                 $address_arr = array('address'=>$request->address,'city'=>$request->city,'state'=>$request->state,'zip'=>$request->zip,'country'=>$request->country);        
        $address=json_encode($address_arr);
        $product = [];
      foreach ($request->product as $key => $value1) {
            $product[]=array('product'=>$value1['product'],'quantity'=>$value1['quantity']);

      }
        $products= json_encode($product);
               $order=Order_status::where('title','pending_payment')->first();
            $order= Order::where('uuid',$uuid)->update([
                                    'user_id'=>Auth::user()->id,
                                     'uuid'=>$uuid,
                                   'order_status_id'=>$order->id,
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
             $prod_uuid[]=$value->product;
           }
           $products_ar = DB::table('products')
                           ->select('products.title','products.description','products.metadata','products.price','categories.title','brands.title','files.path')
                            ->join('categories','products.category_id','=','categories.id')
                            ->join('brands','products.metadata->brand','=','brands.uuid')
                            ->join('files','products.metadata->image','=','files.uuid')
                            ->whereIn('products.uuid',$prod_uuid)
                            ->get();
                    $order['products']=$products_ar;        
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
                                    'order'=>'order deleted succefully']);
      }catch(Exception $e){
        dd($e);
      }
    }

    public function invoice_order($uuid){
      try{
           $order = \DB::select('orders.user_id','orders.order_status_id','orders.payment_id','orders.products','orders.address','orders.user_id','orders.user_id',)

           $products = json_decode($order->products);
           $prod_uuid = [];
           foreach ($products as $key => $value) {
             $prod_uuid[]=$value->product;
           }
           $products_ar = DB::table('products')
                           ->select('products.title','products.description','products.metadata','products.price','categories.title','brands.title','files.path')
                            ->join('categories','products.category_id','=','categories.id')
                            ->join('brands','products.metadata->brand','=','brands.uuid')
                            ->join('files','products.metadata->image','=','files.uuid')
                            ->whereIn('products.uuid',$prod_uuid)
                            ->get();
                    $order['products']=$products_ar;        
            return response()->json(['status'=>'success','order'=>$order]);
      }catch(Exception $e){
        dd($e);
      }
    }
}
