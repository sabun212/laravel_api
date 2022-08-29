<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index ()
    {
        // $user = User::orderBy('time', 'DESC')->get();
        // $response = [
        //     'message' => 'List User',
        //     'data' => $user
        // ];

        // return response()->json($response);

        // $data = User::all();
        $data = User::where('user_id', auth()->user()->id)->get();
        return response()->json(["status"=>"sukses","data" =>$data]);
    }
}
