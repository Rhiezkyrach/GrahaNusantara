<?php

namespace App\Http\Controllers;

use App\Models\Setting;

use App\Models\Kategori;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AdminKategoriController extends Controller
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

        return view('admin.kategori.kategori',[
            'judul' => 'Management Kategori' . ' - ' . $setting->judul_situs,
            'kategori' => Kategori::showAllKategori(),
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

        return view('admin.kategori.tambah_kategori',[
            'judul' => 'Tambah Kategori' . ' - ' . $setting->judul_situs,
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
            'nama' => 'required',
            'status' => 'required',
            'navigasi' => 'required'
        ]);

        $validatedData['urutan'] = $request->urutan;

        Kategori::create($validatedData);

        return redirect('/admin/kategori')->with('success', 'Kategori Berhasil Ditambahkan');
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
    public function edit(Kategori $kategori)
    {
       $setting = Setting::first();

        return view('admin.kategori.edit_kategori',[
            'judul' => 'Edit Kategori' . ' - ' . $setting->judul_situs,
            'kategori' => $kategori,
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
    public function update(Request $request, Kategori $kategori)
    {
        
        $validatedData = $request->validate([
            'nama' => 'required',
            'status' => 'required',
            'navigasi' => 'required',
        ]);

        if($request->nama != $kategori->nama){
            $kategori['slug'] = 'required|max:255';
        }

        $validatedData['urutan'] = $request->urutan;

        Kategori::where('id', $kategori->id)
                ->update($validatedData);
                
        return redirect('/admin/kategori')->with('success', 'Kategori Berhasil Diupdate');
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
