<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    
	public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function login(Request $request)
    {
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
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function create()
    {
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
            $filename='';
            if($request->hasfile('avatar')) 
            { 
              $file = $request->file('avatar');
              $extension = $file->getClientOriginalExtension(); // getting image extension
              $size=$file->getSize()
              $filename =time().'.'.$extension;
              $path = public_path().'/admin/images/';
              $uuid = Str::uuid()->toString();
              $file->move($path, $filename);

            }
           $user_create = User::create([
           	'first_name'=>$request->first_name,
            'last_name' =>$request->last_name,
            'email'=>$request->email,
            'password'=>$request->password,
             'address'=>$request->address,
             'avatar'=>$avatar_id,
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

    public function forget_password(Request $request)
    {
    	try{
    		$rules = array(
                'email' => 'required|email',
                
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status'=>false,'error'=>$validator->errors()], 200);

            }
            $randomId =rand(2,50);

    	$user_email = $request->email;
    	Mail::to($user_email)->send($randomId);
    	return response()->json([
    		'status'=>'success',
    		'email'=>$email]);
    	}catch(Exception $e){
    		dd($e);
    	}
    	

    }

    public function reset_password_token()
    {
       try{
       	$rules = array(
                'email' => 'required|email',
                'password' => 'required',
                'token'=>'required',
                'password_confirmation'=>'required|same:password'
                
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status'=>false,'error'=>$validator->errors()], 200);

            }
       	$password_reset=Password_reset::where('token',$request->token)->pluck('token');
       	if($password_reset){
       		return response()->json(['status'=>'success',
       	                             'message'=>'Token expired']);
       	}
       	  $user_update = User::find('email',$request->email);
             $user_update->email =$request->email;
             $user_update->password = $request->password;
             $user_update->save();
             $password_rest=Password_rest::create(['email'=>$request->email,
                                               'token'=>$request->token]);

       }catch(Exception $e){
       	dd($e);
       }
    }
}
