<?php

namespace App\Http\Controllers;

use App\Models\Statis;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Traits\NetworkAccessTrait;
use RealRashid\SweetAlert\Facades\Alert;

class AdminStatisController extends Controller
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

        $data = Statis::showStatis($this->user_network);

        if ($request->ajax()) {
            return datatables()->of($data)
                ->editColumn('id_network', function (Statis $halaman) {
                    return $halaman->Network ? $halaman->Network->nama : $halaman->id_network;
                })
                ->editColumn('status', function (Statis $halaman) {
                    return $halaman->status == '0'
                    ? "<td><span class='px-3 py-1 text-xs rounded-full bg-rose-200'>TIDAK AKTIF</span></td>"
                    : "<td><span class='px-3 py-1 text-xs bg-green-200 rounded-full'>AKTIF</span></td>";
                })
                ->addColumn('action', function (Statis $halaman) {
                    return view('admin.statis.statis-action', ['data' => $halaman])->render();
                })
                ->rawColumns(['action', 'status'])
                ->toJson();
        };

        return view('admin.statis.statis',[
            'judul' => 'Management Halaman' . ' - ' . $this->setting->judul_situs,
            'halaman' => Statis::getStatis($this->user_network),
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

        return view('admin.statis.tambah_statis',[
            'judul' => 'Tambah Halaman' . ' - ' . $this->setting->judul_situs,
            'list_tayang' => $this->list_tayang(),
            'id_setting' => $this->setting->id,
            'setting' => $this->setting,
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

        $validatedData['id_network'] = $this->user_network;
        
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

        return view('admin.statis.edit_statis',[
            'judul' => 'Edit Halaman' . ' - ' . $this->setting->judul_situs,
            'halaman' => $halaman,
            'list_tayang' => $this->list_tayang(),
            'id_setting' => $this->setting->id,
            'setting' => $this->setting,
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
