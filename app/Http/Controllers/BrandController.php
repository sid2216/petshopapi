<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BrandController extends Controller
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
                $uuid = Str::uuid(10)->toString();
            $slug =str_replace(" ","-",$request->title);
    		$brand_create = Brand::create(['title'=>$request->title,
    	                                         'slug'=>$slug,
                                                 'uuid'=>$uuid]);
            return response()->json(['status'=>'success',
                                    'brand'=>$brand_create,
                                      'message'=>'brand created succesfully']);  
    	}catch(Exception $e){
             dd($e);
    	}
    }
    

    public function edit_brand(Request$request,$uuid)
    {
    	try{
              $rules = array(
                'title' => 'required'
            );
             $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status'=>false,'error'=>$validator->errors()], 200);
                  }
                $brand_update = Brand::where('uuid',$uuid)->first();
                $brand_update->title = $request->tilte;
                $brand_update->slug=str_replace(" ","-",$request->title);
                $brand_update->save();
                return response()->json(['status'=>'success','brand'=>$brand_update,'message'=>'brand updated successfully']);
    	}catch(Exception $e){
    		dd($e);
    	}
    }

    public function brand_show($uuid)
    {
         try{
             $brand = Brand::where('uuid',$uuid)->first();
              return response()->json(['status'=>'success',
                                         'brand'=>$brand]);
         }catch(Exception $e){
             dd($e);
         }
    }

    public function delete_brand($uuid)
    {
    	try{
             $brand = Brand::where('uuid',$uuid)->first();
             $brand->delete();
              return response()->json(['status'=>'success',
                                         'message'=>'brand deleted succefully']);
         }catch(Exception $e){
             dd($e);
         }
    }

    public function brand_index()
    {
    	try{
             $brand = Brand::orderBy('title')->paginate(10);
              return response()->json(['status'=>'success',
                                         'brand'=>$brand]);
         }catch(Exception $e){
             dd($e);
         }
    }
}
