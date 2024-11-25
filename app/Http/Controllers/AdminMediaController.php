<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\NetworkAccessTrait;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class AdminMediaController extends Controller
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

        return view('admin.file_manager.file_manager', [
            'judul' => 'File Manager' . ' - ' . $this->setting->judul_situs,
            'list_tayang' => $this->list_tayang(),
            'id_setting' => $this->setting->id,
            'setting' => $this->setting,
        ]);
    }
}
