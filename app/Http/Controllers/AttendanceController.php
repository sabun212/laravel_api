<?php

namespace App\Http\Controllers;

use App\Models\Attedance;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;


class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attendance = Attedance::where('user_id', auth()->user()->id)->get();
        $response = [
            'data' => $attendance
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
    //     $validatedData = $request->validate([
    //         'tanggal' => 'required|date',
    //         'kegiatan_harian' => 'required',
    //         'keterangan' => 'nullable',

    //     ]);

    //     $validatedData['user_id'] = auth()->user()->id;

    //   $data = Attedance::create($validatedData, [
    //     'user_id' => Auth::user()->id
    //   ]);

    //   if ($data) {
    //     return response()->json(["status"=>'Data Berhasil ditambah', "data"=>$data]);
    // } else {
        // return response()->json(["status"=>'Data Gagal ditambah', "data"=>$data]);
    // }
    $present = Attedance::whereUserId($request->user_id)->whereTanggal(date('Y-m-d'))->first();
    if ($present) {
        return redirect()->back()->with('error','Absensi hari ini telah terisi');
    }
    $validatedData = $request->validate([
        'keterangan'    => ['required'],
    ]);

    $validatedData['user_id'] = Auth::user()->id;

    $validatedData['tanggal'] = date('Y-m-d');
    if ($request->keterangan == 'Masuk' || $request->keterangan == 'Telat') {
        $validatedData['jam_masuk'] = $request->jam_masuk;
        if (strtotime($validatedData['jam_masuk']) >= strtotime('07:00:00') && strtotime($validatedData['jam_masuk']) <= strtotime('09:00:00')) {
            $validatedData['keterangan'] = 'Masuk';
        } else if (strtotime($validatedData['jam_masuk']) > strtotime('09:00:00') && strtotime($validatedData['jam_masuk']) <= strtotime('17:00:00')) {
            $validatedData['keterangan'] = 'Telat';
        } else {
            $validatedData['keterangan'] = 'Alpha';
        }
    }

    $hasil = Attedance::create($validatedData, [
        'user_id' => Auth::user()->id
      ]);

      if ($hasil) {
        return response()->json(["status"=>'Data Berhasil ditambah', "data"=>$hasil]);
    } else {
        return response()->json(["status"=>'Data Gagal ditambah', "data"=>$hasil]);
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
