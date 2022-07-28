<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;

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
            $slug =str_replace(" ","-",$request->title);
    		$brand_create = Brand::create(['title'=>$request->title,
    	                                         'slug'=>$slug]);
            return response()->json(['status'=>'success',
                                      'message'=>'brand created succesfully']);  
    	}catch(Exception $e){
             dd($e);
    	}
    }
    }

    public function edit_brand($uuid)
    {
    	try{
              $rules = array(
                'title' => 'required'
            );
             $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status'=>false,'error'=>$validator->errors()], 200);
                  }
                $brand_update = Brand::find('uuid',$uuid);
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
             $brand = Brand::find('uuid',$uuid);
              return response()->json(['status'=>'success',
                                         'brand'=>$brand]);
         }catch(Exception $e){
             dd($e);
         }
    }

    public function delete_brand($uuid)
    {
    	try{
             $brand = Brand::find('uuid',$uuid);
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
             $brand = Brand::all()->orderBy('title')->paginate(10);
             $brand->delete();
              return response()->json(['status'=>'success',
                                         'message'=>'brand deleted succefully']);
         }catch(Exception $e){
             dd($e);
         }
    }
}
