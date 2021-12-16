<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Login extends ApiController
{
    public function SignIn(Request $request){
        $validated = $request->validate([
            'email' => 'required|max:255',
            'password'  =>'required|min:8'
        ]);

        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            $data = [
                'status' => 'error',
                'msg' => 'Unathorized',
                'errors' => null,
                'content' => null,
            ];
            return $this->errorResponse($data,'Username atau password salah',422);

        }

        $user = User::where('email', $request->post('email'))->first();
        if (! Hash::check($request->post('password'), $user->password, [])) {
            throw new \Exception('Error in Login');
        }

        $tokenResult = $user->createToken('token-auth')->plainTextToken;
        $data = [
            'name'          =>$user->name,
            'id_user'       =>$user->id_user,
            'email'         =>$user->email,
            'status_code'   =>200,
            'access_token'  =>$tokenResult,
            'token_type'    =>'Bearer',
        ];
        return $this->successResponse($data,"Login Berhasil");
      }

      public function SignOut(Request $request){
        $user =  $request->user();
        $user->tokens()->delete();
        return $this->successResponse(null,"Logout Berhasil");
    }

}
