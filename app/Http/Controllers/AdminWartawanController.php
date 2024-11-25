<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Reporter;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\NetworkAccessTrait;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class AdminWartawanController extends Controller
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

        $data = Reporter::showWartawan($this->user_network);

        if ($request->ajax()) {
            return datatables()->of($data)
                ->editColumn('id_network', function (Reporter $wartawan) {
                    return $wartawan->Network ? $wartawan->Network->nama : $wartawan->id_network;
                })
                ->editColumn('status', function (Reporter $wartawan) {
                    return $wartawan->status == '0'
                    ? "<td><span class='px-3 py-1 text-xs rounded-full bg-rose-200'>TIDAK AKTIF</span></td>"
                    : "<td><span class='px-3 py-1 text-xs bg-green-200 rounded-full'>AKTIF</span></td>";
                })
                ->addColumn('action', function (Reporter $wartawan) {
                    return view('admin.wartawan.wartawan-action', ['data' => $wartawan])->render();
                })
                ->rawColumns(['action', 'status'])
                ->toJson();
        };

        return view('admin.wartawan.wartawan',[
            'judul' => 'Management Wartawan' . ' - ' . $this->setting->judul_situs,
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
            return view('admin.wartawan.tambah_wartawan',[
                'judul' => 'Tambah Wartawan' . ' - ' . $this->setting->judul_situs,
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'nama_wartawan' => 'required|max:255',
    //         'status' => 'required',
    //         'foto' => 'image'
    //     ]);

    //     // Upload Avatar
    //     if($request->file('foto')){
    //         $ekstensiGambar = $request->file('foto')->extension();

    //         $date = \Carbon\Carbon::now()->translatedFormat('dmY-His');
            
    //         $namaGambarBaru = Str::slug($request->nama_wartawan) . '-' . $date . '.' .$ekstensiGambar;
    //         $lokasiGambar = 'gambar/foto/wartawan';
                
    //         $validatedData['foto'] = $request->file('foto')->storeAs($lokasiGambar, $namaGambarBaru);
    //     }

    //     Reporter::create($validatedData);

    //     return redirect('/admin/wartawan')->with('success', 'Wartawan Berhasil Ditambahkan');
    // }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reporter  $reporter
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Reporter $wartawan)
    {
        if ($request->ajax()) {
            return view('admin.wartawan.show_wartawan', [
                'judul' => 'Edit Wartawan' . ' - ' . $this->setting->judul_situs,
                'wartawan' => $wartawan,
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reporter  $reporter
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Reporter $wartawan)
    {
        if ($request->ajax()) {
            return view('admin.wartawan.edit_wartawan',[
                'judul' => 'Edit Wartawan' . ' - ' . $this->setting->judul_situs,
                'wartawan' => $wartawan,
            ]);
        }
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
            $lokasiGambar = $this->user_network . '/gambar/foto/wartawan';

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
