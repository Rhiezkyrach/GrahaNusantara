<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use App\Models\Epaper;
use App\Models\Berita;
use App\Models\Kategori;
use App\Models\Iklan;
use App\Models\Setting;
use App\Models\Statis;
use App\Models\Network;

use Illuminate\Support\Facades\DB;

class EpaperController extends Controller
{
    public function index(Epaper $epaper){

        $setting = Setting::first();
        $wcorona = DB::table('widget_corona')->where('id', 1)->first();

        return view('epaper', [
            "judul" => 'ePaper Edisi '. Carbon::parse($epaper->edisi)->translatedFormat('l, d F Y') . " - " . $setting->judul_situs,
            "epaper" => $epaper,
            "prevEpaper" => Epaper::getPrevePaper($epaper->edisi)->limit(5)->get(),
            'counter' => Epaper::where('id', $epaper->id)->increment('counter', 1),
            "foto" => asset('storage/' . $epaper->cover),
            'navKategori' => Kategori::navKategori(),
            'extraNavKategori' => Kategori::extraNavKategori(),
            'headline' => Berita::headlines(),
            "deskripsi" => $setting->deskripsi,
            "keyword" => "berita politik, video politik",
            "author" => $setting->judul_situs,
            'populer' => Berita::populer(),
            "setting" => $setting,
            "halstatis" => Statis::getStatis(),
            "wcorona" => $wcorona,
            "Network" => Network::showAllNetwork()->get(),
            //IKLAN
            "iklanHeader" => Iklan::showIklan('Header')->orderBy('created_at', 'desc')->first(),
            "iklanFooter" => Iklan::showIklan('Footer')->get(),
        ]);
    }
}
