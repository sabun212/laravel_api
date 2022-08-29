<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //register

    public function register(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|max:15|unique:users',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:5|max:255'
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        $User = User::create($validatedData);

        if ($User) {
                return response()->json(["status"=>'Data Berhasil ditambah', "data"=>$User]);
            } else {
                return response()->json(["status"=>'Data Gagal ditambah', "data"=>$User]);

    }
}


    //login
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
