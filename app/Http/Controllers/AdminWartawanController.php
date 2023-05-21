<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Reporter;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class AdminWartawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = Setting::first();

        if(session('success')){
            Alert::success('Success!', session('success'));
        }

        return view('admin.wartawan.wartawan',[
            'judul' => 'Management Wartawan' . ' - ' . $setting->judul_situs,
            'wartawan' => Reporter::showAllWartawan(),
            "setting" => $setting
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $setting = Setting::first();

        return view('admin.wartawan.tambah_wartawan',[
            'judul' => 'Tambah Wartawan' . ' - ' . $setting->judul_situs,
            "setting" => $setting
        ]);
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
            'nama_wartawan' => 'required|max:255',
            'status' => 'required',
            'foto' => 'image'
        ]);

        // Upload Avatar
        if($request->file('foto')){
            $ekstensiGambar = $request->file('foto')->extension();

            $date = \Carbon\Carbon::now()->translatedFormat('dmY-His');
            
            $namaGambarBaru = Str::slug($request->nama_wartawan) . '-' . $date . '.' .$ekstensiGambar;
            $lokasiGambar = 'gambar/foto/wartawan';
                
            $validatedData['foto'] = $request->file('foto')->storeAs($lokasiGambar, $namaGambarBaru);
        }

        Reporter::create($validatedData);

        return redirect('/admin/wartawan')->with('success', 'Wartawan Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reporter  $reporter
     * @return \Illuminate\Http\Response
     */
    public function show(Reporter $reporter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reporter  $reporter
     * @return \Illuminate\Http\Response
     */
    public function edit(Reporter $wartawan)
    {
        $setting = Setting::first();

        return view('admin.wartawan.edit_wartawan',[
            'judul' => 'Edit Wartawan' . ' - ' . $setting->judul_situs,
            'wartawan' => $wartawan,
            "setting" => $setting
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reporter  $reporter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reporter $wartawan)
    {
        $validatedData = $request->validate([
            'nama_wartawan' => 'required|max:255',
            'status' => 'required',
            'foto' => 'image'
        ]);

        // Upload Avatar
        if($request->file('foto')){
            $ekstensiGambar = $request->file('foto')->extension();

            $date = \Carbon\Carbon::now()->translatedFormat('dmY-His');
            
            $namaGambarBaru = Str::slug($request->nama_wartawan) . '-' . $date . '.' .$ekstensiGambar;
            $lokasiGambar = 'gambar/foto/wartawan';

            if($request->fotoLama){
                    Storage::delete($request->fotoLama);
                }
                
            $validatedData['foto'] = $request->file('foto')->storeAs($lokasiGambar, $namaGambarBaru);
        }

        Reporter::where('id_wartawan', $wartawan->id_wartawan)
                ->update($validatedData);

        return redirect('/admin/wartawan')->with('success', 'Wartawan Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reporter  $reporter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reporter $reporter)
    {
        //
    }
}
