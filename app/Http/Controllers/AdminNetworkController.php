<?php

namespace App\Http\Controllers;

use App\Models\Network;
use App\Models\Setting;

use Illuminate\Support\Str;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class AdminNetworkController extends Controller
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
        
        return view('admin.network.network',[
            "judul" => 'Management Network' . ' - ' . $setting->judul_situs,
            "network" => Network::showAllNetwork()->get(),
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
 
        return view('admin.network.tambah_network',[
           "judul" => 'Tambah Network' . ' - ' . $setting->judul_situs,
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
            'nama' => 'required|max:255',
            'url' => 'required|max:255',
            'logo' => 'image|file|max:1024',
            'urutan' => 'required|max:20',
        ]);

        // Upload Gambar
        $ekstensiGambar = $request->file('logo')->extension();

        $getWaktu = \Carbon\Carbon::now()->translatedFormat('dmY-His');

        $namaGambarBaru = 'logo-'. Str::slug($request->nama) . '-'. $getWaktu. '.' .$ekstensiGambar;
        $lokasiGambar = 'network';

        if($request->file('logo')){
            //Simpan Gambar logo
            $validatedData['logo'] = $request->file('logo')->storeAs($lokasiGambar, $namaGambarBaru);
        }


        Network::create($validatedData);

        return redirect('/admin/network')->with('success', 'Network Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Network  $network
     * @return \Illuminate\Http\Response
     */
    public function show(Network $network)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Network  $network
     * @return \Illuminate\Http\Response
     */
    public function edit(Network $network)
    {
        $setting = Setting::first();

        return view('admin.network.edit_network',[
            "judul" => 'Edit Network' . ' - ' . $setting->judul_situs,
            "network" => $network,
            "setting" => $setting
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Network  $network
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Network $network)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'url' => 'required|max:255',
            'logo' => 'image|file|max:1024',
            'urutan' => 'required|max:20',
        ]);

        if($request->nama != $network->nama){
            $network['slug'] = 'required|max:255';
        }

        // Upload Gambar
        if($request->file('logo')){

            if($request->logoLama){
                Storage::delete($request->logoLama);
            }

            $ekstensiGambar = $request->file('logo')->extension();

            $getWaktu = \Carbon\Carbon::now()->translatedFormat('dmY-His');

            $namaGambarBaru = 'logo-'. Str::slug($request->nama) . '-'. $getWaktu. '.' .$ekstensiGambar;
            $lokasiGambar = 'network';

                //Simpan Gambar logo
                $validatedData['logo'] = $request->file('logo')->storeAs($lokasiGambar, $namaGambarBaru);
        }

        Network::where('id', $network->id)
                ->update($validatedData);
                
        return redirect('/admin/network')->with('success', 'Network Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Network  $network
     * @return \Illuminate\Http\Response
     */
    public function destroy(Network $network)
    {
        // Hapus Logo
        if($network->logo){
            Storage::delete($network->logo);
        }

        Network::destroy($network->id);

        return redirect('/admin/network')->with('success', 'Network Berhasil Dihapus');
    }
}
