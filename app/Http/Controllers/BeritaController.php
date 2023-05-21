<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use App\Models\Berita;
use App\Models\Kategori;
use App\Models\Galeri;
use App\Models\Iklan;
use App\Models\Setting;
use App\Models\Statis;
use App\Models\Epaper;
use App\Models\Network;

class BeritaController extends Controller
{

    public function home(Request $request){

        $setting = Setting::first();
        $wcorona = DB::table('widget_corona')->where('id', 1)->first();

        //Home Ajax
        if ($request->ajax()) {
            $terkini =  Berita::terkini()->paginate(10);
            return view('layouts.partials.home_ajax', compact('terkini'))->render();
        }
  
        return view('home', [
            'judul' => $setting->judul_situs . ' - ' . $setting->tagline,
            'deskripsi' => $setting->deskripsi,
            'keyword' => 'berita politik, berita terkini, berita viral, politik, berita hari ini, berita update, rajamedia, raja media, news',
            'author' => $setting->judul_situs,
            'foto' => asset('storage/' . $setting->logo),
            'navKategori' => Kategori::navKategori(),
            'extraNavKategori' => Kategori::extraNavKategori(),
            'headline' => Berita::headlines(),
            'terkini' => Berita::terkini()->paginate(10),
            'trending' => Berita::trending(),
            'populer' => Berita::populer(),
            'epaper' => Epaper::showAllePaper()->first(),
            "setting" => $setting,
            "halstatis" => Statis::getStatis(),
            "wcorona" => $wcorona,
            "Network" => Network::showAllNetwork()->get(),
            //KATEGORI
            'Politik' => Berita::beranda('Politik')->limit(4)->get(),
            'Hukum' => Berita::beranda('Hukum')->limit(4)->get(),
            'Galeri' => Berita::beranda('Galeri')->limit(2)->get(),
            'Nasional' => Berita::beranda('Nasional')->limit(6)->get(),
            'Peristiwa' => Berita::beranda('Peristiwa')->limit(6)->get(),
            'Opini' => Berita::beranda('Opini')->limit(3)->get(),
            'Olahraga' => Berita::beranda('Olahraga')->limit(3)->get(),
            'Parlemen' => Berita::beranda('Parlemen')->limit(3)->get(),
            'Dunia' => Berita::beranda('Dunia')->limit(3)->get(),
            'Daerah' => Berita::beranda('Daerah')->limit(3)->get(),
            'Keamanan' => Berita::beranda('Keamanan')->limit(3)->get(),
            'GayaHidup' => Berita::beranda('Gaya Hidup')->limit(3)->get(),
            'CalonDewan' => Berita::beranda('Calon Dewan')->limit(3)->get(),
            //IKLAN
            "iklanHeader" => Iklan::showIklan('Header')->orderBy('created_at', 'desc')->first(),
            "iklanHeadline" => Iklan::showIklan('Headline')->get(),
            "iklanHomeA" => Iklan::showIklan('Home A')->get(),
            "iklanHomeB" => Iklan::showIklan('Home B')->get(),
            "iklanHomeC" => Iklan::showIklan('Home C')->get(),
            "iklanSidebarA" => Iklan::showIklan('Sidebar A')->get(),
            "iklanSidebarB" => Iklan::showIklan('Sidebar B')->get(),
            "iklanSidebarC" => Iklan::showIklan('Sidebar C')->get(),
            "iklanFooter" => Iklan::showIklan('Footer')->get(),
            "corongRakyat" => Iklan::showTypeIklan('Corong Rakyat')->first(),
            
            

        ]);
    }

