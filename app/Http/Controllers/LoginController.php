<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request) {

        $username=$request->input('username');
        $password=$request->input('password');
        $model = User::where('username', '=', $username)->first();
        if (!empty($model)) {
            $cryptedpassword=$model->password;
            if (Hash::check($password, $cryptedpassword)) {
                $user=[
                    "name" => $model->name,
                    "username" => $model->username
                ];
                $token = $model->createToken('token-name')->plainTextToken;
                $data=[
                    "status" => "Success",
                    "user" => $model,
                    'token' => $token

                ];
            } else {
                $data=[
                    "status" => "username Atau Password Salah!",
                ];
            }
        }
        if(empty($model)) {
            $data=[
                "status" => "username Atau Password Salah!",
                "user" => null
            ];
        }
        return response()->json($data);
      }
}
