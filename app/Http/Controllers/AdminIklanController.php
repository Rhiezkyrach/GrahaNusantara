<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Iklan;

use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\NetworkAccessTrait;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class AdminIklanController extends Controller
{
    use NetworkAccessTrait;

    public $setting;
    public $user_network;

    public function __construct()
    {
        $this->setting = Setting::where('id_network', auth()->user()->id_network)->first();
        $this->user_network = auth()->user()->id_network;
    }

    // index
    public function index(Request $request)
    {

        if (session()->has('success')) {
            Alert::toast(session('success'), 'success');
        }

        if (session()->has('error')) {
            Alert::toast(session('error'), 'error');
        }

        $data = Iklan::getIklan($this->user_network);

        if ($request->ajax()) {
            return datatables()->of($data)
                ->editColumn('id_network', function (Iklan $iklan) {
                    return $iklan->Network ? $iklan->Network->nama : $iklan->id_network;
                })
                ->editColumn('awal_tayang', function (Iklan $iklan) {
                    return Carbon::parse($iklan->awal_tayang)->translatedFormat('d F Y');
                })
                ->editColumn('akhir_tayang', function (Iklan $iklan) {
                    return Carbon::parse($iklan->akhir_tayang)->translatedFormat('d F Y');
                })
                ->editColumn('status', function (Iklan $iklan) {
                    return $iklan->status == '0'
                        ? "<td><span class='px-3 py-1 text-xs rounded-full bg-rose-200'>TIDAK AKTIF</span></td>"
                        : ($iklan->akhir_tayang < Carbon::today()
                            ? "<td><span class='px-3 py-1 text-xs bg-green-200 rounded-full'>AKTIF</span></td>"
                            : "<td><span class='px-3 py-1 text-xs bg-sky-200 rounded-full'>SELESAI</span></td>");
                })
                ->addColumn('action', function (Iklan $iklan) {
                    return view('admin.iklan.iklan-action', ['data' => $iklan])->render();
                })
                ->rawColumns(['status', 'action'])
                ->toJson();
        };

        return view('admin.iklan.iklan',[
            'judul' => 'Management Iklan' . ' - ' . $this->setting->judul_situs,
            'list_tayang' => $this->list_tayang(),
            'id_setting' => $this->setting->id,
            'setting' => $this->setting,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->ajax()) {

            $jenisIklan = 'Banner, Google Ads, Corong Rakyat';
            $posisiIklan = 'Header, Headline, Home A, Home B, Home C, 
                            Sidebar A, Sidebar B, Sidebar C, News A, News B, News C, Footer';

            return view('admin.iklan.tambah_iklan',[
                'judul' => 'Tambah Iklan' . ' - ' . $this->setting->judul_situs,
                'jenisIklan' => explode(',', $jenisIklan),
                'posisiIklan' => explode(',', $posisiIklan),
            ]);
        }
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

        $validatedData['id_network'] = $this->user_network;
        $validatedData['kode'] = $request->kode;
        $validatedData['link'] = $request->link;

        // Upload Foto
        if($request->file('foto')){
            $ekstensiGambar = $request->file('foto')->extension();

            $date = \Carbon\Carbon::now()->translatedFormat('dmY-His');
            
            $namaGambarBaru = Str::slug($request->nama) . '-' . $date . '.' .$ekstensiGambar;
            $lokasiGambar = $this->user_network . '/gambar/iklan';
                
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
    public function show(Request $request, Iklan $iklan)
    {
        if ($request->ajax()) {
            return view('admin.iklan.show_iklan', [
                'judul' => 'Detail Iklan' . ' - ' . $this->setting->judul_situs,
                'iklan' => $iklan,
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Iklan  $iklan
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Iklan $iklan)
    {
        if ($request->ajax()) {
            $jenisIklan = 'Banner, Google Ads, Corong Rakyat';
            $posisiIklan = 'Header, Headline, Home A, Home B, Home C, 
                            Sidebar A, Sidebar B, Sidebar C, News A, News B, News C, Footer';

            return view('admin.iklan.edit_iklan',[
                'judul' => 'Edit Iklan' . ' - ' . $this->setting->judul_situs,
                'iklan' => $iklan,
                'jenisIklan' => explode(',', $jenisIklan),
                'posisiIklan' => explode(',', $posisiIklan),
            ]);
        }
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

        // Upload Foto
        if($request->file('foto')){
            $ekstensiGambar = $request->file('foto')->extension();

            $date = \Carbon\Carbon::now()->translatedFormat('dmY-His');
            
            $namaGambarBaru = Str::slug($request->nama) . '-' . $date . '.' .$ekstensiGambar;
            $lokasiGambar = $this->user_network . '/gambar/iklan';

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
