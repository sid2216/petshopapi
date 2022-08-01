<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }
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
            $slug =str_replace(" ","-",$request->title);
    		$category_create = Category::create(['title'=>$request->title,
    	                                         'slug'=>$slug]);
            return response()->json(['status'=>'success',
                                      'message'=>'category created succesfully']);  
    	}catch(Exception $e){
             dd($e);
    	}
    }
    

    public function edit_category($uuid)
    {
    	try{
              $rules = array(
                'title' => 'required'
            );
             $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status'=>false,'error'=>$validator->errors()], 200);
                  }
                $category_update = Category::find('uuid',$uuid);
                $category_update->title = $request->title;
                $category_update->slug=str_replace(" ","-",$request->title);
                $category_update->save();
                return response()->json(['status'=>'success','category'=>$category_update,'message'=>'category updated successfully']);
    	}catch(Exception $e){
    		dd($e);
    	}
    }

    public function category_show($uuid)
    {
         try{
             $category = Category::find('uuid',$uuid);
              return response()->json(['status'=>'success',
                                         'category'=>$category]);
         }catch(Exception $e){
             dd($e);
         }
    }

    public function delete_category($uuid)
    {
    	try{
             $category = Category::find('uuid',$uuid);
             $category->delete();
              return response()->json(['status'=>'success',
                                         'message'=>'category deleted succefully']);
         }catch(Exception $e){
             dd($e);
         }
    }

    public function category_index()
    {
    	try{
             $category = Category::orderBy('title')->paginate(10);
              return response()->json(['status'=>'success',
                                         'category'=>$category]);
         }catch(Exception $e){
             dd($e);
         }
    }
}
