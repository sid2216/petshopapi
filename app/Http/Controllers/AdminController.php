<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Files;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function login(Request $request)
    {
        try{
     $rules = array(
                'email' => 'required|email',
                'password' => 'required',
            );


            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status'=>false,'error'=>$validator->errors()], 200);

            }else{
            	$user_cred = $request->only('email','password');
            	$token = Auth::attempt($user_cred);
            	if(!$token){
            		return response()->json([
            			'status'=>'error',
            		      'message'=>'unauthorized'],401);
            	}
            	$user = Auth::user();
            	return response()->json([
            		'status'=>'success',
            	      'user'=>$user,
            	      'authorisation'=>['token'=>$token,
            	       'type'=>'Bearer']
            	   ]);

            }
            }catch(Exception $e){
                dd($e);
            }   
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function create(Request $request)
    {

       $rules = array(
                'first_name'=>'required',
                'last_name'=>'required',
                'address'=>'required',
                'avatar'=>'required',
                'phone_number'=>'required',
                'email' => 'required|email',
                'password' => 'required',
                'password_confirmation'=>'required|same:password'
            );

           
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status'=>false,'error'=>$validator->errors()], 200);

            }
            // $filename='';
            // if($request->hasfile('avatar')) 
            // { 
            //   $file = $request->file('avatar');
            //   $extension = $file->getClientOriginalExtension(); // getting image extension
            //   $size=$file->getSize()
            //   $filename =time().'.'.$extension;
            //   $path = public_path().'/admin/images/';
            //   $uuid = Str::uuid()->toString();
            //   $file->move($path, $filename);

            // }
           $user_create = User::create([
           	'first_name'=>$request->first_name,
            'last_name' =>$request->last_name,
            'email'=>$request->email,
            'password'=>$request->password,
             'address'=>$request->address,
             'avatar'=>1,
             'phone_number'=>$request->phone_number,
             'is_admin'=>0,
             'is_marketing'=>0
               ]);
           $token = Auth::login($user_create);
           return response()->json([
                  'status'=>'success',
                  'message'=>'user created successfully',
                  'user'=>$user_create,
                  'authorisation'=>['token'=>$token,
                                     'type'=>'Bearer']
           ]);
    }

    public function user_listing()
    {
        try{
         $user = User::all('first_name','last_name','address','phone_number','created_at','is_marketing');
         return response()->json(['status'=>'success',
                                   'user'=>$user]);

        }catch(Exception $e){
        	dd($e);

        }
    }

    public function edit_user(Request $request,$uuid)
    {
         try{
         	$rules = array(
                'email' => 'required|email',
                'password' => 'required',
                'first_name'=>'required',
                'last_name'=>'required',
                'address'=>'required',
                'avatar'=>'required',
                'phone_number'=>'required',
                'password_confirmation'=>'required|same:password'
            );


            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status'=>false,'error'=>$validator->errors()], 200);

            }
             $user_update = User::find('uuid',$uuid);
             $user_update->first_name = $request->first_name;
             $user_update->last_name =$request->last_name;
             $user_update->email =$request->email;
             $user_update->password = $request->password;
             $user_update->address =$request->address;
             $user_update->avatar  =$avatar;
             $user_update->is_admin  = 0;
             $user_update->is_marketing =0;
             $user_update->save();
          
          return response()->json([
                  'status'=>'success',
                  'message'=>'user updated successfully',
                  'user'=>$user_update,
           ]);

         }catch(Exception $e){
         	dd($e);
         }
    }

    public function destroy($uuid)
    {
        $user = User::find('uuid',$uuid);
        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'user deleted successfully',
            'user' => $user,
        ]);
    }

   
}