    public function detail(Berita $berita){

        $setting = Setting::first();
        $wcorona = DB::table('widget_corona')->where('id', 1)->first();

        $paragraphs = explode('</p>', $berita->isi);
        $deskripsi = html_entity_decode(strip_tags($paragraphs[0]));

        $tags = explode(',', $berita->tag);
        $terkait = Berita::terkait()->filter($tags)->where('id_berita', '!=', $berita->id_berita)->limit(6)->get();
        $sisa = 6 - $terkait->count();
        $terkaitkanal = Berita::terkait()->where('id_channel', $berita->id_channel)->where('id_berita', '!=', $berita->id_berita)->limit($sisa)->get();

        return view('detail',[
            'judul' => $berita->judul,
            'deskripsi' => $deskripsi,
            'keyword' => $berita->tag,
            'author' => $berita->wartawan,
            'foto' => asset('storage/' . $berita->gambar_detail),
            'navKategori' => Kategori::navKategori(),
            'extraNavKategori' => Kategori::extraNavKategori(),
            'headline' => Berita::headlines(),
            'berita' => $berita,
            'counter' => Berita::where('id_berita', $berita->id_berita)->increment('counter', mt_rand(1, 2)),
            'berita_prev' => Berita::beritaPrev($berita->id_berita),
            'berita_next' => Berita::beritaNext($berita->id_berita),
            'galeri' => Galeri::where('id_berita', $berita->id_berita)->get(),
            'terkini' => Berita::terkini()->limit(5)->get(),
            'populer' => Berita::populer(),
            'epaper' => Epaper::showAllePaper()->first(),
            'terkait' => $terkait,
            "setting" => $setting,
            "halstatis" => Statis::getStatis(),
            "wcorona" => $wcorona,
            'terkaitkanal'=> $terkaitkanal,
            "Network" => Network::showAllNetwork()->get(),
            //IKLAN
            "iklanHeader" => Iklan::showIklan('Header')->orderBy('created_at', 'desc')->first(),
            "iklanNewsA" => Iklan::showIklan('News A')->get(),
            "iklanNewsB" => Iklan::showIklan('News B')->get(),
            "iklanNewsC" => Iklan::showIklan('News C')->get(),
            "iklanSidebarA" => Iklan::showIklan('Sidebar A')->get(),
            "iklanSidebarB" => Iklan::showIklan('Sidebar B')->get(),
            "iklanSidebarC" => Iklan::showIklan('Sidebar C')->get(),
            "iklanFooter" => Iklan::showIklan('Footer')->get(),
            "corongRakyat" => Iklan::showTypeIklan('Corong Rakyat')->first(),
        ]);
    }

    public function search(Request $request){

        $setting = Setting::first();
        $wcorona = DB::table('widget_corona')->where('id', 1)->first();

        $filter = '';
        if(request(['cari'])){
            $filter = request(['cari']);
            $data = Str::title($filter['cari']);
        } elseif(request(['tag'])) {
            $filter = request(['tag']);
            $data = Str::title($filter['tag']);
        }

        // dd($filter);
        if($filter == null || !isset($request)){
            $terkini = Berita::terkini()->limit(10)->get();
            $judul = 'Berita Terkini ' . $setting->judul_situs;
        } else {
            $terkini = Berita::terkini()->filter($filter)->limit(10)->get();
            $judul = 'Berita ' . $data . ' - '. $setting->judul_situs;
        }
        
        return view('search',[
            'judul' => $judul,
            'deskripsi' => $setting->deskripsi,
            'keyword' => 'berita politik, berita terkini, berita viral, politik, berita hari ini, berita update, rajamedia, raja media, news',
            'author' => $setting->judul_situs,
            'foto' => asset('storage/' . $setting->logo),
            'navKategori' => Kategori::navKategori(),
            'extraNavKategori' => Kategori::extraNavKategori(),
            'headline' => Berita::headlines(),
            'populer' => Berita::populer(),
            'epaper' => Epaper::showAllePaper()->first(),
            'terkini' => $terkini,
            "setting" => $setting,
            "halstatis" => Statis::getStatis(),
            "wcorona" => $wcorona,
            "Network" => Network::showAllNetwork()->get(),
            //IKLAN
            "iklanHeader" => Iklan::showIklan('Header')->orderBy('created_at', 'desc')->first(),
            "iklanHomeA" => Iklan::showIklan('Home A')->get(),
            "iklanSidebarA" => Iklan::showIklan('Sidebar A')->get(),
            "iklanSidebarB" => Iklan::showIklan('Sidebar B')->get(),
            "iklanSidebarC" => Iklan::showIklan('Sidebar C')->get(),
            "iklanFooter" => Iklan::showIklan('Footer')->get(),
            "corongRakyat" => Iklan::showTypeIklan('Corong Rakyat')->first(),

        ]);
    }

