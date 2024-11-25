<?php

namespace App\Http\Controllers;

use App\Models\Fokus;

use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\NetworkAccessTrait;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class AdminFokusController extends Controller
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

        $data = Fokus::showFokus($this->user_network);

        if ($request->ajax()) {
            return datatables()->of($data)
                ->editColumn('id_network', function (Fokus $foku) {
                    return $foku->Network ? $foku->Network->nama : $foku->id_network;
                })
                ->editColumn('foto', function (Fokus $foku) {
                    return "<img src='". asset('storage/'. $foku->foto) ."'class='h-10 object-cover'>";
                })
                ->editColumn('bg_color', function (Fokus $foku) {
                    return "<div style='background-color:". $foku->bg_color ."'class='w-10 h-10 rounded'>";
                })
                ->editColumn('status', function (Fokus $foku) {
                    return $foku->status == '0'
                        ? "<td><span class='px-3 py-1 text-xs rounded-full bg-rose-200'>TIDAK AKTIF</span></td>"
                        : "<td><span class='px-3 py-1 text-xs bg-green-200 rounded-full'>AKTIF</span></td>";
                })
                ->addColumn('action', function (Fokus $foku) {
                    return view('admin.fokus.fokus-action', ['data' => $foku])->render();
                })
                ->rawColumns(['foto', 'bg_color', 'action', 'status'])
                ->toJson();
        };

        return view('admin.fokus.fokus',[
            'judul' => 'Management Fokus' . ' - ' . $this->setting->judul_situs,
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
    public function create()
    {
        return view('admin.fokus.tambah_fokus',[
            'judul' => 'Tambah Fokus' . ' - ' . $this->setting->judul_situs,
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
            'bg_color' => 'required',
            'foto' => 'image',
        ]);

        $validatedData['id_network'] = $this->user_network;
        $validatedData['urutan'] = $request->urutan;

        // Upload Foto
        if ($request->file('foto')) {
            $ekstensiGambar = $request->file('foto')->extension();

            $date = \Carbon\Carbon::now()->translatedFormat('dmY-His');

            $namaGambarBaru = Str::slug($request->nama) . '-' . $date . '.' . $ekstensiGambar;
            $lokasiGambar = $this->user_network . '/gambar/fokus';

            $validatedData['foto'] = $request->file('foto')->storeAs($lokasiGambar, $namaGambarBaru);
        }

        Fokus::create($validatedData);

        return redirect('/admin/fokus')->with('success', 'Fokus Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Fokus $foku)
    {
        if ($request->ajax()) {
            return view('admin.fokus.show_fokus', [
                'judul' => 'Detail Fokus' . ' - ' . $this->setting->judul_situs,
                'fokus' => $foku,
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Fokus $foku)
    {   
        if($request->ajax()){
            return view('admin.fokus.edit_fokus',[
                'judul' => 'Edit Fokus' . ' - ' . $this->setting->judul_situs,
                'fokus' => $foku,
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fokus $foku)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'status' => 'required',
            'bg_color' => 'required',
            'foto' => 'image',
        ]);

        if($request->nama != $foku->nama){
            $foku['slug'] = 'required|max:255';
        }

        $validatedData['urutan'] = $request->urutan;

        // Upload Foto
        if ($request->file('foto')) {
            $ekstensiGambar = $request->file('foto')->extension();

            $date = \Carbon\Carbon::now()->translatedFormat('dmY-His');

            $namaGambarBaru = Str::slug($request->nama) . '-' . $date . '.' . $ekstensiGambar;
            $lokasiGambar = $this->user_network . '/gambar/fokus';

            //Hapus Gambar Lama
            if ($request->fotoLama) {
                Storage::delete($request->fotoLama);
            }

            //Simpan Gambar
            $validatedData['foto'] = $request->file('foto')->storeAs($lokasiGambar, $namaGambarBaru);
        }

        Fokus::where('id', $foku->id)
                ->update($validatedData);
                
        return redirect('/admin/fokus')->with('success', 'Fokus Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fokus $foku)
    {
        Fokus::destroy($foku->id);

        return redirect('/admin/fokus')->with('success', 'Fokus Berhasil Dihapus');
    }
}
