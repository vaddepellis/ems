<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{

    public function signUp(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'lastname' => 'required|min:3',
            'email'=>'required|email|unique:users',
            'mobile' => 'required|digits:10',
            'password' => 'required|string|confirmed',
        ]   );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,         
            'lastname' => $request->lastname,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
        ]);
        $token = $user->createToken($user->name);

        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'data' => [
                'user' => new UserResource($user),
                'token' => $token->plainTextToken,
            ],
        ], 200);


        
    }
    public function signIn(Request $request){
        $validator = Validator::make($request->all(),[
            'email'=>'required|email|exists:users',
            'password'=>'required|string'
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => 'invalid credentials',
              
            ], 422);
        }
        $user =  User::where('email',$request->email)->first();
        // return response()->json(new UserResource($user));
        if(!$user || !Hash::check($request->password,$user->password)){
           return response()->json([
                'status' => 'error',
                'message' => 'invalid credentials',
            ], 422);
        }
        $token = $user->createToken($user->name);
        return ['status'=>'success','user'=>new UserResource($user),'token'=>$token->plainTextToken];
    }
    public function signOut(Request $request){
        $request->user()->tokens()->delete();
        return response()->json(['status'=>'success','message'=>'logged out successfully !']);
    }
}
