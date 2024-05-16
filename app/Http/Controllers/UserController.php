<?php

namespace App\Http\Controllers;

use Auth;
use App\models\user;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class UserController extends Controller
{
    //
    public function Register(RegisterRequest $request)
    {
        try
        {
     $request->validated();

      $user= User::create([
        'name' => $request->name,
        'email'=>$request->email,
        'password' => Hash::make($request->password),

      ]);
          $token = Auth::login($user);
          return response()->json([
        'status'=>'تم اضافة حسابك',
        'user'=>$user,
        'token'=>$token,
          ]);
        }
        catch(Throwable $th)
        {
            Log::error($th->getMessage());
            Log::Debug($th);
            return response()->json([
                'status'=>'error'
            ]);

        }

    }
    public function login(LoginRequest $request)
    {
        try{

            $credentials = $request->only('email','password');
            $token = Auth::attempt($credentials);
              if(!$token){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized',
                ], 401);
              };
              $user = Auth::user();
              return response()->json([
                'status'=>' تم تسجيل الدخول  ',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',

]              ]);


     }
       catch(\Throwable $th){
          Log::debug($th);
          $e=\Log::error( $th->getMessage());
          return response()->json([
              'status' =>'error',

            ]);


        }}
         public function logout(){
            Auth::logout();
            return response()->json([
                'status'=>'تم تسجيل الخروج',
            ]);
         }
}
