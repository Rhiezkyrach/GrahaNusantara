<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\NetworkAccessTrait;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class AdminSettingController extends Controller
{
    use NetworkAccessTrait;

    public $setting;
    public $user_network;

    public function __construct()
    {
        $this->setting = Setting::where('id_network', auth()->user()->id_network)->first();
        $this->user_network = auth()->user()->id_network;
    }
    
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
        if (session()->has('success')) {
            Alert::toast(session('success'), 'success');
        }

        if (session()->has('error')) {
            Alert::toast(session('error'), 'error');
        }

        $setting = Setting::where('id', $pengaturan->id)->first();

        if(session('success')){
            Alert::success('Success!', session('success'));
        }

        if(session('error')){
            Alert::error('Error!', session('success'));
        }

        return view('admin.setting',[
            'judul' => 'Pengaturan Halaman' . ' - ' . $setting->judul_situs,
            'pengaturan' => $pengaturan,
            "setting" => $setting,
            'list_tayang' => $this->list_tayang(),
            'id_setting' => $pengaturan->id,
            'setting' => $this->setting,
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
            'keyword' => 'required',
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
        $validatedData['tiktok'] = $request->tiktok;
        $validatedData['youtube'] = $request->youtube;
        $validatedData['google_news'] = $request->google_news;
        $validatedData['google_map'] = $request->google_map;
        $validatedData['google_api_key'] = $request->google_api_key;
        $validatedData['whatsapp_api_key'] = $request->whatsapp_api_key;
        $validatedData['openai_api_key'] = $request->openai_api_key;

        // Upload Logo
        if($request->file('logo')){
            $ekstensiGambar = $request->file('logo')->extension();
            $date = \Carbon\Carbon::now()->translatedFormat('dmY-His');
            
            $namaGambarBaru = Str::slug($request->judul_situs) . '-' . $date . '.' .$ekstensiGambar;
            $lokasiGambar = $this->user_network . '/gambar/logo';

            if($request->logoLama){
                Storage::delete($request->logoLama);
            }
                
            $validatedData['logo'] = $request->file('logo')->storeAs($lokasiGambar, $namaGambarBaru);
        }

        // Upload Dark Logo
        if($request->file('darklogo')){
            $ekstensiGambar = $request->file('darklogo')->extension();
            $date = \Carbon\Carbon::now()->translatedFormat('dmY-His');
            
            $namaGambarBaru = Str::slug($request->judul_situs) . '-dark-' . $date . '.' .$ekstensiGambar;
            $lokasiGambar = $this->user_network . '/gambar/logo';

            if($request->darklogoLama){
                Storage::delete($request->darklogoLama);
            }
                
            $validatedData['darklogo'] = $request->file('darklogo')->storeAs($lokasiGambar, $namaGambarBaru);
        }

        // Upload Dark Favicon
        if($request->file('favicon')){
            $ekstensiGambar = $request->file('favicon')->extension();
            $date = \Carbon\Carbon::now()->translatedFormat('dmY-His');
            
            $namaGambarBaru = Str::slug($request->judul_situs) . '-favicon-' . $date . '.' .$ekstensiGambar;
            $lokasiGambar = $this->user_network . '/gambar/logo';

            if($request->faviconLama){
                Storage::delete($request->faviconLama);
            }
                
            $validatedData['favicon'] = $request->file('favicon')->storeAs($lokasiGambar, $namaGambarBaru);
        }

        Setting::where('id', $pengaturan->id)
               ->update($validatedData);

        return redirect('/admin/pengaturan/'. $pengaturan->id. '/edit')->with('success', 'Pengaturan Berhasil Disimpan');
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
