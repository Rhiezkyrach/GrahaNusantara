<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Network;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\NetworkAccess;
use App\Traits\NetworkAccessTrait;
use RealRashid\SweetAlert\Facades\Alert;

class AdminNetworkAccessController extends Controller
{
    use NetworkAccessTrait;
    
    public $setting;
    public $user_network;

    public function __construct()
    {
        $this->setting = Setting::where('id_network', auth()->user()->id_network)->first();
        $this->user_network = auth()->user()->id_network;
    }
    
    public function index(Request $request)
    {
        if (session()->has('success')) {
            Alert::toast(session('success'), 'success');
        }

        if (session()->has('error')) {
            Alert::toast(session('error'), 'error');
        }

        $data = NetworkAccess::where('id_network', $request->id_network);

        if ($request->ajax()) {
            return datatables()->of($data)
                ->addColumn('username', function (NetworkAccess $network_access) {
                    return $network_access->User ? $network_access->User->username : '';
                })
                ->addColumn('name', function (NetworkAccess $network_access) {
                    return $network_access->User ? $network_access->User->name : '';
                })
                ->addColumn('level', function (NetworkAccess $network_access) {
                    return $network_access->User ? $network_access->User->level : '';
                })
                ->addColumn('action', function (NetworkAccess $network_access) {
                    return view('admin.network_access.network_access-action', ['data' => $network_access])->render();
                })
                ->rawColumns(['action'])
                ->toJson();
        };
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->ajax()) {
            return view('admin.network_access.tambah_network_access', [
                "judul" => 'Tambah Akses Network' . ' - ' . $this->setting->judul_situs,
                "user" => User::showAllActiveUser(),
                'id_network' => $request->id_network
            ])->render();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_user' => 'required',
            'id_network' => 'required',
        ]);

        NetworkAccess::create($validatedData);

        return redirect()->back()->with('success', 'Akses User ke Network Ini Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Network $network_access)
    {
        if (session()->has('success')) {
            Alert::toast(session('success'), 'success');
        }

        if (session()->has('error')) {
            Alert::toast(session('error'), 'error');
        }

        return view('admin.network_access.network_access', [
            "judul" => 'Akses Network' . ' - ' . $this->setting->judul_situs,
            'list_tayang' => $this->list_tayang(),
            'id_setting' => $this->setting->id,
            'network' => $network_access,
            'setting' => $this->setting,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, NetworkAccess $network_access)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NetworkAccess $network_access)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NetworkAccess $network_access)
    {
        NetworkAccess::destroy($network_access->id);
        return redirect()->back()->with('success', 'Akses User ke Network Ini Berhasil Dihapus');
    }

    //check unique
    public function checkUnique(Request $request)
    {
        $data = NetworkAccess::where('id_user', $request->id_user)->where('id_network', $request->id_network)->get();

        if ($data->count() > 0) {
            return response()->json([
                'data' => $data
            ]);
        }
    }
}
