<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Order_status;

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
            
    		$orderstatus_create = Order_status::create(['title'=>$request->title]);
            return response()->json(['status'=>'success',
                                      'message'=>'orderstatus created succesfully']);  
    	}catch(Exception $e){
             dd($e);
    	}
    }
    }

    public function edit_orderstatus($uuid)
    {
    	try{
              $rules = array(
                'title' => 'required'
            );
             $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status'=>false,'error'=>$validator->errors()], 200);
                  }
                $orderstatus_update = Order_status::find('uuid',$uuid);
                $orderstatus_update->title = $request->title;
                
                $orderstatus_update->save();
                return response()->json(['status'=>'success','orderstatus'=>$orderstatus,'message'=>'orderstatus updated successfully']);
    	}catch(Exception $e){
    		dd($e);
    	}
    }

    public function orderstatus_show($uuid)
    {
         try{
             $orderstatus = Order_status::find('uuid',$uuid);
              return response()->json(['status'=>'success',
                                         'orderstatus'=>$orderstatus]);
         }catch(Exception $e){
             dd($e);
         }
    }

    public function delete_orderstatus($uuid)
    {
    	try{
             $orderstatus = Order_status::find('uuid',$uuid);
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
             $orderstatus = Order_status::all()->orderBy('title')->paginate(10);
              return response()->json(['status'=>'success',
                                         'orderstatus'=>$orderstatus]);
         }catch(Exception $e){
             dd($e);
         }
    }
}
