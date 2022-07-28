<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

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
    		$category_create = Product::create([
    			'category_uuid'=>$request->category_uuid
    		    'title'=>$request->title,
    	        'price'=>$request->price,
    	        'description'=>$request->description,
    	         'metadata'=>$request->metadata
    	     ]);
            return response()->json(['status'=>'success',
                                      'message'=>'product created succesfully']);  
    	}catch(Exception $e){
             dd($e);
    	}
    }
    }

    public function edit_product($uuid)
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
                $product_update = Product::find('uuid',$uuid);
                $product_update->title = $request->title;
                $product_update->price=$request->price;
                $product_update->description=$request->description;
                $product_update->metadata=$request->metadata;
                $product_update->save();
                return response()->json(['status'=>'success','category'=>$category_update,'message'=>'category updated successfully']);
    	}catch(Exception $e){
    		dd($e);
    	}
    }

    public function product_show($uuid)
    {
         try{
             $product = Product::find('uuid',$uuid);
              return response()->json(['status'=>'success',
                                         'product'=>$product]);
         }catch(Exception $e){
             dd($e);
         }
    }

    public function delete_product($uuid)
    {
    	try{
             $product = Product::find('uuid',$uuid);
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
             $product = Product::all()->orderBy('title')->paginate(10);
             
              return response()->json(['status'=>'success',
                                         'product'=>$product]);
         }catch(Exception $e){
             dd($e);
         }
    }
}
