<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\Setting;


class AdminListTayangController extends Controller
{
    public function index(){

        $setting = Setting::first();

        return view('admin.list_tayang.list_tayang',[
            "judul" => 'List Tayang' . ' - ' . $setting->judul_situs,
            "berita" => Berita::listTayang(),
            "setting" => $setting
        ]);
    }
}
