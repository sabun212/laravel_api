<?php

namespace App\Http\Controllers;

use App\Models\activity;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;


class ActivitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activity = activity::where('user_id', auth()->user()->id)->get();
        $response = [
            'data' => $activity
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'tanggal' => 'required|date',
            'kegiatan_harian' => 'required',
            'keterangan' => 'nullable',

        ]);

        $validatedData['user_id'] = auth()->user()->id;

      $data = activity::create($validatedData, [
        'user_id' => Auth::user()->id
      ]);

      if ($data) {
        return response()->json(["status"=>'Data Berhasil ditambah', "data"=>$data]);
    } else {
        return response()->json(["status"=>'Data Gagal ditambah', "data"=>$data]);

    }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id /*activity $activity*/)
    {
        $activity = activity::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'kegiatan_harian' => 'required',
            'keterangan' => 'nullable',
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {

            $activity->update($request->all());
            $response = [
                'message' => 'Data Diubah',
                "data" => $activity
            ];

            return response()->json($response, Response::HTTP_OK);

        }
        catch(QueryException $e) {

            return response()->json([
                'message' => 'FAILED'. $e->errorInfo
            ]);
        }

        //     $rules =[
        //         'tanggal' => 'required|date',
        //             'kegiatan_harian' => 'required',
        //             'keterangan' => 'nullable',
        //     ];


        // $validatedData = $request->validate($rules);


        // $validatedData['user_id'] = auth()->user()->id;

        // $data = activity::where('id', $activity->id)
        //                 ->update($validatedData);

        //         if ($data) {
        //         return response()->json(["status"=>'Data Berhasil diubah', "data"=>$data]);
        //     } else {
        //         return response()->json(["status"=>'Data Gagal ditubah', "data"=>$data]);

        //     }
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $activity = activity::findOrFail($id);

        try {

            $activity->delete();
            $response = [
                'message' => 'Data Dihapus',
            ];

            return response()->json($response, Response::HTTP_OK);

        }
        catch(QueryException $e) {

            return response()->json([
                'message' => 'FAILED'. $e->errorInfo
            ]);


        }
    }
}
