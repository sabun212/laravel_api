<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class RegisterController extends Controller
{
    public function store(Request $request)
    {
        // $validatedData = $request->validate([
        //     'name' => 'required|max:255',
        //     'email' => 'required|email|',
        //     'password' => 'required|min:5'

        // ]);

        // $User = User::create($validatedData);

        //    if ($User) {
        //     return response()->json(["status"=>'Data Berhasil ditambah', "data"=>$User]);
        // } else {
        //     return response()->json(["status"=>'Data Gagal ditambah', "data"=>$User]);

        // }

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|max:15|unique:users',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:5|max:255'
        ]);

        // $validatedData['password'] = bcrypt($validatedData['password']);

        $validatedData['password'] = Hash::make($validatedData['password']);

        $User = User::create($validatedData);

        if ($User) {
                return response()->json(["status"=>'Data Berhasil ditambah', "data"=>$User]);
            } else {
                return response()->json(["status"=>'Data Gagal ditambah', "data"=>$User]);

    }
}

}
