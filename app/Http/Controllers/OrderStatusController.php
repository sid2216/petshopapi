<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order_status;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OrderStatusController extends Controller
{
    
    public function create(Request $request)
    {
    	try{
    		$rules = array(
                'title' => 'required'
            );
             $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status'=>false,'error'=>$validator->errors()], 200);
            }
            //dd("ok");
             $uuid = Str::uuid(10)->toString();
    		$orderstatus_create = Order_status::create(['title'=>$request->title,'uuid'=>$uuid]);
            return response()->json(['status'=>'success',
                                      'message'=>'orderstatus created succesfully','orderstatus_create'=>$orderstatus_create]);  
    	}catch(Exception $e){
             dd($e);
    	}
    }
    

    public function edit_orderstatus(Request $request,$uuid)
    {
    	try{
              $rules = array(
                'title' => 'required'
            );
             $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status'=>false,'error'=>$validator->errors()], 200);
                  }
                $orderstatus_update = Order_status::where('uuid',$uuid)->first();
                $orderstatus_update->title = $request->title;
                
                $orderstatus_update->save();
                return response()->json(['status'=>'success','orderstatus'=>$orderstatus_update,'message'=>'orderstatus updated successfully']);
    	}catch(Exception $e){
    		dd($e);
    	}
    }

    public function orderstatus_show($uuid)
    {
         try{
             $orderstatus = Order_status::where('uuid',$uuid)->first();
              return response()->json(['status'=>'success',
                                         'orderstatus'=>$orderstatus]);
         }catch(Exception $e){
             dd($e);
         }
    }

    public function delete_orderstatus($uuid)
    {
    	try{
             $orderstatus = Order_status::where('uuid',$uuid)->first();
             $orderstatus->delete();
              return response()->json(['status'=>'success',
                                         'message'=>'orderstatus deleted succefully']);
         }catch(Exception $e){
             dd($e);
         }
    }

    public function orderstatus_index()
    {
    	try{
             $orderstatus = Order_status::orderBy('title')->paginate(10);
              return response()->json(['status'=>'success',
                                         'orderstatus'=>$orderstatus]);
         }catch(Exception $e){
             dd($e);
         }
    }
}
