<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use JWTGuard;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    public function register(Request $request){
         $validator = Validator::make(request()->all(), [
            "name"=> "required|string|min:2|max:100",
            "email"=> "required|string|email|max:100|unique:users",
            "password"=> "required|min:8|confirmed",
         ]);

         if($validator->fails()) {
            return response()->json($validator->errors(),400);
         }

         $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
         ]);

         return response()->json([
            'message'=> 'User Registered successfully',
            'user'=> $user
         ]);
    }

    // for login 
    public function login(Request $request){
        $validator = Validator::make(request()->all(), [
            "email"=> "required|string|email",
            "password"=> "required|min:8",
         ]);

         if($validator->fails()) {
            return response()->json($validator->errors(),400);
         }

         if(!$token = auth()->attempt($validator->validated())){
            return response()->json(['error' => 'Unauthorized']);
         }
         
         return $this->respondWithToken($token);
        

    }
    protected function respondWithToken($token){
        return response()->json([
            'access_token'=> $token,
            'token_type'=> 'bearer',
            'expires_in'=>auth()->factory()->getTTL()*60
        ]);
            
    }

    public function profile(){
      return response()->json(auth()->user());
    }

    public function refresh(){
      return response()->json(auth()->refresh());
    }

    public function logout()
    {
      auth()->logout();
      return response()->json(['message'=>'User Successfully logged out']);
    }
}