    public function indeks(){

        $setting = Setting::first();
        $tanggal = Carbon::now()->translatedFormat('Y-m-d');
        $wcorona = DB::table('widget_corona')->where('id', 1)->first();

        return view('indeks',[
            'judul' => 'Indeks Berita - ' . $setting->judul_situs,
            'deskripsi' => $setting->deskripsi,
            'keyword' => 'berita politik, berita terkini, berita viral, politik, berita hari ini, berita update, rajamedia, raja media, news',
            'author' => $setting->judul_situs,
            'foto' => asset('storage/' . $setting->logo),
            'navKategori' => Kategori::navKategori(),
            'extraNavKategori' => Kategori::extraNavKategori(),
            'headline' => Berita::headlines(),
            'indeks' => Berita::indeks($tanggal)->get(),
            'populer' => Berita::populer(),
            'epaper' => Epaper::showAllePaper()->first(),
            "setting" => $setting,
            "halstatis" => Statis::getStatis(),
            "wcorona" => $wcorona,
            "Network" => Network::showAllNetwork()->get(),
            //IKLAN
            "iklanHeader" => Iklan::showIklan('Header')->orderBy('created_at', 'desc')->first(),
            "iklanHomeA" => Iklan::showIklan('Home A')->get(),
            "iklanSidebarA" => Iklan::showIklan('Sidebar A')->get(),
            "iklanSidebarB" => Iklan::showIklan('Sidebar B')->get(),
            "iklanSidebarC" => Iklan::showIklan('Sidebar C')->get(),
            "iklanFooter" => Iklan::showIklan('Footer')->get(),
            "corongRakyat" => Iklan::showTypeIklan('Corong Rakyat')->first(),
        ]);
    }

    public function indeksFilter(Request $request){

        $setting = Setting::first();
        $tanggal = $request->input('tanggal');
        $wcorona = DB::table('widget_corona')->where('id', 1)->first();

        return view('indeks_filter',[
            'judul' => 'Indeks Berita - ' . $setting->judul_situs,
            'deskripsi' => $setting->deskripsi,
            'keyword' => 'berita politik, berita terkini, berita viral, politik, berita hari ini, berita update, rajamedia, raja media, news',
            'author' => $setting->judul_situs,
            'foto' => asset('storage/' . $setting->logo),
            'navKategori' => Kategori::navKategori(),
            'extraNavKategori' => Kategori::extraNavKategori(),
            'headline' => Berita::headlines(),
            'indeks' => Berita::indeks($tanggal)->get(),
            'epaper' => Epaper::showAllePaper()->first(),
            'tanggal' => $tanggal,
            'populer' => Berita::populer(),
            "setting" => $setting,
            "halstatis" => Statis::getStatis(),
            "wcorona" => $wcorona,
            "Network" => Network::showAllNetwork()->get(),
            //IKLAN
            "iklanHeader" => Iklan::showIklan('Header')->orderBy('created_at', 'desc')->first(),
            "iklanHomeA" => Iklan::showIklan('Home A')->get(),
            "iklanSidebarA" => Iklan::showIklan('Sidebar A')->get(),
            "iklanSidebarB" => Iklan::showIklan('Sidebar B')->get(),
            "iklanSidebarC" => Iklan::showIklan('Sidebar C')->get(),
            "iklanFooter" => Iklan::showIklan('Footer')->get(),
            "corongRakyat" => Iklan::showTypeIklan('Corong Rakyat')->first(),
        ]);
    }

}
