<?php

namespace App\Http\Controllers;

use App\Models\Iklan;
use App\Models\Setting;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class AdminIklanController extends Controller
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

        return view('admin.iklan.iklan',[
            'judul' => 'Management Iklan' . ' - ' . $setting->judul_situs,
            'iklan' => Iklan::orderBy('awal_tayang', 'DESC')->get(),
            "setting" => $setting,
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
        $jenisIklan = 'Banner, Google Ads, Corong Rakyat';
        $posisiIklan = 'Header, Headline, Home A, Home B, Home C, 
                        Sidebar A, Sidebar B, Sidebar C, News A, News B, News C, Footer';

        return view('admin.iklan.tambah_iklan',[
            'judul' => 'Tambah Iklan' . ' - ' . $setting->judul_situs,
            "setting" => $setting,
            'jenisIklan' => explode(',', $jenisIklan),
            'posisiIklan' => explode(',', $posisiIklan),
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
            'nama' => 'required',
            'jenis' => 'required',
            'posisi' => 'required',
            'status' => 'required',
            'urutan' => 'required',
            'AE' => 'max:60',
            'foto' => 'image',
            'awal_tayang' => 'required',
            'akhir_tayang' => 'required',
        ]);

        $validatedData['kode'] = $request->kode;
        $validatedData['link'] = $request->link;

        // Upload Avatar
        if($request->file('foto')){
            $ekstensiGambar = $request->file('foto')->extension();

            $date = \Carbon\Carbon::now()->translatedFormat('dmY-His');
            
            $namaGambarBaru = Str::slug($request->nama) . '-' . $date . '.' .$ekstensiGambar;
            $lokasiGambar = 'gambar/iklan';
                
            $validatedData['foto'] = $request->file('foto')->storeAs($lokasiGambar, $namaGambarBaru);
        }

        Iklan::create($validatedData);

        return redirect('/admin/iklan')->with('success', 'Iklan Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Iklan  $iklan
     * @return \Illuminate\Http\Response
     */
    public function show(Iklan $iklan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Iklan  $iklan
     * @return \Illuminate\Http\Response
     */
    public function edit(Iklan $iklan)
    {
        $setting = Setting::first();
        $jenisIklan = 'Banner, Google Ads, Corong Rakyat';
        $posisiIklan = 'Header, Headline, Home A, Home B, Home C, 
                        Sidebar A, Sidebar B, Sidebar C, News A, News B, News C, Footer';

       return view('admin.iklan.edit_iklan',[
            'judul' => 'Edit Iklan' . ' - ' . $setting->judul_situs,
            'iklan' => $iklan,
            "setting" => $setting,
            'jenisIklan' => explode(',', $jenisIklan),
            'posisiIklan' => explode(',', $posisiIklan),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Iklan  $iklan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Iklan $iklan)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'jenis' => 'required',
            'posisi' => 'required',
            'status' => 'required',
            'urutan' => 'required',
            'AE' => 'max:60',
            'foto' => 'image',
            'awal_tayang' => 'required',
            'akhir_tayang' => 'required',
        ]);

        $validatedData['kode'] = $request->kode;
        $validatedData['link'] = $request->link;

        // Upload Avatar
        if($request->file('foto')){
            $ekstensiGambar = $request->file('foto')->extension();

            $date = \Carbon\Carbon::now()->translatedFormat('dmY-His');
            
            $namaGambarBaru = Str::slug($request->nama) . '-' . $date . '.' .$ekstensiGambar;
            $lokasiGambar = 'gambar/iklan';

            //Hapus Gambar Lama
            if($request->fotoLama){
                Storage::delete($request->fotoLama);
            }
            
            //Simpan Gambar
            $validatedData['foto'] = $request->file('foto')->storeAs($lokasiGambar, $namaGambarBaru);
        }

        Iklan::where('id', $iklan->id)
               ->update($validatedData);

        return redirect('/admin/iklan')->with('success', 'Iklan Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Iklan  $iklan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Iklan $iklan)
    {
        // Hapus Gambar
        if($iklan->foto){
            Storage::delete($iklan->foto);
        }

        Iklan::destroy($iklan->id);

        return redirect('/admin/iklan')->with('success', 'Iklan Berhasil Dihapus');
    }
}
