<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Berita;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Traits\NetworkAccessTrait;
use RealRashid\SweetAlert\Facades\Alert;

class AdminListTayangController extends Controller
{
    use NetworkAccessTrait;

    public $setting;
    public $user_network;

    public function __construct()
    {
        $this->setting = Setting::where('id_network', auth()->user()->id_network)->first();
        $this->user_network = auth()->user()->id_network;
    }
    
    public function index(Request $request){

        if (session()->has('success')) {
            Alert::toast(session('success'), 'success');
        }

        if (session()->has('error')) {
            Alert::toast(session('error'), 'error');
        }

        $data = Berita::listTayang($this->user_network);

        if ($request->ajax()) {
            return datatables()->of($data)
                ->editColumn('id_network', function (Berita $beritum) {
                    return $beritum->Network ? $beritum->Network->nama : $beritum->id_network;
                })
                ->editColumn('tanggal_tayang', function (Berita $beritum) {
                    return Carbon::parse($beritum->tanggal_tayang . $beritum->waktu)->translatedFormat('d F Y, H:i');
                })
                ->editColumn('headline', function (Berita $beritum) {
                    return $beritum->headline == '1' ? '<div class="text-sm text-green-800"><i class="fas fa-check-circle"></i></div>' : '';
                })
                ->editColumn('publish', function (Berita $beritum) {
                    if ($beritum->publish == 0) {
                        return '<div class="inline-flex text-xxs font-semibold text-red-800 bg-red-200 px-2 py-1 rounded-full">Draf</div>';
                    } elseif ($beritum->publish == 1 && Carbon::parse($beritum->tanggal_tayang . $beritum->waktu)->translatedFormat('Y-m-d H:i') >= Carbon::now()) {
                        return '<div class="inline-flex text-xxs font-semibold text-yellow-800 bg-yellow-200 px-2 py-1 rounded-full">Terjadwal</div>';
                    } elseif ($beritum->publish == 1 && Carbon::parse($beritum->tanggal_tayang . $beritum->waktu)->translatedFormat('Y-m-d H:i') <= Carbon::now()) {
                        return '<div class="inline-flex text-xxs font-semibold text-green-800 bg-green-200 px-2 py-1 rounded-full">Tayang</div>';
                    }
                })
                ->addColumn('kategori', function (Berita $beritum) {
                    return $beritum->Kategori ? $beritum->Kategori->nama : '';
                })
                ->addColumn('link', function (Berita $beritum) {
                    return '<input class="w-40 px-1 py-0.5 border border-gray-600 rounded" value="' . url('berita/' . $beritum->slug) . '"/>';
                })
                ->addColumn('action', function (Berita $beritum) {
                    return view('admin.list_tayang.list_tayang-action', ['data' => $beritum])->render();
                })
                ->rawColumns(['action', 'headline', 'publish', 'link'])
                ->toJson();
        };


        return view('admin.list_tayang.list_tayang',[
            "judul" => 'List Tayang' . ' - ' . $this->setting->judul_situs,
            "setting" => Setting::first(),
            "list_tayang" => $this->list_tayang(),
            'id_setting' => $this->setting->id,
            'setting' => $this->setting,
        ]);
    }
}
