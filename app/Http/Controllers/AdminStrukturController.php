<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;

use App\Models\Network;
use App\Models\Setting;
use App\Models\Struktur;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\NetworkAccessTrait;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class AdminStrukturController extends Controller
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

        $data = Struktur::orderBy('id_network', 'DESC');

        if ($request->ajax()) {
            return datatables()->of($data)
                ->editColumn('id_network', function (Struktur $struktur) {
                    return $struktur->Network ? $struktur->Network->nama : $struktur->id_network;
                })
                ->editColumn('nama', function (Struktur $struktur) {
                    return $struktur->User ? $struktur->User->name : $struktur->id_user;
                })
                ->editColumn('status', function (Struktur $struktur) {
                    return $struktur->status == '0'
                        ? "<td><span class='px-3 py-1 text-xs rounded-full bg-rose-200'>TIDAK AKTIF</span></td>"
                        : ($struktur->akhir_tayang < Carbon::today()
                            ? "<td><span class='px-3 py-1 text-xs bg-green-200 rounded-full'>AKTIF</span></td>"
                            : "<td><span class='px-3 py-1 text-xs bg-sky-200 rounded-full'>SELESAI</span></td>");
                })
                ->addColumn('action', function (Struktur $struktur) {
                    return view('admin.struktur.struktur-action', ['data' => $struktur])->render();
                })
                ->rawColumns(['status', 'action'])
                ->toJson();
        };

        return view('admin.struktur.struktur',[
            'judul' => 'Management Struktur' . ' - ' . $this->setting->judul_situs,
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
            return view('admin.struktur.tambah_struktur',[
                'judul' => 'Tambah Struktur' . ' - ' . $this->setting->judul_situs,
                'user' => User::showAllActiveUser(),
                'network' => Network::showAllActiveNetwork(),
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
            'id_network' => 'required',
            'id_user' => 'required',
            'jabatan' => 'required',
            'ttd' => 'image',
        ]);

        // Upload TTD
        if($request->file('ttd')){
            $ekstensiGambar = $request->file('ttd')->extension();

            $date = \Carbon\Carbon::now()->translatedFormat('dmY-His');
            
            $namaGambarBaru = Str::slug($request->nama) . '-' . $date . '.' .$ekstensiGambar;
            $lokasiGambar = $this->user_network . '/gambar/ttd';
                
            $validatedData['ttd'] = $request->file('ttd')->storeAs($lokasiGambar, $namaGambarBaru);
        }

        Struktur::create($validatedData);

        return redirect('/admin/struktur')->with('success', 'Struktur Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Struktur  $struktur
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Struktur $struktur)
    {
        if ($request->ajax()) {
            return view('admin.struktur.show_struktur', [
                'judul' => 'Detail Struktur' . ' - ' . $this->setting->judul_situs,
                'struktur' => $struktur,
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Struktur  $struktur
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Struktur $struktur)
    {
        if ($request->ajax()) {
            return view('admin.struktur.edit_struktur',[
                'judul' => 'Edit Struktur' . ' - ' . $this->setting->judul_situs,
                'struktur' => $struktur,
                'user' => User::showAllActiveUser(),
                'network' => Network::showAllActiveNetwork(),
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Struktur  $struktur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Struktur $struktur)
    {
        $validatedData = $request->validate([
            'id_network' => 'required',
            'id_user' => 'required',
            'jabatan' => 'required',
            'ttd' => 'image',
        ]);

        // Upload TTD
        if($request->file('ttd')){
            $ekstensiGambar = $request->file('ttd')->extension();

            $date = \Carbon\Carbon::now()->translatedFormat('dmY-His');
            
            $namaGambarBaru = Str::slug($request->nama) . '-' . $date . '.' .$ekstensiGambar;
            $lokasiGambar = $this->user_network . '/gambar/ttd';

            //Hapus Gambar Lama
            if($request->ttdLama){
                Storage::delete($request->ttdLama);
            }
            
            //Simpan Gambar
            $validatedData['ttd'] = $request->file('ttd')->storeAs($lokasiGambar, $namaGambarBaru);
        }

        Struktur::where('id', $struktur->id)
               ->update($validatedData);

        return redirect('/admin/struktur')->with('success', 'Struktur Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Struktur  $struktur
     * @return \Illuminate\Http\Response
     */
    public function destroy(Struktur $struktur)
    {
        // Hapus Gambar
        if($struktur->ttd){
            Storage::delete($struktur->ttd);
        }

        Struktur::destroy($struktur->id);

        return redirect('/admin/struktur')->with('success', 'Struktur Berhasil Dihapus');
    }

    //check unique
    public function checkUnique(Request $request)
    {
        $data = Struktur::where('id_network', $request->unique)->get();

        if ($data->count() > 0) {
            return response()->json([
                'data' => $data
            ]);
        }
    }
}
