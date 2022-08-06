<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\File;
use Illuminate\Support\Facades\Validator;

class FilesController extends Controller
{
    public function upload(Request $request)
    {
         dd($request->file);
         try{
             $rules = array(
                'file' =>'required|mimes:jpg,jpeg,png,bmp,tiff',
                
            );
             $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status'=>false,'error'=>$validator->errors()], 200);
            }
            $uuid = Str::uuid(10)->toString();
            $filename='';
            
              $file = $request->file;
              //dd($file);
              $extension = $file->getClientOriginalExtension(); // getting image
              $size=$file->getSize();
              $filename =$file->getClientOriginalName();
              $path = storage_path('app/public/petshop/images'.$filename);
               if (!is_dir($path)) {
                        mkdir($path, 0777, TRUE);
                    }
              $uuid = Str::uuid()->toString();
              $type = $file->getMimeType();
              $file->move($path, $filename);

            
            $files=File::create(['uuid'=>$uuid,
                                 'type'=>$type,
                                  'name'=>$filename,
                                  'path'=>$path,
                                  'size'=>$size ]);
            return response()->json(['status'=>'success',
            	                       'message'=>'files created succefully',
                                       'files'=>$files ]);
         }catch(Exception $e){
         	dd($e);
         }
           }
         public function getfile($uuid)
         {
         	try{
             $file = File::where('uuid',$uuid)->first();
             return response()->json(['status'=>'success',
                                      'file'=>$file]);
         }catch(Exception $e){
         	dd($e);
         }
         }
    
}
