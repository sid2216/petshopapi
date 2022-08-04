<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    
    public function create(Request $request)
    {
    	try{
    		$rules = array(
    			'category_uuid'=>'required',
                'title' => 'required',
                'price'=>'required|numeric',
                'description'=>'required',
                'metadata'=>'required|json'
            );
             $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status'=>false,'error'=>$validator->errors()], 200);
            }
            $uuid = Str::uuid(10)->toString();
            $metadata = json_encode($request->metadata);
    		$category_create = Product::create([
                'uuid'=>$uuid,
    			'category_uuid'=>$request->category_uuid
    		    'title'=>$request->title,
    	        'price'=>$request->price,
    	        'description'=>$request->description,
    	         'metadata'=>$metadata
    	     ]);
            return response()->json(['status'=>'success',
                                      'message'=>'product created succesfully']);  
    	}catch(Exception $e){
             dd($e);
    	}
    }
    }

    public function edit_product(Request $request,$uuid)
    {
    	try{
             $rules = array(
    			'category_uuid'=>'required',
                'title' => 'required',
                'price'=>'required|numeric',
                'description'=>'required',
                'metadata'=>'required|json'
            );
             $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status'=>false,'error'=>$validator->errors()], 200);
            } $metadata = json_encode($request->metadata);
                $product_update = Product::where('uuid',$uuid)->first();
                $product_update->title = $request->title;
                $product_update->price=$request->price;
                $product_update->description=$request->description;
                $product_update->metadata=$metadata;
                $product_update->save();
                return response()->json(['status'=>'success','category'=>$category_update,'message'=>'category updated successfully']);
    	}catch(Exception $e){
    		dd($e);
    	}
    }

    public function product_show($uuid)
    {
         try{
             $product = Product::where('uuid',$uuid)->first();
              return response()->json(['status'=>'success',
                                         'product'=>$product]);
         }catch(Exception $e){
             dd($e);
         }
    }

    public function delete_product($uuid)
    {
    	try{
             $product = Product::where('uuid',$uuid)->first();
             $product->delete();
              return response()->json(['status'=>'success',
                                         'message'=>'category deleted succefully']);
         }catch(Exception $e){
             dd($e);
         }
    }

    public function category_index()
    {
    	try{
             $product = Product::orderBy('title')->paginate(10);
             
              return response()->json(['status'=>'success',
                                         'product'=>$product]);
         }catch(Exception $e){
             dd($e);
         }
    }
}
