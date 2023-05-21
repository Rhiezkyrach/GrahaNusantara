<?php

namespace App\Http\Controllers;

use App\Models\Statis;
use App\Models\Setting;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AdminStatisController extends Controller
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

        return view('admin.statis.statis',[
            'judul' => 'Management Halaman' . ' - ' . $setting->judul_situs,
            'halaman' => Statis::getStatis(),
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

        return view('admin.statis.tambah_statis',[
            'judul' => 'Tambah Halaman' . ' - ' . $setting->judul_situs,
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
            'judul' => 'required',
            'urutan' => 'required',
            'isi' => 'required'
        ]);

        Statis::create($validatedData);

        return redirect('/admin/halaman')->with('success', 'Halaman Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Statis  $statis
     * @return \Illuminate\Http\Response
     */
    public function show(Statis $statis)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Statis  $statis
     * @return \Illuminate\Http\Response
     */
    public function edit(Statis $halaman)
    {
        $setting = Setting::first();

        return view('admin.statis.edit_statis',[
            'judul' => 'Edit Halaman' . ' - ' . $setting->judul_situs,
            'halaman' => $halaman,
            "setting" => $setting
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Statis  $statis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Statis $halaman)
    {
        $validatedData = $request->validate([
            'judul' => 'required',
            'urutan' => 'required',
            'isi' => 'required'
        ]);

        Statis::where('id_statis', $halaman->id_statis)
                ->update($validatedData);

        return redirect('/admin/halaman')->with('success', 'Halaman Berhasil Diupdate');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Statis  $statis
     * @return \Illuminate\Http\Response
     */
    public function destroy(Statis $halaman)
    {
        Statis::destroy($halaman->id_statis);

        return redirect('/admin/halaman')->with('success', 'Halaman Berhasil Dihapus');
    }
}
