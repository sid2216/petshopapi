<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Promotion;

class MainPageController extends Controller
{
    public function index_promotions()
    {   
    	try{
    	$promotions = Promotion::orderBy('title')->paginate(10);
    	return response()->json([
    	                   'status'=>'success',
    	                    'promotions'=>$promotions]);
            }catch(Exception $e){
            	dd($e)
            }
    }

    public function index_blog()
    {
    	try{
             $post = Post::orderBy('title')->paginate(10);
    	return response()->json([
    	                   'status'=>'success',
    	                    'post'=>$post]);
    	}catch(Exception $e){
    		dd($e);
    	}
    }

    public function show_post($uuid)
    {
         try{
         	$post = Post::where('uuid',$uuid)->first();
         	return response()->json(['status'=>'success',
                                     'post'=>$post]);
         }catch(Exception $e){
    		dd($e);
    	}
    }
}    

