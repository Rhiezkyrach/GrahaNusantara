<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


use App\Models\Berita;
use App\Models\Kategori;
use App\Models\Epaper;
use App\Models\Iklan;
use App\Models\Setting;
use App\Models\Statis;
use App\Models\Network;


class KategoriController extends Controller
{
    public function kategori(Kategori $kategori, Request $request){

        $setting = Setting::first();
        $wcorona = DB::table('widget_corona')->where('id', 1)->first();

        $terkiniKanal =  Berita::kategoriTerkini()->where('id_channel', $kategori->id)->paginate(20);

        //Category Ajax
        if ($request->ajax()) {
            return view('layouts.partials.category_ajax', compact('terkiniKanal'))->render();
        }
        
        return view('category',[   
            'judul' => 'Berita ' . $kategori->nama . ' - ' . $setting->judul_situs,
            'deskripsi' => 'Berita ' . $kategori->nama . ' terkini',
            'keyword' => 'Berita ' . $kategori->nama . ' terkini',
            'author' => $setting->judul_situs,
            'foto' => asset('storage/' . $setting->logo),
            'navKategori' => Kategori::navKategori(),
            'extraNavKategori' => Kategori::extraNavKategori(),
            'headline' => Berita::headlines(),
            'hlkategori' => Berita::kategoriTerkini()->where('id_channel', $kategori->id)->where('headline', 1)->limit(5)->get(),
            'kategori' => $terkiniKanal,
            'populer' => Berita::populer(),
            'epaper' => Epaper::showAllePaper()->first(),
            "setting" => $setting,
            "halstatis" => Statis::getStatis(),
            "wcorona" => $wcorona,
            "Network" => Network::showAllNetwork()->get(),
            //IKLAN
            "iklanHeader" => Iklan::showIklan('Header')->orderBy('created_at', 'desc')->first(),
            "iklanHeadline" => Iklan::showIklan('Headline')->get(),
            "iklanSidebarA" => Iklan::showIklan('Sidebar A')->get(),
            "iklanSidebarB" => Iklan::showIklan('Sidebar B')->get(),
            "iklanSidebarC" => Iklan::showIklan('Sidebar C')->get(),
            "iklanFooter" => Iklan::showIklan('Footer')->get(),
            "corongRakyat" => Iklan::showTypeIklan('Corong Rakyat')->first(),

        ]);
    }
}
