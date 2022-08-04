<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Orders;
use Illuminate\Support\Facades\Auth;
class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function create(Request $request)
    {
    	try{
    		$uuid = Str::uuid(10)->toString();
    		if(empty($request->type)){
    			return response()->json(['status'=>false,'error'=>'Payment type rquired']);
    		}
             $type = str_replace(" ","_",strtolower($request->type));

             if($type=='credit_card'){
           $rules = array(
                'holder_name' => 'required',
                'number'=>'required',
                'ccv'=>'required',
                'expire_date'=>'required'
            );
             $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status'=>false,'error'=>$validator->errors()], 200);
            }
            $details = json_encode(["holder_name"=>$request->holder_name,"number"=> $request->number,
    		"ccv"=>$request->ccv,"expire_date"=>$request->expire_date]);
       }elseif($type=='cash_on_delivary'){
       	$rules = array(
                'first_name' => 'required',
                'last_name'=>'required',
                'address'=>'required'
            );
             $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status'=>false,'error'=>$validator->errors()], 200);
            }
       	$cash_on_delivary = json_encode(["first_name"=>$request->first_name,"last_name"=> $request->last_name,"address"=> $request->address]);
       }elseif($type=='bank_transfer') {
       		$rules = array(
                'swift' => 'required',
                'iban'=>'required',
                'name'=>'required'
            );
             $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status'=>false,'error'=>$validator->errors()], 200);
            }
       	$details = json_encode(["swift"=> $request->swift,"iban"=>$request->iban,"name"=>$request->name]);
       }
    	
        $payment_create = Payment::create(['type'=>$type,
    	                                         'details'=>$details,
                                                   'uuid'=>$uuid]);
             if(!empty($payment_create)){
             	Orders::where('user_id',Auth::user()->id)
             	         ->where('order_status_id','2')->update(['payment_id'=>$payment_create->id]);
             }
            return response()->json(['status'=>'success',
                                       'payment'=>$payment_create,
                                      'message'=>'Payment succesfully']);  
    	}catch(Exception $e){
             dd($e);
    	}
    }
    

    public function edit_payment(Request $request,$uuid)
    {
    	try{
              if(empty($request->type)){
    			return response()->json(['status'=>false,'error'=>'Payment type rquired']);
    		}
             $type = str_replace(" ","_",strtolower($request->type));

             if($type=='credit_card'){
           $rules = array(
                'holder_name' => 'required',
                'number'=>'required',
                'ccv'=>'required',
                'expire_date'=>'required'
            );
             $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status'=>false,'error'=>$validator->errors()], 200);
            }
            $details = json_encode(["holder_name"=>$request->holder_name,"number"=> $request->number,
    		"ccv"=>$request->ccv,"expire_date"=>$request->expire_date]);
       }elseif($type=='cash_on_delivary'){
       	$rules = array(
                'first_name' => 'required',
                'last_name'=>'required',
                'address'=>'required'
            );
             $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status'=>false,'error'=>$validator->errors()], 200);
            }
       	$cash_on_delivary = json_encode(["first_name"=>$request->first_name,"last_name"=> $request->last_name,"address"=> $request->address]);
       }elseif($type=='bank_transfer') {
       		$rules = array(
                'swift' => 'required',
                'iban'=>'required',
                'name'=>'required'
            );
             $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status'=>false,'error'=>$validator->errors()], 200);
            }
       	$details = json_encode(["swift"=> $request->swift,"iban"=>$request->iban,"name"=>$request->name]);
       }
    	
        $payment_update = Payment::where('uuid',$uuid)->first();
    	$payment_update->type=$type;
    	$payment_update->details=$details;
    	$payment_update->save();
                                                  
             if(!empty($payment_update)){
             	Orders::where('user_id',Auth::user()->id)
             	         ->where('order_status_id','2')->update(['payment_id'=>$payment_create->id]);
             }
            return response()->json(['status'=>'success',
                                       'payment'=>$payment_update,
                                      'message'=>'Payment update succesfully']);
    	}catch(Exception $e){
    		dd($e);
    	}
    }

    public function payment_show($uuid)
    {
         try{
             $payment = Payment::where('uuid',$uuid)->first();
             $payment['details']=json_decode($payment->details);
              return response()->json(['status'=>'success',
                                        'payment'=>$payment]);
         }catch(Exception $e){
             dd($e);
         }
    }

    public function delete_payment($uuid)
    {
    	try{
             $payment = Payment::where('uuid',$uuid)->first();
             $payment->delete();
              return response()->json(['status'=>'success',
                                         'message'=>'payment deleted succefully']);
         }catch(Exception $e){
             dd($e);
         }
    }

    public function payment_index()
    {
    	try{
             $payment = Payment::orderBy('type')->paginate(10);
             $payment['details']=json_decode($payment->details);
              return response()->json(['status'=>'success',
                                         'payment'=>$payment]);
         }catch(Exception $e){
             dd($e);
         }
    }
}
