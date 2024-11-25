<?php

namespace App\Http\Controllers;

use App\Models\Setting;

use App\Models\Kategori;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\NetworkAccessTrait;
use RealRashid\SweetAlert\Facades\Alert;

class AdminKategoriController extends Controller
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

        $data = Kategori::showKategori($this->user_network);

        if ($request->ajax()) {
            return datatables()->of($data)
                ->editColumn('id_network', function (Kategori $kategori) {
                    return $kategori->Network ? $kategori->Network->nama : $kategori->id_network;
                })
                ->editColumn('navigasi', function (Kategori $kategori) {
                    return $kategori->navigasi == '1' ? '<div class="text-sm text-green-800"><i class="fas fa-check-circle"></i></div>' : '';
                })
                ->editColumn('status', function (Kategori $kategori) {
                    return $kategori->status == '0'
                        ? "<td><span class='px-3 py-1 text-xs rounded-full bg-rose-200'>TIDAK AKTIF</span></td>"
                        : "<td><span class='px-3 py-1 text-xs bg-green-200 rounded-full'>AKTIF</span></td>";
                })
                ->addColumn('action', function (Kategori $kategori) {
                    return view('admin.kategori.kategori-action', ['data' => $kategori])->render();
                })
                ->rawColumns(['action', 'navigasi', 'status'])
                ->toJson();
        };

        return view('admin.kategori.kategori',[
            'judul' => 'Management Kategori' . ' - ' . $this->setting->judul_situs,
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
        return view('admin.kategori.tambah_kategori',[
            'judul' => 'Tambah Kategori' . ' - ' . $this->setting->judul_situs,
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
            'navigasi' => 'required'
        ]);

        $validatedData['id_network'] = $this->user_network;
        $validatedData['urutan'] = $request->urutan;

        Kategori::create($validatedData);

        return redirect('/admin/kategori')->with('success', 'Kategori Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Kategori $kategori)
    {
        if ($request->ajax()) {
            return view('admin.kategori.show_kategori', [
                'judul' => 'Detail Kategori' . ' - ' . $this->setting->judul_situs,
                'kategori' => $kategori,
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Kategori $kategori)
    {   
        if($request->ajax()){
            return view('admin.kategori.edit_kategori',[
                'judul' => 'Edit Kategori' . ' - ' . $this->setting->judul_situs,
                'kategori' => $kategori,
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
    public function update(Request $request, Kategori $kategori)
    {
        
        $validatedData = $request->validate([
            'nama' => 'required',
            'status' => 'required',
            'navigasi' => 'required',
        ]);

        if($request->nama != $kategori->nama){
            $kategori['slug'] = 'required|max:255';
        }

        $validatedData['urutan'] = $request->urutan;

        Kategori::where('id', $kategori->id)
                ->update($validatedData);
                
        return redirect('/admin/kategori')->with('success', 'Kategori Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kategori $kategori)
    {
        Kategori::destroy($kategori->id);

        return redirect('/admin/kategori')->with('success', 'Kategori Berhasil Dihapus');
    }
}
