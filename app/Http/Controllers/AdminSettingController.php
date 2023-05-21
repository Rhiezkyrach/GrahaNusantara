<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class AdminSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $pengaturan)
    {
        $setting = Setting::getSetting();

        if(session('success')){
            Alert::success('Success!', session('success'));
        }

        return view('admin.setting',[
            'judul' => 'Pengaturan Halaman' . ' - ' . $setting->judul_situs,
            'pengaturan' => $pengaturan,
            "setting" => $setting
            
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $pengaturan)
    {
        $validatedData = $request->validate([
            'judul_situs' => 'required|max:255',
            'tagline' => 'required|max:255',
            'deskripsi' => 'required|max:255',
            'alamat' => 'required',
            'telepon' => 'required',
            'email' => 'required',
            'copyright' => 'required',

        ]);

        $validatedData['headcode'] = $request->headcode;
        $validatedData['footercode'] = $request->footercode;
        $validatedData['facebook'] = $request->facebook;
        $validatedData['instagram'] = $request->instagram;
        $validatedData['twitter'] = $request->twitter;
        $validatedData['youtube'] = $request->youtube;

        // Upload Logo
        if($request->file('logo')){
            $request->validate([
               'logo' => 'image',
            ]);

            $ekstensiGambar = $request->file('logo')->extension();

            $date = \Carbon\Carbon::now()->translatedFormat('dmY-His');
            
            $namaGambarBaru = Str::slug($request->judul_situs) . '-' . $date . '.' .$ekstensiGambar;
            $lokasiGambar = 'gambar/logo';

            if($request->logoLama){
                    Storage::delete($request->logoLama);
                }
                
            $validatedData['logo'] = $request->file('logo')->storeAs($lokasiGambar, $namaGambarBaru);
        }

        // Upload Dark Logo
        if($request->file('darklogo')){
            $request->validate([
               'darklogo' => 'image',
            ]);

            $ekstensiGambar = $request->file('darklogo')->extension();

            $date = \Carbon\Carbon::now()->translatedFormat('dmY-His');
            
            $namaGambarBaru = Str::slug($request->judul_situs) . '-dark-' . $date . '.' .$ekstensiGambar;
            $lokasiGambar = 'gambar/logo';

            if($request->darklogoLama){
                    Storage::delete($request->darklogoLama);
                }
                
            $validatedData['darklogo'] = $request->file('darklogo')->storeAs($lokasiGambar, $namaGambarBaru);
        }

        Setting::where('id', $pengaturan->id)
               ->update($validatedData);

        return redirect('/admin/pengaturan/1/edit')->with('success', 'Pengaturan Berhasil Disimpan');
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
