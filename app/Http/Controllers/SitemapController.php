<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\Setting;
use App\Models\Kategori;
use App\Models\Statis;

class SitemapController extends Controller
{
    public $setting;

    public function __construct(){
        $this->setting = Setting::getSetting();
    }

    public function index(){

        return response()->view('sitemap', [
            'berita' => Berita::terkini()->limit(500)->get(),
            'setting' => $this->setting,
            'statis' => Statis::getStatis()
        ])->header('Content-Type', 'text/xml');
    }

    public function feed(){

        return response()->view('feedberita', [
            'berita' => Berita::terkini()->limit(50)->get(),
            'setting' => $this->setting
        ])->header('Content-Type', 'application/xml');
    }

    public function feedkanal(Kategori $kategori){

        $terkiniKanal =  Berita::kategoriTerkini()->where('id_channel', $kategori->id)->limit(100)->get();

        return response()->view('feedberita', [
            'berita' => $terkiniKanal,
            'setting' => $this->setting
        ])->header('Content-Type', 'application/xml');
    }

    public function sitemapKanal(Kategori $kategori){

        $terkiniKanal =  Berita::kategoriTerkini()->where('id_channel', $kategori->id)->limit(100)->get();

        return response()->view('sitemap', [
            'berita' => $terkiniKanal,
            'setting' => $this->setting,
            'statis' => Statis::getStatis()
        ])->header('Content-Type', 'text/xml');
    }
}
