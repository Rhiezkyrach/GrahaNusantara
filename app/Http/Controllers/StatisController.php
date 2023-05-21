<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Kategori;
use App\Models\Statis;
use App\Models\Epaper;
use App\Models\Setting;
use App\Models\Iklan;
use App\Models\Network;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class StatisController extends Controller
{
    public function index(Statis $statis){

        $setting = Setting::first();
        $wcorona = DB::table('widget_corona')->where('id', 1)->first();

        return view('statis', [
            "judul" => $statis->judul . " - " . $setting->judul_situs,
            "statis" => $statis,
            "foto" => asset('storage/' . $setting->logo),
            "deskripsi" => $setting->deskripsi,
            "keyword" => "berita politik, video politik",
            "author" => $setting->judul_situs,
            'navKategori' => Kategori::navKategori(),
            'extraNavKategori' => Kategori::extraNavKategori(),
            'headline' => Berita::headlines(),
            'populer' => Berita::populer(),
            'epaper' => Epaper::showAllePaper()->first(),
            "setting" => $setting,
            "halstatis" => Statis::getStatis(),
            "wcorona" => $wcorona,
            "Network" => Network::showAllNetwork()->get(),
            //IKLAN
            "iklanHeader" => Iklan::showIklan('Header')->orderBy('created_at', 'desc')->first(),
            "iklanSidebarA" => Iklan::showIklan('Sidebar A')->get(),
            "iklanSidebarB" => Iklan::showIklan('Sidebar B')->get(),
            "iklanSidebarC" => Iklan::showIklan('Sidebar C')->get(),
            "iklanFooter" => Iklan::showIklan('Footer')->get(),
            "corongRakyat" => Iklan::showTypeIklan('Corong Rakyat')->first(),
        ]);
    }
}
