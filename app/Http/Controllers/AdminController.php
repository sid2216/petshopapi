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
        $this->middleware('auth:api', ['except' => ['login','register','admin_logout']]);
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
            	      'authorization'=>['token'=>$token,
            	       'type'=>'Bearer']
            	   ]);

            }
            }catch(Exception $e){
                dd($e);
            }   
    }

    public function admin_logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function register(Request $request)
    {
         //dd($request->all());
       $rules = array(
                'first_name'=>'required',
                'last_name'=>'required',
                'address'=>'required',
                'avatar'=>'required',
                'phone_number'=>'required|numeric',
                'email' => 'required|email',
                'password' => 'required',
                'password_confirmation'=>'required|same:password'
            );

           
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status'=>false,'error'=>$validator->errors()], 200);

            }
            
             $uuid = Str::uuid(10)->toString();
            $avatar = File::orderBy('id', 'desc')->first();
             $password = Hash::make($request->password);
           $user_create = User::create([
            'uuid'=>$uuid,
           	'first_name'=>$request->first_name,
            'last_name' =>$request->last_name,
            'email'=>$request->email,
            'password'=>$password,
             'address'=>$request->address,
             'avatar'=>$avatar->uuid,
             'phone_number'=>$request->phone_number,
             'is_admin'=>1,
             'is_marketing'=>1
               ]);
           $token = Auth::login($user_create);
           return response()->json([
                  'status'=>'success',
                  'message'=>'user created successfully',
                  'user'=>$user_create,
                  'authorization'=>['token'=>$token,
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
            $uuid = Str::uuid(10)->toString();
            $avatar = File::orderBy('id', 'desc')->first();
             $password = Hash::make($request->password);
             $user_update = User::where('uuid',$uuid)->first();
            $user_update->uuid = $uuid;
             $user_update->first_name = $request->first_name;
             $user_update->last_name =$request->last_name;
             $user_update->email =$request->email;
             $user_update->password = $request->password;
             $user_update->address =$request->address;
             $user_update->avatar  =$avatar->uuid;
             $user_update->is_admin  = 1;
             $user_update->is_marketing =1;
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
        $user = User::where('uuid',$uuid)->first();
        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'user deleted successfully',
            'user' => $user,
        ]);
    }

   
}
