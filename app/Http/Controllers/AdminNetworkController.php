<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;

use App\Models\Network;

use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\NetworkAccessTrait;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class AdminNetworkController extends Controller
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

        $data = Network::showAllNetwork();

        if ($request->ajax()) {
            return datatables()->of($data)
                ->editColumn('status', function (Network $network) {
                    return $network->status == '0'
                    ? "<td><span class='px-3 py-1 text-xs rounded-full bg-rose-200'>TIDAK AKTIF</span></td>"
                    : "<td><span class='px-3 py-1 text-xs bg-green-200 rounded-full'>AKTIF</span></td>";
                })
                ->addColumn('action', function (Network $network) {
                    return view('admin.network.network-action', ['data' => $network])->render();
                })
                ->rawColumns(['action', 'status'])
                ->toJson();
        };

        return view('admin.network.network',[
            "judul" => 'Management Network' . ' - ' . $this->setting->judul_situs,
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
        if($request->ajax()){
            return view('admin.network.tambah_network',[
               "judul" => 'Tambah Network' . ' - ' . $this->setting->judul_situs,
            ])->render();
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
            'nama' => 'required|max:255',
            'url' => 'required|max:255',
            'logo' => 'image|file|max:1024',
            'urutan' => 'required|max:20',
            'status' => 'nullable',
        ]);

        $last = Network::withTrashed()->orderBy('id_network', 'DESC')->first();

        if ($last) {
            $numberFormat = str_pad((int)$last->id_network + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $numberFormat = str_pad(1, 3, '0', STR_PAD_LEFT);
        }

        $validatedData['id_network'] = $numberFormat;

        // Upload Gambar
        if ($request->file('logo')) {
            $ekstensiGambar = $request->file('logo')->extension();

            $getWaktu = \Carbon\Carbon::now()->translatedFormat('dmY-His');

            $namaGambarBaru = 'logo-'. Str::slug($request->nama) . '-'. $getWaktu. '.' .$ekstensiGambar;
            $lokasiGambar = $this->user_network . '/network';

            if($request->file('logo')){
                //Simpan Gambar logo
                $validatedData['logo'] = $request->file('logo')->storeAs($lokasiGambar, $namaGambarBaru);
            }
        }

        $success = Network::create($validatedData);

        // Upload Logo
        // if ($request->file('logo')) {
        //     $namaGambarBaruSetting = Str::slug($request->judul_situs) . '-' . Carbon::now()->translatedFormat('dmY-His') . '.' . $request->file('logo')->extension();
        //     $lokasiGambarSetting = 'gambar/logo';
        // }

        // CREATE DEFAULT SETTING
        Setting::create([
            'id_network' => $success->id_network,
            'judul_situs' => $success->nama,
            'tagline' => $request->tagline,
            'deskripsi' => $success->nama,
            // 'logo' => $request->file('logo')->storeAs($lokasiGambarSetting, $namaGambarBaruSetting),
            'copyright' => 'Copyright &copy; '  . Carbon::now()->translatedFormat('Y') . ' - <b>' . $success->nama . '</b> Member of Raja Media Network',
        ]);

        return redirect('/admin/network')->with('success', 'Network Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Network  $network
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Network $network)
    {
        if ($request->ajax()) {
            return view('admin.network.show_network', [
                "judul" => 'Detail Network' . ' - ' . $this->setting->judul_situs,
                "network" => $network,
            ])->render();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Network  $network
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Network $network)
    {
        if ($request->ajax()) {
            return view('admin.network.edit_network',[
                "judul" => 'Edit Network' . ' - ' . $this->setting->judul_situs,
                "network" => $network,
            ])->render();
        }
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
            'status' => 'nullable',
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
            $lokasiGambar = $this->user_network . '/network';

                //Simpan Gambar logo
                $validatedData['logo'] = $request->file('logo')->storeAs($lokasiGambar, $namaGambarBaru);
        }

        Network::where('id', $network->id)->update($validatedData);
        Setting::where('id_network', $network->id_network)->update(['tagline' => $request->tagline]);
                
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
        Setting::where('id_network', $network->id_network)->delete();

        return redirect('/admin/network')->with('success', 'Network Berhasil Dihapus');
    }

    //check unique
    public function checkUnique(Request $request)
    {
        $data = Network::where('nama', $request->unique)->get();

        if ($data->count() > 0) {
            return response()->json([
                'data' => $data
            ]);
        }
    }

    //set client
    public function setnetwork(Request $request)
    {
        $data = User::find(auth()->user()->id);
        $data->update(['id_network' => $request->network]);

        return response()->json(['data' => $data]);
    }
}
